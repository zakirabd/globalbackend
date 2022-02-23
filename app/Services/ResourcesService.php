<?php

namespace App\Services;

use App\Models\Resources;

/**
 * Class ResourcesService
 * @package App\Services
 */
class ResourcesService
{
    private $request;
    private $resources;

    public function __construct($request)
    {
        $this->request = $request;

        $this->resources = Resources::where('status', '1');
    }

    public function getResources(){
        if($this->request->keyword !== ''){
            $this->resources->where(function($q){
                $q->where('title', 'like', "%{$this->request->keyword}%");
            });
        }
        return $this->resources->take($this->request->page * 20)->get();
    }

    public function getAllResources(){
        return $this->resources->get();
    }
}
