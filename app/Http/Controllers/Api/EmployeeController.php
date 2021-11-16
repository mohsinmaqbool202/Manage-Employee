<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Response;
use App\Models\Employee;
use App\Models\Department;
use App\Models\SalaryType;
use App\Services\EmployeeService;
use App\Http\Resources\EmployeeResource;

class EmployeeController extends Controller
{

    protected $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = EmployeeResource::collection(Employee::orderBy('id', 'DESC')->get());

        return response()->json([
            'status'    =>  200,
            'employees' =>  $employees
        ]);
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
        $validator = Validator::make($request->all(), [
            'first_name'     => 'required|alpha|max:70',
            'last_name'      => 'required|alpha|max:70',
            'work_hours'     => 'required|numeric',
            'salary_type'    => 'required',
            'salary'         => 'required|numeric',
            'department_id'  => 'required',
            'email'          => 'nullable|email:dns,rfc|max:50',
            'phone'          => 'max:15'
        ]);

        if ($validator->fails()) {
            $result = [
                'status' => 404,
                'message' => $validator->errors()->toArray(),   
            ];
            
            return Response::json($result);
        }

        #save employee in DB
        $result = $this->employeeService->saveEmployee($request);
        $result['employees']= EmployeeResource::collection(Employee::orderBy('id', 'DESC')->get());
        return Response::json($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = $this->employeeService->getEmployeeById($id);
        return Response::json($result);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::find($id);
        if(!$employee)
        {
            return Response::json(['status' => 404, 'message'=> 'This employee not exist.']);
        }

        $departments = Department::pluck('name', 'id');
        $salary_types = SalaryType::pluck('type', 'id');
        $employee = new EmployeeResource($employee);

        return Response::json([
            'status'      => 200, 
            'employee'    => $employee,
            'departments' => $departments,
            'salary_types'=> $salary_types
        ]);
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
        $validator = Validator::make($request->all(), [
            'first_name'     => 'required|alpha|max:70',
            'last_name'      => 'required|alpha|max:70',
            'work_hours'     => 'required|numeric',
            'salary_type'    => 'required',
            'salary'         => 'required|numeric',
            'department_id'  => 'required',
            'email'          => 'nullable|email:dns,rfc|max:50',
            'phone'          => 'max:15'        
        ]);

        #if validation fails
        if ($validator->fails()) {
            $result = [
                'status' => 404,
                'message' => $validator->errors()->toArray(),   
            ];
            
            return Response::json($result);
        }

        #update employee in DB
        $result = $this->employeeService->updateEmployee($request, $id);
        $result['employees']= EmployeeResource::collection(Employee::orderBy('id', 'DESC')->get());
        return Response::json($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);
        if(!$employee)
        {
            return Response::json(['status' => 404, 'message'=> 'This employee not exist.']);
        }

        $employee->delete();
        return Response::json([
            'status' => 200, 
            'message'=> 'Employee deleted successfully.',
            'employees' => EmployeeResource::collection(Employee::orderBy('id', 'DESC')->get()),
        ]);
    }
}
