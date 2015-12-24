
               <div class="title_d"> 
                  <h> Last Prescription(For follow-up)</h> 
               </div>
               <div class="Prescriptionf">
                     <div class="chief_title">
                         <div class="title_on">On Examination </div>
                     </div>
                   <div class="chief_area">
               <div class="menu_item2">
		<ul class="tabs">
                <?php if(!empty($prescription['Appointment']['pulse'])){
			?>
                <li> Pulse : <span><?php echo $prescription['Appointment']['pulse']; ?>  (Beats per min)</span></li>
		
		<?php } ?>
		<?php if(!empty($prescription['Appointment']['bp'])){ ?>
                <li>BP : <span> <?php echo $prescription['Appointment']['bp']; echo '(mm/hg)';?></span></li>
		<?php } ?>
		<?php if(!empty($prescription['Appointment']['temperature'])){?>
                <li>Temperature :<span> <?php echo $prescription['Appointment']['temperature']; echo '( F )'; ?></span></li>
		<?php } ?>
		<?php if(!empty($respiration[$prescription['Appointment']['respiration']])){?>
                <li>Respiration : <span><?php echo $respiration[$prescription['Appointment']['respiration']]; ?></span></li>
		<?php } ?>
		<?php if(!empty($appearance[$prescription['Appointment']['appearance']])){?>
                <li>Appearance :<span> <?php echo $appearance[$prescription['Appointment']['appearance']] ;?> </span></li>
		<?php } ?>
		<?php if(!empty($color[$prescription['Appointment']['color']])){?>
                <li>Color:<span> <?php echo $color[$prescription['Appointment']['color']];?></span></li>
		<?php } ?>
		<?php if(!empty($consciousness[$prescription['Appointment']['consciousness']])){?>
                <li>State of Consciousness :<span> <?php echo $consciousness[$prescription['Appointment']['consciousness']];?></span></li>
		<?php } ?>
		<?php if(!empty($edema[$prescription['Appointment']['edema']])){?>
		<li>Edema :<span> <?php echo $edema[$prescription['Appointment']['edema']]; ?></span></li>
		<?php } ?>
		<?php if(!empty($dehydration[$prescription['Appointment']['dehydration']])){ ?>
                <li>Dehydration :<span> <?php echo $dehydration[$prescription['Appointment']['dehydration']];?></span></li>
		<?php } ?>
		<?php if(!empty($prescription['Appointment']['arrhythmia'])){ ?>
                <li>Arrhythmia :<span> <?php echo $ari[$prescription['Appointment']['arrhythmia']];?></span></li>
		<?php } ?>
		<?php if(!empty($prescription['Appointment']['osat'])){ ?>
                <li>Oxygen saturation :<span> <?php echo $prescription['Appointment']['osat'];?></span> %</li>
		<?php } ?>
                </ul>
            </div>
          </div>
	    <?php $followupImage = '';
		if(!empty($prescription['Appointment']['diseaseImage'])){
		    $followupImage = explode(',',$prescription['Appointment']['diseaseImage']);//pr($followupImage)
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
					 <li><a rel="follow" class ="fancybox-buttons fancybox"  href="<?php echo IMG_URL.'/uploads/'.$image ?>"> <?php echo $this->Html->image(IMG_URL.'/uploads/'.$image,array('width'=>66,'height'=>72)); ?> </a></li>
				
				<?php }
				}
				?>
                            </ul>
                        </div>
                     </div>
                   <div class="chief_title">
                       <div class="title_chief">Chief Complaints</div>
                  </div>
                     <div class="chief_area">
                     <div class="control-groupf">  
                                    <h>Complain</h>  
                                        <p><?php echo $prescription['Prescription']['complain']; ?></p>
                                    </div>
                                    <div class="control-groupf">  
					<h>Diagnosis</h>
					<p><?php echo $prescription['Prescription']['diagnosis'];  ?></p>  
                                    </div>
                                    <div class="control-groupf">  
                                    <h>Rx</h>  
                                    <p><?php echo $prescription['Prescription']['prescription']; ?></p>  
                                    </div>
                                    <div class="control-groupf">  
                                    <h>Advice</h>  
                                    <p><?php echo $prescription['Prescription']['advice']; ?></p>  
                                    </div>
                                    <div class="control-groupf">  
                                    <h>Investigations</h>  
                                    <p><?php echo $prescription['Prescription']['investigations']; ?></p>  
                                    </div>
                                    
                                     
                                    
                      </div>
                  </div>
          