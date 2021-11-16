<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Services\EmployeeService;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=> $this->id,
            'first_name'=> $this->first_name,
            'last_name' => $this->last_name,
            'phone'=>$this->phone,
            'email' =>  $this->email,
            'work_hours' => $this->work_hours,
            'salary_type' => $this->salary_type,
            'salary' => $this->salary,
            'total_salary' => $this->calculateSalary($this->id),
            'department_id' => $this->department_id,
            'department_name' => optional($this->department)->name,
        ];
    }

    public function calculateSalary($id) {
        $service = new EmployeeService();

        return $service->calculateSalary($id);
    }
}
