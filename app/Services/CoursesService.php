<?php

namespace App\Services;

use App\Models\Courses;

/**
 * Class CoursesService
 * @package App\Services
 */
class CoursesService
{
    private $request;
    private $courses;

    public function __construct($request)
    {
        $this->request = $request;

        $this->courses = Courses::where('status', '1')->with('category');
    }

    public function getCourses(){
        if($this->request->keyword !== ''){
            $this->courses->where(function($q){
                $q->where('title', 'like', "%{$this->request->keyword}%");
            });
        }
        return $this->courses->take($this->request->page * 20)->get();
    }

    public function getAllCourses(){
        return $this->courses->get();
    }
}
