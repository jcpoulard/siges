<?php

/*
 * © 2015 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
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

?>


<?php
$acad_sess=acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 


	echo '<p class="note">'.Yii::t('app','Fields with <span class="required">*</span> are required.').'</p>';

	  echo $form->errorSummary($model); ?>

<div class="b_mail">
<div class="box box-info">
         <div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin">
                      
                      <tbody>
                        <tr>
                          <td><?php echo $form->labelEx($model,'module_short_name'); ?></td>
                          <td>
                              <?php echo $form->textField($model,'module_short_name',array('size'=>32,'maxlength'=>64)); ?>
                              <?php echo $form->error($model,'module_short_name'); ?>
                          </td>
                          
                          <td><?php echo $form->labelEx($model,'module_name'); ?></td>
                          <td>
                              <?php echo $form->textField($model,'module_name',array('size'=>32,'maxlength'=>64)); ?>
                              <?php echo $form->error($model,'module_name'); ?>
                          </td>
                          
                          
                        </tr>
                        <td><?php echo $form->labelEx($model,'mod_lateral_menu'); ?></td>
                          <td>
                              <?php echo $form->textField($model,'mod_lateral_menu',array('size'=>32,'maxlength'=>64)); ?>
                              <?php echo $form->error($model,'mod_lateral_menu'); ?>
                          </td>
                          <td></td>
                          <td></td>
                        <tr>
                          
                          
                        </tr>
                       
                        
                        <tr>
                            <td colspan="4"> 
                                
                                <?php if(!isset($_GET['id'])){
                                         if(!isAchiveMode($acad_sess))
                                            echo CHtml::submitButton(Yii::t('app', 'Create '),array('name'=>'create','class'=>'btn btn-warning'));
                                        
                                         echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary'));
                                        }
                                         else
                                           {  if(!isAchiveMode($acad_sess))
                                                 echo CHtml::submitButton(Yii::t('app', 'Save'),array('name'=>'update','class'=>'btn btn-warning'));
                                            
                                              echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary'));
                                              
                                             } 
                                           //back button   
                                              $url=Yii::app()->request->urlReferrer;
                                              $explode_url= explode("php",substr($url,0));
				             
                                              echo ' <a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';
                                      
                                ?>
                                
                            </td>
                            
                        </tr>
                       
                      
                      </tbody>
                    </table>
                  </div><!-- /.table-responsive -->
                </div>
				</div>
<!-- /.box-body -->
                
              </div>
<!-- END OF TEST -->



