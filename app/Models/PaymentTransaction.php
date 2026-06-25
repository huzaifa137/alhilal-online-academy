<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentTransaction extends Model
{
    protected $fillable = [
        'reference',
        'marzpay_uuid',
        'student_id',
        'payment_type',
        'payable_id',
        'amount',
        'method',
        'phone_number',
        'status',
        'redirect_url',
        'webhook_payload',
        'provider_transaction_id',
    ];

    protected $casts = [
        'webhook_payload' => 'array',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isPending(): bool
    {
        return in_array($this->status, ['pending', 'processing']);
    }
}
