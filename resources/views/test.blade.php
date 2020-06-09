<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <title>Collapsible sidebar using Bootstrap 4</title>
        <link href="{{ asset('css/mycss.css') }}" rel="stylesheet" />
        <!-- <link href="{{ asset('css/test.css') }}" rel="stylesheet" /> -->
        <!-- Bootstrap CSS CDN -->

        <!-- Scrollbar Custom CSS -->


        <!-- Font Awesome JS -->

        <script src="https://unpkg.com/wavesurfer.js"></script>
    </head>
<style>
.play{display: flex;
  justify-content: center;
  align-items: center;
  width: 60px;
  height: 60px;
  background: #EFEFEF;
  border-radius: 50%;
  border: none;
  outline: none;
  cursor: pointer;
  padding-bottom: 3px;
    }
  .play:hover {
    background: #DDD;
  }
</style>
    <body>
        <!-- <canvas id="canvas"></canvas> -->
        <div id="waveform"></div>

        <div class="play" id="btn-play" value="PLay" disabled="disabled" />Play</div>
        <input type="button" id="btn-pause" value="Pause" disabled="disabled" />

        <input type="button" id="btn-stop" value="stop" disabled="disabled" />

        <audio id="track"  />

    </body>
    <script>
        var button = {
            play: document.getElementById("btn-play"),
            pause: document.getElementById("btn-pause"),
            stop: document.getElementById("btn-stop")
        };
        button.play.addEventListener(
            "click",
            function() {
                wavesurfer.play();
                button.stop.disabled = false;
                button.pause.disabled = false;
                button.play.disabled = true;
            },
            false
        );
        button.pause.addEventListener(
            "click",
            function() {
                wavesurfer.pause();
                button.stop.disabled = false;
                button.pause.disabled = true;
                button.play.disabled = false;
            },
            false
        );
        button.stop.addEventListener(
            "click",
            function() {
                wavesurfer.stop();
                button.stop.disabled = true;
                button.pause.disabled = false;
                button.play.disabled = false;
            },
            false
        );
        var wavesurfer = WaveSurfer.create({
            // container: "#waveform",

            // progressColor: "#03a9f4",
            // scrollParent: true,

            barWidth: 3,
            cursorWidth: 1,
            container: "#waveform",
            backend: "WebAudio",
            height: 80,
            progressColor: "#2D5BFF",
            responsive: true,
            waveColor: "#EFEFEF",
            cursorColor: "transparent"
        });
        wavesurfer.on("ready", function() {
            button.play.disabled = false;
        });

        // window.addEventListener(
        //     "resize",
        //     function() {
        //         wavesurfer.pause();
        //         var currentProgress =
        //             wavesurfer.getCurrentTime() / wavesurfer.getDuration();
        //         // wavesurfer.empty();
        //         // wavesurfer.drawBuffer();

        //         wavesurfer.drawer.containerWidth =
        //             wavesurfer.drawer.container.clientWidth;
        //         wavesurfer.drawBuffer();
        //         wavesurfer.seekTo(currentProgress);

        //         button.stop.disabled = false;
        //         button.pause.disabled = true;
        //         button.play.disabled = false;
        //     },
        //     false
        // );
        const track = document.querySelector('#track');

        wavesurfer.load("web.mp3");
    </script>
</html>
