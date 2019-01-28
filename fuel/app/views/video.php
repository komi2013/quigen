<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>video</title>
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png" />
    <meta name="robots" content="noindex">
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <script src="/third/vue.min.js"></script>
    <script> var ua = '<?=Config::get("my.ua")?>'; </script>
    <script src="/assets/js/analytics.js"></script>
    <script src="/sw.js"></script>
    <script type="text/javascript" src="//cdn.webrtc.ecl.ntt.com/skyway-latest.js"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css" />
    <link rel="stylesheet" href="/assets/css/pc.css" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>
    <style>
        .remoteVideos {
            width:100%;
        }
    </style>

<div id="content">
<div style="display:none;">
    <div>
      <label for="videoSource">Video source: </label><select id="videoSource"></select>
    </div>
    <div>
      <label for="audioSource">Audio input source: </label><select id="audioSource"></select>
    </div>
    <!-- Get local audio/video stream -->
    <div id="step1">
      <p>Please click `allow` on the top of the screen so we can access your webcam and microphone for calls.</p>
      <div id="step1-error">
        <p>Failed to access the webcam and microphone. Make sure to run this demo on an http server and click allow when asked for permission by the browser.</p>
        <a href="#" id="step1-retry">Try again</a>
      </div>
    </div>

    <p>Your id: <span id="my-id">...</span></p>
    <!-- Make calls to others -->
    <div id="step2">
      <h3>Make a call</h3>
      <form id="make-call" >
        <input type="text" placeholder="Username" id="username"><br>
        <input type="text" placeholder="Join room..." id="join-room">
        <button  id="join" type="submit">Join</button>
      </form>
    </div>
</div>
<div id="ad"><iframe src="/htm/ad_blank/" width="320" height="50" frameborder="0" scrolling="no"></iframe></div>
  <!-- Video area -->
  <div id="video-container" style="position: absolute;">
    <video class="remoteVideos" id="their-videos" autoplay playsinline style="width:100%;"></video>
    <video id="my-video" muted="true" autoplay playsinline style="width:100%;"></video>
  </div>
  <div style="position:fixed;z-index:5;width:100%;bottom:2px;">
  <div id='scrollBottom' style="width:100%;height:300px;overflow:scroll;">
    <div id="chatLog" style="width:100%;height:300px;display:table-cell;vertical-align:bottom;padding:5px;color:lime;font-size: 20px;"></div>
  </div>
  <div style="text-align: center;">
    <input type="text" placeholder="message" id="msg" class="td_68">
    <img src="/assets/img/icon/video_0.png" class="icon camera" id="camera0">
    <img src="/assets/img/icon/video_1.png" class="icon camera" id="camera1" style="display:none;">
    <img src="/assets/img/icon/upload_0.png" class="icon" id="send" style="display:none;">
  </div>
  </div>
  <div style="position:absolute;top:-500px;">
  <a href="#" id="downloadlink">Download</a><br>
  <a href="#" onclick="playRecorded();">makeVideo</a><br>
  <video id="playback_video" controls="1" autoplay style="width: 240px; height: 180px; border: 1px solid black;"></video>
  </div>
</div>
    
<div id="ad_right"></div>
<script>
var csrf = '<?=Model_Csrf::setcsrf()?>';

</script>
<script src="/assets/js/check_news.js"></script>
<script src="/assets/js/basic_offline.js"></script>
<script src="/assets/js/video.js"></script>

<script>  
if(navigator.onLine){
  $(function(){ ga('send', 'pageview'); });
}
</script>
</body>
</html>
