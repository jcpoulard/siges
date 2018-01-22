<?php
	echo '<p class="note">'.Yii::t('app','Fields with <span class="required">*</span> are required.').'</p>';

	  echo $form->errorSummary($model); ?>


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
			