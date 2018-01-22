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
 *//* @var $this ScholarshipholderController */
/* @var $data ScholarshipHolder */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('student')); ?>:</b>
	<?php echo CHtml::encode($data->student); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('partner')); ?>:</b>
	<?php echo CHtml::encode($data->partner); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('percentage_pay')); ?>:</b>
	<?php echo CHtml::encode($data->percentage_pay); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_internal')); ?>:</b>
	<?php echo CHtml::encode($data->is_internal); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('academic_year')); ?>:</b>
	<?php echo CHtml::encode($data->academic_year); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_created')); ?>:</b>
	<?php echo CHtml::encode($data->date_created); ?>
	<br />

	

</div>