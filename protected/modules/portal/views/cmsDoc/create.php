<?php
/* @var $this CmsDocController */
/* @var $model CmsDoc */


?>

<div id="dash">
   <div class="span3">
       <h2>
        <?php echo Yii::t('app','Manage documents');?>
        
    </h2> 
   </div>
    
    <div class="span3">
        <div class="span4">
            <?php
                     $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';
                               // build the link in Yii standard
                     echo CHtml::link($images,array('cmsDoc/create')); 
            ?>
        </div>
        
        
        
        <div class="span4">
            <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                     echo CHtml::link($images,array('/portal/cmsDoc/index')); 

                    ?>
        </div>
    </div>
</div>
<div class="clear"></div>


<?php
    echo $this->renderPartial('//layouts/navBasePortal',NULL,true);	
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>