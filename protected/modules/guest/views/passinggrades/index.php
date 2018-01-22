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
    
$acad=Yii::app()->session['currentId_academic_year']; 

$this->pageTitle = Yii::app()->name.' - '.Yii::t('app','Manage Passing grades');
?>

<div class="search-form">
    <?php
    echo $this->renderPartial('//layouts/navBaseConfiguration',NULL,true);	
    ?>
</div>

		
<div id="dash">
		<div class="span3"><h2>

            <?php echo Yii::t('app','Manage Passing grades'); ?>
      
</h2> </div>


      <div class="span3">
        <div class="span4">
           <?php

                 $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                           // build the link in Yii standard
                 echo CHtml::link($images,array('/guest/academicperiods/index')); 
               ?>
        </div>
    </div>
</div>
 
<div style="clear:both"></div>	


<?php
/* @var $this PassinggradesController */
/* @var $model PassingGrades */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#passing-grades-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
 
<div  class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>


<?php 
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
$gridWidget = $this->widget('groupgridview.GroupGridView', array(
	'id'=>'passing-grades-grid',
	'dataProvider'=>$model->search($acad),
        'showTableOnEmpty'=>false,
        'emptyText'=>Yii::t('app','No Passing grade found'),
        'summaryText'=>Yii::t('app','View passing grades from {start} to {end} (total of {count})'),
	'mergeColumns'=>'academic_lname',
	'columns'=>array(
		array('name'=>'academic_lname',
				'header'=>Yii::t('app','Academic Period'), 
				'value'=>'$data->academicPeriod->name_period'),	
		array('name'=>'level_lname',
			'header'=>Yii::t('app','Levels'), 
			'value'=>'$data->level0->level_name'),
			
		
		'minimum_passing',
		
		array(
			'class'=>'CButtonColumn',
                    'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                          'onchange'=>"$.fn.yiiGridView.update('passing-grades-grid',{ data:{pageSize: $(this).val() }})",
            )),
		),
	),
));

  
       $this->renderExportGridButton($gridWidget, Yii::t('app','Export to CSV'),array('class'=>'btn-info btn'));
?>
