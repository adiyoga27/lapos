<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LevelPermission extends TokoModel
{
    protected $table = 'level_permission';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['level_kode', 'permission'];

    protected $primaryKey = ['level_kode', 'permission'];

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class, 'level_kode', 'kode');
    }
}