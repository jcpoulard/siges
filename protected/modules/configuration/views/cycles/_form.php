<div class="form">
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



/* @var $this CyclesController */
/* @var $model Cycles */
/* @var $form CActiveForm */

$acad_sess=acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 


?>
    <div class="b_mail">	
    <?php
	echo '<p class="note">'.Yii::t('app','Fields with <span class="required">*</span> are required.').'</p>';

	  echo $form->errorSummary($model); ?>
    
<div  id="resp_form_siges">

        <form  id="resp_form">
        
        <div class="col-2">
            <label id="resp_form">
              <?php echo $form->labelEx($model,'cycle_description'); ?>
	                          <td>
	                              <?php echo $form->textField($model,'cycle_description',array('size'=>60,'maxlength'=>100,'placeholder'=>Yii::t('app','Cycle Description'))); ?>
	                              <?php echo $form->error($model,'cycle_description'); ?>
	                          
            </label>
        </div>
                        
                      <div class="col-submit">
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
                                              $url=Yii::app()->request->urlReferrer;
                                              $explode_url= explode("php",substr($url,0));
				             
                                              echo ' <a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';
                                          
        
                                ?>
                      </div>
        </form>
</div>
                            
<!-- END OF TEST -->
    </div>
</div>