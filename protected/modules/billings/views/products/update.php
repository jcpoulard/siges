<?php
/* @var $this ProductsController */
/* @var $model Products */


?>

<div id="dash">
          
          <div class="span3"><h2>
              <?php echo Yii::t('app','Update : {name}',array('{name}'=>$model->product_name)); ?>
              
          </h2> </div>
    
    <div class="span3">
         <div class="span4">
                  <?php
                     $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';
                               // build the link in Yii standard
                     echo CHtml::link($images,array('products/create')); 
                   ?>
               </div>
               
               <div class="span4">
                      <?php
                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                               // build the link in Yii standard
                     echo CHtml::link($images,array('/billings/products/index')); 
                   ?>
               </div>
    </div> 
    </div>
 
<div style="clear:both"></div>



<?php
    echo $this->renderPartial('//layouts/navBaseInventory',NULL,true);	
?>

<?php echo $this->renderPartial('_form', array('model'=>$model,'stock'=>$stock)); ?>