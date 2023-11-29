<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;

    //cara menghubungkan tabel prodis dengan mahasiswas
    public function mahasiswas () {
        return $this->hasMany('App\Models\Mahasiswa');
    }


}



