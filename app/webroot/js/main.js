    // Compatibility shim
    navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;

    // PeerJS object
    var userId = prompt('Enter UserId');
    var peer = new Peer(userId, { host: '192.168.21.225', port: 3000, path: '/', debug: 3, config: {'iceServers': [
      { url: 'stun:stun.l.google.com:19302' } // Pass in optional STUN and TURN server for maximum network compatibility
    ]}});

    peer.on('open', function(){
      $('#my-id').text(peer.id);
    });

    // Receiving a call
    peer.on('call', function(call){
      // Request Confirmation for Answering Call
      if (confirm("Receive call from "+call.peer)){
        call.answer(window.localStream);
        step3(call);
      }else{
        step2();
      }
    });
    peer.on('error', function(err){
      alert(err.message);
      // Return to step 2 if error occurs
      step2();
    });

    // Click handlers setup
    $(function(){
      $('#make-call').click(function(){
        // Initiate a call!
        var call = peer.call($('#callto-id').val(), window.localStream);

        step3(call);
      });

      $('#end-call').click(function(){
        window.existingCall.close();
        step2();
      });

      // Retry if getUserMedia fails
      $('#step1-retry').click(function(){
        $('#step1-error').hide();
        step1();
      });

      // Get things started
      step1();
    });

    function step1 () {

      var resX = "320";
      var resY = "240";
      var frame = "10";

      resX = $("#resX").val();
      resY = $("#resY").val();
      frame = $("#frame").val();

      var constraints = {
 	"audio": false,
 	"video": {
  	"mandatory": {
   	"minWidth": resX,
   	"minHeight": resY,
   	"minFrameRate": frame,
   	"maxWidth": resX,
   	"maxHeight": resY,
   	"maxFrameRate": frame
  	}
      }
    };
    
    console.log(JSON.stringify(constraints));
      // Get audio/video stream
      navigator.getUserMedia(constraints, function(stream){
        // Set your video displays
        $('#my-video').prop('src', URL.createObjectURL(stream));

        window.localStream = stream;
        step2();
      }, function(){ $('#step1-error').show(); });
    }

    function step2 () {
      $('#step1, #step3').hide();
      $('#step2').show();
    }

    function step3 (call) {
      // Hang up on an existing call if present
      if (window.existingCall) {
        window.existingCall.close();
      }

      // Wait for stream on the call, then set peer video display
      call.on('stream', function(stream){
        $('#their-video').prop('src', URL.createObjectURL(stream));
      });

      // UI stuff
      window.existingCall = call;
      $('#their-id').text(call.peer);
      call.on('close', step2);
      $('#step1, #step2').hide();
      $('#step3').show();
    }

 
