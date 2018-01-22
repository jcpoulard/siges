<?php

/*
 * © 2016 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
 * 
 * This file is part of SIGES.

    SIGES is a free software: you can redistribute it and/or modify
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

/* @var $this ProductsController */
/* @var $model Products */
/* @var $form CActiveForm */

$acad_sess=acad_sess();
$acad=Yii::app()->session['currentId_academic_year'];

?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'products-form',
	'enableAjaxValidation'=>false,
)); ?>

<div class="b_m">    
    
	<?php  echo '<p class="note">'.Yii::t('app','Fields with <span class="required">*</span> are required.').'</p>'; ?>
<br/>
	<?php echo $form->errorSummary($model); ?>

<div  id="resp_form_siges">  

 <form  id="resp_form">  
     <div class="col-2">
            <label id="resp_form"> 
	
		<?php echo $form->labelEx($model,'product_name'); ?>
		<?php echo $form->textField($model,'product_name',array('size'=>60,'maxlength'=>128,'placeholder'=>Yii::t('app','Product name'))); ?>
		<?php echo $form->error($model,'product_name'); ?>
            </label>
	</div>

     
      <div class="col-2">
            <label id="resp_form"> 
                <?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50,'placeholder'=>Yii::t('app','Description'))); ?>
		<?php echo $form->error($model,'description'); ?>
            </label>
      </div>
     
        <div class="col-2">
            <label id="resp_form"> 
	
		<?php echo $form->labelEx($stock,'quantity'); ?>
		<?php echo $form->textField($stock,'quantity',array('size'=>60,'maxlength'=>128,'placeholder'=>Yii::t('app','Quantity'))); ?>
		<?php echo $form->error($stock,'quantity'); ?>
            </label>
	</div>
     
     <div class="col-2">
            <label id="resp_form"> 
                
		<?php echo $form->labelEx($stock,'is_donation'); ?>
		<?php echo $form->checkBox($stock,'is_donation',array('onchange'=>"document.getElementById('Stocks_buiying_price').disabled = this.checked;")); ?>
		<?php echo $form->error($stock,'is_donation'); ?>
            </label>
	</div>
     
     <div class="col-2">
            <label id="resp_form"> 
	
		<?php echo $form->labelEx($stock,'buiying_price'); ?>
		<?php echo $form->textField($stock,'buiying_price',array('size'=>60,'maxlength'=>128,'placeholder'=>Yii::t('app','Buying price'),'value'=>0)); ?>
		<?php echo $form->error($stock,'buiying_price'); ?>
            </label>
	</div>
     
     <div class="col-2">
            <label id="resp_form"> 
	
		<?php echo $form->labelEx($stock,'selling_price'); ?>
		<?php echo $form->textField($stock,'selling_price',array('size'=>60,'maxlength'=>128,'placeholder'=>Yii::t('app','Selling price'),'value'=>0)); ?>
		<?php echo $form->error($stock,'selling_price'); ?>
            </label>
	</div>

	

	<div class="col-2">
            <label id="resp_form">
		<?php echo $form->labelEx($model,'stock_alert'); ?>
		<?php echo $form->textField($model,'stock_alert'); ?>
		<?php echo $form->error($model,'stock_alert'); ?>
            </label>
	</div>

	
	<div class="col-submit">
            
            <?php
            
            if(!isset($_GET['id'])){
                                          if(!isAchiveMode($acad_sess))
                                              echo CHtml::submitButton(Yii::t('app', 'Create '),array('name'=>'create','class'=>'btn btn-warning')); //'Create ' avec espace a la fin POUR AVOIR UNE TRADUCTION "ENREGISTRER"
                                         
                                         echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary')); //'Cancel ' avec espace a la fin POUR AVOIR UNE TRADUCTION "Annuler"/ sans espace=>'Retour'
                                        }
                                         else
                                           {   if(!isAchiveMode($acad_sess))
                                                  echo CHtml::submitButton(Yii::t('app', 'Save'),array('name'=>'update','class'=>'btn btn-warning'));
                                            
                                              echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary'));
                                              
                                             } 
            ?>
		
	</div>
 </form>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
</div>