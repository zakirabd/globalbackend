<?php

namespace App\Services;

use App\Models\Categories;

/**
 * Class CategoriesService
 * @package App\Services
 */
class CategoriesService
{
    private $request;
    private $categories;

    public function __construct($request)
    {
        $this->request = $request;

        $this->categories = Categories::where('status', '1');
    }

    public function getCategories(){
        if($this->request->keyword !== ''){
            $this->categories->where(function($q){
                $q->where('title', 'like', "%{$this->request->keyword}%");
            });
        }
        return $this->categories->take($this->request->page * 20)->get();
    }

    public function getAllCategories(){
        return $this->categories->get();
    }

    public function getCategoriesWithClass(){
        return $this->categories->with('courses')->take(4)->get();
    }
}
