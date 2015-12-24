<?php foreach($prescription_list as $key=>$prescription){ ?>
    <p>
    <a class="prescription_list" id="prescription_<?php echo $prescription['Prescription']['id']?>" href="javascript:void(0)"><?php echo $prescription['Prescription']['created']?> </a>
	<?php if($prescription['Prescription']['is_followup']==1 AND $prescription['Prescription']['followupstatus'] ==1){ ?>
	<a class="status_list" id="status_<?php echo $prescription['Prescription']['id']?>_0_<?php echo $patient_id ?>" href="javascript:void(0)"><?php echo $this->Html->image('f.png'); ?> </a>
	<?php } elseif($prescription['Prescription']['is_followup']==1  AND $prescription['Prescription']['followupstatus'] ==0){ ?>
	<a class="status_list" id="status_<?php echo $prescription['Prescription']['id']?>_1_<?php echo $patient_id ?>" href="javascript:void(0)"><?php echo $this->Html->image('uf.png'); ?> </a>
   </p>
    <?php } ?>
<?php } ?>
		
