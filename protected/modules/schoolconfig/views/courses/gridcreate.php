<?php
/* @var $this ReportcardObservationController */
/* @var $model ReportcardObservation */


?>

<div id="dash">
          
          <div class="span3"><h2>
              <?php echo Yii::t('app','Create course with grid');?>
              
          </h2> </div>
   
    <div class="span3">
        <div class="span4">
             
        
           <?php
                    $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                     echo CHtml::link($images,array('/schoolconfig/courses/index')); 
                    // $this->back_url='/configuration/reportcardObservation/index';
                    ?>
        </div>
    </div>
</div>




<div style="clear:both"></div>

</br>
<div class="b_mail">


    
    
<?php echo $this->renderPartial('_gridcreate', array('model'=>$model)); ?>

</div>