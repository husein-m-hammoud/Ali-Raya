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
    // {  $AudioName=$request['AudioName'];

    //    if( $files = $request->file('file')){


        // dd($files);
        // $destinationPath = 'All_Audioaliii/'; // upload path
            //   $profileImage = "hussein" ;
            // $files->move($destinationPath, $profileImage);
            // Storage::put('audio/'.$AudioName.'.wav', $files);
    // }
    // else {return  "koll 5ara ";}
        // $x=file_get_contents("https://homepages.cae.wisc.edu/~ece533/images/airplane.png");
        // dd($x);
        // $x=shell_exec('sox C:\Users\Hussein\Desktop\hussein.wav  C:\wamp64\www\Ali-Raya\public\alii.wav trim 2 0.195');
        // echo $x,"ss";
        // $blobInput = $request->file('audio-blob');
        // $url="Blob {size: 1281461, type: 'audio/mpeg'}";
        // $url = "blob:http://127.0.0.1:8000/04a222af-69fd-4dc8-9f37-661e443d3f1c";
        //save the wav file to 'storage/app/audio' path with fileanme test.wav




        // file_put_contents($img, file_get_contents($url));
        //  $File->move($img, file_get_contents($url));
        // $path = 'https://i.stack.imgur.com/koFpQ.png';
        //     $filename = basename($path);

        // Image::make($path)->save(public_path('images/' . $filename));
    }
}
