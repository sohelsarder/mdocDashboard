<?php
	$model =  Inflector::singularize($this->request->params['controller']);		  
	$v = ucfirst($model);
?>

<span class="titleLeftForm"><?php echo $title_for_layout ;?></span> 
<div class="gap"></div>
<?php echo $this->Form->create($v); ?>
<?php echo $this->Form->input('system_id',array('empty'=>'Please Select')); ?>
<?php echo $this->Form->input('name'); ?>
<?php echo $this->Form->input('prescription'); ?>
<?php echo $this->Form->input('advice'); ?>
<?php echo $this->Form->input('investigations'); ?>


<?php
    echo $this->Form->submit('Save', array('div'=> false));
    echo $this->Html->link(__('Cancel'), array(
	'action' => 'index'
    ), array(
	'class' => 'cancel',
    ));
		
    echo $this->Form->end();
?>
