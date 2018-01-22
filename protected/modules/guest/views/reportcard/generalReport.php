
<?php

/* @var $this ReportCardController */
/* @var $model ReportCard */

?>


	
			

	

	
<!-- Menu of CRUD  -->

<div id="dash">
          
          <div class="span3"><h2>
          <?php  
		
	       echo Yii::t('app','General reports'); 
		?>
             
       </h2> </div>
              
              
      <div class="span3">
           
         </div> 		   

 </div>

<div style="clear:both"></div>	


</br>
<div class="b_mail">
<div class="form">
<?php 
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'generalReport',
	
)); 
echo $this->renderPartial('_generalReport', array(
	'model'=>$model,
	'form' =>$form
	)); ?>
	



<?php $this->endWidget(); ?>


</div>
</div>
