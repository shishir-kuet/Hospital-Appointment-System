<?php
// File: app/Models/Appointment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_number', 'patient_id', 'doctor_id', 'appointment_date',
        'appointment_time', 'status', 'reason_for_visit', 'notes',
        'diagnosis', 'prescription', 'cancellation_reason'
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'datetime:H:i',
        'cancelled_at' => 'datetime',
    ];

    // Relationships
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function bill()
    {
        return $this->hasOne(Bill::class);
    }

    // Scopes
    public function scopeUpcoming($query)
    {
        return $query->where('appointment_date', '>=', now()->toDateString())
                    ->whereIn('status', ['scheduled', 'confirmed']);
    }

    public function scopeToday($query)
    {
        return $query->where('appointment_date', now()->toDateString());
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Auto-generate appointment number
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($appointment) {
            $appointment->appointment_number = 'APT' . str_pad(
                Appointment::count() + 1, 6, '0', STR_PAD_LEFT
            );
        });
    }
}