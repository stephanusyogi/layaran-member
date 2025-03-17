<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\BillingCycle;
use App\Models\Plan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Drivers\Gd\Encoders\JpegEncoder;
use Intervention\Image\Drivers\Gd\Encoders\PngEncoder;
use Yajra\DataTables\DataTables as DataTables;
use Intervention\Image\Laravel\Facades\Image;

class BillingController extends Controller
{
    public function index(){
        $title_page = "My Invoices";

        if (request()->ajax()) {
            $billings = Billing::where('user_id', auth()->id())
                ->orderByRaw("CASE WHEN status = 'pending' THEN 0 ELSE 1 END")
                ->orderBy('created_at', 'desc')
                ->get();

            return Datatables::of($billings)
                ->addColumn('invoice_id', function ($row) {
                    return '<p>' . $row->invoice_id . '</p>';
                })
                ->addColumn('invoice_date', function ($row) {
                    $date = Carbon::parse($row->created_at)->format('l, F jS, Y');
                    return '<p>' . $date . '</p>';
                })
                ->addColumn('due_date', function ($row) {
                    $dueDate = Carbon::parse($row->due_date)->format('l, F jS, Y');
                    return '<p>' . $dueDate . '</p>';
                })
                ->addColumn('total_billing', function ($row) {
                    $total = number_format($row->total, 2, ',', '.');
                    return '<p>Rp. ' . $total . '</p>';
                })
                ->addColumn('status_billing', function ($row) {
                    if ($row->status === 'pending') {
                        return '<p class="text-info"><i class="bx bx-time"></i> Pending</p>';
                    } elseif ($row->status === 'paid') {
                        return '<p class="text-success"><i class="bx bx-check"></i> Paid</p>';
                    } elseif ($row->status === 'overdue') {
                        return '<p class="text-danger"><i class="bx bx-alarm-exclamation"></i> Overdue</p>';
                    } elseif ($row->status === 'unpaid'){
                        return '<p class="text-warning"><i class="bx bx-x-circle"></i> Unpaid</p>';
                    }else {
                        return '<p class="text-secondary"><i class="bx bx-x-circle"></i> Cancelled</p>';
                    }
                })
                ->addColumn('action_link', function ($row) {
                    return route('billings.details', $row->invoice_id);
                })
                ->rawColumns(['invoice_id','invoice_date', 'due_date', 'total_billing', 'status_billing'])
                ->make(true);
        }
        
        return view('billing', compact('title_page'));
    }

    public function order(Request $request){
        try {
            DB::beginTransaction();
    
            $request->validate([
                'customField-1' => 'required|exists:plans,id',
                'customField-2' => 'required|in:one_week,two_weeks,one_month,three_months',
            ], [
                'customField-1.required' => 'Please select a valid plan.',
                'customField-1.in' => 'The selected plan is not available.',
                'customField-2.required' => 'Please select a valid cycle.',
                'customField-2.in' => 'The selected cycle is not available.',
            ]);

            $plan = Plan::findOrFail($request->input('customField-1'));

            $billingCycle = BillingCycle::where('plan_id', $plan->id)
                ->where('cycle', $request->input('customField-2'))
                ->first();

            if (!$billingCycle) {
                throw new \Exception('Billing cycle not found.');
            }
    
            $billing = new Billing();
            $billing->user_id = auth()->id();
            $billing->date = now();
            $billing->due_date = now()->addDays(1);
            $billing->amount = $billingCycle->price;
            $billing->total = $billingCycle->price;
            $billing->status = 'unpaid';

            do {
                $invoiceId = rand(1111111, 9999999);
            } while (Billing::where('invoice_id', $invoiceId)->exists());

            $billing->invoice_id = $invoiceId;
            $billing->plan_id = $plan->id;

            $billing->save();
    
            DB::commit();
            return redirect('/billings')->with('success', 'Billing created successfully. Please proceed to payment.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::error('Billing creation failed: ' . $e->getMessage());
    
            return redirect()->back()->with('error', 'An error occurred while creating billing. Please try again.');
        }
    }

    public function details($invoiceIdid){
        $title_page = "View Invoice";
        $data = Billing::with('plan.billingCycles')->where('invoice_id', $invoiceIdid)->first();

        if (!$data) {
            return redirect('/')->with('error', 'Data not found');
        }
        
        return view('billing-detail', compact('title_page', 'data'));
    }

    public function uploadProof(Request $request, $invoiceId)
    {
        $request->validate([
            'customField-1' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ], [
            'customField-1.required' => 'Please upload your payment proof.',
            'customField-1.file'     => 'The uploaded item must be a file.',
            'customField-1.mimes'    => 'Only PDF files are allowed for the payment proof.',
            'customField-1.max'      => 'The file size must not exceed 2MB.',
        ]);

        $billing = Billing::where('invoice_id', $invoiceId)->firstOrFail();

        try {
            if ($request->hasFile('customField-1')) {
                $file = $request->file('customField-1');
                $extension = strtolower($file->getClientOriginalExtension());
                $filename = time() . '_' . $billing->invoice_id . '.' . $extension;
                $destinationPath = public_path('payment_proofs');
    
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
    
                if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
                    $image = Image::read(file_get_contents($file->getRealPath()))
                        ->resize(300, 200);
    
                    if (in_array($extension, ['jpg', 'jpeg'])) {
                        $encoder = new JpegEncoder(75);
                    } elseif ($extension == 'png') {
                        $encoder = new PngEncoder(75);
                    }
    
                    $image->encode($encoder, 75);
                    $image->save($destinationPath . '/' . $filename);
                }
    
                $billing->payment_proof = $filename;
                $billing->payment_date = now();
                $billing->status = 'pending';
                $billing->save();
    
                return redirect()->back()->with('success', 'Payment proof uploaded successfully.');
            }
    
            return redirect()->back()->with('error', 'File upload failed.');
        } catch (\Exception $e) {
            Log::error("Error uploading payment proof for invoice {$invoiceId}: " . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while processing your request. Please try again.');
        }
    
    }

}
