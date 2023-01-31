<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
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
        'show_id',
        'duration',
        'explicit',
        'subtitle',
        'bytes',
        'status',
        'pub_date'
    ];

    const STATUS_IMPORTING       =  1;
    const STATUS_DRAFT           =  2;
    const STATUS_ACTIVE          =  3;

    const AREA_MAP = [
        self::STATUS_IMPORTING      => 'Importing',
        self::STATUS_DRAFT          => 'Draft',
        self::STATUS_ACTIVE         => 'Active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'show_id'
    ];

    /**
     * Get the user associated with the record.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function show()
    {
        return $this->belongsTo(Show::class);
    }
}
