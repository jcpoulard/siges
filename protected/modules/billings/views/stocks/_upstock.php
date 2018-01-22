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
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<div class="form">
    <?php 
    $form=$this->beginWidget('CActiveForm', array(
	'id'=>'stocks-form',
	'enableAjaxValidation'=>false,
    )); 
    ?>
    
    <div class="b_m">
        <?php  echo '<p class="note">'.Yii::t('app','Fields with <span class="required">*</span> are required.').'</p>'; ?>
        <br/>
        <?php echo $form->errorSummary($model); ?>
        <div  id="resp_form_siges"> 
            <form  id="resp_form">
                <div class="col-2">
                    <label id="resp_form"> 
                        <?php echo $form->labelEx($model,'update_all_price'); ?>
                        <?php echo $form->checkBox($model,'update_all_price',array('onchange'=>"document.getElementById('Stocks_b_price').disabled = !this.checked;document.getElementById('Stocks_s_price').disabled = !this.checked;")); ?>
                        <?php echo $form->error($model,'update_all_price'); ?>
                    </label>
                </div>
                
                <div class="col-2">
                    <label id="resp_form"> 
                        <?php echo $form->labelEx($model,'quantity_update'); ?>
                        <?php  echo $form->textField($model, 'quantity_update',array('size'=>60,'maxlength'=>128,'placeholder'=>Yii::t('app','Quantity'))); ?>
                        <?php echo $form->error($model,'quantity_update'); ?>
                    </label>
                </div>
                
                <div class="col-2">
                    <label id="resp_form"> 
                        <?php echo $form->labelEx($model,'b_price'); ?>
                        <?php  echo $form->textField($model, 'b_price',array('size'=>60,'maxlength'=>128,'placeholder'=>Yii::t('app','Buying price'),'disabled'=>'disabled')); ?>
                        <?php echo $form->error($model,'b_price'); ?>
                    </label>
                </div>
                
                <div class="col-2">
                    <label id="resp_form"> 
                        <?php echo $form->labelEx($model,'s_price'); ?>
                        <?php  echo $form->textField($model, 's_price',array('size'=>60,'maxlength'=>128,'placeholder'=>Yii::t('app','Selling price'),'disabled'=>'disabled')); ?>
                        <?php echo $form->error($model,'s_price'); ?>
                    </label>
                    </div>
               <div class="col-submit">
            
                <?php

                if(!isset($_GET['id'])){
                             echo CHtml::submitButton(Yii::t('app', 'Create '),array('name'=>'create','class'=>'btn btn-warning')); //'Create ' avec espace a la fin POUR AVOIR UNE TRADUCTION "ENREGISTRER"
                             echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary')); //'Cancel ' avec espace a la fin POUR AVOIR UNE TRADUCTION "Annuler"/ sans espace=>'Retour'
                            }
                             else
                               {  echo CHtml::submitButton(Yii::t('app', 'Save'),array('name'=>'update','class'=>'btn btn-warning'));

                                  echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary'));

                                 } 
                ?>
		
                </div> 
                
            </form>
        
    </div>
    
    <?php $this->endWidget(); ?>
</div>