<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bansos extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'income',
        'source',
        'aid_type',
        'start_date',
        'end_date',
        'status',
    ];

    // Relasi ke model User
    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_id');
    }
}
