/* eslint-disable require-jsdoc */

// Peer object
const peer = new Peer({
  key:   "ddd755de-601a-49f2-b30c-5fab34067460",
  debug: 3,
});

let localStream;
let theirStream;
let room;
peer.on('open', () => {
  $('#my-id').text(peer.id);
  // Get things started
  step1();
});

peer.on('error', err => {
  alert(err.message);
  // Return to step 2 if error occurs
  step2();
});

$('#end-call').on('click', () => {
  room.close();
  step2();
});

// Retry if getUserMedia fails
$('#step1-retry').on('click', () => {
  $('#step1-error').hide();
  step1();
});

// set up audio and video input selectors
const audioSelect = $('#audioSource');
const videoSelect = $('#videoSource');
const selectors = [audioSelect, videoSelect];

navigator.mediaDevices.enumerateDevices()
  .then(deviceInfos => {
    const values = selectors.map(select => select.val() || '');
    selectors.forEach(select => {
      const children = select.children(':first');
      while (children.length) {
        select.remove(children);
      }
    });

    for (let i = 0; i !== deviceInfos.length; ++i) {
      const deviceInfo = deviceInfos[i];
      const option = $('<option>').val(deviceInfo.deviceId);

      if (deviceInfo.kind === 'audioinput') {
        option.text(deviceInfo.label ||
          'Microphone ' + (audioSelect.children().length + 1));
        audioSelect.append(option);
      } else if (deviceInfo.kind === 'videoinput') {
        option.text(deviceInfo.label ||
          'Camera ' + (videoSelect.children().length + 1));
        videoSelect.append(option);
      }
    }

    selectors.forEach((select, selectorIndex) => {
      if (Array.prototype.slice.call(select.children()).some(n => {
          return n.value === values[selectorIndex];
        })) {
        select.val(values[selectorIndex]);
      }
    });
    videoSelect.on('change', step1);
    audioSelect.on('change', step1);
});

function step1() {
  // Get audio/video stream
  const audioSource = $('#audioSource').val();
  const videoSource = $('#videoSource').val();
  const constraints = {
    audio: {deviceId: audioSource ? {exact: audioSource} : undefined},
    video: {deviceId: videoSource ? {exact: videoSource} : undefined},
  };
  navigator.mediaDevices.getUserMedia(constraints).then(stream => {
    $('#my-video').get(0).srcObject = stream;
    localStream = stream;

    localStream.getVideoTracks()[0].enabled = false;
    $('#my-video').hide();
    if (room) {
      room.replaceStream(stream);
      return;
    }

    step2();
  }).catch(err => {
    $('#step1-error').show();
    console.error(err);
  });
}

function step2() {
  $('#their-videos').empty();
  $('#their-videos').hide();
  $('#step1, #step3').hide();
  $('#step2').show();
  $('#join-room').focus();
  makeCall();
}
const roomName = getVal.room ? getVal.room : randomStr();
function makeCall() {
    room = peer.joinRoom('mesh_video_' + roomName, {stream: localStream});

    $('#room-id').text(roomName);
    step3(room);
    $('#send').click(function(){
        sendMsg(room);
    });
    $('#msg').keypress(function (e) {
     var key = e.which;
      if (key === 13) {
        sendMsg(room);
      }
    });
    $('.camera').click(function(){
        if(localStream.getVideoTracks()[0].enabled){
          localStream.getVideoTracks()[0].enabled = false;
          $('#my-video').hide();
          $('#camera1').hide();
          $('#camera0').show();
          var data = [0,2];
          stopRecording(localStream);
        }else{
          localStream.getVideoTracks()[0].enabled = true;
          $('#their-videos').hide();
          $('#my-video').show();
          $('#camera0').hide();
          $('#camera1').show();
          var data = [0,1];
          startRecording(localStream);
        }
        room.send(data);
    });
    // recevie chat message
    room.on('data', function(data){
        if(data.data[1] == 1){
          localStream.getVideoTracks()[0].enabled = false;
          $('#my-video').hide();
          $('#camera1').hide();
          $('#camera0').show();
          $('#their-videos').show();
          stopRecording(localStream);
          startRecording(theirStream);
        }else if(data.data[1] == 2){
          $('#their-videos').hide();
          stopRecording(theirStream);
        }else{
          $('#chatLog').append('<p style="color:orange;">' + data.data[0] + '</p>');  
        }
    });
}
function sendMsg(room){
    $('#send').hide();
    if(localStream.getVideoTracks()[0].enabled){
      $('#camera1').show();
    }else{
      $('#camera0').show();
    }
    if($('#msg').val()){
      var data = [$('#msg').val(),0];
      room.send(data);
      $('#chatLog').append('<p>' + $('#msg').val() + '</p>');
      goBottom('scrollBottom');
      $('#msg').val('');
      $('#msg').blur();
    }
}
$('#msg').click(function(){
    $('#camera0').hide();
    $('#camera1').hide();
    $('#send').show();
});
function step3(room) {
  room.on('stream', stream => {
    const peerId = stream.peerId;
      const el = $('#their-videos').get(0);
      el.srcObject = stream;
      el.play();
      theirStream = stream;
      startAudio(localStream);
      setTimeout("stopAudio()", 1000 * 60 * 5);
  });

  room.on('removeStream', function(stream) {
    $('#their-videos').remove();
  });

  // UI stuff
  room.on('close', step2);
  room.on('peerLeave', peerId => {
    $('#their-videos').remove();
  });
  $('#step1, #step2').hide();
  $('#step3').show();
}
var recorder =  null;
var blobUrl = null;
var anchor = document.getElementById('downloadlink');
var playbackVideo =  document.getElementById('playback_video');
var chunks = []; // 格納場所をクリア
const calling = getVal.calling;
function startRecording(stream) {
  if (calling == 'receiver') {
      return;
  }
  if (! stream) {
    console.warn('stream not ready');
    return;
  }
  recorder = new MediaRecorder(stream);
  
  recorder.ondataavailable = function(evt) {
    console.log("data available: evt.data.type=" + evt.data.type + " size=" + evt.data.size);
    chunks.push(evt.data);
  };
  recorder.onstop = function(evt) {
    console.log('recorder.onstop(), so playback');
    recorder = null;
    var videoBlob = new Blob(chunks, { type: "video/webm" });
    var fd = new FormData();
    fd.append('room', roomName);
    fd.append('media', 'video');
    fd.append('u_id', localStorage.ua_u_id);
    fd.append('split', splitRec);
    fd.append('data', videoBlob);
    $.ajax({
        type: 'POST',
        url: '/videoup/',
        data: fd,
        processData: false,
        contentType: false
    }).done(function(data) {
        console.log(data);
    });
  };
  recorder.start(1000); // インターバルは1000ms
  console.log('start recording');
}
// -- 録画停止 -- 
var splitRec = 0;
function stopRecording(stream) {
  if (recorder) {
    recorder.stop();
    startRecording(stream);
    splitRec++;
  }
}
var chunksAudio = [];
function startAudio(stream) {
  if (! stream) {
    return;
  }
  audioRec = new MediaRecorder(stream);
  
  audioRec.ondataavailable = function(evt) {
    chunksAudio.push(evt.data);
  };
  audioRec.onstop = function(evt) {
    audioRec = null;
    var videoBlob = new Blob(chunksAudio, { type: "audio/webm" });
    var fd = new FormData();
    fd.append('room', roomName);
    fd.append('media', 'audio');
    fd.append('u_id', localStorage.ua_u_id);
    fd.append('split', splitAudio);
    fd.append('data', videoBlob);
    $.ajax({
        type: 'POST',
        url: '/videoup/',
        data: fd,
        processData: false,
        contentType: false
    }).done(function(data) {
        console.log(data);
    });
  };
  audioRec.start(1000); // インターバルは1000ms
}
var splitAudio = 0;
function stopAudio(stream) {
  if (audioRec) {
    audioRec.stop();
    startAudio(stream);
    splitAudio++;
  }
}

// -- 再生 --
function playRecorded() {
    if (! blobUrl) {
      window.URL.revokeObjectURL(blobUrl);
      blobUrl = null;
    }

    // Blob
//    var videoBlob = new Blob(chunks, { type: "video/webm" });
    var videoBlob = new Blob(chunks, { type: "audio/webm" });

    var fd = new FormData();
    fd.append('fname', 'test_'+splitAudio+'.webm');
    fd.append('data', videoBlob);
    $.ajax({
        type: 'POST',
        url: '/videoup/',
        data: fd,
        processData: false,
        contentType: false
    }).done(function(data) {
        console.log(data);
    });


    // 再生できるようにURLを生成
    blobUrl = window.URL.createObjectURL(videoBlob);
    
    // ==== (3) ダウンロード ====
    // ダウンロードの準備
    anchor.download = 'recorded.webm';
    anchor.href = blobUrl;
    // ==== (3) ダウンロード ====

    // 録画した内容を再生
    if (blobUrl) {
      playbackVideo.src = blobUrl;
      
      // 再生終了時の処理
      playbackVideo.onended = function() {
        playbackVideo.pause();
        playbackVideo.src = "";
      };

      // 再生開始
      playbackVideo.play();
    }
}
// ==== (2) 録画 ====

function randomStr(){
    var l = 8;
    var c = "abcdefghijklmnopqrstuvwxyz0123456789";
    var cl = c.length;
    var r = "";
    for(var i=0; i<l; i++){
      r += c[Math.floor(Math.random()*cl)];
    }
    return r;
}
function goBottom(targetId) {
    var obj = document.getElementById(targetId);
    if(!obj) return;
    obj.scrollTop = obj.scrollHeight;
}
