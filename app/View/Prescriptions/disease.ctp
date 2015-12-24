<table>
    
    <?php 
    if(!empty($diseaseList)){
        foreach($diseaseList as $key => $val): 
        echo '<div class="clear">';
        echo '<tr>';
        /*echo '<td>';
        echo $this->Form->label('Medicine : ');
        echo $this->Form->input('Condition.'.$key.'.name',array('type'=>'text','value'=>$val['Disease']['name'],'div'=>false,'label'=>false));
        echo '</td>'; */
        echo '<td>';
        echo $this->Form->label('Prescription : ');
        echo $this->Form->input('Prescription.prescription',array('type'=>'textarea','value'=>$val['Disease']['prescription'],'div'=>false,'label'=>false)); 
        echo '</td>';
        echo '<td>';
        echo $this->Form->label('advice : ');
        echo $this->Form->input('Prescription.advice',array('type'=>'textarea','value'=>$val['Disease']['advice'],'div'=>false,'label'=>false)); 
        echo '</td>';
        echo '<td>';
        echo $this->Form->label('Investigations : ');
        echo $this->Form->input('Prescription.investigations',array('type'=>'textarea','value'=>$val['Disease']['investigations'],'div'=>false,'label'=>false)); 
        echo '</td>';
        echo '<td>';
        echo '</tr>';
        echo '</div>';
        
        endforeach;
    } ?>
</table>

