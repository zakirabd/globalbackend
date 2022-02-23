<?php

namespace App\Services;

use App\Models\Messages;
use App\Models\TeacherEnroll;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * Class MessagesService
 * @package App\Services
 */
class MessagesService
{
    protected $messages;
    protected $request;


    public function __construct($request)
    {
        $this->request = $request;
        $this->messages = Messages::with('to_user')->with('from_user');
    }

    public function getMessages(){
        if(auth()->user()->role_id == '4'){
            return $this->messages->where('to_id', auth()->user()->id)
                                ->orWhere('from_id', auth()->user()->id)
                                ->orderBy('id', 'ASC')
                                ->get();
        }else{
            return $this->messages->where('to_id', $this->request->user_id)
                                ->orWhere('from_id', $this->request->user_id)
                                ->orderBy('id', 'ASC')
                                ->get();
        }


    }


    public function getStudentList(){
        $students = User::where('role_id', '4')->where('status', '1')->where('student_status', '1')->orderBy('id', 'DESC');

        if($this->request->keyword != ''){
            $students->where(function($q){
                $q->where(DB::raw("concat(first_name,' ',last_name)"), 'like', "%{$this->request->keyword}%")
                ->orwhere('email', 'like', "%{$this->request->keyword}%")
                ->orWhere('phone_number', 'like', "%{$this->request->keyword}%")
                ->orWhere('name', 'like', "%{$this->request->keyword}%")
                ->orWhere('country', 'like', "%{$this->request->keyword}%")
                ->orWhere('city', 'like', "%{$this->request->keyword}%");
            });
        }
        return response()->json(['students'=> $students->take($this->request->page * 20)->get(), 'page' => $students->count()]);
    }

    public function getTeacherStudents(){
        $teacher_enroll = TeacherEnroll::where('teacher_id', auth()->user()->id)->pluck('student_id');
        $students = User::whereIn('id', $teacher_enroll)->orderBy('id', 'DESC');

        if($this->request->keyword != ''){
            $students->where(function($q){
                $q->where(DB::raw("concat(first_name,' ',last_name)"), 'like', "%{$this->request->keyword}%")
                ->orwhere('email', 'like', "%{$this->request->keyword}%")
                ->orWhere('phone_number', 'like', "%{$this->request->keyword}%")
                ->orWhere('name', 'like', "%{$this->request->keyword}%")
                ->orWhere('country', 'like', "%{$this->request->keyword}%")
                ->orWhere('city', 'like', "%{$this->request->keyword}%");
            });
        }
        return response()->json(['students'=> $students->take($this->request->page * 20)->get(), 'page' => $students->count()]);
    }
}
