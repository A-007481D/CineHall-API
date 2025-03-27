<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'capacity', 'type'];

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }

    public function seances()
    {
        return $this->hasMany(Seance::class);
    }
}
