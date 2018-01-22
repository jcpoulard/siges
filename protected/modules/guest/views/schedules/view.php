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
$this->breadcrumbs=array(
	Yii::t('app','Schedules')=>array('index'),
	$model->scheduleString,
);

?>

<div id="dash">

			<h2><?php echo Yii::t('app','Schedule {name}', array('{name}'=>$model->scheduleString)); ?></h2>

             <div class="icon-dash">

                  <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';


                               // build the link in Yii standard

                     echo CHtml::link($images,array('schedules/index')); 

                   ?>

            </div> 

       

              <div class="icon-dash">

                      <?php

                     $images = '<i class="fa fa-edit">&nbsp;'.Yii::t('app','Update').'</i>';


                               // build the link in Yii standard

                     echo CHtml::link($images,array('schedules/update/','id'=>$model->id)); 

                     ?>

              </div>    

     <div class="icon-dash">

                  <?php

                     $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';


                               // build the link in Yii standard

                     echo CHtml::link($images,array('schedules/create')); 

                   ?>

              </div>

       </div>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		
		'course0.courseName',
		
		array(
		      'label' =>Yii::t('app','Day course'),
		       'type' => 'raw',
		       'value' => $model->day,
		        ),
		'time_start',
		'time_end',		
		
		
	),
)); ?>


