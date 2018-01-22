
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
	echo '<p class="note">'.Yii::t('app','Fields with <span class="required">*</span> are required.').'</p>';

	  echo $form->errorSummary($model); ?>


<label for="Persons"><?php echo Yii::t('app','Student'); ?></label><?php 
					$this->widget('application.components.Relation', array(
							'model' => $model,
							'relation' => 'student0',
							'fields' => 'fullName',
							'allowEmpty' => false,
							'style' => 'dropdownlist',
							)
						); ?>
			<label for="Courses"><?php echo Yii::t('app','Course'); ?></label><?php 
					$this->widget('application.components.Relation', array(
							'model' => $model,
							'relation' => 'course0',
							'fields' => 'courseName',
							'allowEmpty' => true,
							'style' => 'dropdownlist',
							)
						); ?>
			<label for="EvaluationByYear"><?php echo Yii::t('app','Evaluation'); ?></label><?php 
					$this->widget('application.components.Relation', array(
							'model' => $model,
							'relation' => 'evaluation0',
							'fields' => 'examName',
							'allowEmpty' => false,
							'style' => 'dropdownlist',
							)
						); ?>

                        <div class="row">
                    <?php echo $form->labelEx($model,'grade_value'); ?>
                    <?php echo $form->textField($model,'grade_value'); ?>
                    <?php echo $form->error($model,'grade_value'); ?>
	</div>
			