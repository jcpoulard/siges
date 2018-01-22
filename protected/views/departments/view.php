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
	'Departments'=>array('index'),
	$model->department_name,
);

?>

<div id="dash">

             <div class="icon-dash">

                  <?php

                     $images = '<img src="/siges/css/images/cancel.png" alt="Add any" /> <br />'.Yii::t('app','Cancel');

                               // build the link in Yii standard

                     echo CHtml::link($images,array('departments/index')); 

                   ?>

            </div> 

            <div class="icon-dash">

                  <?php

                     $images = '<img src="/siges/css/images/delete.png" alt="Add any" /> <br />'.Yii::t('app','Delete');

                               // build the link in Yii standard

                     echo CHtml::link($images,array('departments/delete','id'=>$model->id,));//'htmlOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')));

                    // echo CHtml::ajax(array('url'=>$this->createUrl('subjects/delete', array('id' => $model->id,'ajax'=>'delete')),));

                   ?>

             </div> 

              <div class="icon-dash">

                      <?php

                     $images = '<img src="/siges/css/images/edit.png" alt="Add any" /> <br />'.Yii::t('app','Update');

                               // build the link in Yii standard

                     echo CHtml::link($images,array('departments/update/','id'=>$model->id)); 

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
	array('label'=>'List Departments', 'url'=>array('index')),
	array('label'=>'Create Departments', 'url'=>array('create')),
	array('label'=>'Update Departments', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Departments', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Departments', 'url'=>array('admin')),
);
?>

<h1>View Departments: <?php echo $model->department_name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id',
		'department_name',
		//'date_created',
		//'date_updated',
		//'create_by',
		//'update_by',
	),
)); ?>


<br /><h2> This Arrondissements belongs to this Departments: </h2>
<ul><?php foreach($model->arrondissements as $foreignobj) { 

				printf('<li>%s</li>', CHtml::link($foreignobj->arrondissement_name, array('arrondissements/view', 'id' => $foreignobj->id)));

				} ?></ul>
