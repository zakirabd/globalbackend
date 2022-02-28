<?php

namespace App\Http\Controllers;

use App\Models\Exams;
use App\Models\StudentExams;
use App\Models\StudentInformation;
use App\Models\User;
use App\Services\UsersService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if(isset($request->query_type) && $request->query_type == 'company_students'){
            return (new UsersService($request))->getStudents();
        }else if(isset($request->query_type) && $request->query_type == 'company_all_teachers'){
            return (new UsersService($request))->getAllTeachers();
        }else if(isset($request->query_type) && $request->query_type == 'company_teachers'){
            return (new UsersService($request))->getTeachers();
        }else if(isset($request->query_type) && $request->query_type == 'company_managers'){
            return (new UsersService($request))->getManagers();
        }

    }

    // lock unlock student
    public function lockUnlockStudent(Request $request, $id){
        $user = User::findOrFail($id);
        $user->status = $request->status;
        $user->save();

        return response()->json(['msg' => 'User status changed successfully.']);
    }

    public function setPassword(Request $request){
        $user = User::findOrFail(auth()->user()->id);
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json(['msg' => 'Password Set Successfully.']);
    }

    // /////////////////////////
    public function loginAfterRegister(Request $request){
        $validator = validator($request->all(), [
            'email' => 'required|email',
            'phone_number' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->getMessageBag()->toarray()], 400);
        }
        try {

            $data = [
                'email' => $request->email,
                'phone_number' => $request->phone_number
            ];

            $user = User::where('email', $data['email'])->where('phone_number', $data['phone_number'])->first();
            if(!$user){
                return response([
                    'message' => 'Bad creds'
                ], 401);
            }

            $token = $user->createToken('token_name')->plainTextToken;

             $response = ['token' => $token, 'user' => $user];
            return response()->json($response);

        } catch (\Exception $e) {
            if ($e->getCode() === 400) {
                return response()->json('Invalid Request. Please enter username & password.', $e->getCode());
            } elseif ($e->getCode() === 401) {
                return response()->json('Invalid Credentials. Your credentials are incorrect. Please try again with valid credentials.', $e->getCode());
            } else {
                return response()->json('Something went wrong on the server.', $e->getCode());
            }
        }
    }

    // register as student
    public function registerStudent(Request $request){
        $user = new User();
        $check_user = User::where('email', $request->email)->where('student_status', '0')->first();

        if(isset($check_user)){
            $check_user->delete();
        }

        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->role_id = '4';
        $user->save();

        $token = $this->loginAfterRegister($request);

        $exams = Exams::with('exam_parent_question')->first();

        $student_exam = new StudentExams();
        $student_exam->student_id = $user->id;
        $student_exam->exam_id = $exams->id;
        $student_exam->over_all = '';
        $student_exam->point = '';
        $student_exam->status = '';
        $student_exam->submit = '0';
        $student_exam->save();
        return $token;
    }

    // register teacher


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    // get current user
    public function getCurrentUser(){
        return auth()->user();
    }


    public function addStudentPersonalInformation(Request $request){
        $info = StudentInformation::where('user_id', auth()->user()->id)->first();
        if(isset($info)){
            $user_info = $info;
        }else{
            $user_info = new StudentInformation();
        }
        $user_info->fill($request->all());
        $user_info->user_id = auth()->user()->id;
        $user_info->save();
        return response()->json(['msg'=> 'Profile updated successfully.']);

    }


    public function getStudentPersonalInformation(Request $request){
        $info = StudentInformation::where('user_id', auth()->user()->id)->first();
        if($request->type == 'weekly_schedule'){
            return $info->weekly_schedule;
        }else if($request->type == 'classes'){
            return $info->classes;
        }else if($request->type == 'class_start_date'){
            return $info->class_start_date;
        }else if($request->type == 'all'){
            return $info;
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User();

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        // if ($request->hasFile('image')) {

        //     $user->image = UploadHelper::imageUpload($request->file('image'), 'uploads');
        // }
        // $user->image = 'image';
        $user->role_id = $request->role_id;
        $user->city = $request->city;
        $user->country = $request->country;
        $user->date_of_birth = $request->date_of_birth;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(['msg' => 'User Created Successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::findOrFail($id);
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
        $user = User::findOrFail($id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        // if ($request->hasFile('image')) {

        //     $user->image = UploadHelper::imageUpload($request->file('image'), 'uploads');
        // }
        // $user->image = 'image';
        $user->role_id = $request->role_id;
        $user->city = $request->city;
        $user->country = $request->country;
        $user->date_of_birth = $request->date_of_birth;
        if($user->password != ""){
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return response()->json(['msg' => 'User Updated Successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(auth()->user()->role_id == '1'){
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json(["msg" => "User has been deleted successfully."]);
        }
    }
}
