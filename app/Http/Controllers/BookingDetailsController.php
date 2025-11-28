<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingDetailsController extends Controller
{
    //create
    public function create($bookingId)
    {
        // Logic to show the form for creating booking details
        return view('booking_details.create', compact('bookingId'));
    }
    //store
    public function store(Request $request){
        // Logic to store booking details
        $data = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'details' => 'required|string|max:255',
        ]);

        // Assuming BookingDetail is a model for booking details
        \App\Models\BookingDetail::create($data);

        return redirect()->route('bookings.edit', $data['booking_id'])
                         ->with('success', 'Booking details added successfully.');
    }
}
