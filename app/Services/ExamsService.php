<?php

namespace App\Services;

use App\Models\Exams;

/**
 * Class ExamsService
 * @package App\Services
 */
class ExamsService
{
    private $request;
    private $exams;

    public function __construct($request)
    {
        $this->request = $request;
        $this->exams = Exams::where('status', '1');
    }

    public function getExams(){
        if($this->request->keyword !== ''){
            $this->exams->where(function($q){
                $q->where('title', 'like', "%{$this->request->keyword}%");
            });
        }
        return $this->exams->take($this->request->page * 20)->get();
    }


}
