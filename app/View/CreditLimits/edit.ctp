<?php
$v = 'Paramedic';
?>
<span class="titleLeft"><?php echo $title_for_layout ;?></span> 
<div class="gap"></div>

<?php echo $this->Form->create($v);
	echo $this->Form->input('id');
	echo $this->Form->input('name',array('readonly'=> true)); 
	echo $this->Form->input('creditLimit',array('type'=>'text','label'=> 'Amount '.$currency));

 ?><br />
<?php
    echo $this->Form->submit('Save', array('div'=> false,'class'=> 'btn'));
    echo '&nbsp;'.$this->Html->link(__('Cancel'), array(
	'action' => 'index'
    ), array(
	'class' => 'btn',
    ));
		
    echo $this->Form->end();
?>
