<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    protected $fillable = ['stay_date', 'price'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}

