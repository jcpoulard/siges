<!-- Menu of CRUD  -->

		
<div id="dash">
		<div class="span3"><h2>
		      
       <?php  	
	      echo Yii::t('app','End Year Decision'); 
		?>
              
        </h2> </div>
              
              
      <div class="span3">
             <div class="span4">

                      <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard

                                echo CHtml::link($images,array('/academic/persons/listforreport?isstud=1&from=stud')); 
                                $this->back_url='/academic/persons/listforreport?isstud=1&from=stud';   
                     
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
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
	
)); 


echo $this->renderPartial('_endYearDecision', array(
	'model'=>$model,
	'form' =>$form
	)); ?>


<?php $this->endWidget(); ?>

</div>
</div>
