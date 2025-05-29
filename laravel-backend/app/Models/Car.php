<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = ['brand', 'model', 'price', 'year', 'image'];

    public function userBookings()
    {
        return $this->hasMany(UserCar::class);
    }

}
