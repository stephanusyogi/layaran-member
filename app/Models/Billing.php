<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Billing extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'billings';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = [
        'id',
        'user_id',
        'invoice_id',
        'plan_id',
        'date',
        'due_date',
        'amount',
        'total',
        'payment_proof',
        'payment_date',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = (string) Str::uuid(); // Auto-generate UUID
        });
    }

    /**
     * Relationship: Billing belongs to a User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function plan(){
        return $this->belongsTo(Plan::class);
    }    

}