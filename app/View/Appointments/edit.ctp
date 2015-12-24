 <script>
$(function() {
	var availableTags = [<?php echo $userName ?>];
	$( "#AppointmentPatientId" ).autocomplete({
	source: availableTags
	});
});
</script>
<?php
	$model =  Inflector::singularize($this->request->params['controller']);		  
	$v = ucfirst($model);
?>
<span class="titleLeft"><?php echo $title_for_layout ;?></span> 
<div class="gap"></div>

<?php echo $this->Form->create($v);

	echo $this->Form->input('id');
	echo $this->Form->input('patient_id',array('type'=>'text','class'=>'ui-widget'));
	echo $this->Form->input('age',array('label'=>'Age (12 years 5 month)'));
	echo $this->Form->input('weight',array('label'=> 'Weight (34 Kg 23 Gm)'));
	echo $this->Form->input('pulse',array('label'=>'Pulse (Beats per min)'));
	echo $this->Form->input('bp',array('label'=>'BP(mm/hg)'));
	echo $this->Form->input('temperature',array('label'=>'Temperature(F)'));
	echo $this->Form->input('respiration',array('options'=> array('High'=>'High','Normal' => 'Normal','Low'=> 'Low'),'empty'=> 'Please Select'));
	echo $this->Form->input('appearance',array('options'=> array('ll-Looking'=>'lll-Looking','Normal' => 'Normal','Toxi'=> 'Toxic'),'empty'=> 'Please Select'));
	echo $this->Form->input('color',array('options'=> array('Anemic(Pale)'=>'Anemic(Pale)','Normal' => 'Normal','Jaundiced(Yellow)'=> 'Jaundiced(Yellow)'),'empty'=> 'Please Select'));
	echo $this->Form->input('consciousness',array('options'=> array('Conscious'=>'Conscious','Semi-Conscious' => 'Semi-Conscious','Unconscious'=> 'Unconscious'),'empty'=> 'Please Select'));
	echo $this->Form->input('edema',array('options'=> array('Present'=>'Present','Absent' => 'Absent'),'empty'=> 'Please Select'));
	echo $this->Form->input('dehydration',array('options'=> array('Present'=>'Present','Absent' => 'Absent'),'empty'=> 'Please Select'));
	echo $this->Form->input('enlargement',array('options'=> array('Liver'=>'Liver','Spleen' => 'Spleen','None'=>'None'),'empty'=> 'Please Select'));
	    
 
 ?>


<?php
    echo $this->Form->submit('Save', array('div'=> false));
    echo $this->Html->link(__('Cancel'), array(
	'action' => 'index'
    ), array(
	'class' => 'cancel',
    ));
		
    echo $this->Form->end();
?>
