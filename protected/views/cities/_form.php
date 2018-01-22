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
<p class="note">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'city_name'); ?>
<?php echo $form->textField($model,'city_name',array('size'=>45,'maxlength'=>45)); ?>
<?php echo $form->error($model,'city_name'); ?>
	</div>

	<div class="row">
			</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_created'); ?>
<?php echo $form->textField($model,'date_created'); ?>
<?php echo $form->error($model,'date_created'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_updated'); ?>
<?php echo $form->textField($model,'date_updated'); ?>
<?php echo $form->error($model,'date_updated'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'create_by'); ?>
<?php echo $form->textField($model,'create_by',array('size'=>45,'maxlength'=>45)); ?>
<?php echo $form->error($model,'create_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'update_by'); ?>
<?php echo $form->textField($model,'update_by',array('size'=>45,'maxlength'=>45)); ?>
<?php echo $form->error($model,'update_by'); ?>
	</div>


<label for="Arrondissements">Belonging Arrondissements</label><?php 
					$this->widget('application.components.Relation', array(
							'model' => $model,
							'relation' => 'arrondissement0',
							'fields' => 'arrondissement_name',
							'allowEmpty' => false,
							'style' => 'dropdownlist',
							)
						); ?>
			