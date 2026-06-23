<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Perizinan extends Model
{
    use HasFactory;

    protected $table = 'perizinans';

    protected $fillable = [
        'santri_id',
        'user_id',
        'tgl_jemput',
        'jam_jemput',
        'tgl_kembali',
        'jam_kembali',
        'alasan',
        'file_pendukung',
        'status',
        'catatan_admin',
        'approved_by',
        'approved_at',
        'checked_out_by',
        'checked_out_at',
        'checked_in_by',
        'checked_in_at',
        'token_gatepass',
    ];

    
    protected $casts = [
        'tgl_jemput' => 'date',
        'tgl_kembali' => 'date',
        'approved_at' => 'datetime',
        'checked_out_at' => 'datetime',
        'checked_in_at' => 'datetime',
    ];

    
    public function santri(): BelongsTo
    {
        return $this->belongsTo(Santri::class, 'santri_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

   
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    
    public function checkerOut(): BelongsTo
    {
        return $this->belongsTo(User::class, 'checked_out_by');
    }

    
    public function checkerIn(): BelongsTo
    {
        return $this->belongsTo(User::class, 'checked_in_by');
    }
}