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
/* @var $this PassinggradesController */
/* @var $model PassingGrades */
/* @var $form CActiveForm */
?>
<?php $this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); ?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'passing-grades-form',
	'enableAjaxValidation'=>false,
)); ?>
<p class="note"><?php echo Yii::t('app','Fields with <span class="required">*</span> are required.');?></p>

<?php echo $form->errorSummary($model); ?>

<div class="box box-info">
         <div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin">
                      
                      <tbody>
                        <tr>
                          <td><?php echo $form->labelEx($model,'level'); ?></td>
                          <td>
                              <?php
			
                                $criteria = new CDbCriteria(array('order'=>'level_name',));

                                echo $form->dropDownList($model, 'level',
                                CHtml::listData(Levels::model()->findAll($criteria),'id','level_name'),
                                array('prompt'=>Yii::t('app','-- Please select level --'))
                                );
                                ?>
                              <?php echo $form->error($model,'level'); ?>
                          </td>
                          <td><?php echo $form->labelEx($model,'minimum_passing'); ?></td>
                          <td>
                             <?php echo $form->textField($model,'minimum_passing'); ?>
                            <?php echo $form->error($model,'minimum_passing'); ?>
                          </td>
                          
                        </tr>
                       
                        
                        <tr>
                            <td colspan="4"> 
                                
                                <?php if(!isset($_GET['id']))
                                         echo CHtml::submitButton(Yii::t('app', 'Create'),array('name'=>'create')); 
                                         else
                                             echo CHtml::submitButton(Yii::t('app', 'Update'),array('name'=>'update'));
                                ?>
                                
                            </td>
                            
                            
                        </tr>
                       
                      
                      </tbody>
                    </table>
                  </div><!-- /.table-responsive -->
                </div><!-- /.box-body -->
                
              </div>
 <?php $this->endWidget(); ?>

