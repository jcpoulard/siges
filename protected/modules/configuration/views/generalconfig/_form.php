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
/* @var $this GeneralconfigController */
/* @var $model GeneralConfig */
/* @var $form CActiveForm */
$acad_sess=acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'general-config-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php
	echo '<p class="note">'.Yii::t('app','Fields with <span class="required">*</span> are required.').'</p>';

	  echo $form->errorSummary($model); ?>

<div  id="resp_form_siges">

        <form  id="resp_form">
        
        <div class="col-2">
            <label id="resp_form">
          
	<div class="row">
		<?php echo $form->labelEx($model,'item_name'); ?>
		<?php echo $form->textField($model,'item_name',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'item_name'); ?>
	</div>
        
          </label>
        </div>
 
 <div class="col-2">
            <label id="resp_form">
          
    <div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>


  </label>
        </div>


<div class="col-2">
            <label id="resp_form">
          
	<div class="row">
		<?php echo $form->labelEx($model,'item_value'); ?>
		<?php echo $form->textArea($model,'item_value',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'item_value'); ?>
	</div>
	
	
	  </label>
        </div>

<div class="col-2">
            <label id="resp_form">
          
	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>
    
    
      </label>
        </div>


<div class="col-2">
            <label id="resp_form">
          
        <div class="row">
		<?php echo $form->labelEx($model,'english_comment'); ?>
		<?php echo $form->textArea($model,'english_comment',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'english_comment'); ?>
	</div>
    
    </label>
  </div>

	
	<div class="row buttons">
		<?php if(!isset($_GET['id'])){
                                         if(!isAchiveMode($acad_sess))
                                             echo CHtml::submitButton(Yii::t('app', 'Create '),array('name'=>'create','class'=>'btn btn-warning')); //'Create ' avec espace a la fin POUR AVOIR UNE TRADUCTION "ENREGISTRER"
                                         
                                         echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary')); //'Cancel ' avec espace a la fin POUR AVOIR UNE TRADUCTION "Annuler"/ sans espace=>'Retour'
                                        }
                                         else
                                           {  if(!isAchiveMode($acad_sess))
                                                 echo CHtml::submitButton(Yii::t('app', 'Save'),array('name'=>'update','class'=>'btn btn-warning'));
                                            
                                              echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary'));
                                              
                                             } 
                                           //back button   
                                              $url=Yii::app()->request->urlReferrer;//$_SERVER['REQUEST_URI'];
                                              $explode_url= explode("php",substr($url,0));
				             
                                              echo ' <a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';
                                          
 ?> 
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->