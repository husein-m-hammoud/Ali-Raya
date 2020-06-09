<!-- main wavesurfer.js lib -->
<style>
#waveform {
  background: #333;

}
.back {
  background: #46a6d8;
}
.wave {
  background: #333;
}
#forRecord {
 display: none;
}
.buttons {
  padding: 10px;
}
.record-container {
  display: none;
  padding: 10px;
  z-index:9999;
  width:100%;
  height:140px;
  background:black;
  position:absolute;
  top:0;
  color: white;
  text-align: center;
  padding-top: 50px;
}
.waveform-container {
    background: #ccfcfc !important;
    padding: 5px !important;
    border: 3px !important;
    border-color: red !important;
    border-radius: 7px !important;
}

showtitle, cursor{
    z-index: 5 !important;
}

.wavesurfer-handle{
  position: fixed;
  height: 130px !important;
  z-index: 15 !important;
  width: 10px !important;
  max-width: 10px !important;
  background: #CCAADD;
  border-radius: 5px;
}


</style>

<script src="//vjs.zencdn.net/7.3.0/video.min.js"></script>
<script src="https://unpkg.com/wavesurfer.js"></script>
<script src="https://unpkg.com/wavesurfer.js/dist/plugin/wavesurfer.regions.min.js"></script>
<script src="https://unpkg.com/wavesurfer.js/dist/plugin/wavesurfer.microphone.min.js"></script>
<script src="https://cdn.webrtc-experiment.com/RecordRTC.js"></script>
<script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>

<div class="waveform-container"><div id="waveform"></div></div>
<div class="record-container"><div>Recording...</div></div>
<audio id="forRecord" class="video-js vjs-default-skin"></audio>

<div style="text-align: center" class="buttons">
  <button class="btn btn-primary" onclick="startRecording(event)">
    <i class="glyphicon glyphicon-record"></i>
    Record
  </button>
  <button class="btn btn-primary" onclick="wavesurfer.play()">
    <i class="glyphicon glyphicon-record"></i>
    Play Record
  </button>
  <button class="btn btn-primary" onclick="playRegion()">
    <i class="glyphicon glyphicon-play"></i>
    Play Selected
  </button>
  <button class="btn btn-primary" onclick="wavesurfer.stop()">
    <i class="glyphicon glyphicon-stop"></i>
    Stop
  </button>
  <p class="row">
    <div class="col-xl-12">
    <button class="btn btn-primary trim-left" onclick="trimLeft()">
    <i class="glyphicon glyphicon-scissors"></i>
    Trim
  </button>
      <button class="btn btn-primary trim-left" onclick="deleteChunk()">
    <i class="glyphicon glyphicon-trash"></i>
    Delete
  </button>
      <button class="btn btn-primary trim-left" onclick="reload()">
    <i class="glyphicon glyphicon-refresh"></i>
    reload
  </button>
    </div>
    <button onclick="download()">
    Download
    </button>
  </p>
</div>

<script>
    let regions = WaveSurfer.regions.create({
                regions: [

                ],
                dragSelection: false,
                slop: 10,
            })

let wavesurfer = WaveSurfer.create({
  container: '#waveform',
  waveColor: '#46a6d8',
  progressColor: '#FFF',
  barWidth: 3,
  barGap: 2,
  height: 130,
  cursorWidth: 1,
  cursorColor: "white",
  //pixelRatio: 1,
  //scrollParent: true,
  responsive: 1000,
  normalize: true,
  //minimap: true,
  plugins: [
      regions,
    ],
//  maxCanvasWidth: 100
});

wavesurfer.on("ready",() => {
  wavesurfer.regions.clear();
  wavesurfer.regions.add(  {
    start: 0,
    end: wavesurfer.getDuration() - (wavesurfer.getDuration() / 60),
    color: 'hsla(200, 50%, 70%, 0.3)',
  });
});


reload();

function trimLeft() {
  // I had to fixed to two decimal if I don't do this not work, I don't know whyyy
  const start = wavesurfer.regions.list[Object.keys(wavesurfer.regions.list)[0]].start.toFixed(2);
  const end = wavesurfer.regions.list[Object.keys(wavesurfer.regions.list)[0]].end.toFixed(2);
  const originalBuffer = wavesurfer.backend.buffer;
  console.log(end, start,end , start,originalBuffer, (end - start) * (originalBuffer.sampleRate * 1))
  var emptySegment = wavesurfer.backend.ac.createBuffer(
    originalBuffer.numberOfChannels,
    //segment duration
    (end - start) * (originalBuffer.sampleRate * 1),
    originalBuffer.sampleRate
  );

  for (var i = 0; i < originalBuffer.numberOfChannels; i++) {
      var chanData = originalBuffer.getChannelData(i);
      var segmentChanData = emptySegment.getChannelData(i);
      for (var j = 0, len = chanData.length; j < end * originalBuffer.sampleRate; j++) {
          segmentChanData[j] = chanData[j + (start * originalBuffer.sampleRate)];
      }
  }

  wavesurfer.loadDecodedBuffer(emptySegment); // Here you go!
              // Not empty anymore, contains a copy of the segment!
  console.log(end, start, end-start)
}

function deleteChunk() {
  // I had to fixed to two decimal if I don't do this not work, I don't know whyyy
  const start = wavesurfer.regions.list[Object.keys(wavesurfer.regions.list)[0]].start.toFixed(2);
  const end = wavesurfer.regions.list[Object.keys(wavesurfer.regions.list)[0]].end.toFixed(2);
  const originalBuffer = wavesurfer.backend.buffer;
  console.log(end, start,end , start,originalBuffer, (end - start) * (originalBuffer.sampleRate * 1))
  var emptySegment = wavesurfer.backend.ac.createBuffer(
    originalBuffer.numberOfChannels,
    (wavesurfer.getDuration() - (end - start)) * (originalBuffer.sampleRate * 1),
    originalBuffer.sampleRate
  );
  console.log("total nueva wave",wavesurfer.getDuration(), end, start)

  for (let i = 0; i < originalBuffer.numberOfChannels; i++) {
    let chanData = originalBuffer.getChannelData(i);
    let segmentChanData = emptySegment.getChannelData(i);
    let offset = end * originalBuffer.sampleRate;
    for (let j = 0; j < originalBuffer.length; j++) {
      if (j < (start * originalBuffer.sampleRate)) {
        //TODO: contemplate other cases when the region is at the end
        segmentChanData[j] = chanData[j];
      } else {
        segmentChanData[j] = chanData[offset];
        offset++;
      }
    }
  }
  //wavesurfer.drawer.clearWave();

//wavesurfer.empty();
 // reload()
  wavesurfer.loadDecodedBuffer(emptySegment); // Here you go!
              // Not empty anymore, contains a copy of the segment!
  console.log(end, start, end-start)
  //wavesurfer.drawBuffer();

}

function playRegion(){
  wavesurfer.regions.list[Object.keys(wavesurfer.regions.list)[0]].play()

  console.log(wavesurfer.regions.list[Object.keys(wavesurfer.regions.list)[0]])
}
function download(){
    window.open(wavesurfer.regions.list[Object.keys(wavesurfer.regions.list)[0]]+".mp3");
    // download("hello world", "dlText.txt", "text/plain");
}
function reload(){

  wavesurfer.load('https://ia902606.us.archive.org/35/items/shortpoetry_047_librivox/song_cjrg_teasdale_64kb.mp3');
  setTimeout(()=>{

  },1200)
//"https://cdn.filestackcontent.com/HB7k1wMDRMqdQdO1FtjX"
}

// wavesurfer.load('https://ia902606.us.archive.org/35/items/shortpoetry_047_librivox/song_cjrg_teasdale_64kb.mp3');


//FOR RECORD


// var player = videojs("forRecord", {
//     controls: true,
//     width: 600,
//     height: 300,
//     plugins: {
//         wavesurfer: {
//             src: "live",
//             waveColor: "#fffa00",
//             progressColor: "#FAFCD2",
//             debug: true,
//             cursorWidth: 1,
//             msDisplayMax: 20,
//             hideScrollbar: true
//         },
//         record: {
//             audio: true,
//             video: false,
//             maxLength: 20,
//             debug: true,
//             //audioEngine: "libvorbis.js",
//             //audioSampleRate: 32000
//             //audioEngine: "lamejs",
//             //audioWorkerURL: "lib/lamejs/worker-example/worker-realtime.js",
//             //audioSampleRate: 44100,
//             //audioBitRate: 128
//         }
//     }
// }, function(){
//     // print version information at startup
//     var msg = 'Using video.js ' + videojs.VERSION +
//         ' with videojs-record ' + videojs.getPluginVersion('record') +
//         ', videojs-wavesurfer ' + videojs.getPluginVersion('wavesurfer') +
//         ' and wavesurfer.js ' + WaveSurfer.VERSION;
//     videojs.log(msg);
// });

// error handling
// player.on('deviceError', function() {
//     console.log('device error:', player.deviceErrorCode);
// });

// // user clicked the record button and started recording
// player.on('startRecord', function() {
//     $(".record-container").show();
//     console.log('started recording!');
// });

// // user completed recording and stream is available
// player.on('finishRecord', function() {
//     $(".record-container").hide();
//     // the blob object contains the recorded data that
//     // can be downloaded by the user, stored on server etc.
//     console.log('finished recording: ', player.recordedData);

//     let fileReader = new FileReader();
//     fileReader.addEventListener('load', e =>
//         wavesurfer.loadArrayBuffer(e.target.result)
//     );
//     fileReader.readAsArrayBuffer(player.recordedData);

//     player.record().saveAs({'audio': 'my-audio-file-name.ogg'});
// });

// player.on('ready', function() {
//     player.record().getDevice();
// });

function startRecording(event){
  if (!player.record().isRecording() || (player.record().isRecording() && player.record().paused)) {
   player.record().start();

  } else {
    player.record().stop();
  }
}
</script>




<script>//download.js v4.2, by dandavis; 2008-2016. [CCBY2] see http://danml.com/download.html for tests/usage
// v1 landed a FF+Chrome compat way of downloading strings to local un-named files, upgraded to use a hidden frame and optional mime
// v2 added named files via a[download], msSaveBlob, IE (10+) support, and window.URL support for larger+faster saves than dataURLs
// v3 added dataURL and Blob Input, bind-toggle arity, and legacy dataURL fallback was improved with force-download mime and base64 support. 3.1 improved safari handling.
// v4 adds AMD/UMD, commonJS, and plain browser support
// v4.1 adds url download capability via solo URL argument (same domain/CORS only)
// v4.2 adds semantic variable names, long (over 2MB) dataURL support, and hidden by default temp anchors
// https://github.com/rndme/download

(function (root, factory) {
	if (typeof define === 'function' && define.amd) {
		// AMD. Register as an anonymous module.
		define([], factory);
	} else if (typeof exports === 'object') {
		// Node. Does not work with strict CommonJS, but
		// only CommonJS-like environments that support module.exports,
		// like Node.
		module.exports = factory();
	} else {
		// Browser globals (root is window)
		root.download = factory();
  }
}(this, function () {

	return function download(data, strFileName, strMimeType) {

		var self = window, // this script is only for browsers anyway...
			defaultMime = "application/octet-stream", // this default mime also triggers iframe downloads
			mimeType = strMimeType || defaultMime,
			payload = data,
			url = !strFileName && !strMimeType && payload,
			anchor = document.createElement("a"),
			toString = function(a){return String(a);},
			myBlob = (self.Blob || self.MozBlob || self.WebKitBlob || toString),
			fileName = strFileName || "download",
			blob,
			reader;
			myBlob= myBlob.call ? myBlob.bind(self) : Blob ;

		if(String(this)==="true"){ //reverse arguments, allowing download.bind(true, "text/xml", "export.xml") to act as a callback
			payload=[payload, mimeType];
			mimeType=payload[0];
			payload=payload[1];
		}


		if(url && url.length< 2048){ // if no filename and no mime, assume a url was passed as the only argument
			fileName = url.split("/").pop().split("?")[0];
			anchor.href = url; // assign href prop to temp anchor
		  	if(anchor.href.indexOf(url) !== -1){ // if the browser determines that it's a potentially valid url path:
        		var ajax=new XMLHttpRequest();
        		ajax.open( "GET", url, true);
        		ajax.responseType = 'blob';
        		ajax.onload= function(e){
				  download(e.target.response, fileName, defaultMime);
				};
        		setTimeout(function(){ ajax.send();}, 0); // allows setting custom ajax headers using the return:
			    return ajax;
			} // end if valid url?
		} // end if url?


		//go ahead and download dataURLs right away
		if(/^data\:[\w+\-]+\/[\w+\-]+[,;]/.test(payload)){

			if(payload.length > (1024*1024*1.999) && myBlob !== toString ){
				payload=dataUrlToBlob(payload);
				mimeType=payload.type || defaultMime;
			}else{
				return navigator.msSaveBlob ?  // IE10 can't do a[download], only Blobs:
					navigator.msSaveBlob(dataUrlToBlob(payload), fileName) :
					saver(payload) ; // everyone else can save dataURLs un-processed
			}

		}//end if dataURL passed?

		blob = payload instanceof myBlob ?
			payload :
			new myBlob([payload], {type: mimeType}) ;


		function dataUrlToBlob(strUrl) {
			var parts= strUrl.split(/[:;,]/),
			type= parts[1],
			decoder= parts[2] == "base64" ? atob : decodeURIComponent,
			binData= decoder( parts.pop() ),
			mx= binData.length,
			i= 0,
			uiArr= new Uint8Array(mx);

			for(i;i<mx;++i) uiArr[i]= binData.charCodeAt(i);

			return new myBlob([uiArr], {type: type});
		 }

		function saver(url, winMode){

			if ('download' in anchor) { //html5 A[download]
				anchor.href = url;
				anchor.setAttribute("download", fileName);
				anchor.className = "download-js-link";
				anchor.innerHTML = "downloading...";
				anchor.style.display = "none";
				document.body.appendChild(anchor);
				setTimeout(function() {
					anchor.click();
					document.body.removeChild(anchor);
					if(winMode===true){setTimeout(function(){ self.URL.revokeObjectURL(anchor.href);}, 250 );}
				}, 66);
				return true;
			}

			// handle non-a[download] safari as best we can:
			if(/(Version)\/(\d+)\.(\d+)(?:\.(\d+))?.*Safari\//.test(navigator.userAgent)) {
				url=url.replace(/^data:([\w\/\-\+]+)/, defaultMime);
				if(!window.open(url)){ // popup blocked, offer direct download:
					if(confirm("Displaying New Document\n\nUse Save As... to download, then click back to return to this page.")){ location.href=url; }
				}
				return true;
			}

			//do iframe dataURL download (old ch+FF):
			var f = document.createElement("iframe");
			document.body.appendChild(f);

			if(!winMode){ // force a mime that will download:
				url="data:"+url.replace(/^data:([\w\/\-\+]+)/, defaultMime);
			}
			f.src=url;
			setTimeout(function(){ document.body.removeChild(f); }, 333);

		}//end saver




		if (navigator.msSaveBlob) { // IE10+ : (has Blob, but not a[download] or URL)
			return navigator.msSaveBlob(blob, fileName);
		}

		if(self.URL){ // simple fast and modern way using Blob and URL:
			saver(self.URL.createObjectURL(blob), true);
		}else{
			// handle non-Blob()+non-URL browsers:
			if(typeof blob === "string" || blob.constructor===toString ){
				try{
					return saver( "data:" +  mimeType   + ";base64,"  +  self.btoa(blob)  );
				}catch(y){
					return saver( "data:" +  mimeType   + "," + encodeURIComponent(blob)  );
				}
			}

			// Blob but not URL support:
			reader=new FileReader();
			reader.onload=function(e){
				saver(this.result);
			};
			reader.readAsDataURL(blob);
		}
		return true;
	}; /* end download() */
}));</script>
