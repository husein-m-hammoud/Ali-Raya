<?php

namespace App\Http\Controllers;

use App\Audio;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use DB;
use File;


class AudioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $allAudio = Audio::where('UserID',Auth::user()->id)->get();
        $authname=Auth::user()->name;
        $authid=Auth::user()->id;

        return view("Audio",['allAudio'=>$allAudio,'authname'=>$authname,'authid'=>$authid]);
    }
    public function indexAdd(){
            return view("AddAudio");
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function useraudio($id)
    {
        $allAudio = Audio::where('UserID',$id)->get();
        $user = DB::table('users')->where('id', $id)->first();
        $authname=$user->name;
        $authid=$id;

        return  view("Audio",['allAudio'=>$allAudio,'authname'=>$authname,'authid'=>$authid]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

$validator = Validator::make($request->all(), [
    'audiofile' => 'max:500000',
    'audiofile' =>'nullable|file|mimes:wav,audio/mpeg,mpga,mp3,aac',
    'audioname' => 'required|max:255',
]);

        $Audio = new Audio();
        if ($files = $request->file('audiofile'))  {

            $destinationPath = 'All_Audio/'.Auth::user()->name."_".Auth::user()->id; // upload path
            $profileImage = date('YmdHis') . "." . 'wav';
            $files->move($destinationPath, $profileImage);
            // Storage::put('audio/'.$destinationPath.'/'.$profileImage, $files);
            $Audio->audiofile= $profileImage ;
         }
         $duration=gmdate("i:s", $request['duration']);

         $Audio->UserId=Auth::user()->id;
         $Audio->duration=$duration;
         $Audio->audioname=$request['audioname'];
         $Audio->save();
         return $Audio;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Audio  $audio
     * @return \Illuminate\Http\Response
     */
    public function show(Audio $audio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Audio  $audio
     * @return \Illuminate\Http\Response
     */
    public function edit(Audio $audio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Audio  $audio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Audio $audio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Audio  $audio
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $file = DB::table('audio')->where('id', $id)->first();
        $test=$file->audiofile;

        $filename = "All_Audio/".Auth::user()->name."_".Auth::user()->id."/".$test;

        if(File::exists($filename)) {
            File::delete($filename);
        }

        DB::table('audio')->where('id',$id)->delete();
        return redirect()->route('Audio');

    }
    public function test(Request $request)
    {
        // $myfile = fopen("c:/Users/Hussein/Desktop/test.txt", "w") or die("Unable to open file!");
        // fwrite($myfile,"hhhhhhh");
        //     fclose($myfile);


            // $fp = fopen("c:/Users/Hussein/Desktop/test.txt", 'a');
            // fwrite($fp, " this is additional text \r\n");
            // fwrite($fp, 'appending data');
            // fclose($fp);

            // $output = str_replace($var ."\r\n", "", $input ."\r\n");
            $path="c:/Users/Hussein/Desktop/test.txt";
            $fn = fopen($path,"r");
            $content = file_get_contents($path);
            while(! feof($fn))  {
              $result = fgets($fn);
              if(strpos($result,'text')){
                // str_replace($request,"", "" );
                $content=str_replace($result, '', $content);
              }
              echo '<br>'.$result;

            }

            fclose($fn);
            file_put_contents($path, $content);

    }
}
