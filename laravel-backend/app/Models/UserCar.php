<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserCar extends Model
{
    use hasFactory;
    protected $table = 'user_car';
    protected $fillable = [
        'user_id',
        'car_id',
        'name',
        'email',
        'phone',
        'test_drive_date',
        'test_drive_time',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
