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
	'Cities'=>array('index'),
	$model->id,
);

?>

<div id="dash">

             <div class="icon-dash">

                  <?php

                     $images = '<img src="/siges/css/images/cancel.png" alt="Add any" /> <br />'.Yii::t('app','Cancel');

                               // build the link in Yii standard

                     echo CHtml::link($images,array('cities/index')); 

                   ?>

            </div> 

            <div class="icon-dash">

                  <?php

                     $images = '<img src="/siges/css/images/delete.png" alt="Add any" /> <br />'.Yii::t('app','Delete');

                               // build the link in Yii standard

                     echo CHtml::link($images,array('cities/delete','id'=>$model->id,));//'htmlOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')));

                    // echo CHtml::ajax(array('url'=>$this->createUrl('subjects/delete', array('id' => $model->id,'ajax'=>'delete')),));

                   ?>

             </div> 

              <div class="icon-dash">

                      <?php

                     $images = '<img src="/siges/css/images/edit.png" alt="Add any" /> <br />'.Yii::t('app','Update');

                               // build the link in Yii standard

                     echo CHtml::link($images,array('cities/update/','id'=>$model->id)); 

                     ?>

              </div>    

           <div class="icon-dash">

                  <?php

                     $images = '<img src="/siges/css/images/add.png" alt="Add any" /> <br />'.Yii::t('app','Create');

                               // build the link in Yii standard

                     echo CHtml::link($images,array('cities/create')); 

                   ?>

              </div>

       </div>

<?php 

$this->menu=array(
	array('label'=>'List Cities', 'url'=>array('index')),
	array('label'=>'Create Cities', 'url'=>array('create')),
	array('label'=>'Update Cities', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Cities', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Cities', 'url'=>array('admin')),
);
?>

<h1>View Cities #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'city_name',
		'arrondissement0.arrondissement_name',
		'date_created',
		'date_updated',
		'create_by',
		'update_by',
	),
)); ?>


<br /><h2> This Persons belongs to this Cities: </h2>
<ul><?php foreach($model->persons as $foreignobj) { 

				printf('<li>%s</li>', CHtml::link($foreignobj->last_name, array('persons/view', 'id' => $foreignobj->id)));

				} ?></ul>
