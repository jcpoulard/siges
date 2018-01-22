<?php 
/* © 2015 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
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
 */?>
<div class="view">

	<b><?php  echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('student')); ?>:</b>
	<?php echo CHtml::encode($data->student); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('infraction_type')); ?>:</b>
	<?php echo CHtml::encode($data->infraction_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('record_by')); ?>:</b>
	<?php echo CHtml::encode($data->record_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('incident_date')); ?>:</b>
	<?php echo CHtml::encode($data->incident_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('incident_description')); ?>:</b>
	<?php echo CHtml::encode($data->incident_description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('decision_description')); ?>:</b>
	<?php echo CHtml::encode($data->decision_description); ?>
	<br />

	
</div>