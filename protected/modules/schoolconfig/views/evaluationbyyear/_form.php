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

$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); 

$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

$siges_structure = infoGeneralConfig('siges_structure_session');


?>

<div class="form">

<?php
	echo '<p class="note">'.Yii::t('app','Fields with <span class="required">*</span> are required.').'</p>';

	  echo $form->errorSummary($model); ?>

<div  id="resp_form_siges">

        <form  id="resp_form">
        
        <div class="col-2">
            <label id="resp_form">
	

                          <label for="Evaluations"><?php echo Yii::t('app','Evaluation'); ?></label>
                          
                              <?php  //li t kreye sou tout ane a
                                     $criteria = new CDbCriteria(array('order'=>'evaluation_name','condition'=>'academic_year='.$acad));
		
			                    echo $form->dropDownList($model, 'evaluation',
			                    CHtml::listData(Evaluations::model()->findAll($criteria),'id','evaluation_name'),
			                    array('prompt'=>Yii::t('app','-- Please select evaluation --'))
								);
								?>
            </label>
        </div>
            
        <div class="col-2">
            <label id="resp_form">    
                          
                          <label for="AcademicPeriods"><?php echo Yii::t('app','Academic Period'); ?>
				                </label>
				               <?php 
							              if($siges_structure==1)
											   $condition = 'id';
											elseif($siges_structure==0)
											   $condition = 'year';
											   
								$criteria = new CDbCriteria(array('condition'=>'is_year=0 AND '.$condition.'=:acad','params'=>array(':acad'=>$acad_sess,),'order'=>'date_start DESC',));
								
								echo $form->dropDownList($model, 'academic_year',
								CHtml::listData(AcademicPeriods::model()->findAll($criteria),'id','name_period'),
								array('prompt'=>Yii::t('app','-- Please select academic period --'))
								);
								 ?>
            </label>
        </div>
            
        <div class="col-2">
            <label id="resp_form">    
                        
                        <?php echo $form->labelEx($model,'evaluation_date'); ?>
							<?php $this->widget('zii.widgets.jui.CJuiDatePicker',
							 array(
									 'model'=>'$model',
									 'name'=>'EvaluationByYear[evaluation_date]',
									 'language'=>'fr',
									 'value'=>$model->evaluation_date,
									 'htmlOptions'=>array('size'=>60, 'style'=>'width:100% !important','placeholder'=>Yii::t('app','Evaluation Date')),
										 'options'=>array(
										 'showButtonPanel'=>true,
										 'changeYear'=>true,                                      
										 
	                                                                         'dateFormat'=>'yy-mm-dd',
	                                                                         'yearRange'=>'1900:2100',
	                                                                         'changeMonth'=>true,
	                                                                            
										 ),
									 )
								 );
								 ?>
									<?php echo $form->error($model,'evaluation_date'); 
									     
									     if($this->error)
									       {
									       	   echo '<div class="" style=" width:45%; margin-top:5px; margin-bottom:5px;  color:red;">';
									              
													    echo Yii::t('app','Evaluation date must belong to the current academic year !');
													      
													       echo '</div>';
									
									       	}
									?>

            </label>
        </div>
        
        
     <div class="col-2">
            <label id="resp_form">
               
                                <?php echo $form->labelEx($model,'last_evaluation'); 
		                                 	 
		                               if($this->last_evaluation==1)
				                          { 
                                             echo $form->checkBox($model,'last_evaluation',array('onchange'=> 'submit()','checked'=>'checked'));
				                              
				                           }
						                 else
							               echo $form->checkBox($model,'last_evaluation',array() );
							               
							             
							           
							          echo $form->error($model,'last_evaluation'); 
                                 
                                 
                                 
                                 ?>
                   
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

</div>
			