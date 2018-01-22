<?php

/*
 * © 2015 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
 * 
 * This file is part of SIGES.

    SIGES is a free software: you can redistribute it and/or modify
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
 					
 $acad=Yii::app()->session['currentId_academic_year'];
?>


</br>



         <div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin">
                      
                      <tbody>
                        
                        <tr>
                          <td colspan="4" style="background-color:#EFF3F8;border: none;">	     		
	
	<div  style="padding:0px;">				
				<!--Academic Period-->
        <div class="left" style="margin-left:10px;">
		
			<?php $modelAcademicP = new AcademicPeriods;
			echo $form->labelEx($modelAcademicP,Yii::t('app','Academic Period '));?>
					 <?php    $this->idAcademicP=Yii::app()->session['AcademicP_sch'] ;
					         if(isset($this->idAcademicP))
						        {  
								   echo $form->dropDownList($modelAcademicP,'name_period',$this->loadAcademicPeriod(), array('options' => array($this->idAcademicP=>array('selected'=>true)),'onchange'=> 'submit()' )); 
					             }
							  else
								{ $this->idShift="";
									unset($this->room_id);
								    echo $form->dropDownList($modelAcademicP,'name_period',$this->loadAcademicPeriod(), array('onchange'=> 'submit()' )); 
									
								}
							
						echo $form->error($modelAcademicP,'name_period'); 
						
					
					  ?>
				</div>
				
	
		
		<!--Shift(vacation)-->
        <div class="left" style="margin-left:10px;">
		
			<?php $modelShift = new Shifts;
			echo $form->labelEx($modelShift,Yii::t('app','Shift'));?>
					 <?php 
					    $this->idShift=Yii::app()->session['Shifts_sch'] ;
						
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
								{ $this->idLevel="";
								  unset($this->room_id);
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
			<div class="left" style="margin-left:10px;">
			<?php $modelSection = new Sections;
			                   echo $form->labelEx($modelSection,Yii::t('app','Section')); ?>
			           <?php 
					 $this->section_id=Yii::app()->session['Sections_sch'] ;
					    
							    if(isset($this->section_id))
							       echo $form->dropDownList($modelSection,'section_name',$this->loadSectionByIdShift($this->idShift), array('options' => array($this->section_id=>array('selected'=>true)),'onchange'=> 'submit()')); 
							    else
								  { $this->idLevel="";
								    unset($this->room_id);
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
					
					    if($this->different)
						   { 
						     
                                                unset(Yii::app()->session['LevelHasPerson_sch']);
							 unset(Yii::app()->session['Rooms_sch']);
							 $this->idLevel=null;
							 
						   }
						 else						  
						  $this->idLevel=Yii::app()->session['LevelHasPerson_sch'] ;
						  
						if(isset($this->idLevel))
							    echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevelByIdShiftSectionIdAcademicP($this->idShift,$this->section_id,$this->idAcademicP), array('options' => array($this->idLevel=>array('selected'=>true)),'onchange'=> 'submit()', )); 
							 else
								{ $this->idLevel="";
								   unset($this->room_id);
								   
								  echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevelByIdShiftSectionIdAcademicP($this->idShift,$this->section_id,$this->idAcademicP), array('onchange'=> 'submit()' )); 
					              
								   
							      }
						echo $form->error($modelLevelPerson,'level'); 
					 
					  ?>
				</div>
			
			<!--room-->
			<div class="left" style="margin-left:10px;">
			     <?php  $modelRoom = new Rooms;
			                     echo $form->labelEx($modelRoom,Yii::t('app','Room')); ?>
			          <?php 
					
					
		//ajoute AcademicPeriod nan rechech room
                             
							  
							  if(isset($this->room_id))
							       echo $form->dropDownList($modelRoom,'room_name',$this->loadRoomByIdShiftSectionLevel($this->idShift,$this->section_id,$this->idLevel), array('onchange'=> 'submit()','options' => array($this->room_id=>array('selected'=>true)) )); 		
							   else
							      {   
                                                                          unset($this->room_id);
								      
									  echo $form->dropDownList($modelRoom,'room_name',$this->loadRoomByIdShiftSectionLevel($this->idShift,$this->section_id,$this->idLevel), array('onchange'=> 'submit()')); 
							          
									     
                                                                        $this->messageidAcademicP=false;
									
							      }
						echo $form->error($modelRoom,'room_name'); 
						
										
					   ?>
				</div>
			 
			</div>
			
							</td>
	       
					       
					    </tr>
					    
					    <tr>
					       <td colspan="4" style="background-color:#EFF3F8;border: none;">



<!-- <div class="principal">  -->
  <div class="list_secondaire">			
			
			<?php 
     
		    			
										   
	                                        
			//error message 
	        	if(($this->success)||($this->messageidAcademicP)||($this->messageNoSchedule))
			      { echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-top:20px; margin-bottom:-26px; ';//-20px; ';
				      echo '">';
				      				      
			           echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
					   <tr>
					    <td style="text-align:center;">';
			       
			       }			      
				 					     	
				   
				  if($this->messageidAcademicP)
				     echo '<span style="color:red;" >'.Yii::t('app','Academic Period cannot be empty.').'</span>'.'<br/>';
				   
				   if($this->messageNoSchedule)
				     echo '<span style="color:red;" >'.Yii::t('app','No schedule saved for this room.').'</span>'.'<br/>';
				   
				   if($this->success)
				     echo '<span style="color:green;" >'.Yii::t('app','You have successfully created PDF file.').'</span>'.'<br/>';
					
				 
				   
					   
			     if(($this->success)||($this->messageidAcademicP)||($this->messageNoSchedule))
			      { 
					 echo'</td>
					    </tr>
						</table>';
					
                      echo '</div>';
			       }
			       
			       							
										
										if(isset($this->room_id)&&($this->room_id!=null))
                                         {
										 
										 
										 
										   $times=$this->getTimes($this->room_id, $this->idAcademicP);
										  if(isset($times))
										     $times=$times->getData();
											 
										  $courses=$this->getCoursesAndTimes($this->room_id, $this->idAcademicP);
										  
										   
										   }
										   
										     
										 	   
											
										   
										 
										  $first_line =true;
										   $compteur=0;
										   $couleur=1;
										   
										   $style_td='\'border-right: 3px solid #E4E9EF;  \'';
										   
										   $style_htd='\' border-right: 3px solid #E4E9EF; background-color: #E4E9EF; \'';
																	
												  
									   echo '<br/><div class=\'dataGrid\' id=\'page\'  >
									   <table style=\'width:100%;  \'>
												   
										   <thead class="" >
												   <tr style=\'color: #; font-size: 0.9em; background-color: #E4E9EF; \'> 
												       <th style='.$style_htd.'>'.Yii::t('app','Monday').'</th>
													   <th style='.$style_htd.'>'.Yii::t('app','Tuesday').'</th>
													   <th style='.$style_htd.'>'.Yii::t('app','Wednesday').'</th>
													   <th style='.$style_htd.'>'.Yii::t('app','Thursday').'</th>
													   <th style='.$style_htd.'>'.Yii::t('app','Friday').'</th>
													   <th style='.$style_htd.'>'.Yii::t('app','Saturday').'</th>
													   <th style='.$style_htd.'>'.Yii::t('app','Sunday').'</th> </tr></thead> <tbody class="">';
																	
											          	 
														 //$i=1;
															
														 
															if(isset($courses)) 
															 {  
															    
																$day[]= array();
																$max=0;
																$max1=0;
																$trash=0;
																$max_day=0;
																$compteur=1;
														        
																foreach($courses as $course)
																  {   
																	switch($course->day_course)
																	  { case 1: 
																			       $max++;
																				   if($max!=0)
																				     $trash=$trash-1;
																				 
																			    $day[0][]=$course;
																				
																				break;
																				 
																		case 2: 
																			       $max++;
																				if($max!=0)
																				     $trash=$trash-1;
																					 
																				$day[1][]=$course; 
																			   
																				break;
																				 
																		case 3: 
																			       $max++;
																				   if($max!=0)
																				     $trash=$trash-1;
																					 
																				 $day[2][]=$course;
																			   
																				break;
																				 
																		case 4: 
																			       $max++;
																				if($max!=0)
																				     $trash=$trash-1;
																					 
																				$day[3][]=$course;
																			   
																				break;
																				 
																		case 5: 
																			       $max++;
																				   if($max!=0)
																				     $trash=$trash-1;
																					 
																				$day[4][]=$course;
																			   
																				break;
																				 
																		case 6: 
																			       $max++;
																				   if($max!=0)
																				     $trash=$trash-1;
																					 
																				$day[5][]=$course;
																			   
																				break;
																				 
																		case 7: 
																			       $max++;
																				   if($max!=0)
																				     $trash=$trash-1;
																					 
																				$day[6][]=$course;
																			   
																				break;
																	  }
																	  
																   }
																    
																	
																     
																	 $old_max=count($day[0]);
																  for($i=0; $i<=6;$i++)
																	{    
																	    
																		 if(isset($day[$i+1]))
																	      { 
																		     if(count($day[$i+1])>=count($day[$i]))
																		        $max1=count($day[$i+1]);
																			 else
																		        $max1=count($day[$i]);
																				
																				
																		    if($old_max <= $max1 )
																		       $old_max=$max1;
																		   
																		      
																		   }
																		 elseif(isset($day[$i]))
																		   {   
																		      $max1=count($day[$i]);
																			  if($max1>=$old_max)
																			    $old_max=$max1;
                                                                               					break;														  
																		   }
																		  
																	}
																	
																
																	
																	
																    for($c=0; $c<$old_max;$c++)
																	{   	
																	      //pour la couleur des lignes
														        
																
																			if($couleur===1)  //choix de couleur
																			{
																				$style_tr='\'font-size: 0.9em; background: #F0F0F0; \'';
																				 														
																			}
																			elseif($couleur===2)
																			 {
																				$style_tr='\'font-size: 0.9em; background: #FAFAFA; \'';
																					
																		     }
																			
																		     echo '<tr style='.$style_tr.'> ';
																			  
																			  
                                                                           for($j=0; $j<=6;$j++)
																		      { 
																			     if(isset($day[$j][$c]->course))
																			       {   
																				   
																					  if($first_line)
																					     {
																						     $subject=$this->getSubjectName($day[$j][$c]->course);
																											foreach($subject as $name)
																											   $subject_name=$name->subject_name;
																											echo '<td style='.$style_td.'>'.$subject_name.'<br/> <i> ('.$name->first_name.' '.$name->last_name.') </i>'.'<br/> <b>'.substr($day[$j][$c]->time_start,0,5).' - '.substr($day[$j][$c]->time_end,0,5).' </b></td>';
																									$compteur++;
																									
                                                                                                       																									  
																						 }
																					   
																						 
																					 
																					}
																					else
																					  echo '<td style='.$style_td.'>***</td>';
																				  
																					
																			  }
																	         
																			  $couleur++;
	                                                            if($couleur===3) //reinitialisation
																    $couleur=1;
																	   
																		     echo '</tr> ';
																	   
																	}//end foreach course
														          
																	
																	 
																 
																 
                                                              }//fin isset($course)
																
                                                         
													
											       echo '<tr ><td></br></br></td></tr>
						
						</tbody>
                                                         

</table></div>';
   
	
	$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'courseDialog',
                'options'=>array(
                    'title'=>Yii::t('app','Add Course'),
                    'autoOpen'=>false,
					'modal'=>'true',
                    'width'=>'34%',
                    
                ),
                ));
	
 

   
 echo "<div id='add_course'></div>";

 $this->endWidget('zii.widgets.jui.CJuiDialog');
 
 //for update course in schedulesView
  $this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'courseDialog1',
                'options'=>array(
                    'title'=>Yii::t('app','Update Course'),
                    'autoOpen'=>false,
					'modal'=>'true',
                    'width'=>'34%',
                   
                ),
                ));
				  
echo "<div id='update_course'></div>";

   
				
				 $this->endWidget('zii.widgets.jui.CJuiDialog');
				

?>


</div>
<!-- </div>  -->

                                             </td>
                                        </tr>
  
  
                       </tbody>
                    </table>
                  </div><!-- /.table-responsive -->
                </div><!-- /.box-body -->
                

