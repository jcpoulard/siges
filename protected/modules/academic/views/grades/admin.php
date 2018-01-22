
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


$this->menu=array(
		array('label'=>Yii::t('app',
				'List Grades'), 'url'=>array('index')),
		array('label'=>Yii::t('app', 'Create Grades'),
				'url'=>array('create')),
			);

		Yii::app()->clientScript->registerScript('search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('grades-grid', {
data: $(this).serialize()
});
				return false;
				});
			");
		?>

<h1> Manage&nbsp;Grades</h1>

<?php echo CHtml::link(Yii::t('app', 'Advanced Search'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>

<?php  
      $dataProvider=$model->search();
    $this->widget('ext.CEditableGridView', array(
	
	'dataProvider'=>$dataProvider,
	'showQuickBar'=>'false',
    
	'columns'=>array(
		
		array('name'=>'student_id','value'=>'$data->student0->id'),
		array('name'=>'student','value'=>'$data->student0->first_name." ".$data->student0->last_name'),
		array('name'=>'course','value'=>'$data->course0->subject'),
		array('name'=>'evaluation_date','value'=>'$data->evaluation0->evaluation_date'),
		array('header' => 'Grade Value', 'name' => 'grade_value', 'class' => 'ext.CEditableColumn'),
		
	),
));  ?>
