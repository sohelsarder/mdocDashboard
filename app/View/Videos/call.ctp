<script src="https://static.vline.com/vline.js" type="text/javascript"></script>
<style>
	.disabled{
		padding: 20px;
		background-color: #AAA;
		color: #000;
	}
	.active{
		padding: 20px;
		background-color: #22ff66;
		color: #000;
	}
	
</style>
<script type="text/javascript">
	var userId = "<?php echo $rmp_id; ?>";
	var rmpId = "<?php echo $rmp_id; ?>";
	var doctorId = "<?php echo $doctor_id;?>";
	$(function() {	
		$(document.body).on("click",'.vl-video-panel', function (event) {
			
			window.close();
		    
		});
	
	});
	
	
	
</script>

<?php

$vline = new Vline();
$vline->setUser($rmp_id, 'RMP');
$vline->init();
echo $this->Html->css(array('call'));		

?><br />


<span style="display: inline" id="step2">
   <h3 id="statusText"> Connecting .. Please Wait... </h3>
    <span class="pure-form" style="display: none">
        <a href="javascript:void(0)" class="pure-button pure-button-error" id="mainCaller" data-userid="<?php echo $doctor_id ?>">Answer  <?php echo $doctorName ?></a>
    </span>	

</span>
   
<br />
<br />
	
<div class="presuggestion" style="display: none"><img src="<?php echo $this->request->webroot;?>img/Instructiosn_1st_screen.png" alt="" style="width:80%;height: 80%" /></div>
<div class="presuggestions" id="allow" style="display: none"><img src="<?php echo $this->request->webroot;?>img/Instructions_2nd_screen.png" alt="" style="width:80%;height: 80%" /></div>

<div style="width: 100%">
	<div id="videoContainer" ID="videoContainer" style="position:relative; max-width:740px; height:480px;float: left;margin: 0;">
	</div>
</div>
<script>
	
	var vlineClient = (function(){
	  
	  
	  var client, vlinesession,
		authToken = '<?php echo $vline->getJWT() ?>',
		serviceId = '<?php echo $vline->getServiceID() ?>',
		profile = {"displayName": '<?php echo $vline->getUserDisplayName() ?>', "id": '<?php echo $vline->getUserID() ?>'};
	
	  // Create vLine client  
	  window.vlineClient = client = vline.Client.create({
		"serviceId": serviceId, "ui":true,
		"uiBigGreenArrow": false,
	});
	  // Add login event handler
	  client.on('login', onLogin);
	  // Do login
	  
	  
      client.login(serviceId, profile, authToken);
      
	
	  function onLogin(event) {
		vlinesession = event.target;
		
		vlinesession.on('exitState:active', function(){
			
			
		  
		})
		vlinesession.on('exitState:close', function(){
			
			
		  
		})
		
		vlinesession.on('remove:mediaSession', function(){
			window.open(siteurl+"Videos/callend"+"/"+rmpId+"/"+doctorId+"/1","_self");
			//window.close();
		   //window.close();
		   $(".postsuggestion").css("display",'inline');
		})
		
		var userId = $("#mainCaller").attr('data-userid');
		initCallButton($("#mainCaller"));
		
	}
	
	  // add event handlers for call button
	  function initCallButton(button) {
		var userId = button.attr('data-userid');
	  
		// fetch person object associated with username
		vlinesession.getPerson(userId).done(function(person) {
		  // update button state with presence
		  function onPresenceChange() {
			alert(2222222)
			alert(person.getPresenceState())
			if(person.getPresenceState() == 'online'){
				$("#statusText").html('Connected');
				$(".pure-form").css("display",'inline');
				$(".presuggestion").css("display",'inline');
				
				button.removeClass().addClass('pure-button pure-button-success');
			}else{
				$("#statusText").html('Connecting .. Please Wait...');
				$(".pure-form").css("display",'none');				
				button.removeClass().addClass('pure-button pure-button-error');
			}
			button.attr('data-presence', person.getPresenceState());
		  }
		
		  // set current presence
		  onPresenceChange();
		
		  // handle presence changes
		  person.on('change:presenceState', onPresenceChange);
		
		  // start a call when button is clicked
		  button.click(function() {
		      	  if (person.getId() == vlinesession.getLocalPersonId()) {
				alert('You cannot call yourself. Login as another user in an incognito window');
				return;
		       	  }
			  if(button.hasClass('pure-button-success'))
				vlineMediaSession = person.startMedia();
				vlineMediaSession.setAudioMuted(true);
			$(".presuggestion").css("display",'none');
			$("#allow").css("display",'inline');
		  });
		});
		
	  }
	  
	  return client;
	})();
	
	$(window).unload(function() {
		
		$(".presuggestion").css("display",'block');
		vlineClient.logout();
	  
	  
	});
	
	
	</script>