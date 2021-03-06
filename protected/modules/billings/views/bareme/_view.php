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



/* @var $this BaremeController */
/* @var $data Bareme */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('min_value')); ?>:</b>
	<?php echo CHtml::encode($data->min_value); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('max_value')); ?>:</b>
	<?php echo CHtml::encode($data->max_value); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('percentage')); ?>:</b>
	<?php echo CHtml::encode($data->percentage); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('compteur')); ?>:</b>
	<?php echo CHtml::encode($data->compteur); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('old_new')); ?>:</b>
	<?php echo CHtml::encode($data->old_new); ?>
	<br />


</div>