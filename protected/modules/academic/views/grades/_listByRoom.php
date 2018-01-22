
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

$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',));
 					

$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

 
     $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
     

   if($current_acad==null)
						         { $condition = '';
							          $condition1 = '';
							        }
						     else{
						     	   if($acad!=$current_acad->id)
							         { $condition = '';
								          $condition1 = '';
								        }
							      else
							        { $condition = 'p.active IN(1,2) AND ';
							           $condition1 = 'student0.active IN(1,2) AND ';
							        }
						        }



 
  $id_teacher='';   
           	
           	 $pers=User::model()->getPersonByUserId(Yii::app()->user->userid);
				 $pers=$pers->getData();
				 foreach($pers as $p)
				      $id_teacher=$p->id;
				

?>
 </br>
 
<?php			
 
if((Yii::app()->user->profil!='Teacher'))
   {	    
 
 ?>

		<div class="b_mail">

<div class="row" style="padding: 5px 10px;"> 
     
      <div class="span9" >

				<!--evaluation-->
									<div class="span2" >
									    <label for="Evaluation_name"><?php echo Yii::t('app','Evaluation Period'); ?></label><?php //echo $form->labelEx($model,'Evaluation Period'); ?>
									           <?php 
											
											        $modelEvaluation= new EvaluationByYear();
													    if(isset($this->evaluation_id)&&($this->evaluation_id!=''))
													       echo $form->dropDownList($modelEvaluation,'evaluation',$this->loadEvaluation($acad_sess), array('onchange'=> 'submit()','options' => array($this->evaluation_id=>array('selected'=>true)))); 
													    else
														  { 
															echo $form->dropDownList($modelEvaluation,'evaluation',$this->loadEvaluation($acad_sess), array('onchange'=> 'submit()')); 
												           }					      
												  
												echo $form->error($modelEvaluation,'evaluation'); 
												
																					
											   ?>
									</div>
				
						
	        <!--Shift(vacation)-->
               <div class="span2" >
		
			<?php $modelShift = new Shifts;
			       echo $form->labelEx($modelShift,Yii::t('app','Shift'));
			$default_vacation=null;
			      $criteria = new CDbCriteria;
				   								$criteria->condition='item_name=:item_name';
				   								$criteria->params=array(':item_name'=>'default_vacation',);
				   		$default_vacation_name = GeneralConfig::model()->find($criteria)->item_value;
				   		
				   		$criteria2 = new CDbCriteria;
				   								$criteria2->condition='shift_name=:item_name';
				   								$criteria2->params=array(':item_name'=>$default_vacation_name,);
				   		$default_vacation = Shifts::model()->find($criteria2);
				   		
				   		
			
			
			?>
					 <?php 
					    
						  if(isset($this->idShift)&&($this->idShift!=''))
						        {   
					               echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('options' => array($this->idShift=>array('selected'=>true)),'onchange'=> 'submit()' )); 
					             }
							  else
								{ $this->idLevel=0;
								    if($default_vacation!=null)
								      {  echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('options' => array(($default_vacation->id)=>array('selected'=>true)),'onchange'=> 'submit()' )); 
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
									               unset($this->room_id);
												   //$this->room_id=0;
											      }
										echo $form->error($modelLevelPerson,'level'); 
									 
									  ?>
								</div>
				
			<!--room-->
								<div class="span2" >
								<?php  $modelRoom = new Rooms;
								                     echo $form->labelEx($modelRoom,Yii::t('app','Room')); ?>
								          <?php 
										
										        
												  
												  if(isset($this->room_id)&&($this->room_id!=''))
												   { 
											          echo $form->dropDownList($modelRoom,'room_name',$this->loadRoomByIdShiftSectionLevel($this->idShift,$this->section_id,$this->idLevel,$acad_sess), array('onchange'=> 'submit()','options' => array($this->room_id=>array('selected'=>true)) )); 
										             }
												   else
												      { echo $form->dropDownList($modelRoom,'room_name',$this->loadRoomByIdShiftSectionLevel($this->idShift,$this->section_id,$this->idLevel,$acad_sess), array('onchange'=> 'submit()')); 
												          //echo $this->room_id;
														 //$this->room_id=0;
												      }
											echo $form->error($modelRoom,'room_name'); 
											
															
										   ?>
								</div>
								
	         </div>
													   
 
 <br/><br/> <br/><br/>
<?php
 if(!isset($this->evaluation_id)||($this->evaluation_id==''))
  {
	 Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','Choose evaluation period.') );
	}	
  else
   {

?> 
  <div style="float:left; width:100%;" >
		
       							

			<?php 	
			  $stud_order_desc_average = array();
				$max_average = 0;
				$max_average_ = 0;
				$min_average = 0;
				$success_f = 0;
				$success_m = 0;
				$average_base = 0;


                
			   $person= new Persons;
			   $tot_stud=0;
			   $showButton=false;
			   $total_succ =0;
			   $total_fail=0;
			   $passing_grade='N/A';
			   $classAverage='N/A';
			   $gen_done=false;  
			   
			   $include_discipline=0;
			   //Extract 
			   $include_discipline = infoGeneralConfig("include_discipline_grade");
			   //Extract max grade of discipline
			    $max_grade_discipline = infoGeneralConfig('note_discipline_initiale');
 	     
			   $include_discipline_comment=Yii::t('app',"Behavior grade is included in this average.");
		     
	 if(isset($this->room_id)&&($this->room_id!=''))
		{	//tcheke si gen not pou sal sa deja
			 $sql__ = 'SELECT g.id FROM grades g INNER JOIN courses c ON(c.id=g.course) WHERE c.room='.$this->room_id.' AND evaluation='.$this->evaluation_id.' ORDER BY id DESC';
															
			$command__ = Yii::app()->db->createCommand($sql__);
			$result__ = $command__->queryAll(); 
																       	   
			if($result__!=null) 
			  $gen_done=true;
						  
         if($gen_done)
		   {	 //totall etudiant
			 $dataProvider_studentEnrolled=Rooms::model()->getStudentsEnrolled($condition,$this->room_id, $acad_sess);
			  if(isset($dataProvider_studentEnrolled))
			    {  $t=$dataProvider_studentEnrolled->getData();
				   foreach($t as $tot)
				       $tot_stud=$tot->total_stud;
				}
			 
			 //moyenne de la classe
			 $classAverage=$this->getClassAverage($this->room_id, $acad_sess);
			
			 //total reussi, et echoue
			    //moyenne de passage classe
			    $passing_grade=$this->getPassingGrade($this->idLevel,$acad_sess); //note de passage pour la classe
			   
			   //Extract average base
			  $average_base = infoGeneralConfig('average_base');
								   				
								   				 
			 $dataProvider_studentEnrolledInfo= Rooms::model()->getInfoStudentsEnrolled($condition,$this->room_id, $acad_sess); 
			 if(isset($dataProvider_studentEnrolledInfo))
			    {  $t=$dataProvider_studentEnrolledInfo->getData();
				   foreach($t as $stud)
				      {
				      	  //moyenne yon elev
				      	 $averag=$this->getAverageForAStudent($stud->student_id, $this->room_id, $this->evaluation_id, $acad_sess);
				      	   
				      	 $stud_order_desc_average[$stud->student_id]= $averag;
				      	 
				      	 
				      	 if($passing_grade!='')
						  {
							   if($averag>=$passing_grade)
					      	    {  $total_succ ++;
					      	        
					      	        if($stud->gender == 1)
								        $success_f++;
								     elseif($stud->gender == 0)
								         $success_m++;
								         	   
					      	      }
					      	   elseif($averag<$passing_grade)
					      	      $total_fail ++;
				      	   
						   }
						 else
						   {   if($averag>=($average_base/2)) 
						         {  $total_succ ++;
					      	        
					      	        if($stud->gender == 1)
								        $success_f++;
								     elseif($stud->gender == 0)
								         $success_m++;
								         	   
					      	      }
					      	   elseif($averag<($average_base/2))
					      	      $total_fail ++;
						    }
				      	   				      	  
				      }
				}
			 
			//$min_average et $max_average_ 
			   arsort($stud_order_desc_average);
			     // get the first item in the $stud_order_desc_average
			     $max_average = reset($stud_order_desc_average);
			     
			     // get the last item in the $stud_order_desc_average
			     $min_average = end($stud_order_desc_average);
			
			
			
			
			$dataProvider=$this->getAllSubjects($this->room_id,$this->idLevel);
			
				
				
				//Grades for the current period
																	   				   
												  
				//liste des etudiants
			 $dataProvider_student=Persons::model()->getStudentsByRoomForGrades($condition,$this->room_id, $acad_sess);
			 
		
		  }
			 
			 
			 
		}	
              $couleur=1;
			  $k=0;
			 //
		echo '<div class="row-fluid"  style=" floaft: left; vertical-align:bottom; padding-bottom:0px;  ">';
		 echo '<div class="span8" style="float:left; font-size: 0.9em; padding: 0px;  margin-bottom: -14px; ">
			      
			       
			   <table class="responstable" style="width:100%; height: 49px; background-color: #c9d4dd; color: #1E65A4; -webkit-border-top-left-radius: 5px;-webkit-border-top-right-radius: 5px;-moz-border-radius-topleft: 5px;-moz-border-radius-topright: 5px;border-top-left-radius: 5px;border-top-right-radius: 5px;">
					   <tr>
					   
					   <td style="text-align:center;">'.Yii::t('app','Students Enrolled').' : '.$tot_stud.'</td>
					       <td style="text-align:center; ">'.Yii::t('app','Passing Average').' : '; if($passing_grade!='') echo $passing_grade; else echo 'N/A'; echo'</td>
					       <td style="text-align:center; ">'.Yii::t('app','Max average').' : '.$max_average.'</td>
					       <td style="text-align:center; ">'.Yii::t('app','Min average').' : '.$min_average.'</td>
					       <td style="text-align:center; ">'.Yii::t('app',' Success(F)').' : '.$success_f.'</td>
					       <td style="text-align:center; ">'.Yii::t('app',' Success(M)').' : '.$success_m.'</td>
					       <td style="text-align:center; ">'.Yii::t('app',' Total Success').' : '.$total_succ.'</td>
					    </tr>
						</table>
				</div>
			      
			       
			       ';
	
	
			   
				echo '<div class="span4"  style=" color:blue; text-align: center; background-color: #F8F8C9;   padding-left:10px; padding-right:40px; padding-top:5px; padding-bottom:5px;  margin-left=-3px;">';

				  if(isset($this->room_id)&&($this->room_id!=''))
					{   
					        echo Yii::t('app','- Weak grades are in <span style="color:red">Red</span>, <span style="color:black">Black</span> grades aren\'t validated yet. -');
					  					  }
					  else 
					    {
					    	 
							        echo '.<br/>';
							   
						
					    	}  
				 // echo '</div>';
					echo '</div>';
     
	echo '</div >';
			
				   
	echo '<div style="margin-top:0px;  margin-bottom: 20px; float:left;   width:100%;  overflow-x:scroll; overflow-y:hidden;  background-color:#EFF4F8;">  
	
	       <table class="" style="  width:100%; background-color:#EFF4F8; color: #1E65A4;">
  
      <thead class="" >
           <tr style="background-color:#E4E9EF;">
				    <th style="background-color:#E4E9EF; width:170px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;. </th>
					<th class="" style="background-color:#E4E9EF; width:40px;">.</th>
				          ';
		
		
 if($include_discipline==1)
   {    												
  	   echo ' <th style="background-color:#E4E9EF; text-align:center; border-left: 1px solid  #E4E9EF;font-size: 1em;">'.Yii::t('app','Discipline').'</th>';  		
		
   }
		//liste des cours
		while(isset($dataProvider[$k][0]))
				{
	               if($dataProvider[$k][4]!=NULL) //reference_id
			 	         {  $id_course = $dataProvider[$k][4];
							 //si kou a evalye pou peryod sa
							$old_subject_evaluated=$this->isOldSubjectEvaluated($id_course,$this->room_id,$this->evaluation_id);         
							  if($old_subject_evaluated)
								 {
								 	$careAbout=$this->isOldSubjectEvaluated($dataProvider[$k][4],$this->room_id,$this->evaluation_id);						                        
								  }
							   else
								 {   $id_course = $dataProvider[$k][0];
								 	$careAbout=$this->isSubjectEvaluated($dataProvider[$k][0],$this->room_id,$this->evaluation_id);						                       															                       
									}
		
						 }
					 else
						{  $id_course = $dataProvider[$k][0];
						    $careAbout=$this->isSubjectEvaluated($dataProvider[$k][0],$this->room_id,$this->evaluation_id);
						}
						
						         
			      
			      if($careAbout)
				     {			
						
				// $dataProvider[$k][1] subject_name
				// $dataProvider[$k][3] short_subject_name
				 
				 echo ' <th style="background-color:#E4E9EF; text-align:center; border-left: 1px solid  #E4E9EF;font-size: 1em;">'.'<span data-toggle="tooltip" title="'.$dataProvider[$k][1].'"> '.$dataProvider[$k][3].'</span></th>';
				   
				      }
				      
				      $k++;
		        }
echo '	
     </tr>
  
  <tr style=""> 
     <th style="background-color:#E4E9EF; text-align:center; border-bottom: 3px solid  #E4E9EF; border-right: 3px solid  #E4E9EF; border-top: 3px solid  #E4E9EF;width:170px;">'.Yii::t('app',"Student Name").' </th>
	<th class="" style="background-color:#E4E9EF; text-align:center; border-bottom: 3px solid  #E4E9EF; border-right: 3px solid  #E4E9EF; border-top: 3px solid  #E4E9EF;width:40px;">'.Yii::t('app',"Average").' </th>
    ';   
    
		
		//coefficients
		$k=0;
 if($include_discipline==1)
   {    												
  	   echo '<th class="" style="background-color:#E4E9EF; text-align:center; border-bottom: 3px solid  #E4E9EF; border-right: 1px solid  #E4E9EF; border-top: 3px solid  #E4E9EF;width:100px ">'.$max_grade_discipline.'</th>'; 		
		
   }		
		
		while(isset($dataProvider[$k][0]))
				{
	               if($dataProvider[$k][4]!=NULL) //reference_id
			 	         {  $id_course = $dataProvider[$k][4];
							 //si kou a evalye pou peryod sa
							$old_subject_evaluated=$this->isOldSubjectEvaluated($id_course,$this->room_id,$this->evaluation_id);         
							  if($old_subject_evaluated)
								 {
								 	$careAbout=$this->isOldSubjectEvaluated($dataProvider[$k][4],$this->room_id,$this->evaluation_id);						                        
								  }
							   else
								 {   $id_course = $dataProvider[$k][0];
								 	$careAbout=$this->isSubjectEvaluated($dataProvider[$k][0],$this->room_id,$this->evaluation_id);						                       															                       
									}
		
						 }
					 else
						{  $id_course = $dataProvider[$k][0];
						    $careAbout=$this->isSubjectEvaluated($dataProvider[$k][0],$this->room_id,$this->evaluation_id);
						}
						
						        
			  
			      if($careAbout)
				     {			
							 echo '<th class="" style="background-color:#E4E9EF; text-align:center; border-bottom: 3px solid  #E4E9EF; border-right: 1px solid  #E4E9EF; border-top: 3px solid  #E4E9EF;width:100px ">'.$dataProvider[$k][2].'</th>';
														
					}
					
					$k++;
		  }
 echo '</tr>
	     	
	   	</thead >
	   	
	   	<tbody class="">
          
  	';
  	
  	    //pou chak elev
			if($gen_done)		       
			  {		       if(isset($dataProvider_student))
			                 {  
				                 $students=$dataProvider_student->getData();
								 
				             foreach($students as $stud)    //foreach($stud_order_desc_average as $stud)
				              {  
				              	 $k=0;
				              	 
							    if($couleur===1)  //choix de couleur																
									 $style_tr="font-size: 1em; background-color: #F0F0F0;";
								 elseif($couleur===2)
									$style_tr="font-size: 1em; background-color: #FAFAFA; ";
									
							     echo '<tr style="'.$style_tr.'">
								            <td style="'.$style_tr.' border-right: 3px solid  #E4E9EF ; width:170px; "> 
				  								<b>'.$stud->first_name.' '.$stud->last_name.'</b></td>';
				  								
				  								
									$average_ = $this->getAverageForAStudent($stud->id, $this->room_id, $this->evaluation_id, $acad_sess);
										
									 echo '<td class="" style="text-align:center; width:40px; border-right: 3px solid  #E4E9EF; "><b>';
									   	   
									   	    if($average_ < $passing_grade)  echo '<div style="color:red;">'.$average_.'</div>';
											 else echo '<div >'.$average_.'</div>';
											 
											 echo '</b> </td>';

											 
									if($include_discipline==1)
									  {		
									  	/*echo '<td class="" style="text-align:center; width:40px; border-right: 3px solid  #E4E9EF; "><b>';
											if($average_ < $passing_grade) echo '<div style="color:red;"> <span data-toggle="tooltip" title="'.$include_discipline_comment.'"> '.$average_.'</span> </div>';
											else echo '<div > <span data-toggle="tooltip" title="'.$include_discipline_comment.'"> '.$average_.'</span> </div>';
											echo '</b> </td>';
											*/
											
											//discipline grade
											  $period_acad_id =null;
			                                  $result=EvaluationByYear::model()->searchPeriodName($this->evaluation_id);
												 if(isset($result))
													{  $result=$result->getData();//return a list of  objects
														foreach($result as $r)
														 {
															$period_exam_name= $r->name_period;
															$period_acad_id = $r->id;
														  }
													  }
			                                    
			                                   $grade_discipline = RecordInfraction::model()->getDisciplineGradeByExamPeriod($stud->id, $period_acad_id);
																
											 echo '<td style="text-align:center; width:100px; border-right: 1px solid  #E4E9EF">';
												echo '<div class="" style="color:green;">';
												echo '<div class="" ><span data-toggle="tooltip" > '.$grade_discipline.' </span>';
												echo '</div></div>';
                                             echo '</td>';

											
									   }
	
									   	  
									   	 	
										
									 
											  while(isset($dataProvider[$k][0]))
				                                {
	                                               if($dataProvider[$k][4]!=NULL) //reference_id
										 	         {  $id_course = $dataProvider[$k][4];
														 //si kou a evalye pou peryod sa
														$old_subject_evaluated=$this->isOldSubjectEvaluated($id_course,$this->room_id,$this->evaluation_id);         
														  if($old_subject_evaluated)
															 {
															 	$careAbout=$this->isOldSubjectEvaluated($dataProvider[$k][4],$this->room_id,$this->evaluation_id);						                        
															  }
														   else
															 {  
															 	$careAbout=$this->isSubjectEvaluated($dataProvider[$k][0],$this->room_id,$this->evaluation_id);						                       															                       
																}
									
													 }
												 else
													{  $id_course = $dataProvider[$k][0];
													    $careAbout=$this->isSubjectEvaluated($dataProvider[$k][0],$this->room_id,$this->evaluation_id);
													}
													
													         
			  
			                                      if($careAbout)
				                                     {			
							                           
							                            //calculer grade puis afficher
							                                    $debase_passingGrade=0;
							                            $debase='';
							                             $weight='';
							                             $id_course=0;
							                             $passing_value=0;
							                             
							                              if($dataProvider[$k][4]!=NULL) //reference_id
												 	         {  $id_course = $dataProvider[$k][4];
																 //si kou a evalye pou peryod sa
																$old_subject_evaluated=$this->isOldSubjectEvaluated($id_course,$this->room_id,$this->evaluation_id);         
																  if($old_subject_evaluated)
																	 {
																	 	$id_course = $dataProvider[$k][4];						                        
																	  }
																   else
																	 {  
																	 	$id_course = $dataProvider[$k][0];						                       															                       
																		}
											
															 }
														 else
															{  $id_course = $dataProvider[$k][0];
															    
															}
							                            
							                            $resultDebase=Courses::model()->ifCourseDeBase($id_course);
							                            if($resultDebase!=null)
							                             {
							                             	foreach($resultDebase as $base)
							                             	 { $weight=$base["weight"];
							                             	   $debase=$base["debase"];
							                             	  }
							                             	  
							                               }
							                            
							                            if($debase==1)
							                              {
							                                 $pass_gra=PassingGrades::model()->getCoursePassingGrade($id_course, $acad_sess);
							                              	  if($pass_gra!=null)
							                              	    $debase_passingGrade=$pass_gra;
							                              	    
							                              	    $passing_value=$debase_passingGrade;
							                              	
							                              	}
							                             else
							                               $passing_value = $dataProvider[$k][2]/2;
							                              	
																  
															$grades=Grades::model()->searchForReportCard($condition,$stud->id,$id_course,$this->evaluation_id); 
																	if(isset($grades))
																		{
														                        $r=$grades->getData();//return a list of  objects
															                 if($r!=null)
																			   { foreach($r as $grade)
																			      {
																			        echo '<td style="text-align:center; width:100px; border-right: 1px solid  #E4E9EF">';
																			        echo '<div class="" style="';		
			     	                                                              echo 'color:green;">';
																			        if($grade->grade_value!=null)
																			           { 
																			           	  echo '<div class="" style="';		
			     	                                                                        if($grade->validate==0)
																			           	      echo 'color:black;">';
																			           	    elseif($grade->grade_value< $passing_value )
																			           	     { 
																			           	        echo 'color:red;">';
																			           	      }
																			           	    elseif($grade->validate==1)
																			           	      echo '">';
																			           	      
																			           	    	 echo '<span data-toggle="tooltip" title="'.$grade->comment.'"> '.$grade->grade_value.'</span>';
																			           	    	 
																			           	   echo '</div>';
																			           	     
																			           	  
																			           }
																		           	 else
																			           {  echo '<div class="" style="';		
			     	                                                                        if($grade->validate==0)
																			           	      echo 'black;">';
																			           	    elseif($grade->grade_value< $passing_value)
																			           	     { 																			           	       										 echo 'color:red;">';
																			           	      }
																			           	    elseif($grade->validate==1)
																			           	      echo '">';
																			           	   
																			           	         echo 'N/A';
																			           	         
																			           	   echo '</div>';
																			           	   
																			             } 
                                                                                     
                                                                                      echo '</div>';
                                                                                      
                                                                                     echo '</td>';
                                                                                                                                                        
                                                                                                                                                   
															                        }
																	             }
																                else
																                  { echo '<td style=" text-align:center;  border-right: 1px solid  #E4E9EF ">';echo '<div class="" style="';		
			     	                                                                       /// if($grade->validate==0)
																			           	   
																			           	      echo '">';
																			           	   
																			           	         echo 'N/A';
																			           	         
																			           	   echo '</div>'; 
																			           	   
																			           	echo '</td>';
																                  }
																	$showButton=true;
																	
																         }//fin if(isset($grades))
															
														}//fin careAbout
														
														$k++;
					                    
				                                }//fin while(isset($dataProvider[$k][0]))								  
									   $couleur++;
	                                if($couleur===3) //reinitialisation
				                       $couleur=1;
								echo '</tr>';
								}// fin foreach($students as $stud)
							  
						//class average
						    echo '<tr ><td></td></tr> <tr style="'.$style_tr.'"><td style="'.$style_tr.' border-right: 3px solid  #E4E9EF ; text-align:right;  width:170px; ">'.Yii::t('app','Class Average').' </td>';
                            echo ' <td style="'.$style_tr.' border-right: 3px solid  #E4E9EF ; text-align:center; width:170px; ">'; echo $classAverage;   echo '</td>';
						   if($include_discipline==1)
						   {    												
							   echo ' <td style="'.$style_tr.' border-right: 3px solid  #E4E9EF ; width:170px; "> </td>'; 		
								
						   }
								//liste des cours
								$k=0;
								while(isset($dataProvider[$k][0]))
										{
											 $id_course = $dataProvider[$k][0];
											 
										  if($dataProvider[$k][4]!=NULL) //reference_id
										 	         {  $id_course = $dataProvider[$k][4];
														 //si kou a evalye pou peryod sa
														$old_subject_evaluated=$this->isOldSubjectEvaluated($id_course,$this->room_id,$this->evaluation_id);         
														  if($old_subject_evaluated)
															 {
															 	$careAbout=$this->isOldSubjectEvaluated($dataProvider[$k][4],$this->room_id,$this->evaluation_id);						                        
															  }
														   else
															 {  $id_course = $dataProvider[$k][0];
															 	$careAbout=$this->isSubjectEvaluated($dataProvider[$k][0],$this->room_id,$this->evaluation_id);						                       															                       
																}
									
													 }
												 else
													{  $id_course = $dataProvider[$k][0];
													    $careAbout=$this->isSubjectEvaluated($dataProvider[$k][0],$this->room_id,$this->evaluation_id);
													}
													
													         
									
										  if($careAbout)
											 {			
												
										 echo ' <td style="'.$style_tr.' border-right: 3px solid  #E4E9EF ; text-align:center; width:170px; ">';echo '<span data-toggle="tooltip" title="'.$dataProvider[$k][1].'"> '.course_average($id_course,$this->evaluation_id).'</span>';echo '</td>';
										   
											  }
											  
											  $k++;
										}
						echo '	
							 </tr>';						
							  
							  
							  
							  
							  
							  }// fin if(isset($dataProvider_student))
							  
							  
			          }
							  
                    echo '
                    
                     </tbody>
                          
                           </table>
                    
               </div>     
                          
                          
                           '; 	  
				   				  
		?>		  
	</div>			   	

<br/>


<div  >

        <form  id="resp_form">  
 	

<div class="col-submit">
<?php 
 
		 
		      if($showButton)
			    {    if(!isAchiveMode($acad_sess))
			           { echo CHtml::submitButton(Yii::t('app', 'Validate & Publish'),array('name'=>'validate_publish','class'=>'btn btn-warning'));
	                        echo CHtml::submitButton(Yii::t('app', 'Validate'),array('name'=>'validate','class'=>'btn btn-warning')); 
	                       //echo CHtml::submitButton(Yii::t('app', 'Publish'),array('name'=>'publish','class'=>'btn btn-warning'));
			            }
			            
	                echo CHtml::submitButton(Yii::t('app', 'View PDF'),array('name'=>'viewPDF','class'=>'btn btn-warning')); 
			       

			      
		      
		       
	                   
	                  //back button   
                                              $url=Yii::app()->request->urlReferrer;
                                              $explode_url= explode("php",substr($url,0));
				             
                                              echo ' <a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';
                                          
                      }
		
?>
	

 </div>

 </form>
</div  >


 

<?php 

   }
   
 }//fen if((Yii::app()->user->profil!='Teacher'))	    
     else //Yii::app()->user->profil=='Teacher'
       {
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
							       echo $form->dropDownList($modelEvaluation,'evaluation',$this->loadEvaluation($acad_sess), array('onchange'=> 'submit()','options' => array($this->evaluation_id=>array('selected'=>true)))); 
							    else
								  { 
									echo $form->dropDownList($modelEvaluation,'evaluation',$this->loadEvaluation($acad_sess), array('onchange'=> 'submit()')); 
						           }					      
						  
						echo $form->error($modelEvaluation,'evaluation'); 
						
															
					   ?>
			</div>
       
		
		  
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
							          
									 $this->room_id=0;
							      }	
		                    
		                    
							      
						echo $form->error($modelRoom,'room_name'); 
						
										
					   ?>
			</div>

			
			<!--Courses-->
			<div class="span2" >
			   
					  
					 <?php $modelCourse = new Courses;
					  ?></label><?php 
					        echo $form->labelEx($modelCourse,Yii::t('app','Course'));
					        
						
						if(isset($this->room_id)&&($this->room_id!='')){
						   	   
					 	    if(isset($this->course_id))
						        {   
					               echo $form->dropDownList($modelCourse,'subject',$this->loadSubjectByTeacherRoom($this->room_id,$id_teacher,$acad_sess), array('onchange'=> 'submit()','options' => array($this->course_id=>array('selected'=>true)) )); 
					             }
							  else
								{ $this->course_id=0;
								    echo $form->dropDownList($modelCourse,'subject',$$this->loadSubjectByTeacherRoom($this->room_id,$id_teacher,$acad_sess),array('onchange'=> 'submit()')); 
								}
								
                          
						  }
						else
							echo $form->dropDownList($modelCourse,'subject',$this->loadSubject(null,null,$acad_sess),array('onchange'=> 'submit()'));
						 
						echo $form->error($modelCourse,'subject'); 
						
					
					  ?>
					  
			   </div>
		</div>
													   

<br/><br/>

  <div  style="float:left; width:100%;" >     
<?php
       
       
   	  if(($this->course_id!='')&&($this->evaluation_id!=''))
 	    $dataProvider=$model->searchForTeacherUserRoomCourse($condition1, $this->evaluation_id,$this->course_id, $acad_sess);
 	  else
 	    $dataProvider=$model->searchForTeacherUserRoomCourse($condition1, 0,0, $acad_sess);
   	
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']); // set controller and model for that before
   $gridWidget = $this->widget('groupgridview.GroupGridView', array(
	'id'=>'grades-grid',
	'dataProvider'=>$dataProvider,
       
       'mergeColumns'=>array('s_full_name','evaluation0.examName'),
	
	'columns'=>array(
		array('header'=>Yii::t('app','Student name'),'name'=>'s_full_name',
                    'type' => 'raw','value'=>'CHtml::link($data->student0->fullName,Yii::app()->createUrl("academic/persons/viewForReport",array("id"=>$data->student0->id,"pg"=>"lr","isstud"=>1,"from"=>"stud")))',
                    'htmlOptions'=>array('style'=>'vertical-align: top'),
                        
                    ),
            
                array('name'=>'evaluation0.examName','header'=>Yii::t('app','Exam name'),'htmlOptions'=>array('style'=>'vertical-align: top')),    
                    
		
		'grade_value',
                'course0.weight',
                      
          array('header'=>Yii::t('app','Com. '),'name'=>'comment',
                    'type' => 'raw','value'=>'($data->comment == null) ? " " : "<span data-toggle=\"tooltip\" title=\"$data->comment\"><i class=\"fa fa-comment-o\"></i> </span>"',
                ),
   
            array('header' =>Yii::t('app','Validate'),
	         'name'=>'validate',
	        'value'=>'$data->validateGrade'
			),
		 	
	array('header' =>Yii::t('app','Publish'),
	         'name'=>'publish',
	        'value'=>'$data->publishGrade'
			),
                
		
		array(
			'class'=>'CButtonColumn',
			'template'=>'',
			'buttons'=>array (
        'update'=> array(
            'label'=>'<i class="fa fa-pencil-square-o"></i>',
            'imageUrl'=>false,
            'url'=>'Yii::app()->createUrl("/academic/grades/update?id=$data->id&from=stud")',
            'options'=>array( 'title'=>Yii::t('app','Update') ),
        ),
        
        'delete'=>array('label'=>'<span class="fa fa-trash-o"></span>',
                            'imageUrl'=>false,
                            'options'=>array('title'=>Yii::t('app','Delete')),
                                
                            ),

         'view'=>array(
            'label'=>'View',
            
            'url'=>'Yii::app()->createUrl("/academic/grades/view?id=$data->id&from=stud")',
            'options'=>array( 'class'=>'icon-search' ),
        ),
        
    ),
			
			'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                                  'onchange'=>"$.fn.yiiGridView.update('grades-grid',{ data:{pageSize: $(this).val() }})",
                    )),
		),
	),
)); 
          $content=$dataProvider->getData();
	        if((isset($content))&&($content!=null)) 
			   $this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app',' CSV'),array('class'=>'btn-info btn'));
		
   ?>
	

   </div>


  <?php     }   ?>
  
</div>
</div>
</div>  
 <div style="clear:both;"></div>
 
