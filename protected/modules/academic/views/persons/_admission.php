
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


$acad=Yii::app()->session['currentId_academic_year'];


$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); 


 $modelEmployeeInfo = new EmployeeInfo;
 
 $modelStudentOtherInfo = new StudentOtherInfo;
         
         if(isset($_GET['id'])&&$_GET['id']!='')
           {
           	   $modelStudentOtherInfo = StudentOtherInfo::model()->find('student=:IdStudent',array(':IdStudent'=>$model->id ));
           
	           if($modelStudentOtherInfo ==null)
		           $modelStudentOtherInfo=new StudentOtherInfo;
	        }


?>
    
 

<?php


	
	  
	echo '<p class="note">'.Yii::t('app','Fields with <span class="required">*</span> are required.').'</p>';

	  echo $form->errorSummary($model); 
	  
	  if(isset($_GET['pn'])&&($_GET['pn']!=''))
	     $model->setAttribute('first_name',$_GET['pn']);
	     
	  if(isset($_GET['n'])&&($_GET['n']!=''))
	     $model->setAttribute('last_name',$_GET['n']);
	  
	
if($this->messagePreviousLevel)
	  {
	  	  	//error message
	     echo '	
<div class="" style="padding-left:0px;"> ';
				      
				      echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
					   <tr>
					    <td style="text-align:center;">';	
				      				      
			     			      
				 				   
				     echo '<span style="color:red;" >'.Yii::t('app','Previous level cannot be null.').'</span>';
				      				 
			      echo '</td>
					    </tr>
						</table>';
					
           echo '</div>';

	  	
	  	}  	
	  
	  ?>


    
    <div  id="resp_form_siges">

        <form  id="resp_form">
        
        <div class="col-2">
            <label id="resp_form"> 

                    <?php echo $form->labelEx($model,'last_name'); ?>
                        <?php echo $form->textField($model,'last_name',array('size'=>60,'maxlength'=>45,'placeholder'=>Yii::t('app','Last Name'))); ?>
                        <?php echo $form->error($model,'last_name'); ?>
                    </label>
        </div>
        <div class="col-2">
            <label id="resp_form">
<?php echo $form->labelEx($model,'first_name'); ?>
                        <?php echo $form->textField($model,'first_name',array('size'=>60,'maxlength'=>45,'placeholder'=>Yii::t('app','First Name'))); ?>
                        <?php echo $form->error($model,'first_name'); ?>
                    </label>
        </div>
        <div class="col-2">
            <label id="resp_form">
<label><?php echo Yii::t('app','Blood Group');?></label>
                        <?php echo $form->dropDownList($model,'blood_group',$model->getBlood_groupValue(),array('prompt'=>Yii::t('app','-- Select blood group --'))); ?>
                        <?php echo $form->error($model,'blood_group'); ?>
                    </label>
        </div>
        <div class="col-2">
            <label id="resp_form">
<?php echo $form->labelEx($model,'gender'); ?>
<?php echo $form->dropDownList($model,'gender',$model->getGenders(),array('prompt'=>Yii::t('app','-- Select gender --'))); ?>
                    </label>
        </div>
        <div class="col-2">
            <label id="resp_form">
<?php echo $form->labelEx($model,'birthday'); ?>
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker',
                             array(
                             'model'=>'$model',
                             'name'=>'Persons[birthday]',
                             'language'=>'fr',
                             'value'=>$model->birthday,
                             'htmlOptions'=>array('size'=>60, 'style'=>'width:100% !important','placeholder'=>Yii::t('app','Birthday')),
                                     'options'=>array(
                                     'showButtonPanel'=>true,
                                     'changeYear'=>true,                                      
                                     'dateFormat'=>'yy-mm-dd',
                                     'yearRange'=>'1900:2100',
                                     'changeMonth'=>true,
                                     'showButtonPane'=>true,
                                            
                                      'dateFormat'=>'yy-mm-dd',   
                                     ),
                             )
                     );
                     ?>
		<?php echo $form->error($model,'birthday'); ?>
                    </label>
        </div>
        <div class="col-2">
            <label id="resp_form">
<?php echo $form->labelEx($model,'id_number'); ?>
                        <?php echo $form->textField($model,'id_number',array('size'=>60,'maxlength'=>45,'placeholder'=>Yii::t('app','Id Number'))); ?>
                        <?php echo $form->error($model,'id_number'); ?>
                    </label>
        </div>
        <div class="col-2">
            <label id="resp_form">
<label><?php echo Yii::t('app','Birth place'); ?> </label>
                        <?php 
                            $criteria = new CDbCriteria(array('order'=>'city_name'));
		
                            echo $form->dropDownList($model, 'cities',
                            CHtml::listData(Cities::model()->findAll($criteria),'id','city_name'),
                            array('prompt'=>Yii::t('app','-- Please select city --'))
                            );
                            ?>
                    </label>
        </div>
        <div class="col-2">
            <label id="resp_form">
<?php echo $form->labelEx($model,'image'); 
			           if(isset($model->image))
				              echo $model->image;?>
                    
                        <input size="60" name="image" type="file" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10pt" />
                        <?php echo $form->error($model,'image'); ?>
                    </label>
        </div>
        <div class="col-2">
            <label id="resp_form">
<?php echo $form->labelEx($model,'phone'); ?>
                        <?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>45,'placeholder'=>Yii::t('app','Phone'))); ?>
                        <?php echo $form->error($model,'phone'); ?>
                    </label>
        </div>
        <div class="col-2">
            <label id="resp_form">
<?php echo $form->labelEx($model,'email'); ?>

                        <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>45,'placeholder'=>Yii::t('app','Email'))); ?>
                        <?php echo $form->error($model,'email'); ?>
                    </label>
        </div>
        <div class="col-2">
            <label id="resp_form">
<?php echo $form->labelEx($model,'adresse'); ?>
                        <?php echo $form->textField($model,'adresse',array('size'=>60,'maxlength'=>255,'placeholder'=>Yii::t('app','Adresse'))); ?>
                        <?php echo $form->error($model,'adresse'); ?>
                    </label>
        </div>
        <div class="col-2">
            <label id="resp_form">
<?php echo $form->labelEx($model,'citizenship'); ?>
                        <?php echo $form->textField($model,'citizenship',array('size'=>60,'maxlength'=>45,'placeholder'=>Yii::t('app','Citizenship'))); 
                            echo $form->error($model,'citizenship'); 
                        ?>
                    </label>
        </div>
        <div class="col-2">
            <label id="resp_form">
<?php echo $form->labelEx($modelStudentOtherInfo,'health_state'); ?>
                        <?php 
                              if($this->health_state!='')
                                $modelStudentOtherInfo->setAttribute('health_state',$this->health_state);
                                
                                echo $form->textField($modelStudentOtherInfo,'health_state',array('size'=>60,'maxlength'=>255,'placeholder'=>Yii::t('app','Health State')));  
                                
                               echo $form->error($modelStudentOtherInfo,'health_state'); 
                        
                        ?>
                    </label>
        </div>
        <div class="col-2">
            <label id="resp_form">

<?php echo $form->labelEx($model,'identifiant'); ?>
                        <?php echo $form->textField($model,'identifiant',array('size'=>60,'maxlength'=>100,'placeholder'=>Yii::t('app','Identifiant')));?> 
                        <?php echo $form->error($model,'identifiant'); ?>
                    </label>
        </div>
        <div class="col-2">
            <label id="resp_form">
<?php echo $form->labelEx($model,'matricule'); ?>
                        <?php echo $form->textField($model,'matricule',array('size'=>60,'maxlength'=>100,'placeholder'=>Yii::t('app','Matricule')));  
                            echo $form->error($model,'matricule'); 
                        ?>
                    </label>
        </div>
        <div class="col-2">
            <label id="resp_form">
<?php echo $form->labelEx($model,'mother_first_name'); ?>
                        <?php echo $form->textField($model,'mother_first_name',array('size'=>60,'maxlength'=>55,'placeholder'=>Yii::t('app','Mother First Name'))); ?>
                        <?php echo $form->error($model,'mother_first_name'); ?>
                    </label>
        </div>
        <div class="col-2">
            <label id="resp_form">
<?php echo $form->labelEx($modelStudentOtherInfo,'father_full_name'); ?>
                        <?php 
                              if($this->father_full_name!='')
                                $modelStudentOtherInfo->setAttribute('father_full_name',$this->father_full_name);

                              echo $form->textField($modelStudentOtherInfo,'father_full_name',array('size'=>60,'maxlength'=>100,'placeholder'=>Yii::t('app','Father full name'))); ?>
                        <?php echo $form->error($modelStudentOtherInfo,'father_full_name'); ?>
                    </label>
        </div>
        <div class="col-2">
            <label id="resp_form">
<?php echo $form->labelEx($modelStudentOtherInfo,'mother_full_name'); ?>                        <?php 
                               if($this->mother_full_name!='')
                                $modelStudentOtherInfo->setAttribute('mother_full_name',$this->mother_full_name);
                              
                               echo $form->textField($modelStudentOtherInfo,'mother_full_name',array('size'=>60,'maxlength'=>100,'placeholder'=>Yii::t('app','Mother full name'))); ?>

                        <?php echo $form->error($modelStudentOtherInfo,'mother_full_name'); ?>
                    </label>
        </div>
        <div class="col-2">
            <label id="resp_form">
<?php echo $form->labelEx($modelStudentOtherInfo,'person_liable'); ?>                        <?php 
                              if($this->person_liable!='')
                                $modelStudentOtherInfo->setAttribute('person_liable',$this->person_liable);
                              
                             echo $form->textField($modelStudentOtherInfo,'person_liable',array('size'=>60,'maxlength'=>100,'placeholder'=>Yii::t('app','Person Liable')));  
                            echo $form->error($modelStudentOtherInfo,'person_liable'); 
                        ?>
                    </label>
        </div>
        <div class="col-2">
            <label id="resp_form">

<?php echo $form->labelEx($modelStudentOtherInfo,'person_liable_phone'); ?>
                        <?php 
                              if($this->person_liable_phone!='')
                                $modelStudentOtherInfo->setAttribute('person_liable_phone',$this->person_liable_phone);	
                                
                               echo $form->textField($modelStudentOtherInfo,'person_liable_phone',array('size'=>60,'maxlength'=>65,'placeholder'=>Yii::t('app','Person Liable Phone')));?> 
                        <?php echo $form->error($modelStudentOtherInfo,'person_liable_phone'); ?>
                    </label>
        </div>
        <div class="col-2">
            <label id="resp_form">                        <?php  
                               
                               echo $form->labelEx($modelStudentOtherInfo,'previous_school');//Yii::t('app','Previous school')); ?>
                    
                        <?php 
                              
                              if($this->previousSchool!='')
                                $modelStudentOtherInfo->setAttribute('previous_school',$this->previousSchool);

                                echo $form->textField($modelStudentOtherInfo,'previous_school',array('size'=>60,'maxlength'=>255,'placeholder'=>Yii::t('app','Previous School'))); ?> 
                        <?php echo $form->error($modelStudentOtherInfo,'previous_school'); ?>
                    </label>
        </div>
        <div class="col-2">
            <label id="resp_form">
                        <?php echo '<span style="color:red;" >'.$form->labelEx($modelStudentOtherInfo,'previous_level').'</span>'; ?>
                    
                    <?php 
                 
                  
						//$modelLevelPerson = new LevelHasPerson;
						 //for create
							 if($this->idPreviousLevel!='')
							    echo $form->dropDownList($modelStudentOtherInfo,'previous_level',$this->loadLevel(), array('options' => array($this->idPreviousLevel=>array('selected'=>true)) )); 
							 else
								 echo $form->dropDownList($modelStudentOtherInfo,'previous_level',$this->loadLevel()); 

		
		 echo $form->error($modelStudentOtherInfo,'previous_level'); 
		 
					 
                    ?>
                    </label>
        </div>
        <div class="col-2">
            <label id="resp_form">
                        <?php 
                           
                            echo $form->labelEx($modelStudentOtherInfo,'school_date_entry'); 
                        ?>
                    
                        <?php 
                                 if($this->school_date_entry!='')
                                   $modelStudentOtherInfo->setAttribute('school_date_entry',$this->school_date_entry);

                             $this->widget('zii.widgets.jui.CJuiDatePicker',
												 array(
                                 'model'=>'$modelStudentOtherInfo',
                                 'name'=>'StudentOtherInfo[school_date_entry]',
                                 'language'=>'fr',
                                 'value'=>$modelStudentOtherInfo->school_date_entry,
                                 'htmlOptions'=>array('size'=>60, 'style'=>'width:100% !important','placeholder'=>Yii::t('app','School Date Entry')),
                                         'options'=>array(
                                         'showButtonPanel'=>true,
                                         'changeYear'=>true,                                      
                                         'dateFormat'=>'yy-mm-dd',
                                         'yearRange'=>'1900:2100',
                                         'changeMonth'=>true,
                                         'showButtonPane'=>true,
                                              
                                         'dateFormat'=>'yy-mm-dd',   
                                         ),
                                 )
                         );
		?>
                <?php echo $form->error($modelStudentOtherInfo,'school_date_entry'); ?>        
                        
                    </label>
        </div>
        <div class="col-2">
            <label id="resp_form">
<?php echo $form->labelEx($model,'comment'.' /'.Yii::t('app', 'filed parts')); ?>
                        <?php echo $form->textField($model,'comment',array('size'=>60,'maxlength'=>255,'placeholder'=>Yii::t('app','Comment'))); ?>
                        <?php echo $form->error($model,'comment'); ?>
                    

</label>
        </div>
        

                    <div class="col-submit">
                                
                                <?php if(!isset($_GET['id'])){
                                         if(!isAchiveMode($acad))
                                            echo CHtml::submitButton(Yii::t('app', 'Create '),array('name'=>'create','class'=>'btn btn-warning')); //'Create ' avec espace a la fin POUR AVOIR UNE TRADUCTION "ENREGISTRER"
                                         
                                         echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary')); //'Cancel ' avec espace a la fin POUR AVOIR UNE TRADUCTION "Annuler"/ sans espace=>'Retour'
                                        }
                                         else
                                           {  if(!isAchiveMode($acad))
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
 
 