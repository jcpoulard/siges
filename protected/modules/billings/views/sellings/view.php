<?php
/*
 * © 2016 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
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
/* @var $this SellingsController */
/* @var $model Sellings */

$this->breadcrumbs=array(
	'Sellings'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Sellings', 'url'=>array('index')),
	array('label'=>'Create Sellings', 'url'=>array('create')),
	array('label'=>'Update Sellings', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Sellings', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Sellings', 'url'=>array('admin')),
);
?>

<h1>View Sellings #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'transaction_id',
		'id_products',
		'quantity',
		'selling_date',
		'client_name',
		'sell_by',
		'amount_receive',
		'amount_selling',
		'amount_balance',
		'discount',
		'update_by',
		'update_date',
		'unit_selling_price',
	),
)); ?>
