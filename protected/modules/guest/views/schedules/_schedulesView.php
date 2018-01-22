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
    
  
$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',));
  
  
  $acad=Yii::app()->session['currentId_academic_year']; 
		 
?>
<div style="width:70%; padding:0px;">
	     		
	
	<div class="left" style="padding:0px;">				
			
		<?php 
		     $userName='';
		     $group_name='';
		     
		       if(isset(Yii::app()->user->name))
		           $userName=Yii::app()->user->name;
	
	if(isset(Yii::app()->user->groupid))
	   {    
	      $groupid=Yii::app()->user->groupid;
	      $group=Groups::model()->findByPk($groupid);
			
		  $group_name=$group->group_name;
	   }	
			if($group_name=='Parent')
			  {	
			  	
			  	
		?>			 
		    <!---->
			<div class="left" style="margin-right:5px;">
			<label for="student"><?php echo Yii::t('app','Child'); ?></label>
	 <?php 
					 
					         $modelPerson= new Persons;
							    if(isset($this->student_id))
							       echo $form->dropDownList($modelPerson,'id',$this->loadChildren($userName), array('onchange'=> 'submit()', 'options' => array($this->student_id=>array('selected'=>true)))); 
							    else
								  { 
									echo $form->dropDownList($modelPerson,'id',$this->loadChildren($userName), array('onchange'=> 'submit()')); 
						           }					      
						  
					
						    						
					   ?>
				</div>
			
			<?php    }
		       elseif($group_name=='Student')
		         {
		         	$this->messageNoSchedule=false;
		         	
		         	$user=$this->getUserInfo();
		         	if(isset($user)&&($user!=''))
		         	    $this->student_id=$user->person_id;
		         	    
		         	     //get room ID in which this child enrolled
				                $modelRoom=Rooms::model()->getRoom($this->student_id, $acad)->getData();
				                
				                foreach($modelRoom as $r)
				                   $this->room_id=$r->id;

							 
						 
                    						  
								  if(($this->room_id!=""))
								  {  
								     
									   
								          $room=$this->getRoom($this->room_id);
											$level=$this->getLevel($this->idLevel);
											$section=$this->getSection($this->section_id);
											$shift=$this->getShift($this->idShift);
											
										//to show update link and create_pdf button only when there records for the room
										$courses=$this->getCoursesAndTimes($this->room_id,$acad);
										if((isset($courses))&&($courses!=null)) 
										  {  
										     $this->temoin_data=true;
										     $this->messageNoSchedule=false;
										  }
										 else
											$this->messageNoSchedule=true;	
												
								     
								  }
								         	
		         }
		        
	     ?>	

			
        
				
	</div>
				
	
			
</div>
			
			
<div class="clear"></div>				
				


<div class="principal">
  <div class="list_secondaire">			
			
			<?php 
     
		    //error message
	    if(($this->messageNoSchedule))
	        { echo '<div class="" style=" width:45%; padding-left:10px; margin-top:10px; margin-bottom:10px; background-color:#F8F8c9; ';		
			      if(($this->messageNoSchedule))
				     echo 'color:red;">';
				 
				   	
				    	
				  
				   if($this->messageNoSchedule)
				     echo Yii::t('app','No schedule saved for this room.').'<br/>';
				   
				  
					
           echo '</div>';
	        }         			
										   
	                                        
										
										
										if(isset($this->room_id)&&($this->room_id!=null))
                                         {
										 
										 
										 
										   $times=$this->getTimes($this->room_id, $acad);
										  if(isset($times))
										     $times=$times->getData();
											 
										  $courses=$this->getCoursesAndTimes($this->room_id, $acad);
										  
										   
										   }
										   
										     
										 	   
											
										   
										 
										  $first_line =true;
										   $compteur=0;
										   $couleur=1;
										   
										   $style_td='\'border-right: 3px solid #E4E9EF;  \'';
										   
										   $style_htd='\' border-right: 3px solid #E4E9EF; background-color: #E4E9EF; \'';
																	
												  
									   echo '<div class=\'dataGrid\' id=\'page\'>
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
																									
                                                                                                       // break;  
                                                                                                     //  }																										  
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
</div>
