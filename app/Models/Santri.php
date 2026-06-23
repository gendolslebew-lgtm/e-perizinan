<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Santri extends Model
{
    use HasFactory;


    protected $table = 'santris';

   
    protected $fillable = [
        'user_id',
        'nis',
        'nama_santri',
        'kelas',
        'kamar',
        'jenis_kelamin',
    ];

    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function perizinans(): HasMany
    {
        return $this->hasMany(Perizinan::class, 'santri_id');
    }
}