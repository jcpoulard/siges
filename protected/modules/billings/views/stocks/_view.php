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
/* @var $this StocksController */
/* @var $data Stocks */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_product')); ?>:</b>
	<?php echo CHtml::encode($data->id_product); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quantity')); ?>:</b>
	<?php echo CHtml::encode($data->quantity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('acquisition_date')); ?>:</b>
	<?php echo CHtml::encode($data->acquisition_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('buiying_price')); ?>:</b>
	<?php echo CHtml::encode($data->buiying_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('selling_price')); ?>:</b>
	<?php echo CHtml::encode($data->selling_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_donation')); ?>:</b>
	<?php echo CHtml::encode($data->is_donation); ?>
	<br />

	
</div>