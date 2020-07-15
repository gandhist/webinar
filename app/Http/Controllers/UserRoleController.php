<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use App\Permission;
use App\RolePermission;

class UserRoleController extends Controller
{
  public function index(){
    $data["role"] = Role::all();
    $data["permission"] = Permission::all();

    return view('role/index')->with($data);
  }

  public function create(){
    $data['permission'] = Permission::all();
    
    return view('role/create')->with($data);
  }

  public function store(Request $request)
  {
    $role = new Role();
    $role->name  = $request->get('name');

    if($role->save()){
      $this->generatePermission($role->id, $request->get('permission'));
    }

    return redirect('/user_role')->with('success', 'Role berhasil dibuat');
  }

  public function show($id)
  {
      echo $id;
  }

  public function edit($id)
  {
      $role = Role::findOrFail($id);
      $permission = Permission::all();
      $role_permission = $role->permission;

      return view('role/edit', [
          "role" => $role,
          "permission" => $permission,
          "role_permission" => $role_permission,
      ]);
  }

  public function update(Request $request, $id)
  {
      $role = Role::findOrFail($id);
      $role->name  = $request->get('name');

      if($role->save()){
        $this->generatePermission($id, $request->get('permission'));
      }

      return redirect('/user_role')->with('success', 'Role berhasil diupdate');
  }

  public function destroy($id)
  {
      $role = Role::findOrFail($id);
      $role->delete();

      $this->deletePermission($id);

      return response()->json(['status'=>'Role berhasil dihapus']);
  }

  private function deletePermission($role_id){
    $data = RolePermission::where("role_id", $role_id);
    $data->delete();
  }

  private function generatePermission($role_id, $permission){
    $this->deletePermission($role_id);

    foreach($permission as $p){
      $new = new RolePermission();
      $new->role_id = $role_id;
      $new->permission_id = $p;

      $new->save();
    }
  }
}
