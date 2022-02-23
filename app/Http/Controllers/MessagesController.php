<?php

namespace App\Http\Controllers;

use App\Models\Messages;
use App\Models\TeacherEnroll;
use App\Services\MessagesService;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return (new MessagesService($request))->getMessages();
    }

    // get students

    public function getStudentsList(Request $request){
        if(auth()->user()->role_id == '1' || auth()->user()->role_id == '2'){
            return (new MessagesService($request))->getStudentList();
        }else if(auth()->user()->role_id == '3' ){
            return (new MessagesService($request))->getTeacherStudents();
        }
    }

    // get message count
    public function getMessageCount(Request $request){
        if(auth()->user()->role_id == '3' || auth()->user()->role_id == '4'){
            return Messages::where('to_id', auth()->user()->id)->where('unread_status', '1')->count();
        }

    }

    // reset new message
    public function resetMessages(Request $request){
        if( auth()->user()->role_id == '4'){
            $new_messages = Messages::where('to_id', auth()->user()->id)->where('unread_status', '1')->get();
            foreach($new_messages as $message){
                $message->unread_status = "0";
                $message->save();
            }
        }else if(auth()->user()->role_id == '3'){
            $new_messages = Messages::where('to_id', auth()->user()->id)->where('from_id', $request->student_id)->where('unread_status', '1')->get();
            foreach($new_messages as $message){
                $message->unread_status = "0";
                $message->save();
            }
        }
    }

    public function resetNewMessages(Request $request){
        if( auth()->user()->role_id == '4'){
            $new_messages = Messages::where('to_id', auth()->user()->id)->where('new_status', '1')->get();
            foreach($new_messages as $message){
                $message->new_status = "0";
                $message->save();
            }
        }else if(auth()->user()->role_id == '3'){
            $new_messages = Messages::where('to_id', auth()->user()->id)->where('from_id', $request->student_id)->where('new_status', '1')->get();
            foreach($new_messages as $message){
                $message->new_status = "0";
                $message->save();
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = new Messages();
        if(auth()->user()->role_id == '1' || auth()->user()->role_id == '2' || auth()->user()->role_id == '3'){
            $message->fill($request->all());
            $message->from_id = auth()->user()->id;
        }else if(auth()->user()->role_id == '4'){

            $teacher_enroll = TeacherEnroll::where('student_id', auth()->user()->id)->first();
            $message->message = $request->message;
            $message->to_id = $teacher_enroll->teacher_id;
            $message->from_id = auth()->user()->id;
        }

        $message->save();
        return response()->json(['msg'=>'messagesend successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
