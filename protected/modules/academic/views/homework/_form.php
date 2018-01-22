
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
/* @var $this HomeworkController */
/* @var $model Homework */
/* @var $form CActiveForm */

$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 


$id_teacher='';   
           	
           	 $pers=User::model()->getPersonByUserId(Yii::app()->user->userid);
				 $pers=$pers->getData();
				 foreach($pers as $p)
				      $id_teacher=$p->id;
				

	



?>



<?php $this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); ?>

</br>
<div class="b_mail">



 
	<?php
	echo '<p class="note">'.Yii::t('app','Fields with <span class="required">*</span> are required.').'</p>';

	  echo $form->errorSummary($model);
	 
	    	        
	       //error message 
	        	if(($this->messageSize)||($this->success))
			      { echo '<div class="" style=" padding-left:0px;margin-right:0px; margin-bottom:-17px; ';//-20px; ';
				      echo '">';
				      				      
			           echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
					   <tr>
					    <td style="text-align:center;">';
			       
			       }			      
				 					     	
				   
				    if($this->messageSize)
				      echo '<span style="color:red;" >'.Yii::t('app','You have exceeded the size limit.').'</span>'.'<br/>';
				 
				  
				    
				    				   
					if($this->success)
				     echo '<span style="color:green;" >'.Yii::t('app','Operation terminated successfully.').'</span>'.'<br/>';
					 
				   
					   
			     if(($this->messageSize)||($this->success))//||($this->alreadyExist))//
			      { 
					 					
                      echo '</div>';
			       }
       		 
	    
	?>



<div class="row" style="padding: 5px 10px;"> 
     
      <div class="span9" >
			
	<?php 
 if((Yii::app()->user->profil!='Teacher'))
      {
	    
	    
            	?>	







			<!--Shift(vacation)-->
       <div class="span2">
		
			<?php $modelShift = new Shifts;
			echo $form->labelEx($modelShift,Yii::t('app','Shift '));?>
					 <?php 
					         $default_vacation=null;
			      $criteria = new CDbCriteria;
				   								$criteria->condition='item_name=:item_name';
				   								$criteria->params=array(':item_name'=>'default_vacation',);
				   		$default_vacation_name = GeneralConfig::model()->find($criteria)->item_value;
				   		
				   		$criteria2 = new CDbCriteria;
				   								$criteria2->condition='shift_name=:item_name';
				   								$criteria2->params=array(':item_name'=>$default_vacation_name,);
				   		$default_vacation = Shifts::model()->find($criteria2);
				   		
				   		

						
						  if(isset($this->idShift)&&($this->idShift!=""))
						        {   
					               echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('options' => array($this->idShift=>array('selected'=>true)),'onchange'=> 'submit()' )); 
					             }
							  else
								{ $this->idLevel=0;
								    if($default_vacation!=null)
								       { echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('options' => array(($default_vacation->id)=>array('selected'=>true)),'onchange'=> 'submit()' )); 
								              $this->idShift=$default_vacation->id;
								       }
								    else
								       echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('onchange'=> 'submit()' )); 
								}
							
						echo $form->error($modelShift,'shift_name'); 
						
					
					  ?>
				</div>
			 





		    <!--section(liee au Shift choisi)-->
			<div class="span2">
			<?php $modelSection = new Sections;
			                   echo $form->labelEx($modelSection,Yii::t('app','Section')); ?>
			           <?php 
					
					    
							    if(isset($this->section_id)&&($this->section_id!=''))
							       echo $form->dropDownList($modelSection,'section_name',$this->loadSectionByIdShift($this->idShift), array('options' => array($this->section_id=>array('selected'=>true)),'onchange'=> 'submit()')); 
							    else
								  { $this->idLevel=0;
									echo $form->dropDownList($modelSection,'section_name',$this->loadSectionByIdShift($this->idShift), array('onchange'=> 'submit()' )); 
						           }					      
						  
						echo $form->error($modelSection,'section_name'); 
						
															
					   ?>
				</div>
			






			<!--level-->
			<div class="span2">
			<?php $modelLevelPerson = new LevelHasPerson;
			                       echo $form->labelEx($modelLevelPerson,Yii::t('app','Level'));?> 
					   <?php 
					 
					   
						if(isset($this->idLevel)&&($this->idLevel!=''))
							    echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevelByIdShiftSectionIdAcademicP($this->idShift,$this->section_id,$acad_sess), array('options' => array($this->idLevel=>array('selected'=>true)),'onchange'=> 'submit()', )); 
							 else
								{ $this->idLevel=0;
								  echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevelByIdShiftSectionIdAcademicP($this->idShift,$this->section_id,$acad_sess), array('onchange'=> 'submit()' )); 
					              $this->room_id=0;
							      }
						echo $form->error($modelLevelPerson,'level'); 
					 
					  ?>
				</div>
			





			<!--room-->
			<div class="span2">
			   <?php  $modelRoom = new Rooms;
			                     echo $form->labelEx($modelRoom,Yii::t('app','Room')); ?>
			          <?php 
					
					        if(($this->room_id==null)||($this->room_id==0))
			                   $this->room_id=Yii::app()->session['Rooms']; 
						    
							  
							  if(isset($this->room_id)&&($this->room_id!=''))
							   { 
						          echo $form->dropDownList($modelRoom,'room_name',$this->loadRoomByIdShiftSectionLevel($this->idShift,$this->section_id,$this->idLevel,$acad_sess), array('onchange'=> 'submit()','options' => array($this->room_id=>array('selected'=>true)) )); 
					             }
							   else
							      { echo $form->dropDownList($modelRoom,'room_name',$this->loadRoomByIdShiftSectionLevel($this->idShift,$this->section_id,$this->idLevel,$acad_sess), array('onchange'=> 'submit()')); 
							          
									 $this->room_id=0;
							      }
						echo $form->error($modelRoom,'room_name'); 
						
										
					   ?>
				</div>
			
		 <?php          
      }//fen if((Yii::app()->user->profil!='Teacher'))
 else // Yii::app()->user->profil=='Teacher'
  {
  	?>




			<!--room-->
					<div class="span2">
					   <?php  $modelRoom = new Rooms;
					                     echo $form->labelEx($modelRoom,Yii::t('app','Room')); ?>
					          <?php 
					                  
					                   
														  
									  if(isset($this->room_id)&&($this->room_id!=''))
									   { 
								          echo $form->dropDownList($modelRoom,'room_name',$this->loadRoomByIdTeacher($id_teacher,$acad_sess), array('onchange'=> 'submit()','options' => array($this->room_id=>array('selected'=>true)) )); 
							             }
									   else
									      { echo $form->dropDownList($modelRoom,'room_name',$this->loadRoomByIdTeacher($id_teacher,$acad_sess), array('onchange'=> 'submit()')); 
									          
											 $this->room_id=0;
									      }
								echo $form->error($modelRoom,'room_name'); 
								
												
							   ?>
						</div>
		

<?php
  	
    }//fen Yii::app()->user->profil=='Teacher'
 	             
		            
		 
		 
		 
		  ?>	
			
		
				
													  
    
      <!--evaluation-->
	


			                </div>
	       
					       
					    </div>




</br>





        <div  id="resp_form_siges">

        <form  id="resp_form">
        
            <div class="col-2">
                <label id="resp_form">


<?php echo $form->labelEx($model,'course'); ?>

				<label><?php $modelCourse = new Courses;
					  ?></label><?php 
	 echo $form->labelEx($modelCourse,Yii::t('app','Course')); 
					        
						
			  if(isset($this->room_id)){
						   
						     
					 if((Yii::app()->user->profil!='Teacher'))
                       {
                       	   if(isset($this->course_id))
						        {   
					               echo $form->dropDownList($modelCourse,'subject',$this->loadSubject($this->room_id,$this->idLevel,$acad_sess), array('onchange'=> 'submit()','options' => array($this->course_id=>array('selected'=>true)) )); 
					             }
							  else
								{ $this->course_id=0;
								    echo $form->dropDownList($modelCourse,'subject',$this->loadSubject($this->room_id,$this->idLevel,$acad_sess),array('onchange'=> 'submit()')); 
								}
                       	                       	
                        }//fen  if((Yii::app()->user->profil!='Teacher'))
                      else // Yii::app()->user->profil=='Teacher'
                        {
                      	   
						    if(isset($this->course_id))
						        {   
					               echo $form->dropDownList($modelCourse,'subject',$this->loadSubjectByTeacherRoom($this->room_id,$id_teacher,$acad_sess), array('onchange'=> 'submit()','options' => array($this->course_id=>array('selected'=>true)) )); 
					             }
							  else
								{ $this->course_id=0;
								    echo $form->dropDownList($modelCourse,'subject',$this->loadSubjectByTeacherRoom($this->room_id,$id_teacher,$acad_sess),array('onchange'=> 'submit()')); 
								}
								
                           }//fen  Yii::app()->user->profil=='Teacher'
      
	    	
								
								
						  }
						else
							echo $form->dropDownList($modelCourse,'subject',$this->loadSubject(null,null),array('onchange'=> 'submit()'));
						 
						echo $form->error($modelCourse,'subject'); 
						
					
					  ?></label>
								
								<?php echo $form->error($model,'course'); ?>

						  </label>
        </div>
        
         <!--homework-->
		



        
        <div class="col-2">
            <label id="resp_form">

<?php echo $form->labelEx($model,'title'); ?>
								<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>45, 'placeholder'=>Yii::t('app','Title '))); ?>
								<?php echo $form->error($model,'title'); ?>
                          </label>
        </div>
        
        <div class="col-2">
            <label id="resp_form">

<?php echo $form->labelEx($model,'description'); ?>
								<?php echo $form->textArea($model,'description',array('rows'=>2, 'cols'=>60, 'placeholder'=>Yii::t('app',' Description'))); ?>
								<?php echo $form->error($model,'description'); ?>
						  </label>
        </div>
        
        <div class="col-2">
            <label id="resp_form">

<?php echo $form->labelEx($model,'limit_date_submission'); ?>
								 <?php $this->widget('zii.widgets.jui.CJuiDatePicker',
				                             array(
				                             'model'=>'$model',
				                             'name'=>'Homework[limit_date_submission]',
				                             'language'=>'fr',
				                             'value'=>$model->limit_date_submission,
				                             'htmlOptions'=>array('size'=>60, 'style'=>'width:100% !important','placeholder'=>Yii::t('app','Submission deadline')),
				                                     'options'=>array(
				                                     'showButtonPanel'=>true,
				                                     'changeYear'=>true,                                      
				                                     'dateFormat'=>'yy-mm-dd',
				                                     'yearRange'=>'1900:2100',
				                                     'changeMonth'=>true,
				                                     'showButtonPane'=>true,
				                                      //'showOn'=>'both',      
				                                      'dateFormat'=>'yy-mm-dd',   
				                                     ),
				                             )
				                   		  );
				                   		?>

								<?php echo $form->error($model,'limit_date_submission'); ?>
                         </label>
        </div>
        
        <div class="col-2">
            <label id="resp_form">

<?php echo $form->labelEx($model,'given_date'); ?>
						  <?php   if(isset($_GET['id'])&&($_GET['id']!=''))
								    echo $form->textField($model,'given_date',array('placeholder'=>$model->given_date, 'disabled'=>'disabled' ));
								  else
								    echo $form->textField($model,'given_date',array('placeholder'=>date('Y-m-d'), 'disabled'=>'disabled' ));
							 ?>
								<?php echo $form->error($model,'given_date'); ?>
                          </label>
        </div>
        
                              
        
        
        <div class="col-2">
            <label id="resp_form">


                          <?php 
                                echo '<b>'. Yii::t('app','Document').': </b>'; 
					           if(isset($model->attachment_ref))
						           {   $explode_name= explode("/",substr($model->attachment_ref, 0));
                                            $i=0;
						           	     foreach($explode_name as $name)
						           	        { if($i==0)
						           	            { echo $name;
						           	               $i=1;
						           	              }
						           	           else
						           	              echo ' / '.$name;
						           	         
						           	         }
						                   
						                  if(isset($_GET['id']))  
		                                    { 
		                                    	if($model->attachment_ref!='')
		                                    	  {
		                                    	  	 
		                                    	  	 if($this->keep==1)
							                          { 
							                         echo '<div style="float:left; width:100%;">    <div class="rmodal" style="float:left; width:auto; margin-top:10px;"> <div class=""  style="margin-right:22px; float:left; width:auto;"> <div class="l" style="margin-right:-100px; width:90%;">'.$form->label($model,'keepDoc').'</div><div class="r" style="margin-right:40px; width:3%;">'.$form->checkBox($model,'keepDoc',array('onchange'=> 'submit()','checked'=>'checked')).'</div></div></div>';
							                              
							                           }
									                 else
										               
										               echo '<div style="float:left; width:100%;">    <div class="rmodal" style="float:left; width:auto; margin-top:10px;"> <div class=""  style="margin-right:22px; float:left; width:auto;"> <div class="l" style="margin-right:-100px; width:90%;">'.$form->label($model,'keepDoc').'</div><div class="r" style="margin-right:40px; width:3%;">'.$form->checkBox($model,'keepDoc',array('onchange'=> 'submit()')).'</div></div></div>';
		                                    	   }
					                        }
						              } 
						           

						        
						           ?>
						            
		
        
		               
		                   
		           <?php  
		                        if((!isset($_GET['id']))||($this->keep==0))
		                           {
		                      ?>
		
        
        

               <label id="upload">
		             <input name="document" id="document" type="file"  /> </label>
		             
				<?php echo $form->error($model,'document'); ?>
       
                      </div>
                             
                        <?php       }
		                     
		                     
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

<!-- END OF TEST -->










