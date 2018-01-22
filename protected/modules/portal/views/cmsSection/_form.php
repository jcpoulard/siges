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
 *//* @var $this CmsSectionController */
/* @var $model CmsSection */
/* @var $form CActiveForm */


?>

<div class="form">

<?php 

$form=$this->beginWidget('CActiveForm', array(
	'id'=>'cms-section-form',
	'enableAjaxValidation'=>false,
)); ?>
    
    <?php
	echo '<p class="note">'.Yii::t('app','Fields with <span class="required">*</span> are required.').'</p>';

	  echo $form->errorSummary($model); ?>

    
  <div class="box box-info">
         <div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin">
                      
                      <tbody>
                        <tr>
                          <td><?php echo $form->labelEx($model,'section_name'); ?></td>
                          <td>
                              <?php echo $form->textField($model,'section_name',array('size'=>45,'maxlength'=>45)); ?>
                              <?php echo $form->error($model,'section_name'); ?>
                          </td>
                          <td><?php echo $form->labelEx($model,'description'); ?></td>
                          <td>
                              <?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>255)); ?>
                              <?php echo $form->error($model,'description'); ?>
                           </td>
                          
                        </tr>
                        <?php if(isset($_GET['id'])) { ?>
                        <tr>
                          <td><?php echo $form->labelEx($model,'is_publish'); ?></td>
                          <td>
                              <?php echo $form->checkBox($model,'is_publish'); ?>
                              <?php echo $form->error($model,'is_publish'); ?>
                          </td>
                          
                        </tr>
                        <?php }?>
                        
                        <tr>
                            <td colspan="4"> 
                                
                                <?php if(!isset($_GET['id'])){
                                         echo CHtml::submitButton(Yii::t('app', 'Create '),array('name'=>'create','class'=>'btn btn-warning')); //'Create ' avec espace a la fin POUR AVOIR UNE TRADUCTION "ENREGISTRER"
                                         echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary')); //'Cancel ' avec espace a la fin POUR AVOIR UNE TRADUCTION "Annuler"/ sans espace=>'Retour'
                                        }
                                         else
                                           {  echo CHtml::submitButton(Yii::t('app', 'Save'),array('name'=>'update','class'=>'btn btn-warning'));
                                            
                                              echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary'));
                                              
                                             } 
                                           //back button   
                                              $url=Yii::app()->request->urlReferrer;//$_SERVER['REQUEST_URI'];
                                              $explode_url= explode("php",substr($url,0));
				             
                                              echo ' <a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';
                                          

                                            
                                ?>
                                
                            </td>
                            
                        </tr>
                       
                      
                      </tbody>
                    </table>
                  </div><!-- /.table-responsive -->
                </div><!-- /.box-body -->
                
              </div>  
	

	

<?php $this->endWidget(); ?>

</div><!-- form -->