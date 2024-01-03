<?php

namespace App\Http\Resources\School\Homework;

use App\Http\Resources\School\Common\ClassListResource;
use App\Http\Resources\School\Common\SectionListResource;
use App\Http\Resources\School\DownloadCenter\DownloadContentStudentResource;
use App\Models\Admission;
use App\Models\HomeWork;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeworkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $studentList = null;
        $documentList = null;
         $students = [];
        if ($this->homework_for) {
            $homework_for =  array();
            foreach (json_decode($this->homework_for) as $key => $value) {
                array_push($homework_for, $value->admission_id);
            }
            if (count($homework_for) > 0) {
                $students = Admission::whereIn('id', $homework_for)->get();
            }

            foreach ($students as $key => $value) {
                foreach($homework_for as $k => $v) {
                    if($value->id == $v) {
                        $students[$key]->evaluation_date = json_decode($this->homework_for)[$k]->evaluation_date;
                    }
                }
            }
            $studentList = DownloadContentStudentResource::collection($students);
        }

        // if ($this->homework_document) {
        //     $homework_document = array();
        //     foreach (json_decode($this->homework_document) as $key => $value)
        //     {
        //         array_push($homework_document, $value->homework_id);
        //     }
        //     if (count($homework_document) > 0) {
        //         $documents = HomeWork::whereIn('id', $homework_document)->get();
        //     }
        // }

        // $todayDate = date('Y-m-d');
        // $is_published = false;
        // if($this->issuing_date != null && $this->issuing_date == $todayDate){
        //     $is_published = true;
        //     $this->update(['status' => 'published']);
        // }

        return [
            'homework_id' => $this->id,
            'homework_class_id' => new ClassListResource($this->schoolClass),
            'homework_section_id' => new SectionListResource($this->schoolSection),
            'homework_subject_id' => new SubjectDropDownResource($this->subject),
            'homework_issue_date' => $this->issuing_date,
            'homework_submission_date' => $this->submission_date,
            'homework_document' => json_decode($this->document),
            'homework_description' => $this->description,
            'homework_evaluation_date' => $this->evaluation_date,
            'homework_status' => $this->status,
            'homework_title' => $this->title,
            'homework_for' => $studentList,
            // 'is_published' => $is_published,
        ];
    }
}
