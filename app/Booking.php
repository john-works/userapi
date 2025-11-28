<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'requested_by',
        'purpose',
        'start',
        'end',
        'internal_participants',
        'external_participants',
    ];
    //bookingDetails
    public function bookingDetails()
    {
        return $this->hasMany(BookingDetail::class, 'booking_id', 'id');
    }

    public static function laratablesCustomActions($booking)
    {
        $data = ['booking'=>$booking];
        return view('actions.booking_actions')->with($data)->render();
    }
}
