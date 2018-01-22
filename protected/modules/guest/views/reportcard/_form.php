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
<p class="note"><?php echo Yii::t('app','Fields with <span class="required">*</span> are required.'); ?></p>

<?php echo $form->errorSummary($model); ?>

	<div class="row">
			</div>

	<div class="row">
			</div>

	<div class="row">
			</div>

	<div class="row">
		<?php echo $form->labelEx($model,'grade_value'); ?>
<?php echo $form->textField($model,'grade_value'); ?>
<?php echo $form->error($model,'grade_value'); ?>
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


<label for="Persons"><?php echo Yii::t('app','Belonging Persons'); ?></label><?php 
					$this->widget('application.components.Relation', array(
							'model' => $model,
							'relation' => 'student0',
							'fields' => 'last_name',
							'allowEmpty' => false,
							'style' => 'dropdownlist',
							)
						); ?>
			<label for="Courses"><?php Yii::t('app','Belonging Courses'); ?></label><?php 
					$this->widget('application.components.Relation', array(
							'model' => $model,
							'relation' => 'course0',
							'fields' => 'weight',
							'allowEmpty' => true,
							'style' => 'dropdownlist',
							)
						); ?>
			<label for="EvaluationByYear"><?php echo Yii::t('app','Belonging EvaluationByYear'); ?></label><?php 
					$this->widget('application.components.Relation', array(
							'model' => $model,
							'relation' => 'evaluation0',
							'fields' => 'evaluation_date',
							'allowEmpty' => false,
							'style' => 'dropdownlist',
							)
						); ?>
			