<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = User::with('roles');

        if ($request->has('filter') && !empty($request->filter)) {
            $data->where('first_name', 'like', $request->filter . '%');
            $data->orWhere('surname', 'like', $request->filter . '%');
            $data->orWhere('email', 'like', $request->filter . '%');
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
    public function store(Request $request, User $user)
    {
        $rules = [
          'first_name' => 'required',
          'surname' => 'required',
          'email' => 'required|email|unique:users',
          'password' => 'required|min:6|confirmed',
          'calendar_color' => 'required|min:3|max:7',
          'job_role' => 'required',
          'hourly_rate_standard' => 'required',
          'hourly_rate_overtime' => 'required',
        ];

        $this->validate($request, $rules);

        $data = $request->all();
        $data['password'] = bcrypt($request->password);

        $user = $user->create($data);
        $user->roles()->attach($request->roles);
        $permissions = Permission::whereIn('id', $request->permissions)->get();
        $user->permissions()->attach($permissions);

        return response()->json($user->load('roles', 'permissions'), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user->load('roles');
        $user->permissions = $user->permissions()->get()->pluck('id');
        return response()->json($user, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        // Set rules
        $rules = [
            'first_name' => 'required',
            'surname' => 'required',
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'min:6|confirmed',
            'calendar_color' => 'required|min:3|max:7',
            'job_role' => 'required',
            'hourly_rate_standard' => 'required',
            'hourly_rate_overtime' => 'required'
        ];

        // Validate those rules
        $this->validate($request, $rules);

        if ($request->has('password')) {
          $request->password = bcrypt($request->password);
        }

        $user->update($request->input());
        $user->roles()->sync(collect($request->roles)->pluck('id'));
        $user->permissions()->sync($request->permissions);

        return response()->json([
          'data' => $user->load('roles'),
          'message' => 'User has been updated successfully!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
          'message' => 'User has been deleted successfully!'
        ], 200);
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

    /**
     * Display a listing of the permission.
     *
     * @return \Illuminate\Http\Response
     */
    public function modules (Request $request)
    {
      $roles = Role::all();
      $permissions = Permission::all();
      $permissionsNode = [];
      foreach ($permissions->groupBy('module') as $key => $value) {
          array_push($permissionsNode, array(
              'name' => $key,
              'id' => $key,
              'children' => $value
          ));
      }
      return response()->json([
        'permissions' => $permissionsNode,
        'roles' => $roles
      ], 200);
    }
}
