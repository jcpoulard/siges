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
    
<?php
/* @var $this CalendarController */
/* @var $model Calendar */


?>

<div id="dash">
          
          <div class="span3"><h2>
 <?php echo Yii::t('app','{name}', array('{name}'=>$model->c_title)); ?>

</h2> </div>
     
</div>



     	
<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
	
		'description',
		array('name'=>'start_date','value'=>$model->startDate),
		array('name'=>'end_date','value'=>$model->endDate),
		//'start_time',
		//'end_time',
		
	),
)); ?>
