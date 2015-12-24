<?php
 echo $this->Html->css(array(
			'jquery.fancybox-buttons',
			'jquery.fancybox',
			'popup',
			'call'
    ));
    echo $this->Html->script(array(   
   'jquery.fancybox',   
   'jquery.fancybox-buttons',
   'prescription'
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
    $(document).ready(function () {
	$("#submitEdit").on("click", function (event) {	    
	    var data = $("#PrescriptionEditForm").serialize();	   
	    $.ajax({
		async:true,		   
		dataType: "html",
		data: data,
		url:siteurl+"Prescriptions/addprescriptions/",
		success:function (data) {
		    if (data == 1) {
			window.location.href = siteurl+"Prescriptions"; 
		    }else{
			
		    }
		   
		},
		type:"post"
				
	    });			
	    return false; 
	});
	
    });
    
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
<div id="dialog" title="Prescription Preview">
		
</div>
<?php $model =  Inflector::singularize($this->request->params['controller']);
$v = ucfirst($model);
$dob = json_decode($dob,true);
$age = $dob['y']. ' Y(s) '.$dob['m'].' M(s) '.$dob['d']. ' D(s)';
//pr($appointment);

if(!empty($appointment['Appointment']['is_followup'])){	
	unset($unit_cost[NEWAPP]);
	$unit_cost[FOLLOWUP]= 'Paid';
}else{
	unset($unit_cost[FOLLOWUP]);
	$unit_cost[NEWAPP]= 'Paid';
}
?>

<?php echo $this->Form->create($v); ?>  
<div class="containt_left">
               <div class="title_d">
              <h> Patient Profile</h>
               </div>
                  <div class="photo"><?php echo $this->Html->image(IMG_URL.'/uploads/'.$appointment['Appointment']['Patient']['image'],array('width'=>143,'height'=>164)); ?></div>
                  <div class="card_detail">
                     <p><b><?php echo $appointment['Appointment']['Patient']['name']. $this->Form->hidden('User.name',array('label'=>false,'div'=>false,'value'=>$appointment['Appointment']['Patient']['name'])); ?>
		     <?php
			echo $this->Form->input('id');
			echo $this->Form->hidden('parent_id');
			echo $this->Form->hidden('patient_id',array('value'=> $appointment['Appointment']['Patient']['id']));
			//echo $this->Form->hidden('spentTime',array('id'=>'spentTime','type'=>'text','value'=>$appointment['Prescription']['spentTime']));
			echo $this->Form->hidden('appointment_id',array('value'=>  $appointment['Appointment']['id']));
			echo $this->Form->hidden('pdf',array('value'=>  $appointment['Prescription']['pdf']));
			echo $this->Form->hidden('User.is_followup',array('value'=> $appointment['Appointment']['is_followup']));		
			?>
		     
		     </b></p>
                        <p>Age : <?php
				echo $age. $this->Form->hidden('User.age',array('label'=>false,'div'=> false,'value'=>$age));?>
				
			</p>
                        <p>Gender : <?php echo $gender[$appointment['Appointment']['Patient']['gender']]. $this->Form->hidden('User.gender',array('label'=>false,'div'=> false,'value'=>$gender[$appointment['Appointment']['Patient']['gender']])); ?></p>
                        <p>Weight : <?php echo $appointment['Appointment']['weight']. $this->Form->hidden('User.weight',array('label'=>false,'div'=> false,'value'=> $appointment['Appointment']['weight']));?></p>
                      <p>Phone : <?php echo $appointment['Appointment']['Patient']['phone']. $this->Form->hidden('User.phone',array('label'=>false,'div'=> false,'value'=>$appointment['Appointment']['Patient']['phone']));?></p>
                  </div>
            </div>
	   
           
         <div class="mid_wrapper">
		
           <div class="containt_mid" id="containt_prescription">
               <div class="title_d"> 
                  <h> Last Prescription(For follow-up)</h> 
               </div>
	       
           </div>        
        <div class="containt_mid">
	
               <div class="title_d">
                  <h>Edit Patient Prescription</h>
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
                <li>Oxygen saturation :<span> <?php echo $appointment['Appointment']['osat'];echo $this->Form->hidden('Examination.osat',array('readonly'=>true,'label'=>false,'value'=>$appointment['Appointment']['osat']));?></span></li>
		<?php } ?>
                </ul>
            </div>
          </div>
	     <?php $diseaseImage ='';
		if(!empty($appointment['Appointment']['diseaseImage'])){
		    $diseaseImage = explode(',',$appointment['Appointment']['diseaseImage']);
		}
		
		?>
           <div class="chief_title">
               <div class="title_on">Photos</div>
                  </div>
                     <div class="chief_area">
                        <div class="menu2">
                            <ul>
                                <?php
				if(!empty($diseaseImage)){
				    foreach($diseaseImage as $image){?>
				      <li><a rel="Past" class ="fancybox-buttons fancybox"  href="<?php echo IMG_URL.'/uploads/'.$image ?>"> <?php echo $this->Html->image(IMG_URL.'/uploads/'.$image,array('width'=>66,'height'=>72)); ?> </a></li>
				
				<?php
				    }
				}  
				    ?>
                            </ul>
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
					<?php if(!empty($appointment['Prescription']['is_followup'])){ ?>
					<div id="follow" style="display: block">
					 <label class="control-label" for="select01">Please set a date for the follow-up appointment</label>
					<?php echo $this->Form->input('followupDate',array('label'=>false,'id'=>'followupDate','type'=>'text')); ?>
					</div>
					<?php }else{ ?>
					<div id="follow" style="display: none">
					 <label class="control-label" for="select01">Please set a date for the follow-up appointment</label>
					<?php echo $this->Form->input('followupDate',array('label'=>false,'id'=>'followupDate','type'=>'text')); ?>
					</div>
					<?php } ?>
                                    <label class="control-label" for="select01">Payment Type</label>  
                                        <div class="controls">  
                                           <?php echo $this->Form->input('paymentType',array('label'=>false,'options'=>$unit_cost,'empty'=>'Please Select')); ?>
                                        </div>  
                                </div>
				<div class="control-group_button">
                                <div class="form-actions">  
                                    
					<?php echo $this->Form->submit('Send Prescription', array('div'=> false,'id'=>'submitEdit','class'=>'btn btn-primary')); ?>
					<?php 
					echo $this->Html->link(__('Cancel'), array(
						'action' => 'index'
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
			<a class="status_list" id="status_<?php echo $prescription['Prescription']['id']?>_0_<?php echo $appointment['Appointment']['Patient']['id'] ?>" href="javascript:void(0)"><?php echo $this->Html->image('f.png'); ?> </a>
		<?php } elseif($prescription['Prescription']['is_followup']==1  AND $prescription['Prescription']['followupstatus'] ==0){ ?>
			<a class="status_list" id="status_<?php echo $prescription['Prescription']['id']?>_1_<?php echo $appointment['Appointment']['Patient']['id'] ?>" href="javascript:void(0)"><?php echo $this->Html->image('uf.png'); ?> </a>
		<?php } ?>
		</p>
                <?php } ?>
		
           </div>
       </div>
       
       

 </div>
