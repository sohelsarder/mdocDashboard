 <?php
 if(!empty($appointment['Appointment']['diseaseImage'])){
 $followupImage = explode(',',$appointment['Appointment']['diseaseImage']); ?>
<ul id="disseas_image">
	       <?php foreach($followupImage as $image){?>
			       <li><a rel="Past" class ="fancybox-buttons fancybox"  href="<?php echo IMG_URL.'/uploads/'.$image ?>"> <?php echo $this->Html->image(IMG_URL.'/uploads/'.$image,array('width'=>66,'height'=>72)); ?> </a></li>
				
		<?php } ?>
</ul>
 <?php } ?>                      