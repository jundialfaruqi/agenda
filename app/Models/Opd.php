<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Opd extends Model
{
    use SoftDeletes;

    protected $table = 'tb_opd';
    
    protected $fillable = [
        'name',
        'singkatan', 
        'alamat',
        'telp',
        'logo'
    ];

    public function agendas()
    {
        return $this->hasMany(Agenda::class);
    }

    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }
}