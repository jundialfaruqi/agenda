<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Agenda extends Model
{
    use SoftDeletes;

    protected $table = 'tb_agenda';

    protected $fillable = [
        'opd_id',
        'user_id',
        'name',
        'slug',
        'date',
        'jam_mulai',
        'jam_selesai',
        'link_paparan',
        'link_zoom',
        'barcode',
        'catatan',
        'status'
    ];

    protected $casts = [
        'date' => 'date',
        'status' => 'string',
        // Biarkan jam sebagai string dari DB (TIME)
    ];

    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }

    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('slug', 'like', '%' . $search . '%')
                    ->orWhere('catatan', 'like', '%' . $search . '%');
            });
        }
        return $query;
    }

    // Accessor: status_waktu agenda berdasarkan waktu (non-kolom)
    public function getStatusWaktuAttribute(): string
    {
        try {
            if (!$this->date || !$this->jam_mulai || !$this->jam_selesai) {
                return 'menunggu';
            }
            $start = Carbon::createFromFormat('Y-m-d H:i:s', $this->date->format('Y-m-d') . ' ' . $this->jam_mulai);
            $end = Carbon::createFromFormat('Y-m-d H:i:s', $this->date->format('Y-m-d') . ' ' . $this->jam_selesai);
            $now = Carbon::now();
            if ($now->lt($start)) return 'akan_datang';
            if ($now->between($start, $end)) return 'sedang_berlangsung';
            return 'selesai';
        } catch (\Throwable $e) {
            return 'menunggu';
        }
    }
}
