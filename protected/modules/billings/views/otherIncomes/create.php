<?php 
/*
 * © 2015 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
 * 
 * This file is part of SIGES.

    SIGES is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License.

    SIGES is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with SIGES.  If not, see <http://www.gnu.org/licenses/>.
 * 
 */

?>
<?php
/* @var $this OtherIncomesController */
/* @var $model OtherIncomes */


$acad=Yii::app()->session['currentId_academic_year'];


$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); 

 if((isset($_GET['p'])&&($_GET['p']!='')&&($_GET['p_id']!=0))&&(isset($_GET['p_id'])&&($_GET['p_id']!='')&&($_GET['p_id']!=0)))
	   $disabled='disabled';
  else
     $disabled='';
?>



<div id="dash">
          
          <div class="span3"><h2>
              <?php echo Yii::t('app','Add other incomes'); ?>
              
          </h2> </div>
     
		   <div class="span3">
		   
<?php if($disabled==''){  ?>      
       
    <div class="span4">
                  <?php

                 $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                           // build the link in Yii standard
                  
                 if($this->recettesItems==1)
                     echo CHtml::link($images,array('/billings/otherIncomes/index/part/rec/ri/1/from/stud'));
                  elseif($this->recettesItems==2)
                     echo CHtml::link($images,array('/billings/otherIncomes/index/part/rec/ri/2/from/stud'));
               ?>
  </div>  

<?php }  ?>  
 
  </div>

</div>



<div style="clear:both"></div>


<div class="b_m">


<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'other-incomes-form',
	//'enableAjaxValidation'=>true,
)); 



echo $this->renderPartial('_form', array(
	'model'=>$model,
	'form' =>$form
	)); ?>


<?php $this->endWidget(); ?>

</div><!-- form -->


</div>


