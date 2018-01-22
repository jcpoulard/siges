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
<div class="liste_note">

     <div class="left" style="padding:0px;">			
				<!--Academic Period-->
        <div class="left">
		
			<?php $modelAcademicP = new AcademicPeriods;
			echo $form->labelEx($modelAcademicP,Yii::t('app','Academic Period '));?>
					 <?php    $this->idAcademicP=Yii::app()->session['AcademicP_sch'] ;
					         if(isset($this->idAcademicP))
						        {  
								   echo $form->dropDownList($modelAcademicP,'name_period',$this->loadAcademicPeriod(), array('options' => array($this->idAcademicP=>array('selected'=>true)),'onchange'=> 'submit()' )); 
					             }
							  else
								{ 
								    echo $form->dropDownList($modelAcademicP,'name_period',$this->loadAcademicPeriod(), array('onchange'=> 'submit()' )); 
									$this->idShift="";
								}
							
						echo $form->error($modelAcademicP,'name_period'); 
						
					
					  ?>
				</div>
		<!--Shift(vacation)-->
        <div class="left">
		
			<?php $modelShift = new Shifts;
			echo $form->labelEx($modelShift,Yii::t('reportcard','Shift'));?>
					 <?php 
					    $this->idShift=Yii::app()->session['Shifts_sch'] ;
						
						  if(isset($this->idShift))
						        {   
					               echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('options' => array($this->idShift=>array('selected'=>true)),'onchange'=> 'submit()' )); 
					             }
							  else
								{ $this->idLevel="";
								    echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('onchange'=> 'submit()' )); 
								}
							
						echo $form->error($modelShift,'shift_name'); 
						
					
					  ?>
				</div>
			 
		    <!--section(liee au Shift choisi)-->
			<div class="left" style="margin-left:10px;">
			<?php $modelSection = new Sections;
			                   echo $form->labelEx($modelSection,Yii::t('reportcard','Section')); ?>
			           <?php 
					 $this->section_id=Yii::app()->session['Sections_sch'] ;
					    
							    if(isset($this->section_id))
							       echo $form->dropDownList($modelSection,'section_name',$this->loadSectionByIdShift($this->idShift), array('options' => array($this->section_id=>array('selected'=>true)),'onchange'=> 'submit()')); 
							    else
								  { $this->idLevel="";
									echo $form->dropDownList($modelSection,'section_name',$this->loadSectionByIdShift($this->idShift), array('onchange'=> 'submit()' )); 
						           }					      
						  
						echo $form->error($modelSection,'section_name'); 
						
															
					   ?>
				</div>
			
			<!--level-->
			<div class="left" style="margin-left:10px;">
			<?php $modelLevelPerson = new LevelHasPerson;
			                       echo $form->labelEx($modelLevelPerson,Yii::t('reportcard','Level'));?> 
					   <?php 
					 
					    $this->idLevel=Yii::app()->session['LevelHasPerson_sch'] ;
						if(isset($this->idLevel))
							    echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevelByIdShiftSectionIdAcademicP($this->idShift,$this->section_id,$this->idAcademicP), array('options' => array($this->idLevel=>array('selected'=>true)),'onchange'=> 'submit()', )); 
							 else
								{ $this->idLevel="";
								  echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevelByIdShiftSectionIdAcademicP($this->idShift,$this->section_id,$this->idAcademicP), array('onchange'=> 'submit()' )); 
					               //unset($this->room_id);
								   $this->room_id="";
							      }
						echo $form->error($modelLevelPerson,'level'); 
					 
					  ?>
				</div>
			
			<!--room-->
			<div class="left" style="margin-left:10px;">
			     <?php  $modelRoom = new Rooms;
			                     echo $form->labelEx($modelRoom,Yii::t('reportcard','Room')); ?>
			          <?php 
					
					
		//ajoute AcademicPeriod nan rechech room
                             if($this->idLevel!=null) 
							    $this->room_id=Yii::app()->session['Rooms_sch'] ;		
							  
							  if(isset($this->room_id))
							       echo $form->dropDownList($modelRoom,'room_name',$this->loadRoomByIdShiftSectionLevel($this->idShift,$this->section_id,$this->idLevel), array('onchange'=> 'submit()','options' => array($this->room_id=>array('selected'=>true)) )); 		
							   else
							      {   echo $form->dropDownList($modelRoom,'room_name',$this->loadRoomByIdShiftSectionLevel($this->idShift,$this->section_id,$this->idLevel), array('onchange'=> 'submit()')); 
							          //echo $this->room_id;
									     unset($this->room_id);
										  $this->messageidAcademicP=false;
									
							      }
						echo $form->error($modelRoom,'room_name'); 
						
										
					   ?>
				</div>
			
			
			</div>
			
</div>
			<div style="clear:both"></div>

			<?php 
      if($this->success)
				    {  echo '<div class="" style=" width:45%;  background-color:#F8F8c9; color:green;">';
					    echo Yii::t('app','You have successfully created PDF file.');
					   echo '</div>';
					}  
      if($this->messageidAcademicP)
				    {  echo '<div class="" style=" width:45%;  background-color:#F8F8c9; color:green;">';
					    echo Yii::t('app','Academic Period cannot be empty.');
					   echo '</div>';
					}            			
										   
	?>		
</div>

<div style="clear:both"></div>




<?php 
                                       
										
										if(isset($this->room_id)&&($this->room_id!=null))
                                         {
										 
										 
										 
										   $times=$this->getTimes($this->room_id, $this->idAcademicP);
										  //if(isset($times))
										     $times=$times->getData();
											  
										  $courses=$this->getCoursesAndTimes($this->room_id, $this->idAcademicP);
										  
										   
										   }
												  
										/*if(isset($courses)&& isset($times)){		   
                                         foreach($courses as $course){
																      $subject=$this->getSubjectName($course->course);
																						  foreach($subject as $name)
																						    echo $course->id.'_'.$name->subject_name.'-';}}*/
																							
													$couleur=1;
										   
										   $style_td='\'border-right: 1px solid #FFF; \'';										
																							
												   echo '<div class=\'dataGrid\' id=\'page\'>
												   <table style=\'width:100%; border:0px solid #EF6D3B;\'>
												   
												   <tr style=\'color: #FFF; font-size: 0.9em; background: -webkit-linear-gradient(#85bad8 30%, #4c99c5 100%);
	background: -o-linear-gradient(#85bad8 30%, #4c99c5 100%);
	background: -moz-linear-gradient(#85bad8 30%, #4c99c5 100%); 
	background: -ms-linear-gradient(#85bad8 30%, #4c99c5 100%);
	background: linear-gradient(#85bad8 30%, #4c99c5 100%);\'> 
												       <th style='.$style_td.'></th>
													   <th style='.$style_td.'>'.Yii::t('app','Monday').'</th>
													   <th style='.$style_td.'>'.Yii::t('app','Tuesday').'</th>
													   <th style='.$style_td.'>'.Yii::t('app','Wednesday').'</th>
													   <th style='.$style_td.'>'.Yii::t('app','Thursday').'</th>
													   <th style='.$style_td.'>'.Yii::t('app','Friday').'</th>
													   <th style='.$style_td.'>'.Yii::t('app','Saturday').'</th>
													   <th style='.$style_td.'>'.Yii::t('app','Sunday').'</th> </tr>';
																	
											           
													//   if(isset($times)){
													  	 
														 $i=0;
														   $oldTime_start="";
														   $oldTime_end="";
															
														if(isset($times)) 
														  {  
															if(isset($courses)) 
															 {   
															  foreach($times as $hres)
															   {
															        //pour la couleur des lignes
														        
																
																			if($couleur===1)  //choix de couleur
																			{
																				$style_tr='\'font-size: 0.9em; background: #E5F1F4; \'';
																				 
																																					
																			}
																			elseif($couleur===2)
																			 {
																				$style_tr='\'font-size: 0.9em; background: #F8F8F8; \'';
																					
																		     }
																
														       
																    echo '
																	   <tr style='.$style_tr.'>
																	           <td style=\'width:120px;'.$style_td.'><b>'.substr($hres->time_start,0,5).' - '.substr($hres->time_end,0,5).'</b></td> ';
                                                                    
																	$oldTime_start=substr($hres->time_start,0,5);
														            $oldTime_end=substr($hres->time_end,0,5);
																	
																 
																 for($c=1; $c<=7;$c++){   
																    $flag=true;
																    foreach($courses as $course)
																	{
																   	  if(($course->day_course==$c)&&((substr($hres->time_start,0,5) ===substr($course->time_start,0,5))&&(substr($hres->time_end,0,5) ===substr($course->time_end,0,5))))
																		  {  
																		  
																		  																				 
																				
																					   $subject=$this->getSubjectName($course->course);
																						  foreach($subject as $name)
																						    echo '<td style='.$style_td.'>'.CHtml::ajaxLink($name->subject_name.'<br/>('.$name->first_name.' '.$name->last_name.')',array('updatecourse?id='.$course->id.'&room='.$this->room_id.'&day='.$course->day_course.'&t_start='.$hres->time_start.'&t_end='.$hres->time_end),array(
																									'success'=>'js:function(data){
																								  $("#courseDialog1").dialog("open");
																								document.getElementById("update_course").innerHTML=data;
																							 
																							}',),array(
																							'style'=>'text-decoration:none; position:relative;',
																							)   ).'<br/>';																							
																							;
																							
																							echo '</td>';
																							$flag=false;
																							
																							break;
																				
																		         
																	  	  }
                                                                      																		       
																			
																	
																	}//end foreach
														             
																	
																	   if($flag==true)
																					  { 
																					      echo '<td style='.$style_td.'><b>'.CHtml::ajaxLink(Yii::t('app','***'),array('addcourse?room='.$this->room_id.'&day='.$c.'&t_start='.$hres->time_start.'&t_end='.$hres->time_end),array(
																									'success'=>'js:function(data){
																								  $("#courseDialog").dialog("open");
																								document.getElementById("add_course").innerHTML=data;
																							 
																							}',),array(
																							'style'=>'text-decoration:none; position:absolute;',
																							)   ).'</b>';
																				     echo '</td>';
																					 
																					
																					 }
																		
																
																} // fin $c 
																
																 $couleur++;
	                                                            if($couleur===3) //reinitialisation
																    $couleur=1;
																	 
																	echo '</tr>'; 
																 } //fin if($oldTime)
																 
																 
                                                                    }
																 } //fin isset courses 
                                                              // }// fin isset times
                                                          
                                                         
													
											       echo '<tr ><td></br></br></td></tr>
                                                         

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



