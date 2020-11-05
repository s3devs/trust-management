<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Models\Customer\Customer;
use App\Http\Controllers\Controller;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Customer $customer)
    {
      $data = $customer->activities();

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * Remove the selected resource from storage.
     *
     * @param  App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroySelected(Request $request, User $user)
    {
        $this->validate($request, [
          'users' => 'required'
        ]);
        $user->whereIn('id', $request->users)->delete();
        return response()->json([
          'message' => 'Users has been deleted successfully!'
        ], 200);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
      User::onlyTrashed()
          ->where('id', $id)
          ->restore();
      return response()->json([
        'message' => 'User has been restored successfully!'
      ], 200);
    }

    /**
     * Remove the selected resource from storage.
     *
     * @param  App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function restoreSelected(Request $request, User $user)
    {
        $this->validate($request, [
          'users' => 'required'
        ]);
        $user->onlyTrashed()
          ->whereIn('id', $request->users)
          ->restore();
        return response()->json([
          'message' => 'Users has been restored successfully!'
        ], 200);
    }
}
