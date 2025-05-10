<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Department;
use App\Role;
use DB;
use Hash;
use App\Country;


class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $employees = Employee::orderBy('id','DESC')->paginate(5);

        return view('employees.index',compact('employees'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


       // $countrylist = Country::pluck('name','code')->toArray();
        $countrylist = DB::table('country')->pluck('name', 'code');
        $departments = DB::table('departments')->pluck('name', 'id');
//        $employees = Employee::where("status","Active")->select(
//            DB::raw("CONCAT(first_name,' ', middle_name,' ', last_name) AS full_name, id")
//        )->orderBy('first_name','asc')->pluck('full_name','id');
        $employees = Employee::where("status","Active")->select(DB::raw("CONCAT(first_name, ' ', middle_name, ' ', last_name) AS full_name"),'id')->pluck('full_name','id')->toArray();




        return view('employees.create',compact('countrylist','departments','employees'));
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
            'national_id' => 'required|unique:employee_info,national_id',
            'private_email' => 'required|unique:employee_info,private_email',
            'work_email' => 'required|unique:employee_info,work_email'
          ]);





        $input = $request->all();


        if($request->file('avatar')) {
            $profile_image = $request->file('avatar');
            $upload = 'uploads/profile';

            $extension=$profile_image->getClientOriginalExtension();
            $profile_image_name =time().".".$extension;
            $success = $profile_image->move($upload, $profile_image_name);

            $input['avatar']=$profile_image_name;
            if($success) {
                $employee = Employee::create($input);
                return redirect()->route('employee.index')
                    ->with('success', 'Employees created successfully');
            }
        }else{
            $employee = Employee::create($input);
            return redirect()->route('employee.index')
                ->with('success', 'Employees created successfully');

        }



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::find($id);
        return view('employees.show',compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {



        // $countrylist = Country::pluck('name','code')->toArray();
        $countrylist = DB::table('country')->pluck('name', 'code');
        $departments = DB::table('departments')->pluck('name', 'id');
//        $employees = Employee::where("status","Active")->select(
//            DB::raw("CONCAT(first_name,' ', middle_name,' ', last_name) AS full_name, id")
//        )->orderBy('first_name','asc')->pluck('full_name','id');
        $employees = Employee::where("status","Active")->select(DB::raw("CONCAT(first_name, ' ', middle_name, ' ', last_name) AS full_name"),'id')->pluck('full_name','id')->toArray();



        $employee = Employee::find($id);
        return view('employees.edit',compact('employee','countrylist','departments','employees'));
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

        $this->validate($request, [
             'national_id' => 'required|unique:employee_info,national_id,'.$id,
             'work_email' => 'required|unique:employee_info,work_email,'.$id,
             'private_email' => 'required|unique:employee_info,private_email,'.$id
           ]);



        $input = $request->all();
        if($request->file('avatar')) {
            $images_check=Employee::find($id);
            if($images_check->avatar!=""){
                $upload_file="uploads/profile/".$images_check->avatar;
                unlink($upload_file);
            }

            $profile_image = $request->file('avatar');
            $upload = 'uploads/profile';
            $extension=$profile_image->getClientOriginalExtension();
            $profile_image_name =time().".".$extension;
            $success = $profile_image->move($upload, $profile_image_name);
            $input['avatar']=$profile_image_name;
            if($success){
                Employee::find($id)->update($input);
            }

         }else{
            Employee::find($id)->update($request->all());
         }
         return redirect()->route('employee.index')
            ->with('success','employees updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $images_check=Employee::find($id);

        if($images_check->avatar!=""){
            $upload_file="uploads/profile/".$images_check->avatar;

            unlink($upload_file);
        }
        $images_check->delete();


        return redirect()->route('employee.index')

            ->with('success','Employees deleted successfully');
    }
}
