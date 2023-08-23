<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class Billing extends Model
{
    use SoftDeletes, Notifiable;

    protected $fillable = [
        'user_id',
        'student_id',
        'id_telegram',
        'bill',
        'kategori_tagihan',
        'date',
        'status',
    ];

    protected $dates = ['deleted_at'];
    // public function student(): BelongsTo
    // {
    //     return $this->belongsTo(Student::class, 'student_id');
    // }

    // public function user(): BelongsTo
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }

    public function students(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function setDateAttribute(string $value): void
    {
        $this->attributes['date'] = date('Y-m-d', strtotime($value));
    }

}
