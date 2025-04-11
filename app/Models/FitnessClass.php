<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FitnessClass extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'instructor_id',
        'start_time',
        'duration',
        'capacity',
        'description',
        'price',
    ];
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function isFull()
    {
        return $this->bookings()->count() >= $this->capacity;
    }
}
