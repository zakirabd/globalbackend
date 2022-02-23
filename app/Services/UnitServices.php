<?php

namespace App\Services;

use App\Models\Units;

/**
 * Class UnitServices
 * @package App\Services
 */
class UnitServices
{
    private $request;
    private $units;

    public function __construct($request)
    {
        $this->request = $request;

        $this->units = Units::where('status', '1')->with('course');
    }

    public function getUnits(){
        if($this->request->keyword !== ''){
            $this->units->where(function($q){
                $q->where('title', 'like', "%{$this->request->keyword}%");
            });
        }
        return $this->units->take($this->request->page * 20)->get();
    }

    public function getAllUnits(){
        return $this->units->get();
    }
}
