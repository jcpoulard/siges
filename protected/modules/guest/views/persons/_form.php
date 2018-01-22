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
<!-- Menu of CRUD  -->
<?php 


$acad=Yii::app()->session['currentId_academic_year'];


$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); 


 $modelStudentOtherInfo = new StudentOtherInfo;
 $modelEmployeeInfo = new EmployeeInfo;

?>

<div id="dash">
   

   <?php        if(isset($_GET['id'])) // c 1 update
                  {  if(isset($_GET['isstud'])) 
                     {  if($_GET['isstud']==1)
                           echo '<h2>' .Yii::t('app','Update student :').'  <b>'.$model->first_name." ".$model->last_name.'</b> </h2>'; 
					 
					    elseif($_GET['isstud']==0)
						       echo '<h2>'.Yii::t('app','Update teacher :').'  <b>'.$model->first_name." ".$model->last_name.'</b> </h2>';
					   }
					 else      
						    echo '<h2>'.Yii::t('app','Update employee :').'  <b>'.$model->first_name." ".$model->last_name.'</b> </h2>'; 
					   			  
				  }
				 else // c 1 create 
                  { if(isset($_GET['isstud'])) 
                     {  if($_GET['isstud']==1)
                           echo '<h2>'.Yii::t('app','Create Student').' </h2>'; 
					 
					    elseif($_GET['isstud']==0)
						       echo '<h2>'.Yii::t('app','Create Teacher').' </h2>';
					   } 
					 else      
						    echo '<h2>'.Yii::t('app','Create Employee').' </h2>'; 
					   
					}
		?>
                  <div class="icon-dash">

                      <?php

                     $images = '<img src="/siges/css/images/cancel.png" alt="Add any" /> <br />'.Yii::t('app','Cancel');

                               // build the link in Yii standard
                        
                     
					 if(isset($_GET['isstud'])) 
                                        {  
                                             if(($_GET['isstud']==1) && ($model->id!=null))
											   {  //update
                                                if(isset($_GET['pg']))
												   {  if($_GET['pg']=='vr')
												        echo CHtml::link($images,array('viewForReport','id'=>$model->id,'isstud'=>1,'from'=>'stud'));
                                                      elseif($_GET['pg']=='vrlr')
												        echo CHtml::link($images,array('viewForReport','id'=>$model->id,'pg'=>'lr','isstud'=>1,'from'=>'stud'));
														  elseif($_GET['pg']=='vrl')
												        echo CHtml::link($images,array('viewForReport','id'=>$model->id,'pg'=>'l','isstud'=>1,'from'=>'stud'));
															 if($_GET['pg']=='lr')
															   echo CHtml::link($images,array('listForReport','id'=>$model->id,'isstud'=>1,'from'=>'stud'));
															   elseif($_GET['pg']=='l')
																   echo CHtml::link($images,array('list','isstud'=>1,'from'=>'stud'));
													}
												else //$_GET['pg'] not set
												  {
												  echo '';//CHtml::link($images,array('viewForReport','id'=>$model->id,'pg'=>'l','isstud'=>1,'from'=>'stud'));

												  }
											   }
											 elseif(($_GET['isstud']==0) )
											  {
											     echo CHtml::link($images,array('persons/listForReport?isstud=0&from=teach'));
											   }
											  elseif($model->id == null) //create
                                                 { if($_GET['isstud']==1)
													 {  if(isset($_GET['pg']))
													     {  if($_GET['pg']=='lr')
															echo CHtml::link($images,array('listForReport','isstud'=>1,'from'=>'stud'));
														 }
													   else
														 echo CHtml::link($images,array('persons/listForReport?isstud=1&from=stud'));
													 }
													elseif($_GET['isstud']==0) 
													  {  if(isset($_GET['pg']))
													     {  if($_GET['pg']=='lr')
															echo CHtml::link($images,array('persons/listForReport','isstud'=>0,'from'=>'teach'));
														 }
													   else
 													     echo CHtml::link($images,array('persons/listForReport?isstud=0&from=teach'));
													   
													  }
												  }
											    elseif(isset($_GET['from1']))
												   {
                                                        if($_GET['from1']=='teach_view')
                                                             echo CHtml::link($images,array('persons/view','id'=>$model->id,'isstud'=>0,'from'=>'teach')); 
                                                   }
					 
												
											   
                                           
                              } 
                              elseif(isset($_GET['from1']) && $_GET['from1']=='view')
                                   echo CHtml::link($images,array('viewForReport','id'=>$model->id,'from'=>'emp'));
                                  else
                                    echo CHtml::link($images,array('persons/listForReport?from=emp')); 
                                                    
						    
                                                
					   
                   ?>

                  </div>  

  <?php if(((isset($_GET['isstud'])) && ($_GET['isstud']==1))||($model->is_student==1)) { ?>
					 
              
			  
<div class="icon-dash">

                  
              </div> 
	
   

  <div class="icon-dash">

                 

              </div> 
			  
			  
			  
			  <?php }?>
			  
			  
  </div>
  
  
    
 

<p class="note"><?php echo Yii::t('app','Fields with <span class="required">*</span> are required.'); ?></p>

<?php echo $form->errorSummary($model); ?>

<div class="principal">
     
  <div class="secondaire">
			<div class="row">
				<?php echo $form->labelEx($model,'last_name'); ?>
		<?php echo $form->textField($model,'last_name',array('size'=>40,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'last_name'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'first_name'); ?>
		<?php echo $form->textField($model,'first_name',array('size'=>40,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'first_name'); ?>
			</div>

			  <div class="row">
				
				      <label for="blood_group"> <?php echo Yii::t('app','Blood Group');
					 ?>
				</label>
				
		<?php echo $form->dropDownList($model,'blood_group',$model->getBlood_groupValue(),array('prompt'=>Yii::t('app','-- Select blood group --'))); ?>
		<?php echo $form->error($model,'blood_group'); ?>
			</div>		
			
			
			<div class="row">
				<?php echo $form->labelEx($model,'gender'); ?>
		<?php echo $form->dropDownList($model,'gender',$model->getGenders(),array('prompt'=>Yii::t('app','-- Select gender --'))); ?>
		<?php echo $form->error($model,'gender'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'birthday'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker',
								 array(
										 'model'=>'$model',
										 'name'=>'Persons[birthday]',
										
										 'value'=>$model->birthday,
										 'htmlOptions'=>array('size'=>40, 'style'=>'width:100px !important'),
											 'options'=>array(
											 'showButtonPanel'=>true,
											 'changeYear'=>true,                                      
											 'dateFormat'=>'yy-mm-dd',
                                                                                         'yearRange'=>'1900:2100',
                                                                                         'changeMonth'=>true,
                                                                                          'showButtonPane'=>true,
                                                                                          'showOn'=>'both',      
																				 'dateFormat'=>'yy-mm-dd',   
											 ),
										 )
									 );
							; ?>
		<?php echo $form->error($model,'birthday'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'id_number'); ?>
		<?php echo $form->textField($model,'id_number',array('size'=>40,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'id_number'); ?>
			</div>
  </div>

  <div class="terciaire">
  
  
      <div class="photo" >
				
				<?php  ?>
		
			
			<div class="row">
            <?php echo $form->labelEx($model,'image'); 
			           if(isset($model->image))
				              echo $model->image;?>
           
			<input size="40" name="image" type="file" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10pt" />
            <?php echo $form->error($model,'image'); ?>
            </div> 
			
			</div>
			
    <div class="niv1">
			<label for="Cities"><?php echo Yii::t('app','City'); ?></label>
                            
                            <?php 
			
                                $criteria = new CDbCriteria(array('order'=>'city_name'));
		
                                echo $form->dropDownList($model, 'cities',
                                CHtml::listData(Cities::model()->findAll($criteria),'id','city_name'),
                                array('prompt'=>Yii::t('app','-- Please select city --'))
                                );
		 ?>
                        
                            
                        

			<div class="row">
				<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textField($model,'phone',array('size'=>40,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'phone'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>40,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'email'); ?>
			</div>
			
			<div class="row">
				<?php echo $form->labelEx($model,'adresse'); ?>
		<?php echo $form->textField($model,'adresse',array('size'=>40,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'adresse'); ?>
			</div>
			
			
			<div class="row">
				<?php   
				         	 echo $form->labelEx($model,'citizenship'); 
				             echo $form->textField($model,'citizenship',array('size'=>40,'maxlength'=>45)); 
				             echo $form->error($model,'citizenship'); 
				             
				        
				     ?>
			</div>

              <div class="row">
				
				      <label for="active"> <?php 
					if(((isset($_GET['isstud'])) && ($_GET['isstud']==1))||($model->is_student==1)) echo Yii::t('app','Student\'s Status'); 
					elseif(((!isset($_GET['isstud'])) || ($_GET['isstud']==0))||($model->is_student==0)) echo Yii::t('app','Employee\'s Status');
					 ?>
				</label>
				
		<?php echo $form->dropDownList($model,'active',$model->getStatusValue(),array('prompt'=>Yii::t('app','-- Select status --'))); ?>
		<?php echo $form->error($model,'active'); ?>
			</div>		
			
			
    </div>
			
   	
    <div class="niv2">
			
	
			<!--Shift(vacation)-->
         <div class="row">
			<label for="Shifts"> <?php 
					if(((isset($_GET['isstud'])) && ($_GET['isstud']==1))||($model->is_student==1)) echo Yii::t('app','Shift'); 
					 ?>
				</label>
					 <?php 
					
					if(((isset($_GET['isstud'])) && ($_GET['isstud']==1))||($model->is_student==1))//for students
					{ 
						$modelShift = new Shifts;
						
						  $default_vacation=null;
			      $criteria = new CDbCriteria;
				   								$criteria->condition='item_name=:item_name';
				   								$criteria->params=array(':item_name'=>'default_vacation',);
				   		$default_vacation_name = GeneralConfig::model()->find($criteria)->item_value;
				   		
				   		$criteria2 = new CDbCriteria;
				   								$criteria2->condition='shift_name=:item_name';
				   								$criteria2->params=array(':item_name'=>$default_vacation_name,);
				   		$default_vacation = Shifts::model()->find($criteria2);
				   		
				   		

						if($model->is_student==1)//for update
						  {    
						  if($this->temoin_update==0)//pour l'affichage
						       {  $shift=$this->getShiftByStudentId($model->id,$acad);
                                                       if($shift!=null)
					              $this->idShift= $shift->id;
                                                       else
                                                           $this->idShift=null;
					            }
					         if(isset($this->idShift)&&($this->idShift!=""))
						       echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('options' => array($this->idShift=>array('selected'=>true)), 'onchange'=> 'submit()',)); 
						      else
								{  $this->idLevel=0;
								     if($default_vacation!=null)
								       { echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('options' => array(($default_vacation->id)=>array('selected'=>true)),'onchange'=> 'submit()' )); 
								             $this->idShift=$default_vacation->id;
								       }
								    else
								       echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('onchange'=> 'submit()' ));    
					            }
					       }
						else //for create
						   {  if(isset($this->idShift)&&($this->idShift!=""))
						        echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('prompt'=>'Select shift','onchange'=> 'submit()','options' => array($this->idShift=>array('selected'=>true)) )); 
					          else
								{  if($default_vacation!=null)
								      { echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('options' => array(($default_vacation->id)=>array('selected'=>true)),'onchange'=> 'submit()' )); 
								            $this->idShift=$default_vacation->id;
								       }
								    else
								       echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('prompt'=>'Select shift','onchange'=> 'submit()' ));                   
								}
					        }
						echo $form->error($modelShift,'shift_name'); 
						
					}
					  ?>
				</div>
			 
		    <!--section(liee au Shift choisi)-->
			<div class="row">
			<label for="Sections"> <?php 
					if(((isset($_GET['isstud'])) && ($_GET['isstud']==1))||($model->is_student==1)) echo Yii::t('app','Section'); 
					?></label><?php 
					
					if(((isset($_GET['isstud'])) && ($_GET['isstud']==1))||($model->is_student==1))//for students
					{ 
						$modelSection = new Sections;
						if($model->is_student==1)//for update
						  {   if($this->temoin_update==0)//pour l'affichage
						       { $section=$this->getSectionByStudentId($model->id,$acad);
                                                       if($section!=null)
						         $this->section_id=$section->id;
                                                       else 
                                                           $this->section_id=null;
					            }
							   
					        if(isset($this->section_id))
						        echo $form->dropDownList($modelSection,'section_name',$this->loadSectionByIdShift($this->idShift), array('onchange'=> 'submit()','options' => array($this->section_id=>array('selected'=>true)))); 
							else
							   {  $this->idLevel=0;
								echo $form->dropDownList($modelSection,'section_name',$this->loadSectionByIdShift($this->idShift), array('onchange'=> 'submit()' )); 
					           }
					       }
						else //for create
						   { 
							    if(isset($this->section_id))
							       echo $form->dropDownList($modelSection,'section_name',$this->loadSectionByIdShift($this->idShift), array('onchange'=> 'submit()','options' => array($this->section_id=>array('selected'=>true)))); 
							    else
									echo $form->dropDownList($modelSection,'section_name',$this->loadSectionByIdShift($this->idShift), array('onchange'=> 'submit()' )); 
					       }
						echo $form->error($modelSection,'section_name'); 
						
					}
											
					   ?>
				</div>
			
			
			<div class="row">
			<label for="Levels"> <?php 
					if(((isset($_GET['isstud'])) && ($_GET['isstud']==1))||($model->is_student==1)) echo Yii::t('app','Entry Level'); 
					 ?>
				</label>
					 <?php 
					 
					if(((isset($_GET['isstud'])) && ($_GET['isstud']==1))||($model->is_student==1))//for students
					{ 
						$modelLevelPerson = new LevelHasPerson;
						if($model->is_student==1)//for update
						  {  if($this->temoin_update==0)//pour l'affichage
						       {   $level=$this->getLevelByStudentId($model->id,$acad);
                                                       if($level != null)
						          $this->idLevel=$level->id;
                                                       else
                                                           $this->idLevel=null;
                                                       
					            }
							     
					          if(isset($this->idLevel))
						         echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevelByIdShiftSectionId($this->idShift,$this->section_id), array('options' => array($this->idLevel=>array('selected'=>true)), 'onchange'=> 'submit()',)); 
							  else
								  echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevelByIdShiftSectionId($this->idShift,$this->section_id), array('onchange'=> 'submit()' )); 
					       }
						else //for create
							 if(isset($this->idLevel))
							    echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevelByIdShiftSectionId($this->idShift,$this->section_id), array('onchange'=> 'submit()','options' => array($this->idLevel=>array('selected'=>true)) )); 
							 else
								 echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevelByIdShiftSectionId($this->idShift,$this->section_id), array('onchange'=> 'submit()' )); 
						
						echo $form->error($modelLevelPerson,'level'); 
						
					} 
					  ?>
				</div>
				
				<div class="row">
			<label for="Room"> <?php 
                                        
					if(((isset($_GET['isstud'])) && ($_GET['isstud']==1))||($model->is_student==1)) echo Yii::t('app','Room'); 
					 ?></label><?php 
					
					if(((isset($_GET['isstud'])) && ($_GET['isstud']==1))||($model->is_student==1))//for students
					{ 
						$modelRoom = new RoomHasPerson;
						if($model->is_student==1)//for update
						  {  if($this->temoin_update==0)//pour l'affichage
						       {  $room=$this->getRoomByStudentId($model->id,$acad);
                                                       if($room !=null)
						          $this->room_id=$room->id;
                                                       else 
                                                           $this->room_id = null;
                                                     
					            }
							   
					         if(isset($this->room_id))
						         echo $form->dropDownList($modelRoom,'room',$this->loadRoomByIdShiftSectionLevel($this->idShift,$this->section_id,$this->idLevel), array('options' => array($this->room_id=>array('selected'=>true)))); 
							 else
								 echo $form->dropDownList($modelRoom,'room',$this->loadRoomByIdShiftSectionLevel($this->idShift,$this->section_id,$this->idLevel)); 
					       }
						else //for create
						   {  
							   if(isset($this->room_id))
							      echo $form->dropDownList($modelRoom,'room',$this->loadRoomByIdShiftSectionLevel($this->idShift,$this->section_id,$this->idLevel), array('options' => array($this->room_id=>array('selected'=>true)))); 
							   else
								   echo $form->dropDownList($modelRoom,'room',$this->loadRoomByIdShiftSectionLevel($this->idShift,$this->section_id,$this->idLevel)); 
					       }
						echo $form->error($modelRoom,'room'); 
						
					}
										
					   ?>
			</div>
				
		<?php 
	  if(!isset($_GET['id']))
	  {
	    if(((isset($_GET['isstud'])) && ($_GET['isstud']==1))||($model->is_student==1))//for students
			{ 
 ?>		
     
     
     <div class="row">
					<?php 
					        $modelStudentOtherInfo = new StudentOtherInfo;
					echo $form->labelEx($modelStudentOtherInfo,'school_date_entry'); ?>
						<?php $this->widget('zii.widgets.jui.CJuiDatePicker',
												 array(
														 'model'=>'$modelStudentOtherInfo',
														 'name'=>'StudentOtherInfo[school_date_entry]',
														 
														 'value'=>$modelStudentOtherInfo->school_date_entry,
														 'htmlOptions'=>array('size'=>40, 'style'=>'width:100px !important'),
															 'options'=>array(
															 'showButtonPanel'=>true,
															 'changeYear'=>true,                                      
															 'dateFormat'=>'yy-mm-dd',
				                                                                                         'yearRange'=>'1900:2100',
				                                                                                         'changeMonth'=>true,
				                                                                                          'showButtonPane'=>true,
				                                                                                          'showOn'=>'both',      
																								 'dateFormat'=>'yy-mm-dd',   
															 ),
														 )
													 );
											; ?>
						<?php echo $form->error($modelStudentOtherInfo,'school_date_entry'); ?>
		</div>
			
     
     
      <div class="row">
		<?php echo $form->labelEx($modelStudentOtherInfo,Yii::t('app','Previous school')); ?>
		<?php echo $form->textField($modelStudentOtherInfo,'previous_school',array('size'=>40,'maxlength'=>255)); ?>
		<?php echo $form->error($modelStudentOtherInfo,'previous_school'); ?>
	   </div>

	   <div class="row">
		<?php echo $form->labelEx($modelStudentOtherInfo,'previous_level');
		  
		if(((isset($_GET['isstud'])) && ($_GET['isstud']==1))||($model->is_student==1))//for students
					{ 
						
						 //for create
							 if(isset($this->idPreviousLevel))
							    echo $form->dropDownList($modelStudentOtherInfo,'previous_level',$this->loadPreviousLevel($this->idLevel), array('options' => array($this->idPreviousLevel=>array('selected'=>true)) )); 
							 else
								 echo $form->dropDownList($modelStudentOtherInfo,'previous_level',$this->loadPreviousLevel($this->idLevel)); 

		
		 echo $form->error($modelStudentOtherInfo,'previous_level'); 
		 
					}     }
		  ?>
	   </div>

		
			
	<?php   } ?>
	
							
				
		<?php 
              if(!isset($_GET['isstud']))
				 {   ?>                        
					 <div class="row">
			             <label for="Titles"> <?php echo Yii::t('app','Titles'); ?></label>
			                
			                <?php //for others titles
							$title = CHtml::listData(Titles::model()->findAll(), 'id', 'title_name');
                            $selected_keys = array_keys(CHtml::listData( $model->titles, 'id' , 'id'));
                               echo CHtml::checkBoxList('Persons[Title][]', $selected_keys, $title);
							
							?>
			          </div>
			          <div class="row">
			             <label for="departement"> <?php echo Yii::t('app','Working department'); ?></label>
			                 
			               <?php  
								      
								$modelDepartment = new DepartmentHasPerson;
							  if($model->is_student==0)//for update
						  {  if($this->temoin_update==0)//pour l'affichage
						       {  $dep=$this->getDepartmentByEmployeeId($model->id,$acad);
                                                       if($dep !=null)
						          $this->department_id=$dep->id;
                                                       else 
                                                           $this->department_id = null;
                                                      // $this->room_id=1;
					            }
							   
					         if(isset($this->department_id))
							      echo $form->dropDownList($modelDepartment,'department_id',$this->loaddepartment(), array('options' => array($this->department_id=>array('selected'=>true)))); 
							  else  
								   echo $form->dropDownList($modelDepartment,'department_id',$this->loadDepartment());
					       }
						else //for create
						   {	 	
							 if(isset($this->department_id))
							      echo $form->dropDownList($modelDepartment,'department_id',$this->loaddepartment(), array('options' => array($this->department_id=>array('selected'=>true)))); 
							  else  
								   echo $form->dropDownList($modelDepartment,'department_id',$this->loadDepartment());   
	                             
						   }    
	                             echo $form->error($modelDepartment,'department_id'); 
	                             
					       ?>
			           </div>
			                    
			                  
			           
			           	<div class="row">
								<?php echo $form->labelEx($modelEmployeeInfo,'job_status'); ?>
						
						
						
						<?php   if($model->is_student==0)//for update
						  {  if($this->temoin_update==0)//pour l'affichage
						       {  $job=$this->getJobStatus($model->id);
                                                       if($job !=null)
						          $this->job_status_id=$job;//->id;
                                                       else 
                                                           $this->job_status_id = null;
                                                      
					            }
							   
					         if(isset($this->job_status_id))
							      echo $form->dropDownList($modelEmployeeInfo,'job_status',$this->loadJobStatus(), array('options' => array($this->job_status_id=>array('selected'=>true)))); 
							  else  
								   echo $form->dropDownList($modelEmployeeInfo,'job_status',$this->loadJobStatus());
					       }
						else //for create
						   {	 	
							 if(isset($this->job_status_id))
							      echo $form->dropDownList($modelEmployeeInfo,'job_status',$this->loadJobStatus(), array('options' => array($this->job_status_id=>array('selected'=>true)))); 
							  else  
								   echo $form->dropDownList($modelEmployeeInfo,'job_status',$this->loadJobStatus());   
	                             
						   }    

                              echo $form->error($modelEmployeeInfo,'job_status'); 
                              
                              ?>
							</div>
							
						<div class="row">
								<?php $modelEmployeeInfo = new EmployeeInfo;
								
								 if($model->is_student==0)//for update
						  {  if($this->temoin_update==0)//pour l'affichage
						       {  $h_date=$this->getHireDate($model->id);
                                                       if($h_date !=null)
						          $modelEmployeeInfo =$h_date;
                                                       
                                                      
					            }
						  }    
					            echo $form->labelEx($modelEmployeeInfo,'hire_date'); ?>
						<?php $this->widget('zii.widgets.jui.CJuiDatePicker',
												 array(
														 'model'=>'$modelEmployeeInfo',
														 'name'=>'EmployeeInfo[hire_date]',
														
														 'value'=>$modelEmployeeInfo->hire_date,
														 'htmlOptions'=>array('size'=>40, 'style'=>'width:100px !important'),
															 'options'=>array(
															 'showButtonPanel'=>true,
															 'changeYear'=>true,                                      
															 'dateFormat'=>'yy-mm-dd',
				                                                                                         'yearRange'=>'1900:2100',
				                                                                                         'changeMonth'=>true,
				                                                                                          'showButtonPane'=>true,
				                                                                                          'showOn'=>'both',      
																								 'dateFormat'=>'yy-mm-dd',   
															 ),
														 )
													 );
											; ?>
						<?php echo $form->error($modelEmployeeInfo,'hire_date'); ?>
							</div>
							

             <?php  }
                if(isset($_GET['from']))
				  {  if(($_GET['from']=="teach")) 
				       {
                           ?>			          
			           <div class="row">
			             <label for="departement"> <?php echo Yii::t('app','Working department'); ?></label>
			                 
			               <?php  
								      
								$modelDepartment = new DepartmentHasPerson;
							  if($model->is_student==0)//for update
						  {  if($this->temoin_update==0)//pour l'affichage
						       {  $dep=$this->getDepartmentByEmployeeId($model->id,$acad);
                                                       if($dep !=null)
						          $this->department_id=$dep->id;
                                                       else 
                                                           $this->department_id = null;
                                                      // $this->room_id=1;
					            }
							   
					         if(isset($this->department_id))
							      echo $form->dropDownList($modelDepartment,'department_id',$this->loaddepartment(), array('options' => array($this->department_id=>array('selected'=>true)))); 
							  else  
								   echo $form->dropDownList($modelDepartment,'department_id',$this->loadDepartment());
					       }
						else //for create
						   {	 	
							 if(isset($this->department_id))
							      echo $form->dropDownList($modelDepartment,'department_id',$this->loaddepartment(), array('options' => array($this->department_id=>array('selected'=>true)))); 
							  else  
								   echo $form->dropDownList($modelDepartment,'department_id',$this->loadDepartment());   
	                             
						   }    
	                             echo $form->error($modelDepartment,'department_id'); 
	                             
					       ?>
			           </div>
			                    
			                  
			           
			           	<div class="row">
								<?php echo $form->labelEx($modelEmployeeInfo,'job_status'); ?>
						
						
						
						<?php   if($model->is_student==0)//for update
						  {  if($this->temoin_update==0)//pour l'affichage
						       {  $job=$this->getJobStatus($model->id);
                                                       if($job !=null)
						          $this->job_status_id=$job;//->id;
                                                       else 
                                                           $this->job_status_id = null;
                                                      
					            }
							   
					         if(isset($this->job_status_id))
							      echo $form->dropDownList($modelEmployeeInfo,'job_status',$this->loadJobStatus(), array('options' => array($this->job_status_id=>array('selected'=>true)))); 
							  else  
								   echo $form->dropDownList($modelEmployeeInfo,'job_status',$this->loadJobStatus());
					       }
						else //for create
						   {	 	
							 if(isset($this->job_status_id))
							      echo $form->dropDownList($modelEmployeeInfo,'job_status',$this->loadJobStatus(), array('options' => array($this->job_status_id=>array('selected'=>true)))); 
							  else  
								   echo $form->dropDownList($modelEmployeeInfo,'job_status',$this->loadJobStatus());   
	                             
						   }    

                              echo $form->error($modelEmployeeInfo,'job_status'); 
                              
                              ?>
							</div>
							
						<div class="row">
								<?php $modelEmployeeInfo = new EmployeeInfo;
								
								 if($model->is_student==0)//for update
						  {  if($this->temoin_update==0)//pour l'affichage
						       {  $h_date=$this->getHireDate($model->id);
                                                       if($h_date !=null)
						          $modelEmployeeInfo =$h_date;//->id;
                                                       
                                                      
					            }
						  }    
					            echo $form->labelEx($modelEmployeeInfo,'hire_date'); ?>
						<?php $this->widget('zii.widgets.jui.CJuiDatePicker',
												 array(
														 'model'=>'$modelEmployeeInfo',
														 'name'=>'EmployeeInfo[hire_date]',
														 
														 'value'=>$modelEmployeeInfo->hire_date,
														 'htmlOptions'=>array('size'=>40, 'style'=>'width:100px !important'),
															 'options'=>array(
															 'showButtonPanel'=>true,
															 'changeYear'=>true,                                      
															 'dateFormat'=>'yy-mm-dd',
				                                                                                         'yearRange'=>'1900:2100',
				                                                                                         'changeMonth'=>true,
				                                                                                          'showButtonPane'=>true,
				                                                                                          'showOn'=>'both',      
																								 'dateFormat'=>'yy-mm-dd',   
															 ),
														 )
													 );
											; ?>
						<?php echo $form->error($modelEmployeeInfo,'hire_date'); ?>
							</div>
							
			            
										          
		<?php	          
				       } }  ?>
		
										   
    </div>
  </div>
 &nbsp;
 </div>

 
 