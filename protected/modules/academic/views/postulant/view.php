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
/* @var $this PostulantController */
/* @var $model Postulant */

$this->breadcrumbs=array(
	'Postulants'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Postulant', 'url'=>array('index')),
	array('label'=>'Create Postulant', 'url'=>array('create')),
	array('label'=>'Update Postulant', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Postulant', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Postulant', 'url'=>array('admin')),
);
?>

<h1>View Postulant #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'first_name',
		'last_name',
		'gender',
		'blood_group',
		'birthday',
		'cities',
		'adresse',
		'phone',
		'person_liable',
		'person_liable_phone',
		'person_liable_adresse',
		'person_liable_relation',
		'apply_for_level',
		'previous_level',
		'previous_school',
		'scholl_date_entry',
		'last_average',
		'status',
		'date_created',
		'date_updated',
		'create_by',
		'update_by',
	),
)); ?>
