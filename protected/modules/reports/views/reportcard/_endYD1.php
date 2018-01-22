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

$menfp = null;

$model_menfp=isLevelExamenMenfp($this->idLevel,$acad_sess);
			      
			      if($model_menfp !=null)
			        $menfp = $model_menfp['id'];
			      


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
				    {  echo '<span style="color:red;" >'.Yii::t('app','Please make the Last Reportcard for: ').$stud_to_produce_last_reportcard.'</span>';
				       
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
	          $female_ =0;
			  $male_ =0;
			  $tot_stud =0;
			  $tot_=0;
			  $female_po=0;
			  $male_po=0;
													
			   $tot_po=0;
			   
			   //Extract average base
			   $average_base = infoGeneralConfig('average_base');
			   
			   $menfp_passing_grade = round( ($average_base/2),2);
			   
			   
			  
			   

	 
	 
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
						   
						  
						  $gender2 = $stud->gender;    // sexe
								   
							   if($gender2==1)
					              {   //female
					                   $female_ =$female_ +1;
					              }
					            elseif($gender2==0)
					               {   //male
					                   $male_ =$male_ +1;
					                }
					                              					                                 
                                 
						     
					          }
						                 
						                 
						                 
					     }
					 
					 //********* end of getting data for stat  **********/
					 

                           
								                  		Yii::app()->session['isPresent']=1;	
															
													 //********* display data stat of success **********/				     
			         
															if($tot_stud!=0)
															  {	
																$female_po=round(($female_*100)/$tot_stud,2);
																$male_po=round(($male_*100)/$tot_stud,2);
																
																$tot_=$female_+$male_;
																$tot_po=round(($tot_*100)/$tot_stud,2);
																	}		 
																		 
																	echo '<div class="all_gender" style="margin-right:15px; margin-bottom:-30px;">
																	<!--  <div class="total_student">'. Yii::t('app','Total Students').'<div>'.$tot_stud.'</div></div>  -->
																	
																	<div class="gender">'.Yii::t('app','').'<div class="female">'.Yii::t('app','Female').'<br/>'.$female_.' : '.$female_po.'%</div><div class="male">'.Yii::t('app','Male').'<br/>'.$male_.' : '.$male_po.'%</div><div class="male">'.Yii::t('app','Total').'<br/>'.$tot_.' : '.$tot_po.'%</div></div>
																	
																	</div>';
			                                         //********* end of displaying data stat OF SUCCESS **********/
			                                         
			     echo '                                    <div class="col-1">
                   <label id="resp_form" style="margin-left:40px; margin-top:30px;" > ';
                    
                   
                    echo $form->radioButtonList($model,'mention',
												    array(0=>Yii::t('app','SUCCESSED STUDENT(S)'),
												          1=>Yii::t('app','FAILLED STUDENT(S)') 
												          ),
												    array(
												        'onclick'=>"this.form.submit()",
												        'template'=>'{input}{label}',
												        'separator'=>'',
												        'labelOptions'=>array(
												            'style'=> '
												                
												                width: auto;
												                float: left;
												                margin-left:-10%;
												                margin-top:1%;
												            '),
												          'style'=>'float:left; margin-top:3%;',
												          )                              
												      );  
												                   
                   
              echo '           
                   </label>
               </div> ';

			                                     
			                                       echo '<div class=\'dataGrid\' id=\'page\'>
															<table  style="  width:100%; background-color:#EFF4F8; color: #1E65A4;">
														 <thead class="" >
														      <tr style="background-color:#E4E9EF;">
		
																						  <th  style='.$style_th.'><b>'.Yii::t('app','Name').'</b></th><th  style='.$style_th.'><b>'.Yii::t('app','Gender').'</b></th><th style='.$style_th.'><b> '.Yii::t('app','General Average').' </b></th>';
	
	if($menfp!=null)
	 echo '<th style='.$style_th.'><b>'.Yii::t('app','MENFP Average').' </b></th>';
	 
	echo '<th style='.$style_th.'><b>'.Yii::t('app','Comment').' </b></th>';
															 	
																	echo '<th  style='.$style_th.'><b>'.Yii::t('app','Check All').'</b><br/>';
																								if($this->isCheck==1) echo '<input type="checkbox" name="check_all" checked="checked" onclick="this.form.submit();">';
																								elseif($this->isCheck==0) echo '<input type="checkbox" name="check_all" onclick="this.form.submit();">';
																					
																	echo '</th>';                                  
														 echo '</tr>
														 
														 </thead >
			   	
			   										<tbody class="">';
			                                         


                  					   
                    foreach($person as $stud){	
//__________________________	

                         
						$student=$this->getStudent($stud->id );
									        
                         $mention=null;
						 $is_move_to_next_year=null;
						 $average=0;
						 $menfp_average=0;
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
									if($menfp!=null)
	                                 { 
										 $menfp_data = MenfpDecision::model()->checkDecisionMenfp($stud->id, $acad_sess);
										 foreach($menfp_data as $menfp_d)
										   {
										   	    $menfp_average = $menfp_d['average'];
										   	}
	                                 }
										 
										   $this->student_id = $stud->id;   //ID student
										   $birthday = $stud->birthday;   // student's birthday
										   $city = $stud->cities;   // where student born
										   $gender = $stud->getGenders1();   // sexe
										   
										   $city_name= $this->getCityName($city); // return the name of the city
										   //$sexe = ($gender)...;
										   
										
									             
												  
										              $display_comment++; //for SUCCESSED stud
		                                            									  
							 			               
							 			               
		                                             												 
																
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
																	
		                                                                     echo '<tr style='.$style_tr.'><td style='.$style_td_name.'>'.$student.'</td><td style='.$style_td.'>'.$gender.'</td><td style='.$style_td.'>';
		                                                             if($average < $passing_grade)
		                                                               echo '<divclass="" style="color:red;">'.$average.'</div>';
		                                                             else
		                                                               echo $average;    
		                                                                    
		                                                             
		                                                             echo ' </td>';
		                                                             
		                                                             if($menfp!=null)
	                                                                  {  echo ' <td style='.$style_td.'>';
		                                                             
				                                                             if($menfp_average < $menfp_passing_grade)
				                                                               echo '<divclass="" style="color:red;">'.$menfp_average.'</div>';
				                                                             else
				                                                               echo $menfp_average;
		                                                                 echo '</td>';
	                                                                  }
	                                                                  
		                                                             echo '<td style='.$style_td.'> '; 
		                                                             
													if($model->mention=='')
													   echo $form->dropDownList($modelPersonsDecision,'decision_finale',array(), array('name'=>'t_comment['.$display_comment.']'));
													elseif($model->mention==0)
													 {
														if((isset($this->comment[$display_comment]))&&($this->comment[$display_comment]!=""))
														  echo $form->dropDownList($modelPersonsDecision,'decision_finale',$this->loadSuccessDecision(), array('options' => array($this->comment[$display_comment]=>array('selected'=>true)), 'name'=>'t_comment['.$display_comment.']')  );
														else
														 echo $form->dropDownList($modelPersonsDecision,'decision_finale',$this->loadSuccessDecision(), array('name'=>'t_comment['.$display_comment.']')); 
													 }
													elseif($model->mention==1)
													 {
													 	if((isset($this->comment[$display_comment]))&&($this->comment[$display_comment]!=""))
														  echo $form->dropDownList($modelPersonsDecision,'decision_finale',$this->loadFailureDecision(), array('options' => array($this->comment[$display_comment]=>array('selected'=>true)), 'name'=>'t_comment['.$display_comment.']')  );
														else
														 echo $form->dropDownList($modelPersonsDecision,'decision_finale',$this->loadFailureDecision(), array('name'=>'t_comment['.$display_comment.']')); 
													 
													   }
														 echo '<!-- <div style="margin-right: 6px;">
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
							   else
								 $nextLevel= $this->idLevel;	
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
		                   
		                    
						   }//end of checking if mention  already set for a specific stud.
					
						 
						        
									 
	                                     
					 
	             } //end 'foreach person
	             	
  $display_comment=-1;

 // close table tag for SUCCESSED
  
     echo ' </tbody></table></div>';

		

		
		
	?>  
			</div>	





<?php
	 	
	   }	  		
			
			
			
  		
			
			
			?>
			
			
			
	
	
	