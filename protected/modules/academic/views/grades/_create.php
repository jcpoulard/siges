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
					
$grades_comment = infoGeneralConfig('grades_comment');	

if($grades_comment==0)
  {
	 $item_array1= array(
	 
		
	  array('name'=>'first_name',
                'header'=>Yii::t('app','First Name'),
	        'value'=>'$data->first_name'
			),
	array('name'=>'last_name',
                'header'=>Yii::t('app','Last Name'),
	        'value'=>'$data->last_name'
			),
     array('header' =>Yii::t('app','Grade Value'), 'id'=>'gradeValue', 'value' => '\'
           <input name="grades[\'.$data->id.\']" type=text value="\'.$data->grade_value.\'" style="width:97%;" disabled="disabled" />
          
		   <input name="id_stud[\'.$data->id.\']" type="hidden" value="\'.$data->id.\'" />
           <!--<input type="image" src="'.Yii::app()->request->baseUrl.'/img.png" />  -->
           \'','type'=>'raw' ),
      
      
       
       
     //  array(             'class'=>'CCheckBoxColumn',   
         //                  'id'=>'chk',
           //      ),           
		
    );
	  
	  
	  
	  $item_array2=array(
	 
	  array('name'=>'first_name',
                'header'=>Yii::t('app','First Name'),
	        'value'=>'$data->first_name'
			),
	array('name'=>'last_name',
                'header'=>Yii::t('app','Last Name'),
	        'value'=>'$data->last_name'
			),
     array('header' =>Yii::t('app','Grade Value'), 'id'=>'gradeValue', 'value' => '\'
           <input name="grades[\'.$data->id.\']" type=text style="width:97%;" />
          
		   <input name="id_stud[\'.$data->id.\']" type="hidden" value="\'.$data->id.\'" />
           <!--<input type="image" src="'.Yii::app()->request->baseUrl.'/img.png" />  -->
           \'','type'=>'raw' ),
      
     
       
       
     //  array(             'class'=>'CCheckBoxColumn',   
       //                    'id'=>'chk',
       //          ),           
		
    );
  }
elseif($grades_comment==1)
{
	$item_array1= array(
	 
		
	  array('name'=>'first_name',
                'header'=>Yii::t('app','First Name'),
	        'value'=>'$data->first_name'
			),
	array('name'=>'last_name',
                'header'=>Yii::t('app','Last Name'),
	        'value'=>'$data->last_name'
			),
     array('header' =>Yii::t('app','Grade Value'), 'id'=>'gradeValue', 'value' => '\'
           <input name="grades[\'.$data->id.\']" type=text value="\'.$data->grade_value.\'" style="width:97%;" disabled="disabled" />
          
		   <input name="id_stud[\'.$data->id.\']" type="hidden" value="\'.$data->id.\'" />
           <!--<input type="image" src="'.Yii::app()->request->baseUrl.'/img.png" />  -->
           \'','type'=>'raw' ),
      
      
      array('header' =>Yii::t('app','Comment'), 'id'=>'commentValue', 'value' => '\'
           <input name="comments[\'.$data->id.\']" type=text value="\'.$data->comment.\'" style="width:97%;" disabled="disabled" />
          
		   <input name="id_stud[\'.$data->id.\']" type="hidden" value="\'.$data->id.\'" />
           <!--<input type="image" src="'.Yii::app()->request->baseUrl.'/img.png" />  -->
           \'','type'=>'raw' ),  
       
     //  array(             'class'=>'CCheckBoxColumn',   
         //                  'id'=>'chk',
           //      ),           
		
    );
	
	$item_array2=array(
	 
	  array('name'=>'first_name',
                'header'=>Yii::t('app','First Name'),
	        'value'=>'$data->first_name'
			),
	array('name'=>'last_name',
                'header'=>Yii::t('app','Last Name'),
	        'value'=>'$data->last_name'
			),
     array('header' =>Yii::t('app','Grade Value'), 'id'=>'gradeValue', 'value' => '\'
           <input name="grades[\'.$data->id.\']" type=text style="width:97%;" />
          
		   <input name="id_stud[\'.$data->id.\']" type="hidden" value="\'.$data->id.\'" />
           <!--<input type="image" src="'.Yii::app()->request->baseUrl.'/img.png" />  -->
           \'','type'=>'raw' ),
      
     array('header' =>Yii::t('app','Comment'), 'id'=>'commentValue', 'value' => '\'
           <input name="comments[\'.$data->id.\']" type=text style="width:97%;" />
          
		   <input name="id_stud[\'.$data->id.\']" type="hidden" value="\'.$data->id.\'" />
           <!--<input type="image" src="'.Yii::app()->request->baseUrl.'/img.png" />  -->
           \'','type'=>'raw' ),
       
       
     //  array(             'class'=>'CCheckBoxColumn',   
       //                    'id'=>'chk',
       //          ),           
		
    );
}
		 
 
					 
	
	$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

	
	  $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
     if($acad!=$current_acad->id)
         $condition = '';
      else
         $condition = 'p.active IN(1, 2) AND ';
      
  
  
  
    if(isset($_GET['msguv'])&&($_GET['msguv']=='y'))
       {    $this->message_UpdateValidate=true;
              }
    else
        $this->message_UpdateValidate=false;
           
           
           

	$modelEvaluation= new EvaluationByYear();
	
	$id_teacher='';   
           	
           	 $pers=User::model()->getPersonByUserId(Yii::app()->user->userid);
				 $pers=$pers->getData();
				 foreach($pers as $p)
				      $id_teacher=$p->id;
				
	                               $this->room_id= Yii::app()->session['Rooms'];
								   
								   $this->evaluation_id= Yii::app()->session['Evaluation'];
							
								   if($this->success)
								      {  
								      	$this->course_id= '';
								      }
								    else
								       $this->course_id= Yii::app()->session['Courses'];
								   
								   
								   
								   
				                

	
	
	
	
?>

<div class="b_m">

<div class="row" style="padding: 5px 10px;"> 
     
      <div class="span9" >
			

         <!--evaluation-->
			<div class="span2" >
			<label for="Evaluation_name"><?php echo Yii::t('app','Evaluation Period'); ?></label><?php //echo $form->labelEx($model,'Evaluation Period'); ?>
			           <?php 
					
					        $modelEvaluation= new EvaluationByYear();
							    if(isset($this->evaluation_id)&&($this->evaluation_id!=''))
							       echo $form->dropDownList($modelEvaluation,'evaluation',$this->loadEvaluationToCreate($acad_sess), array('onchange'=> 'submit()','options' => array($this->evaluation_id=>array('selected'=>true)))); 
							    else
								  { 
									echo $form->dropDownList($modelEvaluation,'evaluation',$this->loadEvaluationToCreate($acad_sess), array('onchange'=> 'submit()')); 
						           }					      
						  
						echo $form->error($modelEvaluation,'evaluation'); 
						
															
					   ?>
				</div>
            


	<?php 
 if((Yii::app()->user->profil!='Teacher'))
      {
	    
	    if(!isset($_GET['stud'])||($_GET['stud']==""))
            {
            	
            	?>	
			<!--Shift(vacation)-->
        <div class="span2" >
		
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
			<div class="span2" >
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
			<div class="span2" >
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
			<div class="span2" >
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
							          //echo $this->room_id;
									 $this->room_id=0;
							      }
						echo $form->error($modelRoom,'room_name'); 
						
										
					   ?>
				</div>
			
		 <?php    }       
      }//fen if((Yii::app()->user->profil!='Teacher'))
 else // Yii::app()->user->profil=='Teacher'
  {
  	?>
			<!--room-->
			<div class="span2" >
			   <?php  $modelRoom = new Rooms;
			                     echo $form->labelEx($modelRoom,Yii::t('app','Room')); ?>
			          <?php 
			                  
			                   
												  
							  if(isset($this->room_id)&&($this->room_id!=''))
							   { 
						          echo $form->dropDownList($modelRoom,'room_name',$this->loadRoomByIdTeacher($id_teacher,$acad_sess), array('onchange'=> 'submit()','options' => array($this->room_id=>array('selected'=>true)) )); 
					             }
							   else
							      { echo $form->dropDownList($modelRoom,'room_name',$this->loadRoomByIdTeacher($id_teacher,$acad_sess), array('onchange'=> 'submit()')); 
							          //echo $this->room_id;
									 $this->room_id=0;
							      }
						echo $form->error($modelRoom,'room_name'); 
						
										
					   ?>
				</div>
<?php
  	
    }//fen Yii::app()->user->profil=='Teacher'
 	             
		             if(isset($_GET['stud'])&&($_GET['stud']!=""))
                      { $this->idLevel=$this->getLevelByStudentId($_GET['stud'])->id;
		                 $this->room_id=$this->getRoomByStudentId($_GET['stud'])->id;
                      }
		 
		 
		 
		  ?>	
			
			
				<!--Courses-->
         <div class="span2" > 
			
					 <?php $modelCourse = new Courses;
					 //<label for="Courses"><?php echo Yii::t('app','Course'); ?></label><?php //echo $form->labelEx($model,'Course ');
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
						
					
					  ?>
				</div>
				
</div>													   
   
<br/><br/><br/>

  <div >
											

			<?php 
                     $weight = ' ';
                     
                     $result = Courses::model()->getWeight($this->course_id);
                    $result =$result->getData();
                    foreach($result as $r)
                      $weight = $r->weight;
                      
					
			 


if((Yii::app()->user->profil!='Teacher'))
   {	    
			$dataProvider=Persons::model()->searchStudentsForGrades($condition,null,null,null,null,$acad_sess);
			 
		    
			   $person= new Persons;
			   
	           if($this->room_id!=0)
				{  $room=$this->getRoom($this->room_id);
				    $level=$this->getLevel($this->idLevel);
					$section=$this->getSection($this->section_id);
					$shift=$this->getShift($this->idShift);
			 
				}
				
				
				
				
					  
				 if(isset($_GET['stud'])&&($_GET['stud']!=""))
                     {
                     	       $this->use_update=false;
		                    if(($this->course_id!='')&&($this->evaluation_id!=''))
						        {
				                      $check = $this->checkDdataByEvaluation_externRequest($_GET['stud'],$this->evaluation_id, $this->course_id);
							 
									 if($check)
									  { $this->use_update=true; }
										  	
						        }
						        
                     	
            	   if(($this->evaluation_id!='')&&($this->course_id!=''))
            	       $dataProvider=Persons::model()->searchStudentsByIDForAddingGrades($condition,$_GET['stud'],$acad_sess,$this->evaluation_id,$this->course_id);
            	                     	        
                      }
                    else
                     {  
                     if(($this->room_id!='')&&($this->evaluation_id!='')&&($this->course_id!=''))
                     	$dataProvider=Persons::model()->searchStudentsForAddingGrades($condition,$this->idShift,$this->section_id,$this->idLevel,$this->room_id,$acad_sess,$this->evaluation_id,$this->course_id);//searchStudentsForGrades($this->idShift,$this->section_id,$this->idLevel,$this->room_id,$acad_sess);
                     }
          
                      
                  
           //error message 
	        	if((($this->use_update)&&($dataProvider->getItemCount()!=0))||($this->message_UpdateValidate))		
	        	  { echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:-45px; ';//-20px; ';
				      echo '">';
	        	  	
	        	  	}
			    elseif((($this->message_evaluation_id)||($this->message_room_id)||($this->message_course_id)||($this->message_noGradeEntered))&&($dataProvider->getData()!=null))
			      { echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:-45px; ';//-20px; ';
				      echo '">';
				      				      
			       }			      
				 elseif(($this->success)||($this->message_GradeHigherWeight) )
				    {   echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:-15px; ';//-20px; ';
				      echo '">';
				      }
				   	elseif(($this->use_update)&&($dataProvider->getItemCount()==0) )
				     { 
				     	echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:-45px; ';//-20px; ';
				      echo '">';

				      }
				    elseif(($dataProvider->getItemCount()==0) )
				     { 
				     	echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:-15px; ';//-20px; ';
				      echo '">';

				      }
				   elseif(($dataProvider->getItemCount()!=0) )
				     { 
				     	echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:-45px; ';//-20px; ';
				      echo '">';

				      }
				    else 	
				   	{
				   		echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:-15px; ';//-20px; ';
				      echo '">';
				            
				   	  }
			   	  
				   	 
				    echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
					   <tr>
					    <td style="text-align:center;">';	  
				  
					     	
				   
				   if($this->message_noGradeEntered)
				     echo '<span style="color:red;" >'.Yii::t('app','You did not insert any grades.').'</span>'.'<br/>';
				   

				   if($this->message_evaluation_id)
				     echo '<span style="color:red;" >'.Yii::t('app','Please fill the Evaluation Period field.').'</span>'.'<br/>';
				   
				   if($this->message_room_id)
				     echo '<span style="color:red;" >'.Yii::t('app','Please, Choose a ROOM.').'</span>'.'<br/>';
				   
				   if($this->message_course_id)
				      echo '<span style="color:red;" >'.Yii::t('app','Please, Choose a COURSE.').'</span>'.'<br/>';
				      
				   if($this->use_update)
				      echo '<span style="color:red;" >'.Yii::t('app','Grades are already added, use update option.').'</span>'.'<br/>';
				   
				   
				  
					if($this->success)
				     echo '<span style="color:green;" >'.Yii::t('app','Operation terminated successfully.').'</span>'.'<br/>';
					  
				    
					if($this->message_GradeHigherWeight)
					  {	 if(!isset($_GET['stud'])||($_GET['stud']==""))
		                     echo '<span style="color:red;" >'.Yii::t('app','Grades GREATER than COURSE WEIGHT are not saved.').'</span>'.'<br/>';
						 else
						   echo '<span style="color:red;" >'.Yii::t('app','Grade VALUE can\'t be GREATER than COURSE WEIGHT!').'</span>'.'<br/>';
					  }
                   

					    echo '<span style="color:blue;" ><b>'.Yii::t('app','- COURSE WEIGHT : ').$weight.' - </b></span>';
					
					 echo'</td>
					    </tr>
						</table>';
					
           echo '</div>';
	       
  }//fen if((Yii::app()->user->profil!='Teacher'))
else // Yii::app()->user->profil=='Teacher'
  {
  	  $dataProvider=Persons::model()->searchStudentsForGrades($condition,null,null,null,null,$acad_sess);
			 
		    
			   $person= new Persons;
			   
	           if($this->room_id!=0)
				{  $room=$this->getRoom($this->room_id);
				    
				}
			
			            $this->use_update=false;
		                    if(($this->room_id!='')&&($this->course_id!='')&&($this->evaluation_id!=''))
						        {
				                     $check = $this->checkDdataByEvaluation($this->evaluation_id, $this->course_id);
							 
									 if($check)
									  { $this->use_update=true; }
										  	
						        }

			
			 
                  if(($this->room_id!='')&&($this->evaluation_id!='')&&($this->course_id!=''))
                      { $dataProvider=Persons::model()->searchStudentsByRoomForAddingGrades_teach($condition,$this->room_id,$this->evaluation_id,$this->course_id,$acad_sess);
                   
                       
                      }
          
              
              if($this->message_UpdateValidate)
                        $this->use_update=false;
          	   
           //error message 
	        //error message 
	        	if((($this->use_update)&&($dataProvider->getItemCount()!=0)))	
	        	  { echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:-45px; ';//-20px; ';
				      echo '">';
	        	  	

	        	  	}
			    elseif((($this->message_evaluation_id)||($this->message_room_id)||($this->message_course_id)||($this->message_noGradeEntered))&&($dataProvider->getData()!=null))
			      { echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:-45px; ';//-20px; ';
				      echo '">';
				      				      
			       }			      
				 elseif(($this->success)||($this->message_GradeHigherWeight) )
				    {   echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:-15px; ';//-20px; ';
				      echo '">';
				      }
				   	elseif((($this->use_update)&&($dataProvider->getItemCount()==0) )||($this->message_UpdateValidate))
				     { 
				     	echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:-45px; ';//-20px; ';
				      echo '">';
				     

				      }
				    elseif(($dataProvider->getItemCount()==0) )
				     { 
				     	echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:-15px; ';//-20px; ';
				      echo '">';

				      }
				   elseif(($dataProvider->getItemCount()!=0) )
				     { 
				     	echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:-45px; ';//-20px; ';
				      echo '">';
				      
				      }
				    else 	
				   	{
				   		echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:-15px; ';//-20px; ';
				      echo '">';
				            
				   	  }
			   	  
				   	 
				    echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
					   <tr>
					    <td style="text-align:center;">';	  
				  
					     	
				   
				   if($this->message_noGradeEntered)
				     echo '<span style="color:red;" >'.Yii::t('app','You did not insert any grades.').'</span>'.'<br/>';
				   

				   if($this->message_evaluation_id)
				     echo '<span style="color:red;" >'.Yii::t('app','Please fill the Evaluation Period field.').'</span>'.'<br/>';
				   
				   if($this->message_room_id)
				     echo '<span style="color:red;" >'.Yii::t('app','Please, Choose a ROOM.').'</span>'.'<br/>';
				   
				   if($this->message_course_id)
				      echo '<span style="color:red;" >'.Yii::t('app','Please, Choose a COURSE.').'</span>'.'<br/>';
				      
				   if($this->use_update)
				      echo '<span style="color:red;" >'.Yii::t('app','Grades are already added, use update option.').'</span>'.'<br/>';
				   
				    if($this->message_UpdateValidate)
				      echo '<span style="color:red;" >'.Yii::t('app','Validated Grades can\'t be updated.<br/>').'</span>'.'<br/>';
				  
					if($this->success)
				     echo '<span style="color:green;" >'.Yii::t('app','Operation terminated successfully.').'</span>'.'<br/>';
					  
				    
				    if($this->message_GradeHigherWeight)
					  {	 if(!isset($_GET['stud'])||($_GET['stud']==""))
		                     echo '<span style="color:red;" >'.Yii::t('app','Grades GREATER than COURSE WEIGHT are not saved.').'</span>'.'<br/>';
						 else
						   echo '<span style="color:red;" >'.Yii::t('app','Grade VALUE can\'t be GREATER than COURSE WEIGHT!').'</span>'.'<br/>';
					  }
				      

					    echo '<span style="color:blue;" ><b>'.Yii::t('app','- COURSE WEIGHT : ').$weight.' - </b></span>';
					
					 echo'</td>
					    </tr>
						</table>';
					
           echo '</div>';
  	
    }//fen Yii::app()->user->profil=='Teacher'
  	       
  if(($this->use_update)||($this->message_UpdateValidate))
    { 
	   if(Yii::app()->user->profil!='Teacher')
	    {
	    	if(isset($_GET['stud'])&&($_GET['stud']!=''))
	    	  {
	    	  	$dataProvider=Persons::model()->searchStudentsByIDForShowingGrades($condition,$_GET['stud'],$acad_sess,$this->evaluation_id,$this->course_id);
	    	  }
	    	else
	    	  {
	    	  	$dataProvider=Persons::model()->searchStudentsForShowingGrades($condition,$this->idShift,$this->section_id,$this->idLevel,$this->room_id,$acad_sess,$this->evaluation_id,$this->course_id);
	    	  	}
	    	  	
	      }
	   else 
	    { 	
	    	  	$dataProvider=Persons::model()->searchStudentsForShowingGrades_teach($condition,$this->room_id,$acad_sess,$this->evaluation_id,$this->course_id);
	    	 

	    }
    	                          
	$this->widget('zii.widgets.grid.CGridView', array(
    
	'dataProvider'=>$dataProvider,
	'showTableOnEmpty'=>'true',
	'selectableRows' => 2,
	
    'columns'=>$item_array1,
));
		
    }
  else
    {      
    	
    	if(isset($_GET['stud'])&&($_GET['stud']!=''))
    	  {
    	  	 if(($this->course_id!='')&&($this->evaluation_id!=''))
    	  	   {      
            	         
            	         
           $dataProvider=Persons::model()->searchStudentsForAddingGrades_externRequest($condition,$_GET['stud'],$acad_sess,$this->evaluation_id,$this->course_id);
    	  
    	  	   }
    	  	   
    	  	   
    	  }
    	
    	
    	
    	                       
	$this->widget('zii.widgets.grid.CGridView', array(
   
	'dataProvider'=>$dataProvider,
	'showTableOnEmpty'=>'true',
	'selectableRows' => 2,
	
    'columns'=>$item_array2,
	
));
		
    	
    	
    	} 
   		
				
		
		   
			

			 ?>

 
 
 </div>

 
  

<div  id="resp_form_siges">

        <form  id="resp_form">  
  
<div class="col-submit">
		<?php 
		     $content=$dataProvider->getData();
		      if((isset($content))&&($content!=null))
			    { 
			  		          if((!$this->use_update)&&(!$this->message_UpdateValidate))
					                 {
                                         if(!isAchiveMode($acad_sess))
                                             echo CHtml::submitButton(Yii::t('app', 'Create '),array('name'=>'create','class'=>'btn btn-warning'));
                                         
                                         echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary'));
                                        }
                                            //back button   
                                              $url=Yii::app()->request->urlReferrer;
                                              $explode_url= explode("php",substr($url,0));
				             
                                              echo '<a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';

					      
					      
					      
					      					     
			    }
		?>
		
		
	</div>

 </form>
</div  >

       
  
                </div>
                
              </div>

</div>




