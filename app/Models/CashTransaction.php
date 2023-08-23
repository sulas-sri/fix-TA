<?php

namespace App\Models;

use App\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CashTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id','student_id', 'amount', 'category', 'is_paid', 'date'];

    protected $casts = [
        'is_paid' => 'integer',
        // 'category' => 'string', // Ubah menjadi string
    ];

    // Menggunakan mutator untuk mengubah array category menjadi JSON saat disimpan ke database
    public function setCategoryAttribute($value)
    {
        $this->attributes['category'] = json_encode($value);
    }

    // Menggunakan accessor untuk mengubah JSON category menjadi array saat diambil dari database
    public function getCategoryAttribute($value)
    {
        return json_decode($value, true);
    }

    /**
     * Get students relation data.
     *
     * @return BelongsTo
     */
    public function students(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    /**
     * Get users relation data.
     *
     * @return BelongsTo
     */
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Set date attribute when storing data.
     *
     * @param string $value
     * @return void
     */
    public function setDateAttribute(string $value): void
    {
        $this->attributes['date'] = date('Y-m-d', strtotime($value));
    }


}
