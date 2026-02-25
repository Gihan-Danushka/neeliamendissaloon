<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'period_start',
        'period_end',

        'basic_salary',
        'allowed_leaves',
        'leaves_taken',
        'excess_leaves',
        'leave_deduction',

        'invoice_total',
        'commission_rate',
        'commission_amount',

        'allowances_total',
        'deductions_total',
        'gross_pay',
        'net_pay',

        'status',
        'paid_at',
        'payment_method',
        'reference_no',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'period_start' => 'date',
        'period_end' => 'date',
        'paid_at' => 'datetime',

        'basic_salary' => 'decimal:2',
        'allowed_leaves' => 'decimal:2',
        'leaves_taken' => 'decimal:2',
        'excess_leaves' => 'decimal:2',
        'leave_deduction' => 'decimal:2',
        'invoice_total' => 'decimal:2',
        'commission_rate' => 'decimal:4',
        'commission_amount' => 'decimal:2',
        'allowances_total' => 'decimal:2',
        'deductions_total' => 'decimal:2',
        'gross_pay' => 'decimal:2',
        'net_pay' => 'decimal:2',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function adjustments()
    {
        return $this->hasMany(PayrollAdjustment::class);
    }
}
