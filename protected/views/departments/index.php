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
	'Departments'=>array(Yii::t('app', 'index')),
	Yii::t('app', 'Manage'),
);

?>

<!-- Menu of CRUD  -->

<div id="dash">

                  <div class="icon-dash">

                      <?php

                     $images = '<img src="/siges/css/images/cancel.png" alt="Add any" /> <br />'.Yii::t('app','Cancel');

                               // build the link in Yii standard

                     echo CHtml::link($images,array('site/index')); 

                   ?>

                  </div>   

		<div class="icon-dash">

                  <?php

                     $images = '<img src="/siges/css/images/add.png" alt="Add any" /> <br />'.Yii::t('app','Create');

                               // build the link in Yii standard

                     echo CHtml::link($images,array('departments/create')); 

                   ?>

            	</div>

 </div>

<?php

$this->menu=array(
		array('label'=>Yii::t('app',
				'List Departments'), 'url'=>array('index')),
		array('label'=>Yii::t('app', 'Create Departments'),
				'url'=>array('create')),
			);

		Yii::app()->clientScript->registerScript('search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('departments-grid', {
data: $(this).serialize()
});
				return false;
				});
			");
		?>

<h1> Manage&nbsp;Departments</h1>

<?php echo CHtml::link(Yii::t('app', 'Advanced Search'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'departments-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'id',
		'department_name',
		//'date_created',
		//'date_updated',
		//'create_by',
		//'update_by',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
