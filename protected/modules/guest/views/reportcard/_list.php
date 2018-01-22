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



  
$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',));
  
  
//Extract reportcard_structure (1:One evaluation by Period OR 2:Many evaluations in ONE Period)
         $criteria_ = new CDbCriteria;
		 $criteria_->condition='item_name=:item_name';
		 $criteria_->params=array(':item_name'=>'reportcard_structure',);
		 $reportcard_structure = GeneralConfig::model()->find($criteria_)->item_value;  
  
  
?>



<div style="clear:both"></div>	
 
  <div>			
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
			
			$form=$this->beginWidget('CActiveForm', array(
	'id'=>'persons-form',
	
)); 


			
			
			if($group_name=='Parent')
			  {	
			  	
			  	
		?>			 
		    <!--evaluation-->
			<div class="left" style="margin-right:5px;">
			<label for="student"><?php echo Yii::t('app','Child'); ?></label>
	 <?php 					
					         $modelPerson= new Persons();
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
		         	
		         	$user=$this->getUserInfo();
		         	if(isset($user)&&($user!=''))
		         	    $this->student_id=$user->person_id;
		         	    
		         	    
		         	    		         	
		         }
		        
	     ?>	




        <div class="left" style="margin-right:5px;">
			<label for="Evaluation_name"><?php echo Yii::t('app','Evaluation Period'); ?></label><?php //echo $form->labelEx($model,'Evaluation Period'); ?>
			           <?php 
					
					         $modelEvaluation= new EvaluationByYear();
							    if(isset($this->evaluation_id))
							       echo $form->dropDownList($modelEvaluation,'evaluation',$this->loadEvaluationReportcardDone(), array('onchange'=> 'submit()', 'options' => array($this->evaluation_id=>array('selected'=>true)))); 
							    else
								  { 
									echo $form->dropDownList($modelEvaluation,'evaluation',$this->loadEvaluationReportcardDone(), array('onchange'=> 'submit()')); 
						           }					      
						  
						echo $form->error($modelEvaluation,'evaluation'); 
						
						 
			$this->endWidget(); 			
			
					   ?>
				</div>

<div>			
		

<div style="clear:both;"></div>


<?php 

       $acad=Yii::app()->session['currentId_academic_year']; 
       $pastp = array();
       $compter_p=1; //on compte deja the current period
       $general_average=0;       
			   
			  
			  
			  				
if(isset($this->evaluation_id)&&($this->evaluation_id!=""))
       {				
			$reportCard='documents/reportcard';
			$eval_date = null;
			$acad_year =0;
			// To find period name in in evaluation by year 
                                                                
                                                               $result=EvaluationByYear::model()->searchPeriodName($this->evaluation_id);
															if(isset($result))
															 {  $result=$result->getData();//return a list of  objects
																foreach($result as $r)
																  {
																	$period_exam_name= $r->name_period;
																   $period_acad_id = $r->id;
																   $eval_date = $r->evaluation_date;
															       $acad_year = $r->academic_year;
																   }
															 }
                                                               // end of code 
			
									 $student=$this->getStudent($this->student_id);
									 
									 $shift=$this->getShiftByStudentId($this->student_id)->shift_name;
									$section=$this->getSectionByStudentId($this->student_id)->section_name;
									
									$level=$this->getLevelByStudentId($this->student_id)->level_name;
									$room=$this->getRoomByStudentId($this->student_id)->room_name;
									$acadPeriod_for_this_room=$this->getAcademicPeriodName($acad,$this->getRoomByStudentId($this->student_id)->id);
									$evaluationPeriod=$this->getEvaluationPeriod($this->evaluation_id);
									
									 
                              $name_acadPeriod_for_this_room=null;           
                              if(isset($acadPeriod_for_this_room))
                               {       
                                 $name_acadPeriod_for_this_room=$acadPeriod_for_this_room->name_period;
                               }    
                                     //retire tout aksan yo    
                                         
		                                 $student_= strtr( $student, $this->pa_daksan );
		                                 $room_ = strtr( $room, $this->pa_daksan );
		                                 $level_ = strtr( $level, $this->pa_daksan );
		                                 $section_ = strtr( $section, $this->pa_daksan );
		                                 $shift_ = strtr( $shift, $this->pa_daksan );
		                                 $evaluationPeriod_ = strtr( $evaluationPeriod, $this->pa_daksan );
		                                 $name_acadPeriod_for_this_room_ = strtr( $name_acadPeriod_for_this_room, $this->pa_daksan );
                                        $period_exam_name_ = strtr( $period_exam_name, $this->pa_daksan );
								
								
								//   <!-- As we change SECTION TO NIVEAU, we should test $section and/or 'Fondamental' -->
								$path=$reportCard.'/'.$name_acadPeriod_for_this_room_.'/'.$shift_.'/'.$section_.'/'.$level_.'/'.$room_;
								$path1=$reportCard.'/'.$name_acadPeriod_for_this_room_.'/'.$shift_.'/Primaire/'.$level_.'/'.$room_;
									 
								                                        
                                         
                      // print_r('<br/><br/><br/>*********'.$path1.'/'.$student_.'_'.$this->student_id.'_'.$period_exam_name_.'_'.$name_acadPeriod_for_this_room_ );                 
                                         
                              if($name_acadPeriod_for_this_room!=null)
                               {  
   							      if($reportcard_structure==1) //One evaluation by Period
								    {
									      
   							             if(file_exists(Yii::app()->basePath.'/../'.$path.'/'.$student_.'_'.$this->student_id.'_'.$period_exam_name_.'_'.$name_acadPeriod_for_this_room_.'.pdf'))  // if pdf file exist, allowlink to print it 
									         {
									            
												 
												 $explode_baseurl= explode("protected",substr(Yii::app()->baseUrl, 0));
                         
												 $url=$student_.'_'.$this->student_id.'_'.$period_exam_name_.'_'.$name_acadPeriod_for_this_room_.'.pdf';                                        
                                   
												 
												 echo '   
															<div class="bulletin" style="width:90%; height:1100px;">
																
															   <div id="pdf" style="width:100%; height:1100px;">
											<object width="100%" height="100%" type="application/pdf" data="'.Yii::app()->baseUrl.'/'.$path.'/'.$student_.'_'.$this->student_id.'_'.$period_exam_name_.'_'.$name_acadPeriod_for_this_room_.'.pdf'.'#toolbar=0&navpanes=0&scrollbar=0&page=1&view=FitV">';
											
											echo '<p>'.Yii::t('app','It appears you don\'t have a PDF plugin for this browser.<br/> You can ').'<a href=\"'.Yii::app()->baseUrl.'/'.$path.'/'.$student_.'_'.$this->student_id.'_'.$period_exam_name_.'_'.$name_acadPeriod_for_this_room_.'.pdf'.'\">'.Yii::t('app',' click here to download the PDF file.</a>'); echo '</p>';
											  echo '
											<!-- <!DOCTYPE html>
											<html moznomarginboxes="" mozdisallowselectionprint="" dir="ltr">   -->
											</object>
											</div>													 
											                </div>';
												
									        
									          }
										   elseif(file_exists(Yii::app()->basePath.'/../'.$path1.'/'.$student_.'_'.$this->student_id.'_'.$period_exam_name_.'_'.$name_acadPeriod_for_this_room_.'.pdf'))  // if pdf file exist, allowlink to print it 
													         {
													            
																 
																 $explode_baseurl= explode("protected",substr(Yii::app()->baseUrl, 0));
				                         
																 $url=$student_.'_'.$this->student_id.'_'.$period_exam_name_.'_'.$name_acadPeriod_for_this_room_.'.pdf';                                        
				                                   
																 
																 echo '   
															<div class="bulletin" style="width:90%; height:1100px;">
																
															   <div id="pdf" style="width:100%; height:1100px;">
											<object width="100%" height="100%" type="application/pdf" data="'.Yii::app()->baseUrl.'/'.$path1.'/'.$student_.'_'.$this->student_id.'_'.$period_exam_name_.'_'.$name_acadPeriod_for_this_room_.'.pdf'.'#toolbar=0&navpanes=0&scrollbar=0&page=1&view=FitV">';
											
											echo '<p>'.Yii::t('app','It appears you don\'t have a PDF plugin for this browser.<br/> You can ').'<a href=\"'.Yii::app()->baseUrl.'/'.$path1.'/'.$student_.'_'.$this->student_id.'_'.$period_exam_name_.'_'.$name_acadPeriod_for_this_room_.'.pdf'.'\">'.Yii::t('app',' click here to download the PDF file.</a>'); echo '</p>';
											  echo '
											<!-- <!DOCTYPE html>
											<html moznomarginboxes="" mozdisallowselectionprint="" dir="ltr">   -->
											</object>
											</div>													 
											                </div>';
																		
									                 }
									               else
											          {  echo ' <div class="bulletin">		
													        <div class="bulletin_i">';
												    	   
											                 echo'<h2>'.strtoupper(strtr(Yii::t('app','Report Card '), $this->pa_daksan )).'</h2></div> '; 
																					
															  echo '<table class="tb"> 
											                                                                     													  
																		  <tr><td></td></tr>
																		  <tr><td style="width:50%; "> '; 
																		    echo Yii::t('app','Reportcard is not yet available. Please, check later.'); 
																		  echo '</td></tr>
																		    </table>
																	         <br/> <br/> 
																	                      
																	    </div>';
											          } 
											                                             
		                                       $this->noStud = 1; //people enrolled this room pour cette annee academic
                                       
  									  
									  }
								  elseif($reportcard_structure==2)  //Many evaluations in ONE Period
									{
									     
   							             if(file_exists(Yii::app()->basePath.'/../'.$path.'/'.$student_.'_'.$this->student_id.'_'.$period_exam_name_.'_'.$eval_date.'_'.$name_acadPeriod_for_this_room_.'.pdf'))  // if pdf file exist, allowlink to print it 
									         {
									            
												 
												 $explode_baseurl= explode("protected",substr(Yii::app()->baseUrl, 0));
                         
												 $url=$student_.'_'.$this->student_id.'_'.$period_exam_name_.'_'.$eval_date.'_'.$name_acadPeriod_for_this_room_.'.pdf';                                        
                                   
												 
												 echo '   
															<div class="bulletin" style="width:90%; height:1100px;">
																
															   <div id="pdf" style="width:100%; height:1100px;">
											<object width="100%" height="100%" type="application/pdf" data="'.Yii::app()->baseUrl.'/'.$path.'/'.$student_.'_'.$this->student_id.'_'.$period_exam_name_.'_'.$eval_date.'_'.$name_acadPeriod_for_this_room_.'.pdf'.'#toolbar=0&navpanes=0&scrollbar=0&page=1&view=FitV">';
											
											echo '<p>'.Yii::t('app','It appears you don\'t have a PDF plugin for this browser.<br/> You can ').'<a href=\"'.Yii::app()->baseUrl.'/'.$path.'/'.$student_.'_'.$this->student_id.'_'.$period_exam_name_.'_'.$eval_date.'_'.$name_acadPeriod_for_this_room_.'.pdf'.'\">'.Yii::t('app',' click here to download the PDF file.</a>'); echo '</p>';
											  echo '
											<!-- <!DOCTYPE html>
											<html moznomarginboxes="" mozdisallowselectionprint="" dir="ltr">   -->
											</object>
											</div>													 
											                </div>';
												
									        
									          }
										   elseif(file_exists(Yii::app()->basePath.'/../'.$path1.'/'.$student_.'_'.$this->student_id.'_'.$period_exam_name_.'_'.$eval_date.'_'.$name_acadPeriod_for_this_room_.'.pdf'))  // if pdf file exist, allowlink to print it 
													         {
													            
																 
																 $explode_baseurl= explode("protected",substr(Yii::app()->baseUrl, 0));
				                         
																 $url=$student_.'_'.$this->student_id.'_'.$period_exam_name_.'_'.$eval_date.'_'.$name_acadPeriod_for_this_room_.'.pdf';                                        
				                                   
																 
																 echo '   
															<div class="bulletin" style="width:90%; height:1100px;">
																
															   <div id="pdf" style="width:100%; height:1100px;">
											<object width="100%" height="100%" type="application/pdf" data="'.Yii::app()->baseUrl.'/'.$path1.'/'.$student_.'_'.$this->student_id.'_'.$period_exam_name_.'_'.$eval_date.'_'.$name_acadPeriod_for_this_room_.'.pdf'.'#toolbar=0&navpanes=0&scrollbar=0&page=1&view=FitV">';
											
											echo '<p>'.Yii::t('app','It appears you don\'t have a PDF plugin for this browser.<br/> You can ').'<a href=\"'.Yii::app()->baseUrl.'/'.$path1.'/'.$student_.'_'.$this->student_id.'_'.$period_exam_name_.'_'.$eval_date.'_'.$name_acadPeriod_for_this_room_.'.pdf'.'\">'.Yii::t('app',' click here to download the PDF file.</a>'); echo '</p>';
											  echo '
											<!-- <!DOCTYPE html>
											<html moznomarginboxes="" mozdisallowselectionprint="" dir="ltr">   -->
											</object>
											</div>													 
											                </div>';
																		
									                 }
									             else
										          {  echo ' <div class="bulletin">		
												        <div class="bulletin_i">';
											    	   
										                 echo'<h2>'.strtoupper(strtr(Yii::t('app','Report Card '), $this->pa_daksan )).'</h2></div> '; 
																				
														  echo '<table class="tb"> 
										                                                                     													  
																	  <tr><td></td></tr>
																	  <tr><td style="width:50%; "> '; 
																	    echo Yii::t('app','Reportcard is not yet available. Please, check later.'); 
																	  echo '</td></tr>
																	    </table>
																         <br/> <br/> 
																                      
																    </div>';
										          } 
										                                             
	                                       $this->noStud = 1; //people enrolled this room pour cette annee academic
                                       

									             
   							      
   							     	
									          }
									                                                  
                                               
                                   }
                                 else //$acadPeriod==null, no people enrolled this room
                                   $this->noStud = 0;

			
			
			
			
			
			


   	}	
else  //default reportcard content			
	{
		echo ' <div class="bulletin">		
		        <div class="bulletin_i">';
	    	   
                 echo'<h2>'.strtoupper(strtr(Yii::t('app','Report Card '), $this->pa_daksan )).'</h2></div> '; 
										
				  echo '<table class="tb"> 
                                                                     													  
							  <tr><td></td></tr>
							  <tr><td style="width:50%; "> '; 
							    
							  echo '</td></tr>
							    </table>
						         <br/> <br/> 
						                      
						    </div>';
	}			
				
				

?>