
@extends('layouts.app2')

@section('content')

<head>
<link href="{{ asset('css/Plyr.css') }}" rel="stylesheet">
<script src="https://cdn.plyr.io/3.6.2/plyr.js"></script>
<script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
<script src="https://cdn.plyr.io/3.6.2/plyr.polyfilled.js"></script>

<!-- <link rel="stylesheet" href="https://cdn.plyr.io/3.6.2/plyr.css" /> -->

<link href="{{ asset('css/audioview.css') }}" rel="stylesheet">
</head>



<br>
<audio controls  id='audio'>

                   <source id ='source' src="{{asset('All_Audio/hussein/20200619093214.wav')}}" type="audio/wav">
                   <source id ='source' src="{{asset('All_Audio/hussein/20200619093441.wav')}}" type="audio/wav">
                         Your browser dose not Support the audio Tag
                     </audio>



     <div class="container">
    <div class="column add-bottom">
        <div id="mainwrap">
            <div id="nowPlay">
                <span id="npAction">Paused...</span><span id="npTitle"></span>
            </div>
            <div id="audiowrap">
                <div id="audio0">
                    <audio id="audio1" preload controls>Your browser does not support HTML5 Audio! 😢</audio>
                </div>
                <div id="tracks">
                    <a id="btnPrev">&vltri;</a><a id="btnNext">&vrtri;</a>
                </div>
            </div>
            <div id="plwrap">
                <ul id="plList"></ul>
            </div>
        </div>
    </div>
    <a href="" >
        <div class="Add ">
        <img src="/Images/Addaudio.png" alt="ADD" height=50 width=50 >
        </div>

    </a>
</div>
<input id='authname'type="hidden" value="{{$authname}}">

<script>
// let audio = document.getElementById("div");
let source = document.getElementById("source");
var allAudio = <?php echo $allAudio; ?>;
// console.log(audio.innerHTML);
var array=[];
        for(let i=0;i<allAudio.length;i++)
        {

            let a={"track":i+1,"name":allAudio[i]['audioname'],"duration": "5:01","file":allAudio[i]['audiofile']}

            array.push(a);
        }
        console.log(array);
jQuery(function ($) {
    'use strict'
    var supportsAudio = !!document.createElement('audio').canPlayType;
    if (supportsAudio) {
        // initialize plyr
        var player = new Plyr('#audio1', {
            controls: [
                'restart',
                'play',
                'progress',
                'current-time',
                'duration',
                'mute',
                'volume',
                'download'
            ]
        });



        var authname =document.getElementById("authname").value;

            console.log(allAudio);
        // @foreach($allAudio as $allAudioa)

        // {{$allAudioa}}

        // @endforeach


        // initialize playlist and controls
        var index = 0,
            playing = false,
            mediaPath = 'https://archive.org/download/mythium/',
            extension = '',
            tracks = array,
            buildPlaylist = $.each(tracks, function(key, value) {
                var trackNumber = value.track,
                    trackName = value.name,
                    trackDuration = value.duration;
                if (trackNumber.toString().length === 1) {
                    trackNumber = '0' + trackNumber;
                }
                console.log(tracks);
                $('#plList').append('<li> \
                    <div class="plItem"> \
                        <span class="plNum">' + trackNumber + '.</span> \
                        <span class="plTitle">' + trackName + '</span> \
                        <span class="plLength">' + trackDuration + '</span> \
                    </div> \
                </li>');
            }),
            trackCount = tracks.length,
            npAction = $('#npAction'),
            npTitle = $('#npTitle'),
            audio = $('#audio1').on('play', function () {
                playing = true;
                npAction.text('Now Playing...');
            }).on('pause', function () {
                playing = false;
                npAction.text('Paused...');
            }).on('ended', function () {
                npAction.text('Paused...');
                if ((index + 1) < trackCount) {
                    index++;
                    loadTrack(index);
                    audio.play();
                } else {
                    audio.pause();
                    index = 0;
                    loadTrack(index);
                }
            }).get(0),
            btnPrev = $('#btnPrev').on('click', function () {
                if ((index - 1) > -1) {
                    index--;
                    loadTrack(index);
                    if (playing) {
                        audio.play();
                    }
                } else {
                    audio.pause();
                    index = 0;
                    loadTrack(index);
                }
            }),
            btnNext = $('#btnNext').on('click', function () {
                if ((index + 1) < trackCount) {
                    index++;
                    loadTrack(index);
                    if (playing) {
                        audio.play();
                    }
                } else {
                    audio.pause();
                    index = 0;
                    loadTrack(index);
                }
            }),
            li = $('#plList li').on('click', function () {
                var id = parseInt($(this).index());
                if (id !== index) {
                    playTrack(id);
                }
            }),
            loadTrack = function (id) {
                $('.plSel').removeClass('plSel');
                $('#plList li:eq(' + id + ')').addClass('plSel');
                npTitle.text(tracks[id].name);
                index = id;
                audio.src = 'All_Audio/'+authname+'/'+ tracks[id].file;
                updateDownload(id, audio.src);
            },
            updateDownload = function (id, source) {
                player.on('loadedmetadata', function () {
                    $('a[data-plyr="download"]').attr('href', source);
                });
            },
            playTrack = function (id) {
                loadTrack(id);
                audio.play();
            };
        extension = audio.canPlayType('audio/mpeg') ? '.mp3' : audio.canPlayType('audio/ogg') ? '.ogg' : '';
        loadTrack(index);
    } else {
        // no audio support
        $('.column').addClass('hidden');
        var noSupport = $('#audio1').text();
        $('.container').append('<p class="no-support">' + noSupport + '</p>');
    }
});

</script>

@endsection
