<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'type',
        'ics_url',
        'converted_ics_path',
        'last_converted',
    ];

    /**
     * Get the user that owns the source.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}