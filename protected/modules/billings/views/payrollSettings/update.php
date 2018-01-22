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
/* @var $this PayrollSettingsController */
/* @var $model PayrollSettings */


$acad_sess=acad_sess();

?>


<!-- Menu of CRUD  -->
<div id="dash">
          
          <div class="span3"><h2>
              <?php  if(!isset($_GET['all']))
                       {  echo Yii::t('app','Update Payroll Setting for: {name}',array('{name}'=>$model->person->fullName)); 
                       
                       }
                     else
                       {   $this->group=1;
                       	    if($_GET['all']=='t')
                             {  echo Yii::t('app', 'Payroll setting for teachers');
                                $this->grouppayroll=2;
                              }
                            elseif($_GET['all']=='e')
                              {  echo Yii::t('app', 'Payroll setting for employees');
                                   $this->grouppayroll=1;
                                }
                       	}  
                       
                 ?>
          </h2> </div>
     
		   <div class="span3">
		   
<?php

$template = '';

           if(!isAchiveMode($acad_sess))
              {     $template = '{update}{delete}';
?>
              <div class="span4">
              <?php

                 $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';
                           // build the link in Yii standard
                 echo CHtml::link($images,array('/billings/payrollSettings/create/part/pay/from/stud')); 
               ?>
   </div>
     <?php
              }
     ?>
     <div class="span4">
                      <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                               // build the link in Yii standard
                     if(isset($_GET['from']))
                       {  if($_GET['from']=='view')
                             {  
                               if(!isset($_GET['all']))
                             	{  echo CHtml::link($images,array('/billings/payrollSettings/view?id='.$model->id)); 
                                   $this->back_url='/billings/payrollSettings/view?id='.$model->id.'/part/pay/from/stud';
                             	 }
                               else
                                 {
                                 	echo CHtml::link($images,array('/billings/payrollSettings/view?id='.$_GET['id'].'&all='.$_GET['all'].'&part=pay&from='.$_GET['from'])); 
                                     $this->back_url='/billings/payrollSettings/view?id='.$_GET['id'].'&all='.$_GET['all'].'&part=pay&from='.$_GET['from'];
                                   }
                                   
                             }
                          
                       }
                     else
                      { echo CHtml::link($images,array('/billings/payrollSettings/index/part/pay/from/stud')); 
                         $this->back_url='/billings/payrollSettings/index/part/pay/from/stud';
                      }
                   ?>
      </div> 
    </div>
 </div>


<div style="clear:both"></div>


<br/>
  <?php
    echo $this->renderPartial('//layouts/navBaseBilling',NULL,true);	
    ?>




<div class="b_mail">
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'payroll-settings-form',
	
)); 

echo $this->renderPartial('_form', array(
	'model'=>$model,
	'form' =>$form
	)); ?>


<?php $this->endWidget(); ?>

</div>

</div>
