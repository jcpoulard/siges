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

            

$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

 
 
	
            $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
            $this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); ?>

<div class="form">

<?php
        $modelCourse = new Courses;

	echo '<p class="note">'.Yii::t('app','Fields with <span class="required">*</span> are required.').'</p>';

	echo $form->errorSummary($model); ?>
        
        <div  id="resp_form_siges">

        <form  id="resp_form">
        
        <div class="col-2">
            <label id="resp_form">  
                            <?php echo $form->labelEx($model,'level_or_course'); ?>
                          
                              <?php
			                      
                                if(isset($this->level_or_course)&&($this->level_or_course!=''))
							       echo $form->dropDownList($model,'level_or_course',$this->loadLevelOrCourse(), array('onchange'=> 'submit()','options' => array($this->level_or_course=>array('selected'=>true)))); 
							    else
								  { 
									echo $form->dropDownList($model,'level_or_course',$this->loadLevelOrCourse(), array('onchange'=> 'submit()')); 
						           }
                                ?>
                              <?php echo $form->error($model,'level_or_course'); ?>
          
                            <?php
                                   if(($this->level_or_course==1)&&($this->course_id!=''))
								     {
								        
						                    // Affiche le coefficient ou la moyenne de base
								       $this->alert_ = '('.Yii::t('app', 'Weight').': '.$this->weight.')'; 
								        }
                                                                        else{
                                                                             $criteria_ = new CDbCriteria;
                                                                             $criteria_->condition='item_name=:item_name';
                                                                             $criteria_->params=array(':item_name'=>'average_base',);
                                                                             $average_base = GeneralConfig::model()->find($criteria_)->item_value;
                                                                             if($average_base!=null)
                                                                                $this->alert_ = Yii::t('app','over ').$average_base;
                                                                        }
								        	
							 ?>
            </label>
        </div>
            
        <div class="col-2">
            <label id="resp_form"> 
                          
                        <?php if($this->level_or_course==0)
                                       echo $form->labelEx($model,'level');
                                    elseif($this->level_or_course==1)
                                      {
                                      	  
                                      	 // echo $form->labelEx($modelCourse,'subject');
                                      	 echo '<b>'.Yii::t('app','Course').'</b> <br/>';
                                      	 
                                      	} 
                                    
                                ?>
                
                              <?php
			
                                if($this->level_or_course==0)
	                              {
	                              	  $criteria = new CDbCriteria(array('order'=>'level_name',));
	
	                                echo $form->dropDownList($model, 'level',
	                                CHtml::listData(Levels::model()->findAll($criteria),'id','level_name'),
	                                array('prompt'=>Yii::t('app','-- Please select level --'))
	                                );
	                                
	                                 echo $form->error($model,'level');
	                                 
	                               }
	                            elseif($this->level_or_course==1) 
	                              {
	                              	 if(isset($this->course_id))
								        {   
							               echo $form->dropDownList($modelCourse,'subject',$this->loadSubjectDeBase($acad_sess), array('onchange'=> 'submit()','options' => array($this->course_id=>array('selected'=>true)) )); 
							             }
									  else
										{ $this->course_id=0;
										    echo $form->dropDownList($modelCourse,'subject',$this->loadSubjectDeBase($acad_sess),array('onchange'=> 'submit()')); 
										}

	                                
	                                 echo $form->error($modelCourse,'subject');
	                              	
	                              	
	                              	}
                                 
                               
                               
                               ?>
                  </label>
        </div>
              
            <div class="col-2">
            <label id="resp_form">  
                        <?php echo $form->labelEx($model,'minimum_passing'); ?>
                          
                             <?php 
                             if($this->level_or_course==0)
                                 echo $form->textField($model,'minimum_passing',array('size'=>60,'placeholder'=>Yii::t('app','Passing Average').' '.$this->alert_));
                             
                             elseif($this->level_or_course==1)
                                 echo $form->textField($model,'minimum_passing',array('size'=>60,'placeholder'=>Yii::t('app','Minimum Passing').' '.$this->alert_));
                             
                              ?>
                            <?php echo $form->error($model,'minimum_passing'); ?>
                          
            </label>
            </div>
                                            
                        
                        <div class="col-submit">
                                
                                 <?php if(!isset($_GET['id'])){
                                          if(!isAchiveMode($acad_sess))
                                              echo CHtml::submitButton(Yii::t('app', 'Create '),array('name'=>'create','class'=>'btn btn-warning')); //'Create ' avec espace a la fin POUR AVOIR UNE TRADUCTION "ENREGISTRER"
                                         echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary')); //'Cancel ' avec espace a la fin POUR AVOIR UNE TRADUCTION "Annuler"/ sans espace=>'Retour'
                                        }
                                         else
                                           {   if(!isAchiveMode($acad_sess))
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
 