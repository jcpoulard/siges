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
/* @var $data Postulant */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('first_name')); ?>:</b>
	<?php echo CHtml::encode($data->first_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_name')); ?>:</b>
	<?php echo CHtml::encode($data->last_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gender')); ?>:</b>
	<?php echo CHtml::encode($data->gender); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('blood_group')); ?>:</b>
	<?php echo CHtml::encode($data->blood_group); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('birthday')); ?>:</b>
	<?php echo CHtml::encode($data->birthday); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cities')); ?>:</b>
	<?php echo CHtml::encode($data->cities); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('adresse')); ?>:</b>
	<?php echo CHtml::encode($data->adresse); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('phone')); ?>:</b>
	<?php echo CHtml::encode($data->phone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('person_liable')); ?>:</b>
	<?php echo CHtml::encode($data->person_liable); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('person_liable_phone')); ?>:</b>
	<?php echo CHtml::encode($data->person_liable_phone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('person_liable_adresse')); ?>:</b>
	<?php echo CHtml::encode($data->person_liable_adresse); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('person_liable_relation')); ?>:</b>
	<?php echo CHtml::encode($data->person_liable_relation); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('apply_for_level')); ?>:</b>
	<?php echo CHtml::encode($data->apply_for_level); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('previous_level')); ?>:</b>
	<?php echo CHtml::encode($data->previous_level); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('previous_school')); ?>:</b>
	<?php echo CHtml::encode($data->previous_school); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('scholl_date_entry')); ?>:</b>
	<?php echo CHtml::encode($data->scholl_date_entry); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_average')); ?>:</b>
	<?php echo CHtml::encode($data->last_average); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_created')); ?>:</b>
	<?php echo CHtml::encode($data->date_created); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_updated')); ?>:</b>
	<?php echo CHtml::encode($data->date_updated); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_by')); ?>:</b>
	<?php echo CHtml::encode($data->create_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_by')); ?>:</b>
	<?php echo CHtml::encode($data->update_by); ?>
	<br />

	*/ ?>

</div>