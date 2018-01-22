<?php
$this->breadcrumbs=array(
	Yii::t('app','Admitted')=>array('admitted'),
	
);
?>

	
<!-- Menu of CRUD  -->

		
<div id="dash">
		<div class="span3"><h2>
      
       <?php  
	      echo Yii::t('app','Admitted Students, By Room'); 
		?>
       
       </h2> </div>
           
           
      <div class="span3">
             <div class="span4">

                      <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                    
					    echo CHtml::link($images,array('/reports/reportcard/generalreport')); 
                   ?>

                  </div>  
          </div>
 </div>
 
<div style="clear:both"></div>	


</br>
<div class="b_mail">
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'reportCard-form',
	
)); 
echo $this->renderPartial('_admittedByRoom', array(
	'model'=>$model,
	'form' =>$form
	)); ?>


<?php $this->endWidget(); ?>

</div>
</div>
