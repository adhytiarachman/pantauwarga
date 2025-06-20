<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    protected $fillable = [
        'no_kk',
        'nik',
        'nama_kepala_keluarga',
        'jenis_kelamin',
        'usia',
        'alamat',
        'status_tinggal',
        'is_kepala_keluarga',
        'user_id', 
        'tempat_lahir', 
        'tanggal_lahir'
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}

}

