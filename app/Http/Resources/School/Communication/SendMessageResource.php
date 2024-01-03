<?php

namespace App\Http\Resources\School\Communication;

use App\Http\Resources\School\Academics\SchoolClassResource;
use App\Http\Resources\School\Human_Resource\DepartmentResource;
use App\Http\Resources\School\Human_Resource\EmployeeResource;
use App\Http\Resources\School\Student\StudentAdmissionResource;
use App\Models\Admission;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Message;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class SendMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $departments = null;
        $employeeDepartmente = null;
        $employees = null;
        $class = null;
        $student = null;
        $students = null;
        if ($this->receiver_ids) {
            $receiver_ids = explode(",", json_decode($this->receiver_ids));
            if ($this->message_for == 'individuals') {
                $employeeDepartmente = Employee::where('id', $receiver_ids[0])->first();
                $employees =  Employee::whereIn('id', $receiver_ids)->allowed()->get();
            } else if ($this->message_for == 'parents') {
                // $student = Admission::where('id', $receiver_ids[0])->first();
                $students = Admission::whereIn('id', $receiver_ids)->allowed()->get();
                // $class = SchoolClassResource::whereIn('id', $receiver_ids)->allowed()->get();
            } else {
                $departments = Department::whereIn('id', $receiver_ids)->get();
            }
        }
        return [
            'message_id' => $this->id,
            'message_school_id' => $this->school_id,
            'message_user_id' => $this->user_id,
            'message_title' => $this->title,
            'message_email' => $this->email,
            'message_sms' => $this->sms,
            'message_content' => $this->content,
            'message_message_for' => $this->message_for,
            'message_receiver_ids' => $receiver_ids,
            'message_status' => $this->status,
            'employee_department' => $employeeDepartmente != null ? $employeeDepartmente->department_id : "",
            'departments' => $departments != null ? DepartmentResource::collection($departments) : '',
            'employees' => $employees != null ? EmployeeResource::collection($employees) : '',
            'student' => $student != null ? $student->student_admission_id : "",
            'student_list' => $students != null ? StudentAdmissionResource::collection($students) : '',
            'class_list' => $class != null ? SchoolClassResource::collection($class) : '',
        ];
    }
}
