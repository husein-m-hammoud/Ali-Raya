
<div class="loader-wrapper">
    <span class="loader"><span class="loader-inner"></span></span>
</div>
<head>
<link href="{{ asset('css/foraudio.css') }}" rel="stylesheet" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="http://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<!-- <script src="//vjs.zencdn.net/7.3.0/video.min.js"></script> -->
<script src="https://unpkg.com/wavesurfer.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://unpkg.com/wavesurfer.js/dist/plugin/wavesurfer.regions.min.js"></script>

    <script>
        Mp3LameEncoderConfig = {
            memoryInitializerPrefixURL: "Mp3Lame/"
        };
    </script>
    <script src="Mp3Lame/Mp3LameEncoder.min.js"></script>
    <script type="module" src="{{ asset('js/worker.js') }}"></script>
    <script
        type="module"
        src="{{ asset('js/audio-helper.js') }}"
    ></script>
    <script type="module" src="{{ asset('js/utils.js') }}"></script>
    <script
        type="module"
        src="{{ asset('js/worker-client.js') }}"
    ></script>
    <script
        src="{{ asset('./dist/worker.js') }}"
        type="text/js-worker"
        x-audio-encode
    ></script>
    <link
        rel="stylesheet"
        href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
        crossorigin="anonymous"
    />

    <script>

    var xhr = new XMLHttpRequest();
    var file = "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css";
    var randomNum = Math.round(Math.random() * 10000);

    xhr.open('HEAD', file + "?rand=" + randomNum, true);
    xhr.send();

    xhr.addEventListener("readystatechange", processRequest, false);

    function processRequest(e) {
      if (xhr.readyState == 4) {
        if (xhr.status >= 200 && xhr.status < 304) {
            $(".loader-wrapper").fadeOut("slow");

        } else {
          alert("connection doesn't exist!");
        }
      }
    }
    </script>
</head>

<body >

<div class="container" style="margin-top: 50px;">
    <div class="waveform-container"><div id="waveform"></div></div>
    <div class="record-container"><div>Recording...</div></div>
    <audio id="forRecord" class="video-js vjs-default-skin"></audio>

    <div style="text-align: center" class="buttons">


        <p class="row">
        <button id="start-btn" class="btn btn-primary"  >
                <i class="glyphicon glyphicon-record"></i>
                Start Recording
            </button>
            <button id="stop-btn" disabled class="btn btn-primary" >
                <i class="glyphicon glyphicon-play"></i>
                Stop recording
            </button>
            <button class="btn btn-primary" id="playRegion" disabled="true">
                <i class="glyphicon glyphicon-play"></i>
                Play Selected
            </button>
            <button class="btn btn-primary" id="stop" disabled="true">
                <i class="glyphicon glyphicon-stop"></i>
                Stop
            </button>

            <button class="btn btn-primary trim-left" id="trim" disabled="true">
                <i id="trim_icon" class="glyphicon glyphicon-scissors"></i>
                Trim
            </button>

            <button
                class="btn btn-primary trim-left"
                id="reload"
                disabled="true"
            >
                <i class="glyphicon glyphicon-refresh"></i>
                reload
            </button>

            <button
                class="btn btn-primary trim-left"
                id="download"
                disabled="true"
            >
                <i id="download-icon" class="glyphicon glyphicon-cloud-upload"></i>
                Upload
            </button>
        </p>
    </div>
    <div id="app"></div>
    <section>
        <form
            id="upload"
            action="upload.php"
            method="POST"
            enctype="multipart/form-data"
        >
            <fieldset>
                <input
                    type="hidden"
                    id="MAX_FILE_SIZE"
                    name="MAX_FILE_SIZE"
                    value="300000"
                />

                <div>
                    <div class="fileUpload">
                        <input
                            type="file"
                            class="upload"
                            id="fileselect"
                            name="fileselect[]"
                            multiple="multiple"
                        />
                        <span >Upload Audio</span>
                    </div>

                    <div id="filedrag">
                        Or Drop
                        <i class="glyphicon glyphicon-music"></i>
                        Adudio File Here
                    </div>
                </div>

                <div id="submitbutton">
                    <button type="submit">Upload Files</button>
                </div>
            </fieldset>
        </form>

        <div id="messages"></div>
    </section>
</div>
<br><br><br>
</body>


        <script type="module">
            import { sliceAudioBuffer } from "/js/audio-helper.js";

            import { encode } from "/js/worker-client.js";
            import {

                readBlobURL,
                download,
                rename
            } from "/js/utils.js";

            let btn_download = document.getElementById("download");

            let btn_playRegion = document.getElementById("playRegion");
            let btn_stop = document.getElementById("stop");
            let btn_trim = document.getElementById("trim");
            let btn_reload = document.getElementById("reload");
            var file = document.getElementById("fileselect");


            let regions = WaveSurfer.regions.create({
                regions: [],
                dragSelection: false,
                slop: 10
            });

            let wavesurfer = WaveSurfer.create({
                container: "#waveform",
                waveColor: "#46a6d8",
                progressColor: "#FFF",
                barWidth: 3,
                barGap: 2,
                height: 130,
                cursorWidth: 1,
                cursorColor: "white",
                //pixelRatio: 1,
                //scrollParent: true,
                sampleRate:20000,
                responsive: 1000,
                normalize: true,
                //minimap: true,
                plugins: [regions]
                //  maxCanvasWidth: 100
            });

            wavesurfer.on("ready", () => {
                wavesurfer.regions.clear();
                wavesurfer.regions.add({
                    start: 0,
                    end:
                        wavesurfer.getDuration() -
                        wavesurfer.getDuration() / 60,
                    color: "hsla(200, 50%, 70%, 0.3)"
                });
            });


            btn_trim.addEventListener("click", async function() {





                btn_stop.click();
                btn_stop.disabled=true;

                // I had to fixed to two decimal if I don't do this not work, I don't know whyyy
                const start = wavesurfer.regions.list[
                    Object.keys(wavesurfer.regions.list)[0]
                ].start.toFixed(2);
                const end = wavesurfer.regions.list[
                    Object.keys(wavesurfer.regions.list)[0]
                ].end.toFixed(2);
                if ((end-start)>30)
                {
                    console.log("is bigger than 30");
                    return
                }
                const originalBuffer = wavesurfer.backend.buffer;
                console.log(
                    end,
                    start,
                    end,
                    start,
                    originalBuffer,
                    (end - start) * (originalBuffer.sampleRate * 1)
                );
                var emptySegment = wavesurfer.backend.ac.createBuffer(
                    originalBuffer.numberOfChannels,
                    //segment duration
                    (end - start) * (originalBuffer.sampleRate * 1),
                    originalBuffer.sampleRate
                );

                for (var i = 0; i < originalBuffer.numberOfChannels; i++) {
                    var chanData = originalBuffer.getChannelData(i);
                    var segmentChanData = emptySegment.getChannelData(i);
                    for (
                        var j = 0, len = chanData.length;
                        j < end * originalBuffer.sampleRate;
                        j++
                    ) {
                        segmentChanData[j] =
                            chanData[j + start * originalBuffer.sampleRate];
                    }
                }

                wavesurfer.loadDecodedBuffer(emptySegment); // Here you go!



            });



            btn_stop.addEventListener("click", function() {
                console.log(file.files[0]);
                wavesurfer.stop();
            });
            btn_playRegion.addEventListener("click", function() {
                btn_stop.disabled = false;




                wavesurfer.regions.list[
                    Object.keys(wavesurfer.regions.list)[0]
                ].play();


            });
            function FileListItem(a) {
                a = [].slice.call(Array.isArray(a) ? a : arguments)
                for (var c, b = c = a.length, d = !0; b-- && d;) d = a[b] instanceof File
                if (!d) throw new TypeError("expected argument to FileList is File or array of File objects")
                for (b = (new ClipboardEvent("")).clipboardData || new DataTransfer; c--;) b.items.add(a[c])
                return b.files
                }

            btn_download.addEventListener("click", async function() {
                // I had to fixed to two decimal if I don't do this not work, I don't know whyyy
                const start = wavesurfer.regions.list[
                    Object.keys(wavesurfer.regions.list)[0]
                ].start.toFixed(2);
                const end = wavesurfer.regions.list[
                    Object.keys(wavesurfer.regions.list)[0]
                ].end.toFixed(2);
                const originalBuffer = wavesurfer.backend.buffer;
                console.log(
                    end,
                    start,
                    end,
                    start,
                    originalBuffer,
                    (end - start) * (originalBuffer.sampleRate * 1)
                );
                var emptySegment = wavesurfer.backend.ac.createBuffer(
                    originalBuffer.numberOfChannels,
                    //segment duration
                    (end - start) * (20000 * 1),
                    20000
                );

                for (var i = 0; i < originalBuffer.numberOfChannels; i++) {
                    var chanData = originalBuffer.getChannelData(i);
                    var segmentChanData = emptySegment.getChannelData(i);
                    for (
                        var j = 0, len = chanData.length;
                        j < end * 20000;
                        j++
                    ) {
                        segmentChanData[j] =
                            chanData[j + start * 20000];
                    }
                }
                const type = "wav";

                const { length, duration } = emptySegment;

                const audioSliced = sliceAudioBuffer(
                    emptySegment,
                    ~~((length * start) / duration),
                    ~~((length * end) / duration)
                );

                encode(audioSliced, type).then(res=>{send(res)})

                    .catch(e => console.error(e));

                console.log("download-file");
            });
            btn_reload.addEventListener("click", function() {
                var file = document.getElementById("fileselect");
                var value=document.getElementById("fileselect").Value;
                if(value){
                wavesurfer.loadBlob(value);
                }
                else{
                    wavesurfer.loadBlob(file.files[0]);
                }
                setTimeout(() => {}, 1200);
                btn_playRegion.disabled = false;
                btn_download.disabled = false;

                btn_trim.disabled = false;
            });

        </script>
        <script src="{{ asset('js/Dragover.js') }}"></script>
        <script defer >


//
           function goto(){
            // const link = document.createElement("a");

            //     link.href = "/test";

            //     link.click();
            //     }
           }
            function send(blob){

                var fd =  new FormData();

                fd.append('file', blob);
            //

                fd.append("_token", "{{ csrf_token() }}");

               $.ajax({url:"/test-php",
                    method:"POST",
                    data:fd,
                    dataType:'JSON',
                    contentType: false,
                    cache: false,
                    processData: false

               ,success : function(data) {
                  console.log(data)
                },
                error : function(request,error)
                {
                    // alert("Request: "+JSON.stringify(request));
                }
                    });
                }



        </script>
        <script>

    var xhr = new XMLHttpRequest();
    var file = "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css";
    var randomNum = Math.round(Math.random() * 10000);

    xhr.open('HEAD', file + "?rand=" + randomNum, true);
    xhr.send();

    xhr.addEventListener("readystatechange", processRequest, false);

    function processRequest(e) {
      if (xhr.readyState == 4) {
        if (xhr.status >= 200 && xhr.status < 304) {

            $(".loader-wrapper").fadeOut("slow");

        } else {
          alert("connection doesn't exist!");
        }
      }
    }
    </script>
      <script src="js/recorderr.js"></script>
      <script src="{{ asset('js/Recorder.js') }}">


</script>
    </div>
</div>


