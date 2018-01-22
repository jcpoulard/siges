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
<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
)); ?>

        <div class="row">
                <?php echo $form->label($model,'id'); ?>
                <?php echo $form->textField($model,'id'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'course'); ?>
                <?php ; ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'period'); ?>
                <?php ; ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'date_created'); ?>
                <?php echo $form->textField($model,'date_created'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'date_updated'); ?>
                <?php echo $form->textField($model,'date_updated'); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'create_by'); ?>
                <?php echo $form->textField($model,'create_by',array('size'=>45,'maxlength'=>45)); ?>
        </div>

        <div class="row">
                <?php echo $form->label($model,'update_by'); ?>
                <?php echo $form->textField($model,'update_by',array('size'=>45,'maxlength'=>45)); ?>
        </div>

        <div class="row buttons">
                <?php echo CHtml::submitButton(Yii::t('app', 'Search')); ?>
        </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
