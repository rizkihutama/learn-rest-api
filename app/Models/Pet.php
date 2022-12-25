<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pet extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id_pet';
    protected $table = 'pets';
    protected $guarded = ['id_pet'];

    protected $fillable = [
        'id_pet',
        'category_id',
        'name',
        'gender',
        'dob',
        'weight',
        'description',
        'image',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $cast = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    /**
     *  Relationship
     */
    public function categories(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id_category');
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class, 'pet_id', 'id_pet');
    }
}
