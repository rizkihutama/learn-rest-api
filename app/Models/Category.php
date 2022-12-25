<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id_category';
    protected $able = 'categories';
    protected $guarded = ['id_category'];

    protected $fillable = [
        'id_category',
        'category',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $cast = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     *  Relationship
     */
    public function pets(): HasMany
    {
        return $this->hasMany(Pet::class, 'pet_id', 'id_pet');
    }
}
