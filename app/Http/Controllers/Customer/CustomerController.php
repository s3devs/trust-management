<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Models\Customer\Customer;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, Customer $customer)
    {

      $data = $customer->with('account_manager');

      if ($request->has('prospect') && $request->boolean('prospect')) {
        $data->orWhere('prospect', 1);
      } else if ($request->has('prospect') && !$request->boolean('prospect')) {
        $data->orWhere('prospect', 0);
      }

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
    public function store(Request $request, Customer $customer)
    {
      $rules = [
        'type' => 'required',
        'label' => 'required',
        'account_manager_id' => 'required',
        'general_contact_number' => 'required',
        'general_email_address' => 'required|email',
        'status' => 'required',
      ];

      $this->validate($request, $rules);

      $customer = $customer->create($request->input());

      return response()->json($customer->load('account_manager', 'referral_source'), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Customer $customer)
    {
        return response()->json($customer->load('account_manager', 'referral_source', 'parent_company', 'contacts', 'locations'), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Customer $customer)
    {
      $rules = [
        'type' => 'required',
        'label' => 'required',
        'account_manager_id' => 'required',
        'general_contact_number' => 'required',
        'general_email_address' => 'required|email',
        'status' => 'required',
      ];

      $this->validate($request, $rules);

      $customer->update($request->input());

      return response()->json([
        'data' => $customer->load('account_manager', 'referral_source'),
        'message' => 'Customer has been updated successfully!'
      ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return response()->json([
          'message' => 'Customer has been deleted successfully!'
        ], 200);
    }

    /**
     * Remove the selected resource from storage.
     *
     * @param  App\Models\Customer\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function destroySelected(Request $request, Customer $customer)
    {
        $this->validate($request, [
          'customers' => 'required'
        ]);
        $customer->whereIn('id', $request->customers)->delete();
        return response()->json([
          'message' => 'Customers has been deleted successfully!'
        ], 200);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  App\Models\Customer\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
      Customer::onlyTrashed()
          ->where('id', $id)
          ->restore();
      return response()->json([
        'message' => 'Customer has been restored successfully!'
      ], 200);
    }

    /**
     * Remove the selected resource from storage.
     *
     * @param  App\Models\Customer\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function restoreSelected(Request $request, Customer $customer)
    {
        $this->validate($request, [
          'customers' => 'required'
        ]);
        $customer->onlyTrashed()
          ->whereIn('id', $request->customers)
          ->restore();
        return response()->json([
          'message' => 'Customers has been restored successfully!'
        ], 200);
    }
}
