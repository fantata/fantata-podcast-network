<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Show extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'description',
        'email',
        'user_id',
        'category_id',
        'explicit',
        'subtitle',
        'status'
    ];

    const STATUS_IMPORTING       =  1;
    const STATUS_DRAFT           =  2;
    const STATUS_PUBLISHED       =  3;

    const AREA_MAP = [
        self::STATUS_IMPORTING      => 'Importing',
        self::STATUS_DRAFT          => 'Draft',
        self::STATUS_PUBLISHED      => 'Published',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'user_id'
    ];

    /**
     * Get the user associated with the record.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the episodes owned by this show.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function episodes()
    {
        return $this->HasMany(Episode::class);
    }

    /**
     * Get the category associated with the record.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
