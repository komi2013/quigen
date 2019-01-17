/* eslint-disable require-jsdoc */

  // Peer object
  const peer = new Peer({
    key:   "ddd755de-601a-49f2-b30c-5fab34067460",
    debug: 3,
  });

  let localStream;
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

//$( "#videoSource" ).each(function( index ) {
//  console.log( index + ": " + $( this ).text() );
//  $( "#content" ).append(index + ": " + $( this ).val()+ ": <br>");
//  
//});
//$( "#content" ).append($("#videoSource").text()+'<br>');
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

  function makeCall() {
    const roomName = getVal.room ? getVal.room : randomStr();
    room = peer.joinRoom('mesh_video_' + roomName, {stream: localStream});
    $('#room-id').text(roomName);
    step3(room);
    $('#send').click(function(){
        $('#send').hide();
        if(localStream.getVideoTracks()[0].enabled){
          $('#camera1').show();
        }else{
          $('#camera0').show();
        }
        if($('#msg').val()){
          var data = [$('#msg').val(),0];//0=no change
          room.send(data);
          $('#chatLog').append('<p>' + $('#msg').val() + '</p>');
          $('#msg').val('');
        }
    });
    $('#msg').keypress(function (e) {
     var key = e.which;
      if (key === 13) {
        $('#send').hide();
        if(localStream.getVideoTracks()[0].enabled){
          $('#camera1').show();
        }else{
          $('#camera0').show();
        }
        if($('#msg').val()){
          var data = [$('#msg').val(),0];//0=no change
          room.send(data);
          $('#chatLog').append('<p>' + $('#msg').val() + '</p>');
          $('#msg').val('');
        }
      }
    });
    $('.camera').click(function(){
        if(localStream.getVideoTracks()[0].enabled){
          localStream.getVideoTracks()[0].enabled = false;
          $('#my-video').hide();
          $('#camera1').hide();
          $('#camera0').show();
          var data = [0,2];//2=$('#their-videos').hide();
        }else{
          localStream.getVideoTracks()[0].enabled = true;
          $('#their-videos').hide();
          $('#my-video').show();
          $('#camera0').hide();
          $('#camera1').show();
          var data = [0,1];//videOn 1=$('#their-videos').show();
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
        }else if(data.data[1] == 2){
          $('#their-videos').hide();
          $('#camera0').hide();
          $('#camera1').show();
        }else{
          $('#chatLog').append('<p style="color:orange;">' + data.data[0] + '</p>');  
        }
    });
  }
  
$('#msg').click(function(){
    $('#camera0').hide();
    $('#camera1').hide();
    $('#send').show();
});
  function step3(room) {
    // Wait for stream on the call, then set peer video display
    room.on('stream', stream => {
      const peerId = stream.peerId;
      const id = 'video_' + peerId + '_' + stream.id.replace('{', '').replace('}', '');
      $('#their-videos').append($(
        '<div class="video_' + peerId +'" id="' + id + '">' +
        '<video class="remoteVideos" autoplay playsinline>' +
        '</div>'));
        const el = $('#' + id).find('video').get(0);
  //      startRecording(stream);
        el.srcObject = stream;
        el.play();
    });

    room.on('removeStream', function(stream) {
      const peerId = stream.peerId;
      $('#video_' + peerId + '_' + stream.id.replace('{', '').replace('}', '')).remove();
    });

    // UI stuff
    room.on('close', step2);
    room.on('peerLeave', peerId => {
      $('.video_' + peerId).remove();
    });
    $('#step1, #step2').hide();
    $('#step3').show();
  }

function startRecording(stream) {
  if (! stream) {
    console.warn('stream not ready');
    return;      
  }
//  if (recorder !== 'undefined') {
//    console.warn('already recording');
//    return;
//  }
  recorder = new MediaRecorder(stream);
  chunks = []; // 格納場所をクリア
  recorder.ondataavailable = function(evt) {
    console.log("data available: evt.data.type=" + evt.data.type + " size=" + evt.data.size);
    chunks.push(evt.data);
  };
  recorder.onstop = function(evt) {
    console.log('recorder.onstop(), so playback');
    recorder = null;
    playRecorded();
  };
  recorder.start(1000); // インターバルは1000ms
  console.log('start recording');
}

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
