<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Absensi extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id_karyawan', 'tanggal', 'absen'
    ];

    public function karyawan() {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id');
    }
}
