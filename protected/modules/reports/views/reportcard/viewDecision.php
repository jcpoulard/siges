
<?php

/* @var $this ReportCardController */
/* @var $model ReportCard */

?>


	
			

	

	
<div class="form">
<?php 
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'endYearDecision',
	
)); 
echo $this->renderPartial('_viewDecision', array(
	'model'=>$model,
	'form' =>$form
	)); ?>
	



<?php $this->endWidget(); ?>

</div>

