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

    
$acad=Yii::app()->session['currentId_academic_year']; 



                  if(isset($_GET['shi'])) $this->idShift=$_GET['shi'];
				  else{$idShift = Yii::app()->session['Shifts_admit'];
				  $this->idShift=$idShift;}
				  
			      if(isset($_GET['sec'])) $this->section_id=$_GET['sec'];
				  else{$section = Yii::app()->session['Sections_admit'];
				  $this->section_id=$section;}
				  
				  if(isset($_GET['lev'])) $this->idLevel=$_GET['lev'];
				  else{$level = Yii::app()->session['LevelHasPerson_admit'];
				  $this->idLevel=$level;}
				  
				  if(isset($_GET['roo'])) $this->room_id=$_GET['roo'];
				  else{$room = Yii::app()->session['Rooms_admit'];
				  $this->room_id=$room;}
				  
				
				  if(isset($_GET['stud'])) $this->student_id=$_GET['stud'];
				  
   
 

?>



<div style="width:70%; padding:0px;">


	<div class="left" style="padding:0px;">			
					 
		    <!--evaluation-->
			<div class="left" style="margin-right:10px;">
			<label for="Evaluation_name"></label>
			           
				</div>
			
			
	</div>		
	
	<div style="padding:0px;">			
			<!--Shift(vacation)-->
        <div class="left">
		
			<?php $modelShift = new Shifts;
			echo $form->labelEx($modelShift,Yii::t('app','Shift'));?>
					 <?php 
					
						
						  if((isset($this->idShift))&&($this->idShift!=0))
						        {   
					               echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('options' => array($this->idShift=>array('selected'=>true)),'onchange'=> 'submit()' )); 
					             }
							  else
								{ $this->idLevel=0;
								    echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('onchange'=> 'submit()' ));
									$this->room_id=0;									
								}
							
						echo $form->error($modelShift,'shift_name'); 
						
					
					  ?>
				</div>
			 
		    <!--section(liee au Shift choisi)-->
			<div class="left" style="margin-left:10px;">
			<?php $modelSection = new Sections;
			                   echo $form->labelEx($modelSection,Yii::t('app','Section')); ?>
			           <?php 
					
					    
							    if((isset($this->section_id))&&($this->section_id!=0))
							       echo $form->dropDownList($modelSection,'section_name',$this->loadSectionByIdShift($this->idShift), array('options' => array($this->section_id=>array('selected'=>true)),'onchange'=> 'submit()')); 
							    else
								  { $this->idLevel=0;
									echo $form->dropDownList($modelSection,'section_name',$this->loadSectionByIdShift($this->idShift), array('onchange'=> 'submit()' )); 
						           }					      
						  
						echo $form->error($modelSection,'section_name'); 
						
															
					   ?>
				</div>
			
			<!--level-->
			<div class="left" style="margin-left:10px;">
			<?php $modelLevelPerson = new LevelHasPerson;
                        
			                       echo $form->labelEx($modelLevelPerson,Yii::t('app','Level'));?> 
					   <?php 
					 
					   
						if((isset($this->idLevel))&&($this->idLevel!=0))
							    echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevelByIdShiftSectionId($this->idShift,$this->section_id,$acad), array('options' => array($this->idLevel=>array('selected'=>true)),'onchange'=> 'submit()', )); 
							 else
								{ $this->idLevel=0;
								  echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevelByIdShiftSectionId($this->idShift,$this->section_id,$acad), array('onchange'=> 'submit()' )); 
					              $this->room_id=0;
							      }
						echo $form->error($modelLevelPerson,'level'); 
					 
					  ?>
				</div>
			
			<!--room-->
			<div class="left" style="margin-left:10px;">
			     <?php  $modelRoom = new Rooms;
			                     echo $form->labelEx($modelRoom,Yii::t('app','Room')); ?>
			          <?php 
					
					
						    
							  
							  if((isset($this->room_id))&&($this->room_id!=0))
							   { 
						          echo $form->dropDownList($modelRoom,'room_name',$this->loadRoomByIdShiftSectionLevel($this->idShift,$this->section_id,$this->idLevel), array('onchange'=> 'submit()','options' => array($this->room_id=>array('selected'=>true)) )); 
					             }
							   else
							      { echo $form->dropDownList($modelRoom,'room_name',$this->loadRoomByIdShiftSectionLevel($this->idShift,$this->section_id,$this->idLevel), array('onchange'=> 'submit()')); 
							          
									 $this->room_id=0;
							      }
						echo $form->error($modelRoom,'room_name'); 
						
					   ?>
				</div>
			</div>
			
	
			
			
			
		 	
		
													   
    </div>



<div class="principal">
  <div class="list_secondaire">
											

			<?php 		
			
			
			$person= new Persons;
			$modelacademicP = new AcademicPeriods;
			$couleur=1;   
              			


			
				 
			//error message
	    if(($this->messageNoCheck==1))
	        { echo '<div class="" style=" width:45%; margin-top:10px; margin-bottom:10px; background-color:#F8F8c9; ';		
			      if(($this->messageNoCheck==1))
				     echo 'color:red;">';
				 
					
				   if($this->messageNoCheck==1)
					 {
						     $this->messageNoCheck==0;
							echo '<input type="hidden" name="t_comment[]" id="t_comment[]" value="">';
							echo Yii::t('app','You must check students to take decision.<br/>');
					        
						   						
		              }
		                    
           echo '</div>';
	        }
		
			   
					
		  
			   
if((isset($this->room_id))&&($this->room_id!=""))
   { 
	          
	          $female_success =0;
			  $male_success =0;
			  $tot_stud =0;
			  $tot_suc=0;
			  $female_success_po=0;
			  $male_success_po=0;
													
			   $tot_suc_po=0;
			   
			   $female_faill =0;
			  $male_faill =0;
			  
			  $tot_faill=0;
			  $female_faill_po=0;
			  $male_faill_po=0;
													
			   $tot_sfaill_po=0;
			   
			  $lastReportcardNotSet=true; 
			   
			   
	          
	           if($this->room_id!=0)
				{  $room=$this->getRoomName($this->room_id);
				    $level=$this->getLevel($this->idLevel);
					$section=$this->getSection($this->section_id);
					$shift=$this->getShift($this->idShift);
				}
                                $passing_grade = 0;
				if($this->room_id!=null){
				
                                 $passing_grade=$this->getPassingGrade($this->idLevel,$acad); //note de passage pour la classe
                                
                                 
                                 }
			
      
	     if($passing_grade!=null) // passing grade is set for this level
	       {			 	      		      
		  //getting all stud for this room_id   		
  			$dataProvider=Persons::model()->getStudentsByRoomForReport($this->room_id, $acad);
				                            
				//totall etudiant
				
				$this->tot_stud=0;
				
			 $dataProvider_studentEnrolled=Rooms::model()->getStudentsEnrolled($this->room_id, $acad);
			  if(isset($dataProvider_studentEnrolled))
			    {  $t=$dataProvider_studentEnrolled->getData();
				   foreach($t as $tot)
				       $this->tot_stud=$tot->total_stud;
				}
			
		if($this->tot_stud!=0)	
		  {
			//********* getting data for stat  **********/	
		       if($dataProvider->getItemCount()!=0)
		   		{ 
		   			//total students
		   			$tot_stud =$this->tot_stud;
		   			 $person=$dataProvider->getData();
		   			 
				  foreach($person as $stud)
				     {	
                       //in decision_finale table
						 $mention=null;
						 $is_move_to_next_year=null;
						 $average=0;
						   
						 $is_mention_set = $this->checkDecisionFinale($stud->id, $acad);                                                         
							
						 foreach($is_mention_set as $result)
							  $average = $result["general_average"];
						   
						  $gender2 = $stud->gender;    // sexe
								   
							
							                if($average >= $passing_grade)
											       { //moyenne >= note de passing
					                                 
					                                   
					                                   if($gender2==1)
					                                    {   //female
					                                      	$female_success =$female_success +1;
					                                    }
					                                   elseif($gender2==0)
					                                     {   //male
					                                       	$male_success =$male_success +1;
					                                     }
					                                }
					                              else{
					                                   
					                                     
					                                     if($gender2==1)
					                                    {   //female
					                                      	$female_faill =$female_faill +1;
					                                    }
					                                   elseif($gender2==0)
					                                     {   //male
					                                       	$male_faill =$male_faill +1;
					                                     }

					                                 }
					                                 
                                 
						     
					          }
						                 
						                 
						                 
					     }
					 
					 //********* end of getting data for stat  **********/
					 
             
				
						//reccuperer l'id du Stud
					   $person=$dataProvider->getData();
                       $display_comment=-1; // for admitted stud
					   $admitted_stud=0;
					   $failed_stud=0;
					   $failed_array=null;
					   
					    $style_td='\'border-right: 1px solid #FFF; \'';
					   
					  
					   $total_find = $this->tot_stud;
					   
					   
								 
											     
												  
													
														      
                        					   
                    foreach($person as $stud){	
	
                         $mention=null;
						 $is_move_to_next_year=null;
						 $average=0;
						 // record already in decision_finale table
						 $is_mention_set = $this->checkDecisionFinale($stud->id, $acad);                                                         
							
						//check if mention and/or is_move_to_next_year already set for a specific stud.(it means decision is already taken for him).	   
						 if((isset($is_mention_set))&&($is_mention_set!=null))
						   {  
							 foreach($is_mention_set as $result)
							    $mention = $result["mention"];
							   $is_move_to_next_year = $result["is_move_to_next_year"];
							   $average = $result["general_average"];
						   }
						 
						        
						if(($mention==null)&&($is_move_to_next_year==null))	 
                          {
							       $total_find--;
							       
								   $lastReportcardNotSet=false; //on a deja produit  le dernier bulletin
								   
								   $this->student_id = $stud->id;   //ID student
								   $birthday = $stud->birthday;   // student's birthday
								   $city = $stud->cities;   // where student born
								   $gender = $stud->getGenders1();   // sexe
								   
								   $city_name= $this->getCityName($city); // return the name of the city
								  
								   
								
							        $student=$this->getStudent($this->student_id );
							                        
										  
								              $display_comment++; //for admitted stud
                                            									  
					 if($average >= $passing_grade)
					    { //moyenne >= note de passing
						                  //afficher les admis 
						                     //******DISPLAY ADMITTED STUDENTS*****/
		                                  if($admitted_stud==0)			 
											{	$admitted_stud=1;
													Yii::app()->session['isPresent']=1;	
													
											 //********* display data stat of success **********/				     
	         
													if($tot_stud!=0)
													  {	
														$female_success_po=round(($female_success*100)/$tot_stud,2);
														$male_success_po=round(($male_success*100)/$tot_stud,2);
														
														$tot_suc=$female_success+$male_success;
														$tot_suc_po=round(($tot_suc*100)/$tot_stud,2);
															}		 
																 
															echo '<div class="all_gender">
															<!--  <div class="total_student">'. Yii::t('app','Total Students').'<div>'.$tot_stud.'</div></div>  -->
															
															<div class="gender">'.Yii::t('app','').'<div class="female">'.Yii::t('app',' Success(F)').'<br/>'.$female_success.' : '.$female_success_po.'%</div><div class="male">'.Yii::t('app',' Success(M)').'<br/>'.$male_success.' : '.$male_success_po.'%</div><div class="male">'.Yii::t('app',' Total Success').'<br/>'.$tot_suc.' : '.$tot_suc_po.'%</div></div>
															
															</div>
											             
												<div style="clear:both"></div>	';
	                                         //********* end of displaying data stat OF SUCCESS **********/
	                                         
	                                                
	                                               echo Yii::t('app','ADMITTED STUDENT(S)');    

															 
													echo '<div class=\'dataGrid\' id=\'page\'><table style=\'width:100%;\'>
												<tr style=\'color: #FFF; font-size: 0.9em; background: -webkit-linear-gradient(#85bad8 30%, #4c99c5 100%);
												background: -o-linear-gradient(#85bad8 30%, #4c99c5 100%);
												background: -moz-linear-gradient(#85bad8 30%, #4c99c5 100%); 
												background: -ms-linear-gradient(#85bad8 30%, #4c99c5 100%);
												background: linear-gradient(#85bad8 30%, #4c99c5 100%);\'>

																				  <td  style='.$style_td.'><b>'.Yii::t('app','Name').'</b></td><td  style='.$style_td.'><b>'.Yii::t('app','Gender').'</b></td><td style='.$style_td.'><b> '.Yii::t('app','Average ').'</b></td><td style='.$style_td.'><b>'.Yii::t('app','Mention').' </b></td><td style='.$style_td.'><b>'.Yii::t('app','Comment').' </b></td>';
													 	
															echo '<td  style="text-align:center"><b>'.Yii::t('app','Check All').'</b><br/>';
																						if($this->isCheck==1) echo '<input type="checkbox" name="check_all" checked="checked" onclick="this.form.submit();">';
																						elseif($this->isCheck==0) echo '<input type="checkbox" name="check_all" onclick="this.form.submit();">';
																			
															echo '</td>';                                  
												 echo '</tr>';
                                             }												 
														
														//pour la couleur des lignes
														       $flag_color =null; 
																
                                                                if($couleur===1)  //choix de couleur
                                                                {
																    $style_tr='\'font-size: 0.9em; background: #E5F1F4; \'';
                                                                                                                                    if($flag_color==true)
                                                                                                                                        $style_tr='\'font-size: 0.9em;background: #E5F1F4; color: #FF0000; \'';
                                                                                                                                        
                                                                }
															    elseif($couleur===2)
                                                                                                                            {
																    $style_tr='\'font-size: 0.9em; background: #F8F8F8; \'';
                                                                                                                                    if($flag_color==true)
                                                                                                                                        $style_tr='\'font-size: 0.9em; background: #F8F8F8; color: #FF0000; \'';
                                                                                                                            }
											
                                                                $mension=Yii::t('app','ADMITTED');
                                                                $flag_color = false;
									$this->comment = Yii::app()->session['comment_admit'];
															
                                                                     echo '<tr style='.$style_tr.'><td style='.$style_td.'>'.$student.'</td><td style='.$style_td.'>'.$gender.'</td><td style='.$style_td.'>'. $average.' </td><td>'.$mension.'</td>
					<td > <div style="margin-right: 6px;">
							<textarea name="t_comment['.$display_comment.']" id="t_comment['.$display_comment.']"  rows="1" cols="30" style="width:90%; height:27px;" >'; if((isset($this->comment[$display_comment]))&&($this->comment[$display_comment]!="")) echo $this->comment[$display_comment]; echo' </textarea>
					        
					</div></td><td style="width:20px;">';
					if($this->isCheck==1) 
						 echo '<input type="checkbox" name="olone_check[]" value="'.$display_comment.'" checked="checked" >';
					 elseif($this->isCheck==0) 
						echo '<input type="checkbox" name="olone_check[]" value="'.$display_comment.'"  >';
					echo '</td></tr>';
					
					//getting data to send to decision_finale's table
					
					//is move=true
					$is_move=1;
					
					//next level
					  $nextLevel=null;
					  $model_next_l=new Levels;
					   $result=$model_next_l->getNextLevel($this->idLevel);
					   if((isset($result))&&($result!=""))
						  { $r=$result->getData();
							 foreach($r as $l)
								$nextLevel=$l->id;
						  }
					   else
						 $nextLevel= $this->idLevel;	
					//comment
					$comment=null;
					if(isset($this->comment[$display_comment]))
					   $comment=$this->comment[$display_comment];		
											
					$this->data_EYD[$display_comment]=array($this->student_id, $acad, $average, $mension, $comment, $is_move, $this->idLevel, $nextLevel);
					Yii::app()->session['Temp_value'] =$this->data_EYD;
					
					                               
		                          $couleur++; 
			                   if($couleur===3) //reinitialisation
									$couleur=1;                                    		                   
							}
						else //$average < $passing_grad  : failed
						   {  $total_find--;
						      
						      //getting data for failed stud
						     
						      
						      $failed_array[]= array($student,$gender,$average, $this->student_id);
							  
						    }
							
                    }//end of checking if mention  already set for a specific stud.			 
	                                     
					 
	             } //end 'foreach person	
  $display_comment=-1;

 // close table tag for admitted
  if($admitted_stud==1)	
     echo '</table></div>';

		
					         
					        
		 
		 
		 //******DISPLAY FAILED STUDENTS*****/
$display_comment2=-1; //for failed stud
					   		 
 if(isset($failed_array))	 
   { 
   	
   	          //********* display data stat of faill **********/				     
	         
													if($tot_stud!=0)
													  {	
														$female_faill_po=round(($female_faill*100)/$tot_stud,2);
														$male_faill_po=round(($male_faill*100)/$tot_stud,2);
														
														$tot_faill=$female_faill+$male_faill;
														$tot_faill_po=round(($tot_faill*100)/$tot_stud,2);
															}		 
																 
															echo '<div class="all_gender">
														<!--	<div class="total_student">'. Yii::t('app','Total Students').'<div>'.$tot_stud.'</div></div>   -->
															
															<div class="gender">'.Yii::t('app','').'<div class="female">'.Yii::t('app',' Faill(F)').'<br/>'.$female_faill.' : '.$female_faill_po.'%</div><div class="male">'.Yii::t('app',' Faill(M)').'<br/>'.$male_faill.' : '.$male_faill_po.'%</div><div class="male">'.Yii::t('app',' Total Faill').'<br/>'.$tot_faill.' : '.$tot_faill_po.'%</div></div>
															
															</div>
											             
												<div style="clear:both"></div>	';
	                                         //********* end of displaying data stat of faill **********/
   	
   	
   	
   	echo Yii::t('app','FAILLED STUDENT(S)');    

	 foreach($failed_array as $f_stud)
				  {//$failed_array[0...5]
                      				                        if($failed_stud==0)			 
																  {	$failed_stud=1;
																     	
																	  echo '<div class=\'dataGrid2\' id=\'page2\'><table style=\'width:100%;\'>
																	<tr style=\'color: #FFF; font-size: 0.9em; background: -webkit-linear-gradient(#85bad8 30%, #4c99c5 100%);
																	background: -o-linear-gradient(#85bad8 30%, #4c99c5 100%);
																	background: -moz-linear-gradient(#85bad8 30%, #4c99c5 100%); 
																	background: -ms-linear-gradient(#85bad8 30%, #4c99c5 100%);
																	background: linear-gradient(#85bad8 30%, #4c99c5 100%);\'>

																									  <td  style='.$style_td.'><b>'.Yii::t('app','Name').'</b></td><td  style='.$style_td.'><b>'.Yii::t('app','Gender').'</b></td><td style='.$style_td.'><b> '.Yii::t('app','Average ').'</b></td><td style='.$style_td.'><b>'.Yii::t('app','Mention').' </b></td><td style='.$style_td.'><b>'.Yii::t('app','Comment').' </b></td>';
																			
																				echo '<td  style="text-align:center"><b>'.Yii::t('app','Check All').'</b><br/>';
																											if($this->isCheck2==1) echo '<input type="checkbox" name="check_all2" checked="checked" onclick="this.form.submit();">';
																											elseif($this->isCheck2==0) echo '<input type="checkbox" name="check_all2" onclick="this.form.submit();">';
																								
																				echo '</td>';                                  
																	 echo '</tr>';
																  
																  }
																  
													     Yii::app()->session['isPresent2']=1;			  
																  
																   $display_comment2++;
															//pour la couleur des lignes
														       $flag_color =null; 
																
                                                                if($couleur===1)  //choix de couleur
                                                                {
																    $style_tr='\'font-size: 0.9em; background: #E5F1F4; \'';
                                                                                                                                    if($flag_color==true)
                                                                                                                                        $style_tr='\'font-size: 0.9em;background: #E5F1F4; color: #FF0000; \'';
                                                                                                                                        
                                                                }
															    elseif($couleur===2)
                                                                                                                            {
																    $style_tr='\'font-size: 0.9em; background: #F8F8F8; \'';
                                                                                                                                    if($flag_color==true)
                                                                                                                                        $style_tr='\'font-size: 0.9em; background: #F8F8F8; color: #FF0000; \'';
                                                                                                                            }                           
														
															 
															 //moyenne <= note de passing 
															 //afficher les echoues //FAILED STUD
															     
	                                                               //body of the table
																   
                                                                $mension2=Yii::t('app','FAILLED'); 
                                                                $flag_color = false;
																$this->comment2 = Yii::app()->session['comment2_admit'];
																									
																echo '<tr style='.$style_tr.'><td style='.$style_td.'>'.$f_stud[0].'</td><td style='.$style_td.'>'.$f_stud[1].'</td><td style='.$style_td.'>'.$f_stud[2].'</td><td>'.$mension2.'</td>
																<td > <div style="margin-right: 6px;">
																		<textarea name="t_comment2['.$display_comment2.']" id="t_comment2['.$display_comment2.']"  rows="1" cols="30" style="width:90%; height:27px;" >'; if((isset($this->comment2[$display_comment2]))&&($this->comment2[$display_comment2]!="")) echo $this->comment2[$display_comment2]; echo' </textarea>
																		
																</div></td><td style="width:20px;">';
																if($this->isCheck2==1) 
																	 echo '<input type="checkbox" name="olone_check2[]" value="'.$display_comment2.'" checked="checked" >';
																 elseif($this->isCheck2==0) 
																	echo '<input type="checkbox" name="olone_check2[]" value="'.$display_comment2.'"  >';
																echo '</td></tr>';
																
																
																//getting data to send to decision_finale's table
																
																//is move=true
																$is_move2=0;
																
																//next level
																  $nextLevel2=null;
																  	
																//comment
																$comment2=null;
																if(isset($this->comment2[$display_comment2]))
																   $comment2=$this->comment2[$display_comment2];		
														 								
																$this->data_EYD2[$display_comment2]=array($f_stud[3], $acad, $f_stud[2], $mension2, $comment2, $is_move2, $this->idLevel, $nextLevel2);
																Yii::app()->session['Temp_value2'] =$this->data_EYD2;
																
																					
                                                                //$flag_color = true;
															  
															  
															
															  
													$couleur++; 
	                                                            if($couleur===3) //reinitialisation
																    $couleur=1;
																	
																	
																	
					     }	//end for each failed_array
						 $display_comment2=-1;
						 
						  // close table tag for failed
														 if($failed_stud==1)	
                                                              echo '</table></div>';
															  
		}
  
	echo '<div class="clear" ></div>';
		echo '<div class="" style=" width:100%; margin-top:10px; margin-bottom:-30px;  color:red;">';
			 
			 //check if all stud are moved
		        $temp = $this->tot_stud-$total_find;
						   if($temp<=0)
						    {
					          $this->messageDecisionDone=true;
											
		                     }
							
					  
			     if(($temp<=0)||($lastReportcardNotSet))
						{
						      
							  //display default header 
					       $style_td='\'border-right: 1px solid #FFF; \'';
										 
								echo '<div class=\'dataGrid\' id=\'page\'><table style=\'width:100%;\'>
							<tr style=\'color: #FFF; font-size: 0.9em; background: -webkit-linear-gradient(#85bad8 30%, #4c99c5 100%);
							background: -o-linear-gradient(#85bad8 30%, #4c99c5 100%);
							background: -moz-linear-gradient(#85bad8 30%, #4c99c5 100%); 
							background: -ms-linear-gradient(#85bad8 30%, #4c99c5 100%);
							background: linear-gradient(#85bad8 30%, #4c99c5 100%);\'>
			
											      <td  style='.$style_td.'><b>'.Yii::t('app','Name').'</b></td><td  style='.$style_td.'><b>'.Yii::t('app','Gender').'</b></td><td style='.$style_td.'><b> '.Yii::t('app','Average ').'</b></td><td style='.$style_td.'><b>'.Yii::t('app','Mention').' </b></td><td style='.$style_td.'><b>'.Yii::t('app','Comment').' </b></td>';
             			
							                                  
							 echo '</tr>
							        </table></div>';
							
							 
							  echo '<div class="" style=" width:45%; margin-top:10px; margin-bottom:-30px;  color:red;">';
					       if($this->messageDecisionDone)   
					          echo Yii::t('app','Decision is already taken.');
					       elseif($lastReportcardNotSet)
					            echo Yii::t('app','Please make the Last Reportcard for this room, to be able to take decision.');
					             
					          
					           
					           echo '</div>  <br/><br/>';
					
							  echo '<input type="hidden" name="t_comment[]" id="t_comment[]" value="">';
							  
						   						
		                    }
		                      
			//Submit button
		    if(!$this->messageDecisionDone)
	  		 { echo CHtml::submitButton(Yii::t('app', 'Execute Decision '),array('name'=>'execute')); 
	          
			 
			 }
			 
		  echo '</div> ';																			
																	
	  
	
	  
			  
		         }
		        else  
		           {  //no students enrolled this room
		           	    //display default header 
					       echo '<div class="clear" ></div>';
										 
                             $style_td='\'border-right: 1px solid #FFF; \'';
				 											echo '<div style=" width:100%; margin-top:10px; margin-bottom:-30px;  color:red;"><table style=\'width:100%;\'>
				<tr style=\'color: #FFF; font-size: 0.9em; background: -webkit-linear-gradient(#85bad8 30%, #4c99c5 100%);
				background: -o-linear-gradient(#85bad8 30%, #4c99c5 100%);
				background: -moz-linear-gradient(#85bad8 30%, #4c99c5 100%); 
				background: -ms-linear-gradient(#85bad8 30%, #4c99c5 100%);
				background: linear-gradient(#85bad8 30%, #4c99c5 100%);\'>

											      <td  style='.$style_td.'><b>'.Yii::t('app','Name').'</b></td><td  style='.$style_td.'><b>'.Yii::t('app','Gender').'</b></td><td style='.$style_td.'><b> '.Yii::t('app','Average ').'</b></td><td style='.$style_td.'><b>'.Yii::t('app','Mention').' </b></td><td style='.$style_td.'><b>'.Yii::t('app','Comment').' </b></td>';
             			
					  		                                  
				 echo '</tr>
				        </table></div>';
							  
							 
							  echo '<div class="" style=" width:45%; margin-top:40px; margin-bottom:-30px;  color:red;">';
					       
					          echo Yii::t('app','No enrolled students for this room.');
					         
					              
					           echo '</div>  <br/><br/>';
					
							  echo '<input type="hidden" name="t_comment[]" id="t_comment[]" value="">';

		           	}
		           	
		           	
	  
           }
         else  //no passing grade set
           {
           	    //display default header 
					       echo '<div class="clear" ></div>';
										 
                             $style_td='\'border-right: 1px solid #FFF; \'';
				 											echo '<div style=" width:100%; margin-top:10px; margin-bottom:-30px;  color:red;"><table style=\'width:100%;\'>
				<tr style=\'color: #FFF; font-size: 0.9em; background: -webkit-linear-gradient(#85bad8 30%, #4c99c5 100%);
				background: -o-linear-gradient(#85bad8 30%, #4c99c5 100%);
				background: -moz-linear-gradient(#85bad8 30%, #4c99c5 100%); 
				background: -ms-linear-gradient(#85bad8 30%, #4c99c5 100%);
				background: linear-gradient(#85bad8 30%, #4c99c5 100%);\'>

											      <td  style='.$style_td.'><b>'.Yii::t('app','Name').'</b></td><td  style='.$style_td.'><b>'.Yii::t('app','Gender').'</b></td><td style='.$style_td.'><b> '.Yii::t('app','Average ').'</b></td><td style='.$style_td.'><b>'.Yii::t('app','Mention').' </b></td><td style='.$style_td.'><b>'.Yii::t('app','Comment').' </b></td>';
             			
					  		                                  
				 echo '</tr>
				        </table></div>';
							  
							 
							  echo '<div class="" style=" width:45%; margin-top:40px; margin-bottom:-30px;  color:red;">';
					       
					          echo Yii::t('app','No passing grade set.');
					         
					              
					           echo '</div>  <br/><br/>';
					
							  echo '<input type="hidden" name="t_comment[]" id="t_comment[]" value="">';
           	}
     
	  
}
else 
		{	  
		  //display default header
       echo '<div class="clear" ></div>';
       		  
		  $style_td='\'border-right: 1px solid #FFF; \'';
							 
					echo '<div style=" width:100%; margin-top:10px; margin-bottom:-30px;  color:red;"><table style=\'width:100%;\'>
				<tr style=\'color: #FFF; font-size: 0.9em; background: -webkit-linear-gradient(#85bad8 30%, #4c99c5 100%);
				background: -o-linear-gradient(#85bad8 30%, #4c99c5 100%);
				background: -moz-linear-gradient(#85bad8 30%, #4c99c5 100%); 
				background: -ms-linear-gradient(#85bad8 30%, #4c99c5 100%);
				background: linear-gradient(#85bad8 30%, #4c99c5 100%);\'>

											      <td  style='.$style_td.'><b>'.Yii::t('app','Name').'</b></td><td  style='.$style_td.'><b>'.Yii::t('app','Gender').'</b></td><td style='.$style_td.'><b> '.Yii::t('app','Average ').'</b></td><td style='.$style_td.'><b>'.Yii::t('app','Mention').' </b></td><td style='.$style_td.'><b>'.Yii::t('app','Comment').' </b></td>';
             			
							                                  
				 echo '</tr>
				        </table></div>';
		}			
				 
				
														  

echo '</div>';	    
 
		

 ?>

  </div>
 </div>


