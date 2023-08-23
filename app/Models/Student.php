<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Student extends Model
{
    use HasFactory, SoftDeletes;
    use HasRoles;

    protected $fillable = [
        'school_class_id', 'student_identification_number',
        'name', 'email', 'phone_number', 'gender', 'school_year_start',
        'school_year_end', 'role'
    ];

    /**
     * Get school class relation data.
     *
     * @return BelongsTo
     */
    public function school_class(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'school_class_id');
    }

    /**
     * Get school major relation data.
     *
     * @return BelongsTo
     */
    // public function school_major(): BelongsTo
    // {
    //     return $this->belongsTo(SchoolMajor::class);
    // }

    /**
     * Get cash transaction relation data.
     *
     * @return HasMany
     */
    public function cash_transactions(): HasMany
    {
        return $this->hasMany(CashTransaction::class);
    }

    public function billings()
    {
        return $this->hasMany(Billing::class);
    }

    /**
     * Get student gender name.
     *
     * @return string
     */
    public function getGenderName(): string
    {
        return match ($this->gender) {
            1 => 'Laki-laki',
            2 => 'Perempuan'
        };
    }
}
