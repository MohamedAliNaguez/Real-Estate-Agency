<?php

namespace App\Http\Controllers;

use App\Http\Resources\PropertyResource;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $properties = Property::all();
        return PropertyResource::collection($properties);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:House,Apartment',
            'address' => 'required|string',
            'size' => 'required|integer',
            'bedrooms' => 'required|integer',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        $property = Property::create($data);

        return PropertyResource::collection($property);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $property = Property::find($id);

        if (!$property) {
            return response()->json(['message' => 'Property not found'], 404);
        }

        return PropertyResource::collection($property);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $property = Property::find($id);

        if (!$property) {
            return response()->json(['message' => 'Property not found'], 404);
        }

        $data = $request->validate([
            'type' => 'in:House,Apartment',
            'address' => 'string',
            'size' => 'integer',
            'bedrooms' => 'integer',
            'latitude' => 'numeric',
            'longitude' => 'numeric',
            'price' => 'numeric',
        ]);

        $property->update($data);

        return PropertyResource::collection($property);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $property = Property::find($id);

        if (!$property) {
            return response()->json(['message' => 'Property not found'], 404);
        }

        $property->delete();

        return response()->json(['message' => 'Property deleted successfully'], 200);
    }
    /**
     * Search for properties based on provided filters such as type, address, size, bedrooms, and price.
     *
     * This method retrieves properties from the database that match the filter criteria provided by the user.
     * If no properties match the criteria, a 404 response is returned with a message indicating no properties were found.
     *
     * @param \Illuminate\Http\Request $request The incoming HTTP request containing the filter parameters.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response containing the list of matching properties or a 404 response if none are found.
     */
    public function search(Request $request)
    {
        // Initialize the property query
        $query = Property::query();

        // Apply filters if provided in the request
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }
        if ($request->has('address')) {
            $query->where('address', 'like', '%' . $request->address . '%');
        }
        if ($request->has('size')) {
            $query->where('size', $request->size);
        }
        if ($request->has('bedrooms')) {
            $query->where('bedrooms', $request->bedrooms);
        }
        if ($request->has('price')) {
            $query->where('price', '<=', $request->price);
        }

        // Get the search results
        $results = $query->get();

        // If no properties are found, return a not found response
        if ($results->isEmpty()) {
            return response()->json(['message' => 'Property not found'], 404);
        }

        // Return the found properties as a resource collection
        return PropertyResource::collection($results);
    }



    /**
     * Retrieve properties within a specified radius from a given geographical location (latitude and longitude).
     *
     * This method calculates the distance between the given location and properties in the database using the Haversine formula.
     * The properties are then filtered by the radius and ordered by proximity.
     * If no properties are found within the radius, a 404 response is returned.
     *
     * @param \Illuminate\Http\Request $request The incoming HTTP request containing the latitude, longitude, and radius parameters.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response containing the properties within the specified radius or a 404 response if none are found.
     */
    public function nearby(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'latitude' => 'required|numeric', // Latitude of the reference location (numeric value)
            'longitude' => 'required|numeric', // Longitude of the reference location (numeric value)
            'radius' => 'required|numeric|min:1', // The search radius (numeric value, must be at least 1 km)
        ]);

        // Extract validated inputs
        $latitude = $validated['latitude'];
        $longitude = $validated['longitude'];
        $radius = $validated['radius'];

        // Query the properties using the Haversine formula to calculate distance
        $properties = Property::selectRaw(
            "*,
        (6371 * acos(
            cos(radians(?)) * cos(radians(latitude))
            * cos(radians(longitude) - radians(?))
            + sin(radians(?)) * sin(radians(latitude))
        )) AS distance",
            [$latitude, $longitude, $latitude]
        )
            ->having("distance", "<=", $radius) // Filter properties by the specified radius
            ->orderBy("distance") // Order by distance (closest to furthest)
            ->get();

        // If no properties are found within the radius, return a not found response
        if ($properties->isEmpty()) {
            return response()->json(['message' => 'No properties found within the specified radius'], 404);
        }

        // Return the found properties as a resource collection
        return PropertyResource::collection($properties);
    }


}
