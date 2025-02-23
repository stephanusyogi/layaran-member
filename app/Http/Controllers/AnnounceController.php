<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class AnnounceController extends Controller
{
    public function index(Request $request){
        if (request()->ajax()) {
            $data = Announcement::with(['author'])->withTrashed()->latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('published_at_render', function ($row) {
                    return $row->first_name . ($row->last_name ? ' ' . $row->last_name : '');
                })
                ->addColumn('published_at_render', function ($row) {
                    return Carbon::parse($row->published_at)->format('l, F d Y');
                })
                ->addColumn('publish_draft_status', function ($row) {
                    if ($row->status === 'draft') {
                        $div = '<button type="button" class="badge badge-sm border border-warning text-warning bg-warning text-white d-flex align-items-center">
                            <svg width="9" height="9" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="me-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Draft
                        </button>';
                    } else {
                        $div = '<button type="button" class="badge badge-sm border border-info text-info bg-info text-white d-flex align-items-center">
                            <svg width="9" height="9" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke-width="2" stroke="currentColor" class="me-1">
                                <path d="M5 12.5L10 17.5L19 5.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            Published
                        </button>';
                    }
                    return $div;
                })
                ->addColumn('author_name', function ($row) {
                    return $row->author ? $row->author->first_name . ' ' . $row->author->last_name : 'Unknown';
                })
                ->addColumn('status_item', function ($row) {
                    if ($row->deleted_at) {
                        $div = '<button type="button" class="badge badge-sm border border-warning text-warning bg-warning text-white">
                        <svg width="9" height="9" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="me-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Deleted
                    </button>';
                    }else{
                        $div = '<button type="button" class="badge badge-sm border border-success text-success bg-success text-white">
                        <svg width="9" height="9" viewBox="0 0 10 9" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor" class="me-1">
                            <path d="M1 4.42857L3.28571 6.71429L9 1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Active
                    </button>';
                    }
                    return $div;
                })
                ->addColumn('action', function ($row) {
                    $span = '  
                    <a href="'.route('announcements.details', $row->id).'" class="badge badge-sm border border-secondary text-secondary bg-secondary text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" style="vertical-align: middle; margin-right: 4px;">
                            <path fill="currentColor" d="M12 9a3 3 0 0 0-3 3a3 3 0 0 0 3 3a3 3 0 0 0 3-3a3 3 0 0 0-3-3m0 8a5 5 0 0 1-5-5a5 5 0 0 1 5-5a5 5 0 0 1 5 5a5 5 0 0 1-5 5m0-12.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5" />
                        </svg>
                        Detail
                    </a>';
    
                    return $span;
                })
                ->rawColumns(['status_item','publish_draft_status','action'])
                ->make(true);
        }

        $title_page = "Announcements";
        return view('announcement', compact('title_page'));
    }

    public function details(Request $request ,$id){
        $announcement = Announcement::find($id);
        if ($request->ajax()) {
            if (!$announcement) {
                return response()->json(['error' => 'Announcement not found'], 404);
            }

            return response()->json([
                'title' => $announcement->title,
                'description' => $announcement->description,
                'status' => $announcement->status,
                'isNew' => $announcement->published_at >= Carbon::now()->subDays(3),
                'published_at' => $announcement->published_at ? Carbon::parse($announcement->published_at)->format('l, F d Y') : null,
                'author' => optional($announcement->author)->name ?? 'Unknown',
            ]);
        }else{
            if (!$announcement) {
                return redirect()->back()->with('error', 'Announcement not found.');
            }
            
            $title_page = 'Detail Announcement';

            return view('announcement-detail', compact('title_page', 'announcement'));
        }
    }

    public function delete(Request $request, $id){
        $request->validate([
            'announcementDelete' => ['required', 'accepted'],
        ], [
            'announcementDelete.required' => 'You must confirm this action before proceeding.',
            'announcementDelete.accepted' => 'Please check the confirmation box to delete this announcement.',
        ]);

         /** @var Announcement $item */
        $item = Announcement::withTrashed()->find($id);
        dd($item);
        if (!$item) {
            return redirect()->back()->with('error', 'User not found.');
        }

        try {

            $item->delete();
            return redirect()->route('announcements')->with('success', 'Announcement account has been deleted.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Account deactivation failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete. <br> Please try again.');
        }
    }

    public function update(Request $request, $id)
    {
        $formData = $request->validate([
            'customField-1' => 'required|string|max:255',
            'customField-2' => 'required|in:draft,published',
            'customField-3' => 'nullable|string',
        ], [
            'customField-1.required' => 'Title is required.',
            'customField-1.string'   => 'Title must be a string.',
            'customField-1.max'      => 'Title cannot exceed 255 characters.',
            'customField-2.in'       => 'Status must be either draft or published.',
            'customField-3.string'   => 'Description must be a string.',
        ]);

        try {
            DB::beginTransaction();

            $announcement = Announcement::findOrFail($id);

            $updateData = [
                'title'       => $formData['customField-1'],
                'description' => $formData['customField-2'] ?? '',
                'status'      => $formData['customField-3'],
            ];

            if ($announcement->status === 'draft' && $formData['customField-3'] === 'published') {
                $updateData['published_at'] = now();
            }

            $announcement->update($updateData);

            DB::commit();

            return redirect()->route('announcements')->with('success', 'Announcement updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            \Illuminate\Support\Facades\Log::error('Announcement update failed: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Update failed! Please try again.');
        }
    }

    public function add(){
        $title_page = 'Create New Announcement';

        return view('announcement-add', compact('title_page'));
    }

    public function create(Request $request)
    {
        $formData = $request->validate([
            'customField-1' => 'required|string|max:255',
            'customField-2' => 'required|in:draft,published',
            'customField-3' => 'nullable|string',
        ], [
            'customField-1.required' => 'Title is required.',
            'customField-2.required' => 'Status is required.',
            'customField-2.in'       => 'Invalid status selected.',
        ]);

        try {
            DB::beginTransaction();

            $data = [
                'title'        => $formData['customField-1'],
                'description'  => $formData['customField-3'] ?? '',
                'status'       => $formData['customField-2'],
                'published_at' => $formData['customField-2'] === 'published' ? now() : null,
                'author_id'    => Auth::id(), // Assumes the user is logged in.
            ];

            Announcement::create($data);

            DB::commit();

            return redirect()->route('announcements')
                             ->with('success', 'Announcement created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::error('Announcement creation failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Creation failed! Please try again.');
        }
    }


}
