
<div class="hero-unit">
<?php 
$model =  Inflector::singularize($this->request->params['controller']);
$v = ucfirst($model);
?>
<span class="titleLeft"><?php echo $title_for_layout ;?></span> 
<div class="gap"></div>
<?php echo $this->Form->create($v, array('type'=>'file'));?>
<?php	echo $this->Form->input('name',array('class'=>'input-text'));				
	echo $this->Form->input('email',array('class'=>'input-text'));
	echo $this->Form->input('phone',array('class'=>'input-text'));
	echo $this->Form->input('available_time',array('class'=>'input-textarea'));
	echo $this->Form->input('speciality',array('placeholder'=>'Hearth , Brain','class'=>'input-text')); 
	echo $this->Form->input('doctor_identity',array('label'=>'Doctor Identity','class'=>'input-textarea'));
	echo $this->Form->hidden('status', array('value'=> 1));
	echo $this->Form->hidden('role_id', array('value'=>2));
	echo $this->Form->input('password',array('class'=>'input-text'));			
	echo $this->Form->input('verify_password', array('type' => 'password','class'=>'input-text'));
	echo $this->Form->label('Signature'); ?>
	<input type="file" name="image"/>
	<br /><br />
	<?php
	echo $this->Form->submit('Save', array('div'=> false,'class'=>'btn'));
	echo '&nbsp;'. $this->Html->link(__('Cancel'), array(
		'action' => 'userlists'
	), array( 'class' => 'btn pure-button pure-button-success',
	));
	echo $this->Form->end();
	?>
	

</div>



