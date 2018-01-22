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


$acad_sess=acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; //sou tout ane akademik lan


?>
<div class="form">
<?php
	echo '<p class="note">'.Yii::t('app','Fields with <span class="required">*</span> are required.').'</p>';

	  echo $form->errorSummary($model); ?>
    <div  id="resp_form_siges">

        <form  id="resp_form">
        
        <div class="col-2">
            <label id="resp_form">            
              <?php echo $form->labelEx($model,Yii::t('app','level_name')); ?>
                              <?php echo $form->textField($model,'level_name',array('size'=>60,'maxlength'=>45,'placeholder'=>Yii::t('app','Level Name'))); ?>
                              <?php echo $form->error($model,'level_name'); ?>
            </label>
        </div>
      
        <div class="col-2">
            <label id="resp_form">
                         
                         <?php echo $form->labelEx($model,Yii::t('app','short_level_name')); ?>
                         
                              <?php echo $form->textField($model,'short_level_name',array('size'=>60,'maxlength'=>45,'placeholder'=>Yii::t('app','Short Level Name'))); ?>
                              <?php echo $form->error($model,'short_level_name'); ?>
            </label>
        </div>
        
         <div class="col-2">
            <label id="resp_form">    
                         <?php echo '<label>'.Yii::t('app','Previous Level').'</label>';?>
                          
                             <?php 
                                                   if(isset($this->idLevel['id']))
							      echo $form->dropDownList($model,'previous_level',$this->loadLevel($this->idLevel), array('options' => array($this->idLevel['id']=>array('selected'=>true)))); 
							 else
								{ 
								  echo $form->dropDownList($model,'previous_level',$this->loadLevel(null)); 
					             }
                                                        echo $form->error($model,'level'); 
                                              ?> 
            </label>
         </div>
        
         <div class="col-2">
            <label id="resp_form">    
                          <?php echo '<label>'. Yii::t('app', 'Section').'</label>'; ?>
                            
                                <?php 
						
						  $modelSection = new Sections;
						     if(isset($_GET['id']))//c 1 update
							  { 
						        
									 if(isset($this->section_id))
									   echo $form->dropDownList($modelSection,'section_name',$this->loadSection(), array('onchange'=> 'submit()','options' => array($this->section_id=>array('selected'=>true)))); 
							   }
							  else	
                                                          {
                                                              $criteria = new CDbCriteria(array('order'=>'section_name',));
		
                                                                    echo $form->dropDownList($model, 'section',
                                                                    CHtml::listData(Sections::model()->findAll($criteria),'id','section_name'),
                                                                    array('onchange'=> 'submit()','prompt'=>Yii::t('app','-- Select --'))
                                                                            );
                                                                    echo $form->error($modelSection,'section'); 
                                                          }
							     
						  	
					
											
					   ?>
            </label>
         </div>
                            
               
                <?php
                        if($this->addCycleLine)
                          {
                          	$modelCycleSection = new SectionHasCycle;
                          	
                      ?>
             <div class="col-2">
            <label id="resp_form">             
                          <?php echo $form->labelEx($modelCycleSection,Yii::t('app','cycle ')); ?>
                          
                              <?php if(isset($_GET['id']))//c 1 update
							  { 
							  	$modelCHS= new SectionHasCycle;
							  	$modelCHS=SectionHasCycle::model()->getCycleBySectionIdLevelId($this->section_id,$_GET['id'],$acad);
							  	 
							  	if(isset($modelCHS)&&($modelCHS!=null))
							  	 { 
									$this->cycle_id =$modelCHS->cycle;
																		    
							  	 }
						        
						        
									 if(isset($this->cycle_id))
									   echo $form->dropDownList($modelCycleSection,'cycle',$this->loadCycle(), array('options' => array($this->cycle_id=>array('selected'=>true))));
									 else
									    echo $form->dropDownList($modelCycleSection,'cycle',$this->loadCycle(), array('prompt'=>Yii::t('app','-- Select --')   ));
									      
							   }
							  else	
                                                          {
                                                              echo $form->dropDownList($modelCycleSection,'cycle',$this->loadCycle(), array('prompt'=>Yii::t('app','-- Select --')   )); 

                                                                     
                                                          }
                                       ?>
                                       
                              <?php echo $form->error($modelCycleSection,'cycle'); ?>
            </label>
             </div>
                          	
                          	
                 <?php         	
                            }
                
                 ?>        
                        
                      <div class="col-submit">
                                
                                <?php if(!isset($_GET['id'])){
                                	
                                          if(!isAchiveMode($acad_sess))
                                             echo CHtml::submitButton(Yii::t('app', 'Create '),array('name'=>'create','class'=>'btn btn-warning')); //'Create ' avec espace a la fin POUR AVOIR UNE TRADUCTION "ENREGISTRER"
                                         echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary')); //'Cancel ' avec espace a la fin POUR AVOIR UNE TRADUCTION "Annuler"/ sans espace=>'Retour'
                                        }
                                         else
                                           {  
                                           	   if(!isAchiveMode($acad_sess))
                                           	      echo CHtml::submitButton(Yii::t('app', 'Save'),array('name'=>'update','class'=>'btn btn-warning'));
                                            
                                              echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary'));
                                              
                                             } 
                                           
                                           
                                             if(!isAchiveMode($acad_sess))
                                                 echo CHtml::submitButton(Yii::t('app', 'Add Room'),array('name'=>'addRoom','class'=>'btn btn-warning')); 
                                
                                //back button   
                                              $url=Yii::app()->request->urlReferrer;//$_SERVER['REQUEST_URI'];
                                              $explode_url= explode("php",substr($url,0));
				             
                                              echo ' <a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';
                                          


                                
                                
                                ?>
                      </div>
                </form>
                
              </div>
    
</div>