<?php

/*
 * © 2015 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
 * 
 * This file is part of SIGES.

    SIGES is a free software: you can redistribute it and/or modify
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



<!-- Menu of CRUD  -->
<?php
    if (! Yii::app()->request->isAjaxRequest) 
      {  echo '<div id="dash">
   
		<h2>'.Yii::t('app','Create Schedules').' </h2>
		
                  <div class="icon-dash">

                     
                  ';
                     $images = '<img src="'.Yii::app()->baseUrl.'/css/images/cancel.png" alt="Add any" /> <br />'.Yii::t('app','Cancel');

                               // build the link in Yii standard

                     echo CHtml::link($images,array('schedules/index')); 

                echo '  

                  </div> 
               </div>
             ';
		}
?>		
<?php
$this->breadcrumbs=array(
	Yii::t('app','Schedules')=>array('index'),
	Yii::t('app', 'Create'),
);


?>


<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'schedules-form',
	'enableAjaxValidation'=>false,
	
)); 


        echo $this->renderPartial('_addCourseForm', array('model'=>$model,'form'=>$form));
  ?>

<div class="row buttons">
	<?php 
		      echo CHtml::submitButton(Yii::t('app', 'Create'),array('name'=>'createCourse')); 
	?>
</div>

<?php $this->endWidget(); ?>

</div>
