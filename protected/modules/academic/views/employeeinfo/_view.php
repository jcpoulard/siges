
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
/* @var $this TeacherinfoController */
/* @var $data TeacherInfo */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('employee')); ?>:</b>
	<?php echo CHtml::encode($data->teacher); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hire_date')); ?>:</b>
	<?php echo CHtml::encode($data->hire_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('country_of_birth')); ?>:</b>
	<?php echo CHtml::encode($data->country_of_birth); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('university_or_school')); ?>:</b>
	<?php echo CHtml::encode($data->university_or_school); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('number_of_year_of_study')); ?>:</b>
	<?php echo CHtml::encode($data->number_of_year_of_study); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('field_study')); ?>:</b>
	<?php echo CHtml::encode($data->field_study); ?>
	<br />

</div>