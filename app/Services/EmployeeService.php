<?php
namespace App\Services;
use Illuminate\Http\Request;
use Response;
use App\Models\Employee;
use App\Models\Department;
use App\Http\Resources\EmployeeResource;


class EmployeeService
{
	public function saveEmployee(Request $request)
	{
		try {
        
            $employee = new Employee;
            $employee->first_name    =   $request->first_name;
            $employee->last_name     =   $request->last_name;
            $employee->phone         =   $request->phone;
            $employee->email         =   $request->email;
            $employee->work_hours    =   $request->work_hours;
            $employee->salary_type   =   $request->salary_type;
            $employee->salary        =   $request->salary;
            $employee->department_id =   $request->department_id;
            $employee->save();

            $result = [
                'status' => 200,
                'message' => 'Employee added successfully.'
            ];

        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'message' => $e->getMessage()
            ];
        }

        return $result;
	}

	public function getEmployeeById($id)
	{
		try {

			$employee = Employee::find($id);
	        if(!$employee)
	        {
	            return $result = [
	                'status' => 404,
	                'message' => 'Employee not exist.'
	            ];
	        }

	        $employee = new EmployeeResource($employee);
	        $result = [
	                'status' => 200,
	                'employee' => $employee
	            ];

	    } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return $result;
	}

	public function updateEmployee(Request $request, $id)
	{
		try 
		{
            $employee = Employee::find($id);
            if(!$employee)
            {
                return ['status' => 404, 'message'=> 'Employee not exist.'];
            }

            $employee->first_name    =   $request->first_name;
            $employee->last_name     =   $request->last_name;
            $employee->phone         =   $request->phone;
            $employee->email         =   $request->email;
            $employee->work_hours    =   $request->work_hours;
            $employee->salary_type   =   $request->salary_type;
            $employee->salary        =   $request->salary;
            $employee->department_id =   $request->department_id;
            $employee->save();

            $result = [
                'status' => 200,
                'message' => 'Employee updated successfully.'
            ];

        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'message' => $e->getMessage()
            ];
        }

        return $result;
	}

    public function calculateSalary($id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return 0;
        }
        $salary = 0;
        $salary_type = $employee->salary_type;
        switch ($salary_type) {

            case 1:#hourly rate salary
                $salary = $employee->salary * $employee->work_hours;
                break;

            case 2:#fixed salary
                $salary = $employee->salary;
                break;

            case 3:
                if($employee->work_hours >= 100)
                {
                    $salary = $employee->salary * $employee->work_hours;
                }
                else
                {
                    $salary = ($employee->salary * $employee->work_hours) * (75 / 100);
                }
                break;
        }


        return $salary;
    }
}
