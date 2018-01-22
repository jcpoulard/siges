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


$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

    $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
     if($current_acad==null)
						          $condition = '';
						     else{
						     	   $condition = 'p.active IN(1,2) AND ';
						        }
$couleur=1; //
$display_name=false;
$success_mention = infoGeneralConfig('success_mention');
	  
$failure_mention = infoGeneralConfig('failure_mention'); 

$modelPersonsDecision=new Persons;			   
	
			    
   	        if($this->room_id!=0)
				{   $room=$this->getRoomName($this->room_id);
				    $level=$this->getLevel($this->idLevel);
					$section=$this->getSection($this->section_id);
					$shift=$this->getShift($this->idShift);
				}
                                $passing_grade = 0;
				if($this->room_id!=null){ 
                                 $passing_grade=$this->getPassingGrade($this->idLevel,$acad_sess); //note de passage pour la classe
                                
                                 
                                 }
			
      
	     if($passing_grade!=null) // passing grade is set for this level
	       {			 	      		      
		    //getting all stud for this room_id   		
  			$dataProvider=Persons::model()->getStudentsByRoomForReport($condition,$this->room_id, $acad_sess);
  			
				                            
				//totall etudiant
				
				$this->tot_stud=0;
				
			 $dataProvider_studentEnrolled=Rooms::model()->getStudentsEnrolled($condition,$this->room_id, $acad_sess);
			  
			  if(isset($dataProvider_studentEnrolled))
			    {  $t=$dataProvider_studentEnrolled->getData();
				   foreach($t as $tot)
				       $this->tot_stud=$tot->total_stud;
				}
			
		if($this->tot_stud!=0)	
		  {
			
			
			             
				
						//reccuperer l'id du Stud
					   $person=$dataProvider->getData();
                       $display_comment=-1; // for SUCCESSED stud
					   $admitted_stud=0;
					   $failed_stud=0;
					   $failed_array=null;
					   
					   $compt_taken_decision=0;
					   $compt_stud_to_produce_last_reportcard=0;
					   $stud_to_produce_last_reportcard='';
					   $first_time=true;					  
					   $total_find = 0;
					   			 
					  
                    foreach($person as $stud)
                      {	
						$student=$this->getStudent($stud->id );
									        
                         $mention=null;
						 $is_move_to_next_year=null;
						 $average=0;
						 // record already in decision_finale table
						 $is_mention_set = $this->checkDecisionFinale($stud->id, $acad_sess);                                                         
							
						//check if mention and/or is_move_to_next_year already set for a specific stud.(it means decision is already taken for him).	   
						 if((isset($is_mention_set))&&($is_mention_set!=null))
						   {  
							 foreach($is_mention_set as $result)
							   { $mention = $result["mention"];
							     $is_move_to_next_year = $result["is_move_to_next_year"];
							     $average = $result["general_average"];
							   }
						if(($mention==null)&&($is_move_to_next_year==null))	 
		                   {
						      $total_find++;
									  
		                    }
		                   else
		                      $compt_taken_decision++; 
		                    
						   }//end of checking if mention  already set for a specific stud.
						 else
						   {   						           
						   	   $compt_stud_to_produce_last_reportcard++;
						   	   
						   	   if($first_time)
						   	    {
						   	    	$first_time=false;
						   	    	$stud_to_produce_last_reportcard = $student;
						   	      }
						   	    else
						   	    $stud_to_produce_last_reportcard = $stud_to_produce_last_reportcard.', '.$student;
						   	  //on n'a pas encore produit  le dernier bulletin
						   	  
						    }
				  
				         }	
				   
				   
			 //check if all stud are moved
			       if($compt_stud_to_produce_last_reportcard == 0)//last reportcard set
				     { 
				     	if($compt_taken_decision==$this->tot_stud)
							$this->messageDecisionDone=true;
							         
					   }
			        else // at least 1 last reportcard not set 
					  {   
						  if(($this->tot_stud - $total_find - $compt_taken_decision) >= ($this->tot_stud/2)) 
							    $this->lastReportcardNotSet=true;
						   else
							  $display_name=true;//   fe fe denye kane pou moun sa yo 
					  }   
					  
				  
				  
				  
				  					     
												  
		       }
		     else   //no students enrolled this room
		       { 
		           $this->messageNoStud=true;
		          }

		 }
         else  //no passing grade set
           {
           	    $this->messageNoPassingGradeSet=true;     
		       
            } 
   	       
		       
		       
		       									
														      
                 
			
	
					 
                    		//error message 
	        if(($display_name)||($this->messageDecisionDone)||($this->lastReportcardNotSet)||($this->messageNoStud)||($this->messageNoPassingGradeSet))		
			      { echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:0px; ';//-20px; ';
				      echo '">';
				      
				      echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
					   <tr>
					    <td style="text-align:center;">';	
				      				      
			       }
			                 	
				   if($this->messageNoStud)
				     { 
							echo '<input type="hidden" name="t_comment[]" id="t_comment[]" value="">';
							echo '<span style="color:red;" >'.Yii::t('app','No enrolled students for this room.').'</span>'.'<br/>';
				    	echo'</td>
					    </tr>
						</table>
						</div>';
				     }
				   
				  if($this->messageNoPassingGradeSet)
				     { 
							echo '<input type="hidden" name="t_comment[]" id="t_comment[]" value="">';
							echo '<span style="color:red;" >'.Yii::t('app','No passing grade set.').'</span>'.'<br/>';
				    	echo'</td>
					    </tr>
						</table>
						</div>';

				     }


				  
				  if($this->messageDecisionDone)
				    {  echo '<span style="color:red;" >'.Yii::t('app','End year decision is already taken.').'</span>';
				       
				       echo'</td>
					    </tr>
						</table>
						</div>';

				    }
				 
				 if($this->lastReportcardNotSet)
				    {  echo '<span style="color:red;" >'.Yii::t('app','Please make the Last Reportcard for this room, to be able to take decision.').'</span>';
				       
				       echo'</td>
					    </tr>
						</table>
						</div>';

				    }
				    
				  if($display_name)
				    {  echo '<span style="color:red;" >'.Yii::t('app','Please make the Last Reportcard for: '.$stud_to_produce_last_reportcard).'</span>';
				       
				       echo'</td>
					    </tr>
						</table>
						</div>';

				    }
				    
				     

   				echo '<div style="clear:both;"></div>';
           				
			     

				
				
			   
		$style_th='"text-align:center; vertical-align:middle; background-color:#E4E9EF; border-left: 1px solid  #E4E9EF;font-size: 1em; "';//'\'border-right: 1px solid #FFF; \'';
					    $style_td='"text-align:center; vertical-align:middle; border-left: 1px solid  #E4E9EF;font-size: 1em; "';//'\'border-right: 1px solid #FFF; \'';
					     $style_td_name='"text-align:left; vertical-align:middle; font-size: 1em; "';//'\'border-right: 1px solid #FFF; \'';
					   
			
			
			
			
			
			
   if((!$this->messageDecisionDone)&&(!$this->lastReportcardNotSet)&&(!$this->messageNoStud)&&(!$this->messageNoPassingGradeSet))
	 {
	 
	 ?>
	 
	
  <div class="list_secondaire">
											

 
	 
	 <?php
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
			   

	 
	 
	 	  //********* getting data for stat  **********/	
		       if($dataProvider->getItemCount()!=0)
		   		{ 
		   			 //getting all stud for this room_id   		
  			
		   			$tot_stud =$this->tot_stud;
		   			 $person=$dataProvider->getData();
		   			 
				  foreach($person as $stud)
				     {	
                       //in decision_finale table
						 $mention=null;
						 $is_move_to_next_year=null;
						 $average=0;
						   
						 $is_mention_set = $this->checkDecisionFinale($stud->id, $acad_sess);                                                         
							
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
					 


                  					   
                    foreach($person as $stud){	
//__________________________	

                         
						$student=$this->getStudent($stud->id );
									        
                         $mention=null;
						 $is_move_to_next_year=null;
						 $average=0;
						 // record already in decision_finale table
						 $is_mention_set = $this->checkDecisionFinale($stud->id, $acad_sess);                                                         
							
						//check if mention and/or is_move_to_next_year already set for a specific stud.(it means decision is already taken for him).	   
						 if((isset($is_mention_set))&&($is_mention_set!=null))
						   {  
							 foreach($is_mention_set as $result)
							   { $mention = $result["mention"];
							     $is_move_to_next_year = $result["is_move_to_next_year"];
							     $average = $result["general_average"];
							   }
							  if(($mention==null)&&($is_move_to_next_year==null))	 
		                          {
										   $this->student_id = $stud->id;   //ID student
										   $birthday = $stud->birthday;   // student's birthday
										   $city = $stud->cities;   // where student born
										   $gender = $stud->getGenders1();   // sexe
										   
										   $city_name= $this->getCityName($city); // return the name of the city
										   //$sexe = ($gender)...;
										   
										
									       
									                        
												  
										              $display_comment++; //for SUCCESSED stud
		                                            									  
							 if($average >= $passing_grade)
							    { //moyenne >= note de passing
								                  //afficher les admis 
								                     //******DISPLAY SUCCESSED STUDENTS*****/
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
																		 
																	echo '<div class="all_gender" style="margin-right:15px; ">
																	<!--  <div class="total_student">'. Yii::t('app','Total Students').'<div>'.$tot_stud.'</div></div>  -->
																	
																	<div class="gender">'.Yii::t('app','').'<div class="female">'.Yii::t('app',' Success(F)').'<br/>'.$female_success.' : '.$female_success_po.'%</div><div class="male">'.Yii::t('app',' Success(M)').'<br/>'.$male_success.' : '.$male_success_po.'%</div><div class="male">'.Yii::t('app',' Total Success').'<br/>'.$tot_suc.' : '.$tot_suc_po.'%</div></div>
																	
																	</div>
													            <div style="padding-top:30px;"><b>'.Yii::t('app','SUCCESSED STUDENT(S)').'</b></div> 
														<div style="clear:both"></div>	';
			                                         //********* end of displaying data stat OF SUCCESS **********/
			                                         
			                                                
			                                                
		
																	 
															echo '<div class=\'dataGrid\' id=\'page\'>
															<table  style="  width:100%; background-color:#EFF4F8; color: #1E65A4;">
														 <thead class="" >
														      <tr style="background-color:#E4E9EF;">
		
																						  <th  style='.$style_th.'><b>'.Yii::t('app','Name').'</b></th><th  style='.$style_th.'><b>'.Yii::t('app','Gender').'</b></th><th style='.$style_th.'><b> '.Yii::t('app','General Average').' </b></th><th style='.$style_th.'><b>'.Yii::t('app','Mention').' </b></th><th style='.$style_th.'><b>'.Yii::t('app','Comment').' </b></th>';
															 	
																	echo '<th  style='.$style_th.'><b>'.Yii::t('app','Check All').'</b><br/>';
																								if($this->isCheck==1) echo '<input type="checkbox" name="check_all" checked="checked" onclick="this.form.submit();">';
																								elseif($this->isCheck==0) echo '<input type="checkbox" name="check_all" onclick="this.form.submit();">';
																					
																	echo '</th>';                                  
														 echo '</tr>
														 
														 </thead >
			   	
			   										<tbody class="">';
		                                             }												 
																
																//pour la couleur des lignes
																       $flag_color =null; 
																		
		                                                                if($couleur===1)  //choix de couleur
		                                                                {
																		    $style_tr='\'font-size: 1em; background-color: #F0F0F0; \'';
		                                                                     
		                                                                     if($flag_color==true)
		                                                                       $style_tr='\'font-size: 1em; background-color: #F0F0F0; color: #FF0000; \'';
		                                                                                                                                        
		                                                                }
																	    elseif($couleur===2)
		                                                                 {
																		    $style_tr='\'font-size: 1em; background-color: #FAFAFA; \'';
		                                                                                                                                    
		                                                                     if($flag_color==true)
		                                                                       $style_tr='\'font-size: 1em; background-color: #FAFAFA; color: #FF0000; \'';
		                                                                   }
													
		                                                               
		                                                               
		                                                                $flag_color = false;
											$this->comment = Yii::app()->session['comment_admit'];
																	
		                                                                     echo '<tr style='.$style_tr.'><td style='.$style_td_name.'>'.$student.'</td><td style='.$style_td.'>'.$gender.'</td><td style='.$style_td.'>'. $average.' </td><td style='.$style_td.'>'.$success_mention.'</td>
							<td style='.$style_td.'> '; 
													if((isset($this->comment[$display_comment]))&&($this->comment[$display_comment]!=""))
													  echo $form->dropDownList($modelPersonsDecision,'decision_finale',$this->loadSuccessDecision(), array('options' => array($this->comment[$display_comment]=>array('selected'=>true)), 'name'=>'t_comment['.$display_comment.']')  );
													else
													 echo $form->dropDownList($modelPersonsDecision,'decision_finale',$this->loadSuccessDecision(), array('name'=>'t_comment['.$display_comment.']')); echo '<!-- <div style="margin-right: 6px;">
									<textarea name="t_comment['.$display_comment.']" id="t_comment['.$display_comment.']"  rows="1" cols="20" style="width:90%; height:20px;" >'; if((isset($this->comment[$display_comment]))&&($this->comment[$display_comment]!="")) echo $this->comment[$display_comment]; echo' </textarea>
							        
							</div> --></td><td style="width:100px;text-align:center; vertical-align:middle;">';
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
							   //else
								 //$nextLevel= $this->idLevel;	
							//comment
							$comment=null;
							if(isset($this->comment[$display_comment]))
							   $comment=$this->comment[$display_comment];		
													
							$this->data_EYD[$display_comment]=array($this->student_id, $acad_sess, $average, $success_mention, $comment, $is_move, $this->idLevel, $nextLevel);
							Yii::app()->session['Temp_value'] =$this->data_EYD;
							
							                               
				                          $couleur++; 
					                   if($couleur===3) //reinitialisation
											$couleur=1;                                    		                   
									}
								else //$average < $passing_grad  : failed
								   {  
								      
								      //getting data for failed stud
								     
								      
								      $failed_array[]= array($student,$gender,$average, $this->student_id);
									  
								    }
									
		                    }
		                   
		                    
						   }//end of checking if mention  already set for a specific stud.
					
						 
						        
									 
	                                     
					 
	             } //end 'foreach person
	             	
  $display_comment=-1;

 // close table tag for SUCCESSED
  if($admitted_stud==1)	
     echo ' </tbody></table></div>';

		
					         
					        
		 
		 
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
																 
															echo '<div class="all_gender" style="margin-right:15px; ">
														<!--	<div class="total_student">'. Yii::t('app','Total Students').'<div>'.$tot_stud.'</div></div>   -->
															
															<div class="gender">'.Yii::t('app','').'<div class="female">'.Yii::t('app',' Faill(F)').'<br/>'.$female_faill.' : '.$female_faill_po.'%</div><div class="male">'.Yii::t('app',' Faill(M)').'<br/>'.$male_faill.' : '.$male_faill_po.'%</div><div class="male">'.Yii::t('app',' Total Faill').'<br/>'.$tot_faill.' : '.$tot_faill_po.'%</div></div>
															
															</div>
											             <div style="padding-top:30px;"><b>'.Yii::t('app','FAILLED STUDENT(S)').'</b></div>
												<div style="clear:both"></div>	';
	                                         //********* end of displaying data stat of faill **********/
   	
   	
   	
   //echo Yii::t('app','FAILLED STUDENT(S)');    

	 foreach($failed_array as $f_stud)
				  {//$failed_array[0...5]
                      				                        if($failed_stud==0)			 
																  {	$failed_stud=1;
																     	
																	  echo '<div class=\'dataGrid2\' id=\'page2\'>
																	  <table  style="  width:100%; background-color:#EFF4F8; color: #1E65A4;">
												 <thead class="" >
												      <tr style="background-color:#E4E9EF;">

																				  <th  style='.$style_th.'><b>'.Yii::t('app','Name').'</b></th><th  style='.$style_th.'><b>'.Yii::t('app','Gender').'</b></th><th style='.$style_th.'><b> '.Yii::t('app','Average ').'</b></th><th style='.$style_th.'><b>'.Yii::t('app','Mention').' </b></th><th style='.$style_th.'><b>'.Yii::t('app','Comment').' </b></th>';
													 	
															echo '<th  style='.$style_th.'><b>'.Yii::t('app','Check All').'</b><br/>';
																						if($this->isCheck2==1) echo '<input type="checkbox" name="check_all2" checked="checked" onclick="this.form.submit();">';
																						elseif($this->isCheck2==0) echo '<input type="checkbox" name="check_all2" onclick="this.form.submit();">';
																			
															echo '</th>';                                  
												 echo '</tr>
												 
												 </thead >
	   	
	   										<tbody class="">';		}
																  
													     Yii::app()->session['isPresent2']=1;			  
																  
																   $display_comment2++;
															//pour la couleur des lignes
														       $flag_color =null; 
																
                                                                if($couleur===1)  //choix de couleur
                                                                {
																    $style_tr='\'font-size: 1em; background-color: #F0F0F0; \'';
                                                                     
                                                                     if($flag_color==true)
                                                                       $style_tr='\'font-size: 1em; background-color: #F0F0F0; color: #FF0000; \'';
                                                                                                                                        
                                                                }
															    elseif($couleur===2)
                                                                 {
																    $style_tr='\'font-size: 1em; background-color: #FAFAFA; \'';
                                                                                                                                    
                                                                     if($flag_color==true)
                                                                       $style_tr='\'font-size: 1em; background-color: #FAFAFA; color: #FF0000; \'';
                                                                   }
                        
														
															 
															 //moyenne <= note de passing 
															 //afficher les echoues //FAILED STUD
															     
	                                                               //body of the table
																   
                                                               
                                                                 
                                                                $flag_color = false;
																$this->comment2 = Yii::app()->session['comment2_admit'];
																									
																echo '<tr style='.$style_tr.'><td style='.$style_td_name.'>'.$f_stud[0].'</td><td style='.$style_td.'>'.$f_stud[1].'</td><td style='.$style_td.'>'.$f_stud[2].'</td><td style='.$style_td.'>'.$failure_mention.'</td>
																<td style='.$style_td.'>'; 
											if((isset($this->comment2[$display_comment2]))&&($this->comment2[$display_comment2]!=""))
											  echo $form->dropDownList($modelPersonsDecision,'decision_finale',$this->loadFailureDecision(), array('options' => array($this->comment2[$display_comment2]=>array('selected'=>true)), 'name'=>'t_comment2['.$display_comment2.']')  );
											else
											 echo $form->dropDownList($modelPersonsDecision,'decision_finale',$this->loadFailureDecision(), array('name'=>'t_comment2['.$display_comment2.']')); echo '<!-- <div style="margin-right: 6px;">
																		<textarea name="t_comment2['.$display_comment2.']" id="t_comment2['.$display_comment2.']"  rows="1" cols="20" style="width:90%; height:20px;" >'; if((isset($this->comment2[$display_comment2]))&&($this->comment2[$display_comment2]!="")) echo $this->comment2[$display_comment2]; echo' </textarea>
																		
																</div>--> </td><td style="width:100px;text-align:center; vertical-align:middle;">';
																if($this->isCheck2==1) 
																	 echo '<input type="checkbox" name="olone_check2[]" value="'.$display_comment2.'" checked="checked" >';
																 elseif($this->isCheck2==0) 
																	echo '<input type="checkbox" name="olone_check2[]" value="'.$display_comment2.'"  >';
																echo '</td></tr>';
																
																
																//getting data to send to decision_finale's table
																
																//is move=true
																$is_move2=0;
																
																//next level
																  $nextLevel2 = $this->idLevel;
																  	
																//comment
																$comment2=null;
																if(isset($this->comment2[$display_comment2]))
																   $comment2=$this->comment2[$display_comment2];		
														 								
																$this->data_EYD2[$display_comment2]=array($f_stud[3], $acad_sess, $f_stud[2], $failure_mention, $comment2, $is_move2, $this->idLevel, $nextLevel2);
																Yii::app()->session['Temp_value2'] =$this->data_EYD2;
																
																					
                                                                //$flag_color = true;
															  
															  
															
															  
													$couleur++; 
	                                                            if($couleur===3) //reinitialisation
																    $couleur=1;
																	
																	
																	
					     }	//end for each failed_array
						 $display_comment2=-1;
						 
						  // close table tag for failed
														 if($failed_stud==1)	
                                                              echo ' </tbody></table></div>';
															  
		}
		
		
	?>  
			</div>	





<?php
	 	
	   }	  		
			
		?>	
			
  
  