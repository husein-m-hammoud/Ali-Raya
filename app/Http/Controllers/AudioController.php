<?php

namespace App\Http\Controllers;

use App\Audio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AudioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function AudioCutter()
    {
        return view("AudioCutter");
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
// return $request;
$validator = Validator::make($request->all(), [
    'file' => 'max:500000',
    'file' =>'nullable|file|mimes:wav,audio/mpeg,mpga,mp3,aac'
]);
        // $this->Validate($request,[
        //     'file'=>'max:50000', //50MB
        //     // 'file' => 'required|mimes:audio/mp3',
        //     // //
        //     // 'file' => 'required|mimes:wav',
        //     //
        //
        // ]);
            // $my_blob= $request['file'];
            // $destinationPath = 'All_Audio0/'; // upload path
            // $my_blob->move($destinationPath, 'first');
            //  file_put_contents("C:\Users\Hussein\Desktop\Ali-Raya\public", $my_blob);
        $Audio = new Audio();
        if ($files = $request->file('file'))  {
            dd($files);
            $destinationPath = 'All_Audio0/'; // upload path
            $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
            // $files->move($destinationPath, $profileImage);
            Storage::put('audio/'.$destinationPath.'/'.$profileImage, $files);
            $Audio->audioname= "kill" ;
         }
        // $Audio->audioname= $request['file'] ;
         $Audio->UserId=2;
         $Audio->save();
         return view('welcome');
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
    public function destroy(Audio $audio)
    {
        //
    }
    public function test(Request $request)
    {
       if( $files = $request->file('file')){


        // dd($files);
        // $destinationPath = 'All_Audioaliii/'; // upload path
            //   $profileImage = "hussein" ;
            // $files->move($destinationPath, $profileImage);
            Storage::put('audio/hussein.mp3', $files);
    }
    else {return  "koll 5ara ";}
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
