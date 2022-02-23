<?php

namespace App\Services;

use App\Models\TeacherEnroll;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * Class UsersService
 * @package App\Services
 */
class UsersService
{
    private $request;
    private $users;
    private $teacher_enroll;

    public function __construct($request)
    {
        $this->request = $request;
        $this->users = User::query();

        if(auth()->user()->role_id == '3'){
            $this->teacher_enroll = TeacherEnroll::where('teacher_id', auth()->user()->id)->pluck('student_id');
        }
    }

    public function getStudents(){
        if(auth()->user()->role_id == '3'){
            $this->users->whereIn('id', $this->teacher_enroll)->with('teacher');
        }else{
            $this->users->where('role_id', '4')->with('teacher')->where('student_status', $this->request->student_status);
        }
        if($this->request->keyword !== ''){
            $this->users->where(function($q){
                $q->where(DB::raw("concat(first_name,' ',last_name)"), 'like', "%{$this->request->keyword}%")
                ->orwhere('email', 'like', "%{$this->request->keyword}%")
                ->orWhere('phone_number', 'like', "%{$this->request->keyword}%")
                ->orWhere('name', 'like', "%{$this->request->keyword}%")
                ->orWhere('country', 'like', "%{$this->request->keyword}%")
                ->orWhere('city', 'like', "%{$this->request->keyword}%");
            });
        }
        return $this->users->take($this->request->page * 20)->get();
    }

    public function getAllTeachers(){
        return $this->users->where('role_id', '3')->orderBy('id', 'DESC')->get();
    }


    public function getTeachers(){
        $this->users->where('role_id', '3');
        if($this->request->keyword !== ''){
            $this->users->where(function($q){
                $q->where(DB::raw("concat(first_name,' ',last_name)"), 'like', "%{$this->request->keyword}%")
                ->orwhere('email', 'like', "%{$this->request->keyword}%")
                ->orWhere('phone_number', 'like', "%{$this->request->keyword}%")
                ->orWhere('name', 'like', "%{$this->request->keyword}%")
                ->orWhere('country', 'like', "%{$this->request->keyword}%")
                ->orWhere('city', 'like', "%{$this->request->keyword}%");
            });
        }
        return $this->users->take($this->request->page * 20)->get();
    }

    public function getManagers(){
        $this->users->where('role_id', '2');
        if($this->request->keyword !== ''){
            $this->users->where(function($q){
                $q->where(DB::raw("concat(first_name,' ',last_name)"), 'like', "%{$this->request->keyword}%")
                ->orwhere('email', 'like', "%{$this->request->keyword}%")
                ->orWhere('phone_number', 'like', "%{$this->request->keyword}%")
                ->orWhere('name', 'like', "%{$this->request->keyword}%")
                ->orWhere('country', 'like', "%{$this->request->keyword}%")
                ->orWhere('city', 'like', "%{$this->request->keyword}%");
            });
        }
        return $this->users->take($this->request->page * 20)->get();
    }
}
