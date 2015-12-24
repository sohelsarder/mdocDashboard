
<?php

echo $this->Html->css(array('call'));		
echo $this->Html->script(array('peer','rmpcall'));
?>		
<script type="text/javascript">
	 
	step1();
	
	 function step1 () {

	var resX = "320";
	var resY = "240";
	var frame = "10";
  
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
	 },
	 "optional": [
	  {
	   "minWidth": resX
	  },
	  {
	   "minHeight": resY
	  },
	  {
	   "minFrameRate": frame
	  },
	  {
	   "maxWidth": resX
	  },
	  {
	   "maxHeight": resY
	  },
	  {
	   "maxFrameRate": frame
	  }
	 ]
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
	
</script>



  <div class="pure-g">
    

      <!-- Video area -->
      <div class="pure-u-2-3" id="video-container">
        <video id="their-video" autoplay></video>
        <video id="my-video" muted="true" autoplay></video>
      </div>

      <!-- Steps -->
      <div class="pure-u-1-3">
        <div id="step_Start">
          
        </div>

            
      

        <!-- Get local audio/video stream -->
        <div id="step1">
          <p>Please click `allow` on the top of the screen so we can access your webcam and microphone for calls.</p>
          <div id="step1-error">
            <p>Failed to access the webcam and microphone. Make sure to run this demo on an http server and click allow when asked for permission by the browser.</p>
            <a href="#" class="pure-button pure-button-error" id="step1-retry">Try again</a>
          </div>
        </div>

        <!-- Make calls to others -->
        <div id="step2">
	 
          <p>Your id: <span id="my-id">...</span></p>
          <div class="pure-form">
            <input type="text" placeholder="Call user id..." id="callto-id" ">
            <a href="#" class="pure-button pure-button-success" id="make-call">Call</a>
          </div>
	  
	    
        </div>

        <!-- Call in progress -->
        <div id="step3">
          <p>Currently in call with <span id="their-id">...</span></p>
          <p><a href="#" class="pure-button pure-button-error" id="end-call">End call</a></p>
        </div>
      </div>
  </div>
