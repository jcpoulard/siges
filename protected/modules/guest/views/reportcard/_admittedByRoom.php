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
				  
				  if(isset($_GET['ev'])) $this->evaluation_id=$_GET['ev'];
				  else{$eval = Yii::app()->session['EvaluationByYear_admit'];
				  $this->evaluation_id=$eval;}
				  
				  if(isset($_GET['stud'])) $this->student_id=$_GET['stud'];
				 
				  				 
                 if(isset($_GET['tot'])) $this->tot_stud=$_GET['tot'];
				 else{$tot = Yii::app()->session['tot_stud_admit'];
				  }

		 
 
?>



<div style="width:70%; padding:0px;">
			 
     		
	<div class="left" style="padding:0px;">			
					 
		    <!--evaluation-->
			<div class="left" style="margin-right:10px;">
			<label for="Evaluation_name"><?php echo Yii::t('app','Evaluation Period'); ?></label><?php //echo $form->labelEx($model,'Evaluation Period'); ?>
			           <?php 
					
					         $modelEvaluation= new EvaluationByYear();
							    if(isset($this->evaluation_id))
							       echo $form->dropDownList($modelEvaluation,'evaluation',$this->loadEvaluation(), array('onchange'=> 'submit()','options' => array($this->evaluation_id=>array('selected'=>true)))); 
							    else
								  { 
									echo $form->dropDownList($modelEvaluation,'evaluation',$this->loadEvaluation(), array('onchange'=> 'submit()')); 
						           }					      
						  
						echo $form->error($modelEvaluation,'evaluation');  
						  						
					   ?>
				</div>
			
			
	</div>		
	
	<div style="padding:0px;">			
			<!--Shift(vacation)-->
        <div class="left">
		
			<?php $modelShift = new Shifts;
			echo $form->labelEx($modelShift,Yii::t('app','Shift'));?>
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
								       echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('options' => array(($default_vacation->id)=>array('selected'=>true)),'onchange'=> 'submit()' )); 
								    else
								       echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('onchange'=> 'submit()' )); 
								}
							
						echo $form->error($modelShift,'shift_name'); 
						
					
					  ?>
				</div>
			 
		    <!--section(liee au Shift choisi)-->
			<div class="left" style="margin-left:10px;">
			<?php $modelSection = new Sections;
			                   echo $form->labelEx($modelSection,Yii::t('app','Section')); ?>
			           <?php 
					
					    
							    if(isset($this->section_id))
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
					 
					   
						if(isset($this->idLevel))
							    echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevelByIdShiftSectionId($this->idShift,$this->section_id,$acad), array('options' => array($this->idLevel=>array('selected'=>true)),'onchange'=> 'submit()', )); 
							 else
								{ $this->idLevel=0;
								$this->room_id=0;
								  echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevelByIdShiftSectionId($this->idShift,$this->section_id,$acad), array('onchange'=> 'submit()' )); 
					              
							      }
						echo $form->error($modelLevelPerson,'level'); 
					 
					  ?>
				</div>
			
			<!--room-->
			<div class="left" style="margin-left:10px;">
			     <?php  $modelRoom = new Rooms;
			                     echo $form->labelEx($modelRoom,Yii::t('app','Room')); ?>
			          <?php 
					
					
						    
							  
							  if(isset($this->room_id))
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
			     
				 
					
				 //error message
	    if(($this->messageEvaluation_id_admit))
	        { echo '<div class="" style=" width:45%; margin-top:10px; margin-bottom:10px; background-color:#F8F8c9; ';		
			      if(($this->messageEvaluation_id_admit))
				     echo 'color:red;">';
				
				   if($this->messageEvaluation_id_admit)
				      echo Yii::t('app','Please fill the Evaluation Period field.<br/>');
				  
					
					
           echo '</div>';
	        }

					
				
			   $person= new Persons;
			   $modelacademicP = new AcademicPeriods;
			   $passing_grade = 0;
			   $noPassingGrade=false;
			   
			   
if((isset($this->room_id))&&($this->room_id!=""))
   { if((isset($this->evaluation_id))&&($this->evaluation_id!=""))
      {
	           if($this->room_id!=0)
				{  $room=$this->getRoomName($this->room_id);
				    $level=$this->getLevel($this->idLevel);
					$section=$this->getSection($this->section_id);
					$shift=$this->getShift($this->idShift);
				}
                                
				if($this->room_id!=null){
				
                                 $passing_grade=$this->getPassingGrade($this->idLevel,$acad); //note de passage pour la classe
                               
                                 
                                 }
			
			
		   $female_success =0;
		   $male_success =0;
		   $tot_stud =0;
		   $tot_suc=0;
		   $female_success_po=0;
			$male_success_po=0;
			
			$tot_suc_po=0;
			
			
		   
		if($passing_grade!=null) // passing grade is set for this level
	     {	$noPassingGrade=false;		 	      		      
		  //total students
		   $dataProvider_s2=Persons::model()->searchStudentsForGrades($this->idShift,$this->section_id,$this->idLevel,$this->room_id,$acad);
					  
		   	  if($dataProvider_s2->getItemCount()!=0)
		   		{ 
		   			//total students
		   			$tot_stud =$dataProvider_s2->getItemCount();
		   			
				  $person_s2=$dataProvider_s2->getData();
																 								   
						foreach($person_s2 as $stud2)
						  { 
						  	 $studentID = $stud2->id;   //ID student
						     $gender2 = $stud2->getGenders1();   // sexe
						     $gender = $stud2->gender;   // sexe
						     
							 $dataProvider_s2 = $this->getStudentAverageInfo($studentID,$this->room_id,$this->idLevel, $this->idShift, $this->section_id,$this->evaluation_id,$acad);
							 
						     
						     if($dataProvider_s2[2]>=$passing_grade)
						       { 
                                   
                                   if($gender==1)
                                    {   //female
                                      	$female_success =$female_success +1;
                                    }
                                   elseif($gender==0)
                                     {   //male
                                       	$male_success =$male_success +1;
                                     }
                                }
                              
                                 
						     
					      }
						  
					 }
		if($tot_stud!=0)
		  {	
			$female_success_po=round(($female_success*100)/$tot_stud,2);
			$male_success_po=round(($male_success*100)/$tot_stud,2);
			
			$tot_suc=$female_success+$male_success;
			$tot_suc_po=round(($tot_suc*100)/$tot_stud,2);
				}		 
					 
				echo '<div class="all_gender" style="margin-bottom:-20px; ">
				<div class="total_student">'. Yii::t('app','Total Students').'<div>'.$tot_stud.'</div></div>
				
				<div class="gender">'.Yii::t('app','').'<div class="female">'.Yii::t('app',' Success(F)').'<br/>'.$female_success_po.'%</div><div class="male">'.Yii::t('app',' Success(M)').'<br/>'.$male_success_po.'%</div><div class="male">'.Yii::t('app',' Total Success').'<br/>'.$tot_suc_po.'%</div></div>
				
				</div>	
				  <div class="clear"></div> 
             ';
             
	
				
				
	     }// end of if($passing_grade!=null) //
	    else
	       {	//	passing grade not set for this level	 	      		      
		       $noPassingGrade=true;
	       }
      }
	  else //display a message to ask for fill in evalvuationPeriod 
		{
		   $this->messageEvaluation_id_admit=true;
		}
	  
}
			$couleur=1; //
				 
				$style_td='\'border-right: 1px solid #FFF; \'';
				 
		echo '   
       <div style=" width:100%; margin-top:10px; margin-bottom:-30px; "><table style=\'width:100%;\'>
	<tr style=\'color: #FFF; font-size: 0.9em; background: -webkit-linear-gradient(#85bad8 30%, #4c99c5 100%);
	background: -o-linear-gradient(#85bad8 30%, #4c99c5 100%);
	background: -moz-linear-gradient(#85bad8 30%, #4c99c5 100%); 
	background: -ms-linear-gradient(#85bad8 30%, #4c99c5 100%);
	background: linear-gradient(#85bad8 30%, #4c99c5 100%);\'>

											      <td  style='.$style_td.'><b>'.Yii::t('app','Code student').'</b></td><td  style='.$style_td.'><b>'.Yii::t('app','Name').'</b></td><td  style='.$style_td.'><b>'.Yii::t('app','Gender').'</b></td><td style='.$style_td.'><b>'.Yii::t('app','Sum').'</b></td><td style='.$style_td.'><b> '.Yii::t('app','Average ').'</b></td><td style='.$style_td.'><b>'.Yii::t('app','Place').'</b></td><td><b>'.Yii::t('app','Mention').' </b></td></tr>';

if($noPassingGrade==false)
{														  
if((isset($this->room_id))&&($this->room_id!=""))
   { if((isset($this->evaluation_id))&&($this->evaluation_id!=""))
      {	
      
		   		      
		     		  $dataProvider=Persons::model()->searchStudentsForGrades($this->idShift,$this->section_id,$this->idLevel,$this->room_id,$acad);
					  
		   		   if($dataProvider->getItemCount()==0)
		   			{ if(($this->room_id==null)&&($this->idLevel!=null)&&($this->section_id!=null)&&($this->idShift!=null))
		   			    echo "";//"Just pick an other room or move ....";
		   			
		   		    }
                    
		           else
		   			   $this->tot_stud=$dataProvider->getItemCount();
		               			       Yii::app()->session['tot_stud_admit'] = $this->tot_stud; 
				
						//reccuperer l'id du Stud
					   $person=$dataProvider->getData();
                                           
                    foreach($person as $stud){	
						
						   $this->student_id = $stud->id;   //ID student
						   $code= $stud->id_number;   //code student
						   
						   $gender = $stud->getGenders1();   // sexe
						   
						   
							        $student=$this->getStudent($this->student_id );
							        
									
		$averageInfo= $this->getStudentAverageInfo($this->student_id,$this->room_id,$this->idLevel, $this->idShift, $this->section_id,$this->evaluation_id,$acad);
		                             
					
                                                                if($averageInfo[3]===1)								        
                                                                   $place=$averageInfo[3].'<span style="font-size:6pt;">'.Yii::t('app','st').'</span>';
                                                                elseif($averageInfo[3]===2)
                                                                        $place=$averageInfo[3].'<span style="font-size:6pt;">'.Yii::t('app','nd').'</span>'; 
                                                                    elseif($averageInfo[3]===3)
                                                                          $place=$averageInfo[3].'<span style="font-size:6pt;">'.Yii::t('app','rd').'</span>'; 
                                                                         else
                                                                          $place=$averageInfo[3].'<span style="font-size:6pt;">'.Yii::t('app','th').'</span>'; 		 
															   
															
                                                            
															if($averageInfo[2]>=$passing_grade){ //moyenne >= note de passing
                                                                $mension=Yii::t('app','ADMITTED');
                                                                $flag_color = false;
                                                                                                                        }
                                                            else{
                                                                $mension=Yii::t('app','FAILLED'); 
                                                                $flag_color = true;
                                                            }

												                
														
														//pour la couleur des lignes
														        
																
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
																
											      echo '<tr style='.$style_tr.'><td style='.$style_td.'>'.$code.'</td><td style='.$style_td.'>'.$student.'</td><td style='.$style_td.'>'.$gender.'</td><td style='.$style_td.'>';
											      if($averageInfo[1]!=0) echo $averageInfo[0].' / '.$averageInfo[1]; else echo' --- '; echo'</td><td style='.$style_td.'>'; if($averageInfo[2]!=-1) echo $averageInfo[2]; else echo' --- '; echo' </td><td style='.$style_td.'>'; if($averageInfo[1]!=0) echo $place; else echo 'N/A'; echo'</td><td>'; if($averageInfo[1]!=0) echo $mension; else echo 'N/A'; echo' </td></tr>';
                                                                  
																   $couleur++;
	                                                            if($couleur===3) //reinitialisation
																    $couleur=1;
	
	                                   
						
	         } //end 'foreach person			
	
        }
}			
		}//end $noPassingGrade==false
	echo '</table></div>';	    


if($noPassingGrade==true)
  {
       echo '<div class="" style=" width:45%; margin-top:40px; margin-bottom:-30px;  color:red;">';
					       
		echo Yii::t('app','No passing grade set.');
					         
					              
	    echo '</div>  <br/><br/>';	
	    
	    
  }
		

			 ?>

  </div>
 </div>


