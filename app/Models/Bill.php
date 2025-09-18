<?php
// File: app/Models/Bill.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_number', 'appointment_id', 'patient_id', 'consultation_fee',
        'additional_charges', 'tax_amount', 'discount_amount', 'total_amount',
        'payment_status', 'payment_method', 'payment_date', 'notes'
    ];

    protected $casts = [
        'consultation_fee' => 'decimal:2',
        'additional_charges' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'payment_date' => 'datetime',
    ];

    // Relationships
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function billItems()
    {
        return $this->hasMany(BillItem::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('payment_status', 'pending');
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    public function scopeOverdue($query)
    {
        return $query->where('payment_status', 'overdue');
    }

    // Auto-generate bill number
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($bill) {
            $bill->bill_number = 'BILL' . str_pad(
                Bill::count() + 1, 6, '0', STR_PAD_LEFT
            );
        });
    }
}