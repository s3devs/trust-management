<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Models\Customer\Customer;
use App\Http\Controllers\Controller;
use App\Models\Customer\Location;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Customer $customer)
    {
      $data = $customer->locations();

      if ($request->has('filter') && !empty($request->filter)) {
      }
      if ($request->input('deleted') ? $request->boolean('deleted') : false) {
        $data->onlyTrashed();
      }
      $data = $data->orderBy($request->has('order') ? $request->order : 'created_at', $request->has('descending') ? $request->descending : 'desc')
                  ->paginate($request->has('limit') ? $request->limit : 15);
      return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Customer $customer)
    {
        $rules = [
            'label' => 'required',
            'address_line_1' => 'required',
            'address_city' => 'required',
            'address_postcode' => 'required',
        ];

        $this->validate($request, $rules);

        $location = $customer->locations()->create($request->input());

        return response()->json($location, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer, Location $location)
    {
      return response()->json($location, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer, Location $location)
    {
        // Set rules
        $rules = [
            'label' => 'required',
            'address_line_1' => 'required',
            'address_city' => 'required',
            'address_postcode' => 'required',
        ];

        // Validate those rules
        $this->validate($request, $rules);

        $location->update($request->input());
        return response()->json($location, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Customer $customer, Location $location)
    {
      $location->delete();

      return response()->json([
        'message' => 'Location has been deleted successfully!'
      ], 200);
    }

    /**
     * Remove the selected resource from storage.
     *
     * @param  App\Models\Customer\Location $location
     * @return \Illuminate\Http\Response
     */
    public function destroySelected(Request $request, Customer $customer, Location $location)
    {
        $this->validate($request, [
          'locations' => 'required'
        ]);
        $location->whereIn('id', $request->locations)->delete();
        return response()->json([
          'message' => 'Locations has been deleted successfully!'
        ], 200);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  App\Models\Customer\Location $location
     * @return \Illuminate\Http\Response
     */
    public function restore(Customer $customer, $location, Location $locations)
    {
      $locations->onlyTrashed()
              ->where('id', $location)
              ->restore();
      return response()->json([
        'message' => 'Location has been restored successfully!'
      ], 200);
    }

    /**
     * Remove the selected resource from storage.
     *
     * @param  App\Models\Customer\Location $location
     * @return \Illuminate\Http\Response
     */
    public function restoreSelected(Request $request, Customer $customer, Location $location)
    {
        $this->validate($request, [
          'locations' => 'required'
        ]);
        $location->onlyTrashed()
          ->whereIn('id', $request->locations)
          ->restore();
        return response()->json([
          'message' => 'Locations has been restored successfully!'
        ], 200);
    }
}
