<?php

namespace App\Http\Controllers;

use App\User;
use App\SharedResource;
use Illuminate\Http\Request;
use Freshbitsweb\Laratables\Laratables;

class SharedResourceController extends Controller
{
    /**
     * Display a listing of the shared resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Logic to retrieve and display shared resources
        return view('shared_resources.index');
    }

    /**
     * Show the form for creating a new shared resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::select('username', 'first_name', 'last_name')->get();
        $data=[
            'users' => $users,
        ];
        return view('master_data.shared_resources.create');
    }
    //store method to handle the form submission
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'id' => 'nullable|integer',
        ]);

        // Create or update the shared resource
        SharedResource::updateOrCreate(
            ['id' => $request->input('id')],
            [
                'name' => $data['name'],
                'location' => $data['location'],
            ]
        );
        return response()->json(['Shared resource saved successfully']);
    }
    public function list(){
        return Laratables::recordsOf(SharedResource::class);
    }
    public function edit(SharedResource $shared_resource){
        return $this->create()->with('shared_resource', $shared_resource);
    }
    public function unavailResource(SharedResource $shared_resource)
    {
        $shared_resource->is_available = false;
        $shared_resource->save();
        return redirectBackWithSessionSuccess('Shared resource marked as unavailable.');
    }
    public function availResource(SharedResource $shared_resource)
    {
        $shared_resource->is_available = true;
        $shared_resource->save();
        return redirectBackWithSessionSuccess('Shared resource marked as available.');
    }

    public function destroy(SharedResource $shared_resource)
    {
        $shared_resource->delete();
        return response()->json(['Shared resource deleted successfully.']);
    }
}
