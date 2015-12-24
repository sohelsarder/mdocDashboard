 <?php
 echo $this->Html->css(array(
			'jquery.fancybox-buttons',
			'jquery.fancybox',
			'popup'
    ));
 echo $this->Html->script(array(   
   'jquery.fancybox',   
   'jquery.fancybox-buttons',   
  
  ));
 
 ?>
 <script>
  $(function() {
    $( "#followupDate" ).datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat: 'yy-mm-dd' ,
      minDate: 0
    });
  });
  </script>
  
 <script type="text/javascript">

var i=0;
function GetCount(iid){
                i= i+1;
		mins=0;secs=0;out="";
		mins=Math.floor(i/60);//minutes
		secs=Math.floor(i);//seconds
		
		out += mins +" "+((mins==1)?"min":"mins")+", ";	
		out = out.substr(0,out.length-2);
		document.getElementById(iid).value=out;
		setTimeout(function(){GetCount(iid)}, 1000);
}

window.onload=function(){
	GetCount('spentTime');
	
};
</script>
 <!--
<script type="text/javascript">
	
</script> -->
<style type="text/css">
	.fancybox-custom .fancybox-skin {
		box-shadow: 0 0 50px #222;
	}
</style>
<script src="https://static.vline.com/vline.js" type="text/javascript"></script>
<?php
$vline = new Vline();
$vline->setUser('doctor0'.$this->Session->read('Auth.User.id'), $this->Session->read('Auth.User.name'));
$vline->init();
echo $this->Html->css(array('call'));		
echo $this->Html->script(array('prescription'));
?>		
<script type="text/javascript">
    $(document).ready(function () { 
     $("#dialog").dialog({
        autoOpen: false,                                    
        width: 638,
        modal: true,                                          
        
	 });
     });    

</script>

<?php $model =  Inflector::singularize($this->request->params['controller']);
$v = ucfirst($model); 
$dob = json_decode($dob,true);
$age = $dob['y']. ' Y(s) '.$dob['m'].' M(s) '.$dob['d']. ' D(s)';

if(!empty($appointment['Appointment']['is_followup'])){	
	unset($unit_cost[NEWAPP]);	
	$unit_cost[FOLLOWUP]= 'Paid';
}else{
	unset($unit_cost[FOLLOWUP]);	
	$unit_cost[NEWAPP]= 'Paid';
}
$payment_type = '';
if(!empty($appointment['Appointment']['is_followup'])){
	$unit_cost_id = FOLLOWUP ;
}else{
	$unit_cost_id = NEWAPP;
}
?>
<!--<div id="view_prescription">
	

</div> -->
<?php echo $this->Form->create($v); ?>  
<div class="containt_left">
               <div class="title_d">
              <h> Patient Profile</h>
               </div>
                  <div class="photo"><?php echo $this->Html->image(IMG_URL.'/uploads/'.$appointment['Patient']['image'],array('width'=>143,'height'=>164)); ?></div>
                  <div class="card_detail">
                     <p><b><?php echo $appointment['Patient']['name']. $this->Form->hidden('User.name',array('label'=>false,'div'=>false,'value'=>$appointment['Patient']['name'])); ?>
		     <?php
			echo $this->Form->hidden('patient_id',array('value'=> $appointment['Patient']['id']));
			echo $this->Form->hidden('appointment_id',array('value'=> $appointment['Appointment']['id']));
			echo $this->Form->hidden('User.is_followup',array('value'=> $appointment['Appointment']['is_followup']));		       
			echo $this->Form->hidden('Prescription.parent_id',array('value'=> $appointment['Appointment']['parent_id']));
			echo $this->Form->hidden('Prescription.doctor_id',array('label'=>false,'div'=> false,'value'=> $this->Session->read('Auth.User.id')));
			echo $this->Form->hidden('Prescription.name',array('readonly'=>true,'label'=>false,'div'=> false,'value'=>$this->Session->read('Auth.User.name')));
			echo $this->Form->hidden('spentTime',array('id'=>'spentTime','type'=>'text','readonly'=> true)); 		
			?>
		     
		     </b></p>
                        <p>Age : <?php
				echo $age. $this->Form->hidden('User.age',array('label'=>false,'div'=> false,'value'=>$age));?>
				
			</p>
                        <p>Gender : <?php echo $gender[$appointment['Patient']['gender']]. $this->Form->hidden('User.gender',array('label'=>false,'div'=> false,'value'=>$gender[$appointment['Patient']['gender']])); ?></p>
                        <p>Weight : <?php echo $appointment['Appointment']['weight']. $this->Form->hidden('User.weight',array('label'=>false,'div'=> false,'value'=> $appointment['Appointment']['weight']));?></p>
                      <p>Phone : <?php echo $appointment['Patient']['phone']. $this->Form->hidden('User.phone',array('label'=>false,'div'=> false,'value'=>$appointment['Patient']['phone']));?></p>
                  </div>
            </div>
	   
           
         <div class="mid_wrapper">
           <div class="containt_mid" id="containt_prescription">
               
	       <div class="title_d"> 
                  <h> Last Prescription(For follow-up)</h> 
               </div>
	<?php if(!empty($followup)){ ?>
               <div class="Prescriptionf">
                     <div class="chief_title">
                         <div class="title_on">On Examination </div>
                     </div>
                   <div class="chief_area">
               <div class="menu_item2">
		<ul class="tabs">
		<?php //pr($followup); ?>
                <?php if(!empty($followup['Appointment']['pulse'])){
			?>
                <li> Pulse : <span><?php echo$followup['Appointment']['pulse']; ?>  (Beats per min)</span></li>
		
		<?php } ?>
		<?php if(!empty($followup['Appointment']['bp'])){ ?>
                <li>BP : <span> <?php echo $followup['Appointment']['bp']; echo '(mm/hg)';?></span></li>
		<?php } ?>
		<?php if(!empty($followup['Appointment']['temperature'])){?>
                <li>Temperature :<span> <?php echo $followup['Appointment']['temperature']; echo '( F )'; ?></span></li>
		<?php } ?>
		<?php if(!empty($respiration[$followup['Appointment']['respiration']])){?>
                <li>Respiration : <span><?php echo $respiration[$followup['Appointment']['respiration']]; ?></span></li>
		<?php } ?>
		<?php if(!empty($appearance[$followup['Appointment']['appearance']])){?>
                <li>Appearance :<span> <?php echo $appearance[$followup['Appointment']['appearance']] ;?> </span></li>
		<?php } ?>
		<?php if(!empty($color[$followup['Appointment']['color']])){?>
                <li>Color:<span> <?php echo $color[$followup['Appointment']['color']];?></span></li>
		<?php } ?>
		<?php if(!empty($consciousness[$followup['Appointment']['consciousness']])){?>
                <li>State of Consciousness :<span> <?php echo $consciousness[$followup['Appointment']['consciousness']];?></span></li>
		<?php } ?>
		<?php if(!empty($edema[$followup['Appointment']['edema']])){?>
		<li>Edema :<span> <?php echo $edema[$followup['Appointment']['edema']]; ?></span></li>
		<?php } ?>
		<?php if(!empty($dehydration[$followup['Appointment']['dehydration']])){ ?>
                <li>Dehydration :<span> <?php echo $dehydration[$followup['Appointment']['dehydration']];?></span></li>
		<?php } ?>
		<?php if(!empty($followup['Appointment']['arrhythmia'])){ ?>
                <li>Arrhythmia :<span> <?php echo $ari[$followup['Appointment']['arrhythmia']];?></span></li>
		<?php } ?>
		<?php if(!empty($followup['Appointment']['osat'])){ ?>
                <li>Oxygen saturation :<span> <?php echo $followup['Appointment']['osat'];?></span>%</li>
		<?php } ?>
                </ul>
            </div>
          </div>
	<?php $followupImage = '';
		if(!empty($followup['Appointment']['diseaseImage'])){
			$followupImage = explode(',',$followup['Appointment']['diseaseImage']);		
		}
		?>
           <div class="chief_title">
               <div class="title_on">Photos</div>
                  </div>
                     <div class="chief_area">
                        <div class="menu2">
                            <ul>
                                <?php
				if(!empty($followupImage)){
				foreach($followupImage as $image){?>
				    <li><a rel="Past" class ="fancybox-buttons fancybox"  href="<?php echo IMG_URL.'/uploads/'.$image ?>"> <?php echo $this->Html->image(IMG_URL.'/uploads/'.$image,array('width'=>66,'height'=>72)); ?> </a></li>
				
					<?php
					}
				} ?>
                            </ul>
                        </div>
                     </div>
                   <div class="chief_title">
                       <div class="title_chief">Chief Complaints</div>
                  </div>
                     <div class="chief_area">
                     <div class="control-groupf">  
                                    <h>Complain</h>  
                                        <p><?php echo $followup['Prescription']['complain'];?></p>
                                    </div>
                                    <div class="control-groupf">  
                                    <h>Diagnosis</h>
					<p><?php echo $followup['Prescription']['diagnosis'];?></p>  
                                    </div>
                                    <div class="control-groupf">  
                                    <h>Rx</h>  
                                        <p><?php echo $followup['Prescription']['prescription'];?></p>  
                                    </div>
                                    <div class="control-groupf">  
                                    <h>Advice</h>  
                                        <p><?php echo $followup['Prescription']['advice'];?></p>  
                                    </div>
                                    <div class="control-groupf">  
                                    <h>Investigations</h>  
                                        <p><?php echo $followup['Prescription']['investigations'];?></p>  
                                    </div>
                      </div>
                  </div>
	       <?php } ?>
	       
	       
           </div>
        <div class="containt_mid">
	
               <div class="title_d">
                  <h>Create New Prescription</h>
                     <div class="rmp_info">
                        <div class="menu2">
                           <ul class="tabs">
                                <li>RMP : <?php echo $rmp[0]['User']['name']. $this->Form->hidden('User.rmp',array('label'=>false,'div'=> false,'value'=>$rmp[0]['User']['name'])).$this->Form->hidden('User.rmp_id',array('label'=>false,'div'=> false,'value'=>$rmp[0]['User']['id']));?> </li>
                                <li>RMP ID : <?php echo $rmp[0]['User']['id'] ?> </li>
                                <li>RMP Phone : <?php echo $rmp[0]['User']['phone'];?> </li>   
                            </ul>
                       </div>
                   </div>
               </div>
                  <div class="Prescription">
                     <div class="chief_title">
                         <div class="title_on">On Examination </div>
                     </div>
                   <div class="chief_area">
               <div class="menu_item2">
                <ul class="tabs">
		<?php if(!empty($appointment['Appointment']['pulse'])){
			?>
                <li> Pulse : <span><?php echo $appointment['Appointment']['pulse']; ?>  (Beats per min)<?php echo $this->Form->hidden('Examination.pulse',array('readonly'=>true,'label'=>false,'value'=> $appointment['Appointment']['pulse']));?></span></li>
		
		<?php } ?>
		<?php if(!empty($appointment['Appointment']['bp'])){ ?>
                <li>BP : <span> <?php echo $appointment['Appointment']['bp']; echo '(mm/hg)';echo $this->Form->hidden('Examination.bp',array('readonly'=>true,'label'=>false,'value'=>$appointment['Appointment']['bp']));?></span></li>
		<?php } ?>
		<?php if(!empty($appointment['Appointment']['temperature'])){?>
                <li>Temperature :<span> <?php echo $appointment['Appointment']['temperature']; echo '( F )'; echo $this->Form->hidden('Examination.temperature',array('readonly'=>true,'label'=>false,'value'=>$appointment['Appointment']['temperature']));?></span></li>
		<?php } ?>
		<?php if(!empty($respiration[$appointment['Appointment']['respiration']])){?>
                <li>Respiration : <span><?php echo $respiration[$appointment['Appointment']['respiration']]; echo $this->Form->hidden('Examination.respiration',array('readonly'=>true,'label'=>false,'value'=>$respiration[$appointment['Appointment']['respiration']]));?></span></li>
		<?php } ?>
		<?php if(!empty($appearance[$appointment['Appointment']['appearance']])){?>
                <li>Appearance :<span> <?php echo $appearance[$appointment['Appointment']['appearance']] ;echo $this->Form->hidden('Examination.appearance',array('readonly'=>true,'label'=>false,'value'=>$appearance[$appointment['Appointment']['appearance']]));?> </span></li>
		<?php } ?>
		<?php if(!empty($color[$appointment['Appointment']['color']])){?>
                <li>Color:<span> <?php echo $color[$appointment['Appointment']['color']];echo $this->Form->hidden('Examination.color',array('readonly'=>true,'label'=>false,'value'=>$color[$appointment['Appointment']['color']]));?></span></li>
		<?php } ?>
		<?php if(!empty($consciousness[$appointment['Appointment']['consciousness']])){?>
                <li>State of Consciousness :<span> <?php echo $consciousness[$appointment['Appointment']['consciousness']];echo $this->Form->hidden('Examination.consciousness',array('readonly'=>true,'label'=>false,'value'=>$consciousness[$appointment['Appointment']['consciousness']]));?></span></li>
		<?php } ?>
		<?php if(!empty($edema[$appointment['Appointment']['edema']])){?>
		<li>Edema :<span> <?php echo $edema[$appointment['Appointment']['edema']]; echo $this->Form->hidden('Examination.edema',array('readonly'=>true,'label'=>false,'value'=>$edema[$appointment['Appointment']['edema']]));?></span></li>
		<?php } ?>
		<?php if(!empty($dehydration[$appointment['Appointment']['dehydration']])){ ?>
                <li>Dehydration :<span> <?php echo $dehydration[$appointment['Appointment']['dehydration']];echo $this->Form->hidden('Examination.dehydration',array('readonly'=>true,'label'=>false,'value'=>$dehydration[$appointment['Appointment']['dehydration']]));?></span></li>
		<?php } ?>
		<?php if(!empty($appointment['Appointment']['arrhythmia'])){ ?>
                <li>Arrhythmia :<span> <?php echo $ari[$appointment['Appointment']['arrhythmia']];echo $this->Form->hidden('Examination.arrhythmia',array('readonly'=>true,'label'=>false,'value'=>$ari[$appointment['Appointment']['arrhythmia']]));?></span></li>
		<?php } ?>
		<?php if(!empty($appointment['Appointment']['osat'])){ ?>
                <li>Oxygen saturation :<span> <?php echo $appointment['Appointment']['osat'];echo $this->Form->hidden('Examination.osat',array('readonly'=>true,'label'=>false,'value'=>$appointment['Appointment']['osat']));?></span> %</li>
		<?php } ?>
                </ul>
            </div>
          </div>
	<?php	$diseaseImage = '';
		if(!empty($appointment['Appointment']['diseaseImage'])){
			$diseaseImage = explode(',',$appointment['Appointment']['diseaseImage']);
		}
		?>
           <div class="chief_title">
               <div class="title_on">Photos</div>
                  </div>
                     <div class="chief_areap">
                        <div class="menu2">
                            <ul id="disseas_image">
				<?php
				if(!empty($diseaseImage)){
					foreach($diseaseImage as $image){?>
						<li><a rel="recent" class ="fancybox-buttons fancybox"  href="<?php echo IMG_URL.'/uploads/'.$image ?>"> <?php echo $this->Html->image(IMG_URL.'/uploads/'.$image,array('width'=>66,'height'=>72)); ?> </a></li>
				
				<?php
				}
					} ?>
                            </ul>
			   <a class="get_images" id="appointment_<?php echo $appointment_id ?>" href="javascript:void(0)">Get More Image </a>
                        </div>
                     </div>
                   <div class="chief_title">
                       <div class="title_chief">Chief Complaints</div>
                  </div>
                     <div class="chief_area">
				<div class="control-group">  
                                    <label class="control-label" for="textarea">Complain</label>  
                                        <div class="controls">  
                                           <?php echo $this->Form->input('complain',array('label'=>false,'class'=>'input-xlarge')); ?> 
                                        </div>  
				</div>
                                <div class="control-group">  
                                    <label class="control-label" for="textarea">Diagnosis</label>  
                                        <div class="controls">  
                                           <?php echo $this->Form->input('diagnosis',array('label'=>false,'class'=>'input-xlarge')); ?>  
                                        </div>  
                                </div>
                                <div class="control-group">  
                                    <label class="control-label" for="textarea">Rx</label>  
                                        <div class="controls">  
                                            <?php  echo $this->Form->input('Prescription.prescription',array('label'=>false,'class'=>'input-xlarge'));  ?>
                                        </div>  
                                </div>
                                <div class="control-group">  
                                    <label class="control-label" for="textarea">Advice</label>  
                                        <div class="controls">  
                                           <?php echo $this->Form->input('Prescription.advice',array('label'=> false,'class'=>'input-xlarge')); ?>
                                        </div>  
                                </div>
                                <div class="control-group">  
                                    <label class="control-label" for="textarea">Investigations</label>  
                                        <div class="controls">  
                                           <?php  echo $this->Form->input('Prescription.investigations',array('label'=>false,'class'=>'input-xlarge'));  ?> 
                                        </div>  
                                </div> 
                                <div class="control-group">
                                      
                                    <label class="control-label" for="select01">Would you like to set a follow up appointment?</label>  
                                        <div class="controls">  
                                            <?php echo $this->Form->input('is_followup',array('label'=> false,'options'=> array('1'=>'No','2'=>'Yes'))); ?> 
                                        </div>
					<div id="follow" style="display: none">
					 <label class="control-label" for="select01">Please set a date for the follow-up appointment</label>
					<?php echo $this->Form->input('followupDate',array('label'=>false,'id'=>'followupDate','type'=>'text')); ?>
					</div>
                                    <label class="control-label" for="select01">Payment Type</label>  
                                        <div class="controls">  
                                           <?php echo $this->Form->input('paymentType',array('label'=>false,'options'=>$unit_cost,'empty'=>'Please Select','selected'=>$unit_cost_id)); ?>
                                        </div>  
                                </div>
				<div class="clear"></div>
				<div class="control-group_button">
                                <div class="form-actions">  
                                    
					<?php echo $this->Form->submit('Send Prescription', array('div'=> false,'id'=>'submit','class'=>'btn btn-primary')); ?>
					
					<?php echo '&nbsp;&nbsp'; echo $this->Form->submit('Reject', array('div'=> false,'id'=>'reject','class'=>'btn')); ?>
					<?php
					echo '&nbsp';
					echo $this->Html->link(__('Cancel'), array(
						'controller'=>'Users','action' => 'appointment',$appointment_id
					    ), array(
						'class' => 'btn pure-button pure-button-success',
					    )); ?>
                                 </div>
				</div>
				
                           
                      </div>
                  </div> 
           </div>
       </div>
       <?php  echo $this->Form->end(); ?>
       
       <div class="containt_right">
           <div class="title_d">
           <h>Past Prescription</h>
           </div>
           <div class="date_box" id="past_prescription">
		<?php foreach($prescription_list as $key=>$prescription){ ?>               
	       <p><a class="prescription_list" id="prescription_<?php echo $prescription['Prescription']['id']?>" href="javascript:void(0)"><?php echo $prescription['Prescription']['created']?> </a>
		<?php if($prescription['Prescription']['is_followup']==1 AND $prescription['Prescription']['followupstatus'] ==1){ ?>
			<a class="status_list" id="status_<?php echo $prescription['Prescription']['id']?>_0_<?php echo $appointment['Patient']['id'] ?>" href="javascript:void(0)"><?php echo $this->Html->image('f.png'); ?> </a>
		<?php } elseif($prescription['Prescription']['is_followup']==1  AND $prescription['Prescription']['followupstatus'] ==0){ ?>
			<a class="status_list" id="status_<?php echo $prescription['Prescription']['id']?>_1_<?php echo $appointment['Patient']['id'] ?>" href="javascript:void(0)"><?php echo $this->Html->image('uf.png'); ?> </a>
		<?php } ?>
		</p>
                <?php } ?>
		
           </div>
       </div>
       
       

 </div>
   

<div id="popup_box">    <!-- Our PopupBox DIV-->
    
    <a id="popupBoxClose">Close</a>
    <?php
	echo $this->Form->create('Appointment');
	echo $this->Form->hidden('Appointment.appointment_id',array('value'=>  $appointment['Appointment']['id']));
	echo '<div class="chief_area">'; ?>
	
	<div class="control-group">  
        <label class="control-label_reject" for="textarea">Comments</label>  
                <div class="controls">  
                <?php echo $this->Form->input('Appointment.comments',array('label'=> false,'class'=>'input-xlarge_reject')); 
		echo $this->Form->hidden('Paramedic.rmp_id',array('label'=>false,'div'=> false,'value'=>$rmp[0]['User']['id']));
		echo $this->Form->hidden('Paramedic.name',array('label'=>false,'div'=>false,'value'=>$appointment['Patient']['name']));
		
		?>
                </div>  
        </div>
	<?php 
	
	echo '</div>';
	echo $this->Form->submit('Submit', array('div'=> true,'id'=>'delete','class'=>'btn btn-primary'));
	echo $this->Form->end();
	?>
</div>


<div class="clear"></div>
<div id="ajaxcircle" style="display: none"; > <?php echo $thumbnail= $this->Html->image('wait26.gif'); ?> <br /> </div>
<br />

<div class="video">
<span style="display: inline" id="step2">
<div id="reply">Please wait for reply </div>
<span class="pure-form">
<input  id="callto-id" type="hidden" value="<?php echo 'RMP00'.$rmp[0]['User']['id'] ?>">
<input type="hidden" value="<?php echo 'doctor0'.$this->Session->read('Auth.User.id') ; ?>" id="doctorId">
<a href="javascript:void(0)" class="btn pure-button pure-button-success" id="make-call">Call to <?php echo $rmp[0]['User']['name'] ?></a>
</span>	
<span id="videoContainer" ID="videoContainer" style="position:relative; width:747px; height:480px;float: right;margin: 0px;">
	
</span>
</div> 
<script>
	var vlineClient = (function(){
	  var client, vlinesession,
		authToken = '<?php echo $vline->getJWT() ?>',
		serviceId = '<?php echo $vline->getServiceID() ?>',
		profile = {"displayName": '<?php echo $vline->getUserDisplayName() ?>', "id": '<?php echo $vline->getUserID() ?>'};
	
	  
	  window.vlineClient = client = vline.Client.create({
		"serviceId": serviceId, 
		"uiOutgoingDialog": true, 
		"uiIncomingDialog": true, 
		"uiVideoPanel": "videoContainer"
	});
	  
	client.on('login', onLogin);
	client.login(serviceId, profile, authToken);
	function onLogin(event) {
		vlinesession = event.target;
		vlinesession.on('enterState:incoming', function(){
		   $.ajax({
				async:true,					
				dataType: "html",
				url:siteurl+"Users/callwarn/",
				success:function (data) {						
					$("#sound").html(data);
				},
				type:"post"				
			});				
			return false;
		})
		vlinesession.on('enterState:active', function(){
			
		    $("#reply").html('Call in progress.........');
		    $("#make-call").css("display","none");
		    $("#sound").html('');
		})
		
		vlinesession.on('exitState:active', function(){
		    $("#reply").html('');
		    $("#make-call").css("display","inline");
		})
		var userId = $("#mainCaller").attr('data-userid');
		initCallButton($("#mainCaller"));	
	}
	function initCallButton(button) {		
		var userId = button.attr('data-userid');
		vlinesession.getPerson(userId).done(function(person) {
		  function onPresenceChange() {
			if(person.getPresenceState() == 'online'){
			    button.removeClass().addClass('active');
			}else{
			    button.removeClass().addClass('disabled');
			}
			button.attr('data-presence', person.getPresenceState());
		  }
		onPresenceChange();
		person.on('change:presenceState', onPresenceChange);
		button.click(function() {
		      	  if (person.getId() == vlinesession.getLocalPersonId()) {
				alert('You cannot call yourself. Login as another user in an incognito window');
				return;
		       	  }
			  if(button.hasClass('active'))
				
				vlineMediaSession = person.startMedia();
				vLineMediaSession.on("")
				vlineMediaSession.setAudioMuted(true);
				
		  });
		});
		
	  }
	  
	  return client;
	})();
	
	$(window).unload(function() {
	    vlineClient.logout();
	  
	});
	</script>
	
<script type="text/javascript">

	$(function() {  
		
		$(document.body).on('click', '.bt' ,function(){  
			window.onbeforeunload = null;
			
		});
		$(document.body).on('click', '.btn' ,function(){  
			 window.onbeforeunload = null;
			 
			
		}); 
			
		
		
	      
		
	});
	 window.onbeforeunload = function (event) {
		var message = 'Important: Please click on \'Cancel\' button to leave this page.';
		if (typeof event == 'undefined') {
		 event = window.event;
		}
		if (event) {					  
		 event.returnValue = message;
		}
		 return message;
       };
</script> 
<div  id="sound"> </div>

