<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\Customer\Contact;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Customer $customer)
    {
      $data = $customer->contacts();

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
            'first_name' => 'required',
            'surname' => 'required',
            'email_address' => 'required|email',
            'contact_number' => 'required',
        ];

        $this->validate($request, $rules);
        $contact = $customer->contacts()->create($request->input());

        return response()->json($contact, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer, Contact $contact)
    {
      return response()->json($contact->load('location'), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Customer $customer, Contact $contact)
    {
        // Set rules
        $rules = [
            'label' => 'required',
            'first_name' => 'required',
            'surname' => 'required',
            'email_address' => 'required|email',
            'contact_number' => 'required',
        ];

        // Validate those rules
        $this->validate($request, $rules);

        $contact->update($request->input());
        return response()->json($contact, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Customer $customer, Contact $contact)
    {
      $contact->delete();

      return response()->json([
        'message' => 'Contact has been deleted successfully!'
      ], 200);
    }

    /**
     * Remove the selected resource from storage.
     *
     * @param  App\Models\Customer\Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function destroySelected(Request $request, Customer $customer, Contact $contact)
    {
        $this->validate($request, [
          'contacts' => 'required'
        ]);
        $contact->whereIn('id', $request->contacts)->delete();
        return response()->json([
          'message' => 'Contacts has been deleted successfully!'
        ], 200);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  App\Models\Customer\Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function restore(Customer $customer, $contact, Contact $contacts)
    {
      $contacts->onlyTrashed()
              ->where('id', $contact)
              ->restore();
      return response()->json([
        'message' => 'Contact has been restored successfully!'
      ], 200);
    }

    /**
     * Remove the selected resource from storage.
     *
     * @param  App\Models\Customer\Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function restoreSelected(Request $request, Customer $customer, Contact $contact)
    {
        $this->validate($request, [
          'contacts' => 'required'
        ]);
        $contact->onlyTrashed()
          ->whereIn('id', $request->contacts)
          ->restore();
        return response()->json([
          'message' => 'Contacts has been restored successfully!'
        ], 200);
    }
}
