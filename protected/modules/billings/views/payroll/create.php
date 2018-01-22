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
/* @var $this PayrollController */
/* @var $model Payroll */



?>




<!-- Menu of CRUD  -->
<div id="dash">
          
          <div class="span3"><h2>
              <?php echo Yii::t('app','Add payroll'); ?>
              
         </h2> </div>
     
		   <div class="span3">
             <div class="span4">

                      <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                               // build the link in Yii standard
	                  
	                if((isset($_GET['from1']))&&($_GET['from1']=='vfr'))
                      {  
                      	echo CHtml::link($images,array('/billings/payroll/view/id/'.$_GET['id'].'/emp/'.$_GET['emp'].'/month_/'.$_GET['month_'].'/year_/'.$_GET['year_'].'/di/'.$_GET['di'].'/part/pay/from1/vfr/from/emp')); 
                        $this->back_url='/billings/payroll/view/id/'.$_GET['id'].'/emp/'.$_GET['emp'].'/month_/'.$_GET['month_'].'/year_/'.$_GET['year_'].'/di/'.$_GET['di'].'/part/pay/from1/vfr/from/emp';
                        
                       }
                     else
                       {
                       	 echo CHtml::link($images,array('/billings/payroll/index/part/pay/from/stud')); 
	                     $this->back_url='/billings/payroll/index/part/pay/from/stud';
	                     
                       }
                       
                       
                   ?>
      </div> 
    </div>
 </div>


<div style="clear:both"></div>


	

<div class="b_m">

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'payroll-form',
	//'enableAjaxValidation'=>true,
)); 
echo $this->renderPartial('_form', array(
	'model'=>$model,
	'form' =>$form
	)); ?>


<?php $this->endWidget(); ?>

</div>

</div>






