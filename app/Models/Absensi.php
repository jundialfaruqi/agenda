<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Absensi extends Model
{
    use SoftDeletes;

    protected $table = 'tb_absensi';
    
    protected $fillable = [
        'agenda_id',
        'opd_id',
        'nip_nik',
        'name',
        'jabatan',
        'asal_daerah',
        'telp',
        'instansi',
        'ttd',
        'waktu_hadir',
        'status'
    ];

    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }

    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }
}