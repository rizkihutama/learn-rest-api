<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id_gallery';
    protected $table = 'galleries';
    protected $guarded = ['id_gallery'];

    protected $fillable = [
        'id_gallery',
        'pet_id',
        'image',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $cast = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    /**
     *  Relationship
     */
    public function pets(): BelongsTo
    {
        return $this->belongsTo(Pet::class, 'id_pet', 'pet_id');
    }
}
