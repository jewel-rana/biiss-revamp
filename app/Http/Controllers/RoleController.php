<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Role;
use App\Permission;
use DB;


class RoleController extends Controller
{
/**
* Display a listing of the resource.
*
* @return \Illuminate\Http\Response
*/
public function index(Request $request)
{
    $search=trim($request->input('search'));
    $roles = Role::orderBy('id','DESC')->paginate(5);
    if(isset($search)){
        $roles=Role::where('name','like','%'.$search.'%')->orWhere('display_name','like','%'.$search.'%')->orderBy('id','DESC')->paginate(5);
    }

    $title = 'Roles';
    return view('roles.index',compact('roles', 'title'))
    ->with('i', ($request->input('page', 1) - 1) * 5);
}

/**
* Show the form for creating a new resource.
*
* @return \Illuminate\Http\Response
*/
public function create()
{
$permission = Permission::get();
$permission = Permission::where("parent_id", null)->where("is_active",'1')->get();

foreach ($permission as $singleparent){
    $children[$singleparent->name]=Permission::where("parent_id", $singleparent->id)->get();
}
$title = 'Create new role';
return view('roles.create',compact('permission','children', 'title'));
}

/**
* Store a newly created resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @return \Illuminate\Http\Response
*/
public function store(Request $request)
{
$this->validate($request, [
'name' => 'required|unique:roles,name',
'display_name' => 'required',
'description' => 'required',
'permission' => 'required',
]);

$role = new Role();
$role->name = $request->input('name');
$role->display_name = $request->input('display_name');
$role->description = $request->input('description');
$role->save();

foreach ($request->input('permission') as $key => $value) {
$role->attachPermission($value);
}

return redirect()->route('roles.index')
->with('success','Role created successfully');
}
/**
* Display the specified resource.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function show($id)
{
$role = Role::find($id);
$rolePermissions = Permission::join("permission_role","permission_role.permission_id","=","permissions.id")
->where("permission_role.role_id",$id)
->get();
    
    $title = 'Role Details';
return view('roles.show',compact('role','rolePermissions', 'title'));
}

/**
* Show the form for editing the specified resource.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function edit($id)
{
$role = Role::find($id);
$permission = Permission::where("parent_id", null)->where("is_active",'1')->get();

foreach ($permission as $singleparent){
    $children[$singleparent->name]=Permission::where("parent_id", $singleparent->id)->get();
}





$rolePermissions = DB::table("permission_role")->where("permission_role.role_id",$id)
->pluck('permission_role.permission_id','permission_role.permission_id')->toArray();
    $title = 'Edit Role';
return view('roles.edit',compact('role','permission','rolePermissions','children', 'title'));
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

  // dd($request->input('permission'));


$this->validate($request, [
'display_name' => 'required',
'description' => 'required',
'permission' => 'required',
]);

$role = Role::find($id);
$role->display_name = $request->input('display_name');
$role->description = $request->input('description');
$role->save();

DB::table("permission_role")->where("permission_role.role_id",$id)
->delete();

foreach ($request->input('permission') as $key => $value) {
$role->attachPermission($value);
}

return redirect()->route('roles.index')
->with('success','Role updated successfully');
}
/**
* Remove the specified resource from storage.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function destroy($id)
{
DB::table("roles")->where('id',$id)->delete();
return redirect()->route('roles.index')
->with('success','Role deleted successfully');
}
}