<?php

namespace App\Services;

use App\Models\Lessons;

/**
 * Class LessonsService
 * @package App\Services
 */
class LessonsService
{
    private $request;
    private $lessons;

    public function __construct($request)
    {
        $this->request = $request;

        $this->lessons = Lessons::where('status', '1')->with('unit');
    }

    public function getLessons(){
        if($this->request->keyword !== ''){
            $this->lessons->where(function($q){
                $q->where('title', 'like', "%{$this->request->keyword}%");
            });
        }
        return $this->lessons->take($this->request->page * 20)->get();
    }

    public function getAllLessons(){
        return $this->lessons->get();
    }
}
