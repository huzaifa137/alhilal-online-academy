<?php

namespace App\Models\Academic;

use App\Models\PaymentTransaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaterialPayment extends Model
{
    protected $fillable = [
        'subject_material_id',
        'student_id',
        'payment_transaction_id',
        'amount_paid',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function material(): BelongsTo
    {
        return $this->belongsTo(SubjectMaterial::class, 'subject_material_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function paymentTransaction(): BelongsTo
    {
        return $this->belongsTo(PaymentTransaction::class);
    }
}