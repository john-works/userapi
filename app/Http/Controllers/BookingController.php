<?php

namespace App\Http\Controllers;

use App\Booking;
use App\SharedResource;
use Illuminate\Http\Request;
use Freshbitsweb\Laratables\Laratables;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('bookings.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $resources = SharedResource::where('is_available', true)->get();
        $data = [
            'resources' => $resources
        ];
        return view('bookings.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $resp = [];
        try{
            $data = $request->validate([
                'booking_id' => 'nullable|integer',
                'requested_by' => 'required',
                'purpose' => 'required|string|max:255',
                'start' => 'required',
                'end' => 'required',
                'internal_participants' => 'nullable|string',
                'external_participants' => 'nullable|string',
                'shared_resources' => 'required|array',
            ]);

        //check if booking_id is provided and perform update, otherwise create a new booking
        if (isset($data['booking_id'])) {
            $booking = Booking::findOrFail($data['booking_id']);
            $booking->update($data);
            // Update booking details if they have changed
            $booking->bookingDetails()->sync($data['shared_resources']);
            //mark the added shared resources as booked and mark the removed ones as available
            foreach ($data['shared_resources'] as $resourceId) {
                $resource = SharedResource::find($resourceId);
                if ($resource) {
                    $resource->is_available = false;
                    $resource->save();
                }
            }
            //mark the previously booked resources as available
            $previousResources = $booking->bookingDetails->pluck('id')->toArray();
            $removedResources = array_diff($previousResources, $data['shared_resources']);
            foreach ($removedResources as $resourceId) {
                $resource = SharedResource::find($resourceId);
                if ($resource) {
                    $resource->is_available = true;
                    $resource->save();
                }
            }
            $msg = "Booking successfully updated";
            

        } else {
            $booking = Booking::create($data);
            $booking->bookingDetails()->createMany(array_map(function ($resourceId) use ($booking) {
                return [
                    'booking_id' => $booking->id,
                    'shared_resource_id' => $resourceId,
                ];
            }, $data['shared_resources']));
            //mark the added shared resources as booked
            foreach ($data['shared_resources'] as $resourceId) {
                $resource = SharedResource::find($resourceId);
                if ($resource) {
                    $resource->is_available = false;
                    $resource->save();
                }
            }
            $msg = "Booking successfully created";
        }
            $resp = [
                'success' => true,
                'message' => $msg,
                'id' => $booking->id,
            ];
            return response()->json($resp);

        } catch (\Exception $e) {
            $resp = [
                'success' => false,
                'message' => 'An error occurred while processing your request: ' . $e->getMessage(),
            ];
            return $resp;
        }
    }
    public function list()
    {
        return Laratables::recordsOf(Booking::class);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        return $this->create()->with('booking', $booking);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        //
    }
}
