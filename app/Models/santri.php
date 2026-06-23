<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Santri extends Model
{
    use HasFactory;

    // Menentukan nama tabel karena bentuk jamaknya (santris) custom
    protected $table = 'santris';

    // Kolom yang boleh diisi (mass assignable)
    protected $fillable = [
        'user_id',
        'nis',
        'nama_santri',
        'kelas',
        'kamar',
        'jenis_kelamin',
    ];

    /**
     * Relasi ke model User (Satu santri terhubung ke satu akun user/wali)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke model Perizinan (Satu santri bisa punya banyak data perizinan)
     */
    public function perizinans(): HasMany
    {
        return $this->hasMany(Perizinan::class, 'santri_id');
    }
}