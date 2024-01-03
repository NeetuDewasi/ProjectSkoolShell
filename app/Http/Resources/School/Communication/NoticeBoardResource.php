<?php

namespace App\Http\Resources\School\Communication;

use App\Http\Resources\School\Human_Resource\DepartmentDropDownResource;
use App\Models\Department;
use Illuminate\Http\Resources\Json\JsonResource;

class NoticeBoardResource extends JsonResource
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
        if($this->message_for){
            $message_for = explode(",", json_decode($this->message_for));
            if (count($message_for) > 0){
                $departments = Department::whereIn('id', $message_for)->get();
                $departments = DepartmentDropDownResource::collection($departments);
            }
        }
        return [
            'noticeBoard_id' => $this->id,
            'noticeBoard_title' => $this->title,
            'noticeBoard_description' => $this->description,
            'noticeBoard_notice_on' => $this->notice_on,
            'noticeBoard_publish_on' => $this->publish_on,
            'noticeBoard_message_for' => $this->message_for,
            'noticeBoard_status' => $this->status,
            'noticeBoard_department' => $departments
        ];
    }
}
