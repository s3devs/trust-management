<?php

namespace App\Http\Controllers\Supplier;

use Illuminate\Http\Request;
use App\Models\Supplier\Supplier;
use App\Http\Controllers\Controller;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, Supplier $supplier)
    {

      $data = $supplier->with('account_manager');

      if ($request->has('filter') && !empty($request->filter)) {
          $data->where('company_name', 'like', $request->filter . '%');
          $data->orWhere('general_email_address', 'like', $request->filter . '%');
      }

      if ($request->has('deleted') ? $request->boolean('deleted') : false) {
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Supplier $supplier)
    {
      $rules = [
        'label' => 'required',
        'account_manager_id' => 'required',
        'general_contact_number' => 'required',
        'general_email_address' => 'required|email',
        'status' => 'required',
      ];

      $this->validate($request, $rules);

      $supplier = $supplier->create($request->input());

      return response()->json($supplier->load('account_manager'), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Supplier $supplier)
    {
        return response()->json($supplier->load('account_manager', 'contacts', 'locations'), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Supplier $supplier)
    {
      $rules = [
        'label' => 'required',
        'account_manager_id' => 'required',
        'general_contact_number' => 'required',
        'general_email_address' => 'required|email',
        'status' => 'required',
      ];

      $this->validate($request, $rules);

      $supplier->update($request->input());

      return response()->json([
        'data' => $supplier->load('account_manager'),
        'message' => 'Supplier has been updated successfully!'
      ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return response()->json([
          'message' => 'Supplier has been deleted successfully!'
        ], 200);
    }

    /**
     * Remove the selected resource from storage.
     *
     * @param  App\Models\Supplier\Supplier $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroySelected(Request $request, Supplier $supplier)
    {
        $this->validate($request, [
          'suppliers' => 'required'
        ]);
        $supplier->whereIn('id', $request->suppliers)->delete();
        return response()->json([
          'message' => 'Suppliers has been deleted successfully!'
        ], 200);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  App\Models\Supplier\Supplier $supplier
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
      Supplier::onlyTrashed()
          ->where('id', $id)
          ->restore();
      return response()->json([
        'message' => 'Supplier has been restored successfully!'
      ], 200);
    }

    /**
     * Remove the selected resource from storage.
     *
     * @param  App\Models\Supplier\Supplier $supplier
     * @return \Illuminate\Http\Response
     */
    public function restoreSelected(Request $request, Supplier $supplier)
    {
        $this->validate($request, [
          'suppliers' => 'required'
        ]);
        $supplier->onlyTrashed()
          ->whereIn('id', $request->suppliers)
          ->restore();
        return response()->json([
          'message' => 'Suppliers has been restored successfully!'
        ], 200);
    }
}
