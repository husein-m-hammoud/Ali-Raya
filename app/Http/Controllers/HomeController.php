<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;
use DB;
use File;
use App\User;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $this->middleware('auth');
        if(Auth::user()->Type==1)
        {
        $Users = DB::table('users')->where('Type', 2)->get();

        return view('homepage',['Users'=>$Users]);
        }
        return view('UserPage');

    }
    public function register()
    {

        $data['title'] = '404';
        $data['name'] = 'Page not found';
        return response()
            ->view('errors.404',$data,404);
    }
    public function registerId()
    {


        return view('auth/register');

    }
    public function showpassword(){
        return view('ChangePassword');
    }
    public function changePassword(Request $request){

        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        return redirect()->back()->with("success","Password changed successfully !");

    }
    public function deleteUser($id){
        // $user= DB::table('users')->where('id', $id)->get();

        $file = DB::table('users')->where('id', $id)->first();
        $name=$file->name;

        $filename = "All_Audio/".$name."_".$id;

        if(File::exists($filename)) {
            File::deleteDirectory($filename);
        }
         $user = DB::table('users')->where('id', $id)->delete();
         return redirect()->back();
    }
    public function edit($id){
        $user = DB::table('users')->where('id', $id)->first();
        return view("edit",['user'=>$user]);
    }
    public function update(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],

            'Type'=>['required', 'string', 'max:2'],
            'Phone'=>['required', 'integer', 'digits_between:4,25'],
            'Address'=>['required', 'string', 'max:255'],


        ]);
        USer::where('id', $id)

          ->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'Type'=>$request['Type'],
            'Phone'=>$request['Phone'],
            'Address'=>$request['Address'],
            'ExtensionNumber'=>$request['ExtensionNumber'],
        ]);

        return redirect()->route("home")->with("success","USer changed successfully !");

    }
    public function rest($id){
        $rand="123456789";
        USer::where('id', $id)

        ->update(['password'=>bcrypt($rand)]);
        return redirect()->route("home")->with("success","USer changed successfully !");
    }
    public function block($id){
        $rand=rand(10000000,99999999999);
        USer::where('id', $id)

          ->update(['password'=>bcrypt($rand)]);
        // $user = DB::table('users')->where('id', $id)->first();
        // $user->password = bcrypt($rand);
        // $user->save();
        return redirect()->route("home")->with("success","USer changed successfully !");
    }

}
