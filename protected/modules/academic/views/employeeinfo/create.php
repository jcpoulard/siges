
<?php 
/*
 * © 2010 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
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
/* @var $this TeacherinfoController */
/* @var $model TeacherInfo */


?>


<!-- Menu of CRUD  -->
<div id="dash">
          
          <div class="span3"><h2>
             <?php if(isset($_GET['isstud'])&&($_GET['isstud']==0))
                      echo Yii::t('app','Create more info for teacher');
                   else
                       echo Yii::t('app','Create more info for employee'); ?> 
             
          </h2> </div>
          
      <div class="span3">
             <div class="span4">
                      <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                               // build the link in Yii standard
                     
                     if(isset($_GET['from']))
                      {
                        if($_GET['from']=='view')
                          {
                            echo CHtml::link($images,array('/academic/employeeinfo/view','id'=>$_GET['id']));
                             $this->back_url='/academic/employeeinfo/view?id='.$_GET['id'];
                          }
                        elseif($_GET['from']=='teach')
                          {
                          	 if(isset($_GET['emp'])&&($_GET['emp']!=""))
                          	   { echo CHtml::link($images,array('/academic/persons/viewForReport?id='.$_GET['emp'].'&isstud=0&from=teach'));
                          	      $this->back_url='/academic/persons/viewForReport?id='.$_GET['emp'].'&isstud=0&from=teach';
                          	   }
                          	 
                          	}
                          elseif($_GET['from']=='emp')
                          {
                          	 if(isset($_GET['emp'])&&($_GET['emp']!=""))
                          	   { echo CHtml::link($images,array('/academic/persons/viewForReport?id='.$_GET['emp'].'&pg=lr&from=emp'));
                          	     $this->back_url='/academic/persons/viewForReport?id='.$_GET['emp'].'&pg=lr&from=emp';
                          	   }
                          	 else
                          	   { echo CHtml::link($images,array('/academic/persons/listForReport/from/emp/'));
                          	     $this->back_url='/academic/persons/listForReport/from/emp/';
                          	   }
                          	 
                          	}
                          
                      }
                      else
                       {  echo CHtml::link($images,array('/academic/employeeinfo/index'));
                           $this->back_url='/academic/employeeinfo/index';   
                       }
                        
 
                   ?>
      </div> 
    </div>
</div>


<div style="clear:both"></div>


<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'employee-info-form',
	
));
echo $this->renderPartial('_form', array(
	'model'=>$model,
	'form' =>$form
	)); ?>


<?php $this->endWidget(); ?>

</div>



