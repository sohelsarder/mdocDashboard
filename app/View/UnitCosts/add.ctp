<?php	  
	$v = 'UnitCost';
?>

<span class="titleLeftForm"><?php echo $title_for_layout ;?></span> 
<div class="gap"></div>
<?php echo $this->Form->create($v); ?>
<?php echo $this->Form->input('name'); ?>
<?php echo $this->Form->input('amount',array('type'=>'text','label'=> 'Amount '.$currency)); ?>
<?php echo $this->Form->input('mpower_amount',array('type'=>'text','label'=> 'mPower Amount '.$currency)); ?>
<?php echo $this->Form->input('rmp_amount',array('type'=>'text','label'=> 'RMP Amount '.$currency)); ?>
<br />
<?php
    echo $this->Form->submit('Save', array('div'=> false,'class'=>'btn'));
    echo '&nbsp;'. $this->Html->link(__('Cancel'), array(
	'action' => 'index'
    ), array(
	'class' => 'btn pure-button pure-button-success',
    ));
		
    echo $this->Form->end();
?>
