<?php
    if(!empty($diseaseList)){
        
        echo $this->Form->input('Prescription.disease_id',array('options'=>$diseaseList,'empty'=>'Select Disease','div'=>false,'label'=>false));
    }else{
        echo $this->Form->input('Prescription.disease_id',array('options'=>'','empty'=>'Select Disease','div'=>false,'label'=>false));
    }
?>