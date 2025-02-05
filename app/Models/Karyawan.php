<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Karyawan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id_user', 'nama', 'umur', 'jabatan', 'alamat'
    ];

    public function user() {
        return $this->BelongsTo(User::class, 'id_user', 'id');
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'id_karyawan', 'id');
    }

}
