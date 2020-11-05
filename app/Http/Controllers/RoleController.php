<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Role::with('permissions');

        if ($request->has('filter') && !empty($request->filter)) {
            $data->where('name', 'like', $request->filter . '%');
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
    public function store(Request $request, Role $role)
    {
        $rules = [
          'name' => 'required',
          'slug' => 'required'
        ];

        $this->validate($request, $rules);

        $data = $request->all();
        $role = $role->create($data);

        return response()->json($role->load('permissions'), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $role = $role;
        $role->permissions = $role->permissions()->get()->pluck('id');
        return response()->json($role, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        // Set rules
        $rules = [
          'name' => 'required',
          'slug' => 'required'
        ];

        // Validate those rules
        $this->validate($request, $rules);

        $role->update($request->input());
        $role->permissions()->sync($request->permissions);

        return response()->json([
          'data' => $role->load('permissions'),
          'message' => 'Role has been updated successfully!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return response()->json([
          'message' => 'Role has been deleted successfully!'
        ], 200);
    }

    /**
     * Remove the selected resource from storage.
     *
     * @param  App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function destroySelected(Request $request, Role $role)
    {
        $this->validate($request, [
          'roles' => 'required'
        ]);
        $role->whereIn('id', $request->roles)->delete();
        return response()->json([
          'message' => 'Roles has been deleted successfully!'
        ], 200);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
      Role::onlyTrashed()
          ->where('id', $id)
          ->restore();
      return response()->json([
        'message' => 'Role has been restored successfully!'
      ], 200);
    }

    /**
     * Remove the selected resource from storage.
     *
     * @param  App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function restoreSelected(Request $request, Role $role)
    {
        $this->validate($request, [
          'roles' => 'required'
        ]);
        $role->onlyTrashed()
          ->whereIn('id', $request->roles)
          ->restore();
        return response()->json([
          'message' => 'Roles has been restored successfully!'
        ], 200);
    }
}
