<?php

namespace App\Http\Resources\School\DownloadCenter;

use App\Http\Resources\School\Student\StudentAdmissionResource;
use App\Models\Admission;
use Illuminate\Http\Resources\Json\JsonResource;

class UploadContentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $students = null;
        if ($this->content_for) {
            $content_for = explode(",", json_decode($this->content_for));

            if (count($content_for) > 0) {
                $students = Admission::whereIn('id', $content_for)->get();
                $students = DownloadContentStudentResource::collection($students);
            }
        }
        $todayDate = date('Y-m-d');
        $is_publish = false;
        if ($this->published_at != null && $this->published_at <= $todayDate) {
            $is_publish = true;
            $this->update(['status' => 'published']);
        }

        return [
            'upload_content_id' => $this->id,
            'upload_user_id' => $this->user_id,
            'upload_school_class_id' => $this->school_class_id,
            'upload_school_class' => $this->schoolClass != null ? $this->schoolClass->name : null,
            'upload_school_section_id' => $this->school_section_id,
            'upload_school_section' => $this->schoolSection != null ? $this->schoolSection->name : null,
            'upload_content_type' => $this->content_type,
            'upload_title' => $this->title,
            'upload_students' => $students,
            'is_publish' => $is_publish,
            'upload_published_at' => $this->published_at,
            'upload_description' => $this->description,
            'upload_documents' => json_decode($this->documents),
            'upload_status' => $this->status
        ];
    }
}
