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





 

<!-- Menu of CRUD  -->

<div id="dash">

		<div class="span3"><h2>

<?php echo Yii::t('app','View Schedules'); ?> </h2> </div>
		
                  <div class="icon-dash">

                      <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';


                               // build the link in Yii standard

                     echo CHtml::link($images,array('persons/index?isstud=0')); 

                   ?>

                  </div>   

		<div class="icon-dash">

                  
            	</div>

 </div>

<?php



		Yii::app()->clientScript->registerScript('search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('schedules-grid', {
data: $(this).serialize()
});
				return false;
				});
			");
		?>




<div class="search-form" style="display:none">

</div>


<?php  echo Schedules::model()->id; ?>


<?php 
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']); // set controller and model for that before
   $gridWidget=$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'schedules-grid',
	'dataProvider'=>$model->search(),
	
	'columns'=>array(
		
		array('name'=>'course','value'=>'$data->course0->courseName'),
		'day',
		'time_start',
		'time_end',
		
		
		array(
			'class'=>'CButtonColumn',
			'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                                  'onchange'=>"$.fn.yiiGridView.update('schedules-grid',{ data:{pageSize: $(this).val() }})",
                    )),
		),
	),
)); 

$this->renderExportGridButton($gridWidget, Yii::t('app','Export to CSV'),array('class'=>'btn-info'));
?>


