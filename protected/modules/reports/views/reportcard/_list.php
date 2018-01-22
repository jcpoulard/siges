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
         $reportcard_structure = infoGeneralConfig('reportcard_structure'); 
         
         $siges_structure=infoGeneralConfig('siges_structure_session'); 
  
  
?>


<div class="liste_note">

     <div class="left" style="padding:0px;">
     				 
		    <!--evaluation-->
			<div class="left" style="margin-right:0px">
			<label for="Evaluation_name"><?php echo Yii::t('app','Evaluation Period'); ?></label>
			           <?php 
					
					         $modelEvaluation= new EvaluationByYear();
							    if(isset($this->evaluation_id))
							       echo $form->dropDownList($modelEvaluation,'evaluation',$this->loadEvaluationReportcardDone(), array('onchange'=> 'submit()', 'options' => array($this->evaluation_id=>array('selected'=>true)))); 
							    else
								  { 
									echo $form->dropDownList($modelEvaluation,'evaluation',$this->loadEvaluationReportcardDone(), array('onchange'=> 'submit()')); 
						           }					      
						  
						echo $form->error($modelEvaluation,'evaluation');  
						  						
					   ?>
				</div>
			
			
	</div>		

</div>

<div style="clear:both;"></div>

<?php 


 $acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

 

       $pastp = array();
       $compter_p=1; //on compte deja the current period
       $general_average=0;       
			   
			   if((isset($_GET['stud']))&&($_GET['stud']!=''))
			        $this->student_id=$_GET['stud'];
					
			   
			   
			   if((isset($_GET['shi']))&&($_GET['shi']!=''))
			    {
				   $idShift = $_GET['shi'];
				   $this->idShift=$idShift;
				}
				
			   
				
			   if((isset($_GET['sec']))&&($_GET['sec']!=''))
			   {
				   $section = $_GET['sec'];
				  $this->section_id=$section;
				}
				
			   if((isset($_GET['lev']))&&($_GET['lev']!=''))
			   {
				  $level = $_GET['lev'];
				  $this->idLevel=$level;
				}
				
			   if((isset($_GET['roo']))&&($_GET['roo']!=''))
			   {
				   $room = $_GET['roo'];
				  $this->room_id=$room;
				}
				
			   if((isset($_GET['ev']))&&($_GET['ev']!=''))
			    {
				  $eval = $_GET['ev'];
				  $this->evaluation_id=$eval;
				}
				
				if((isset($_GET['pp']))&&($_GET['pp']!=''))
			    {
				  $pp = $_GET['pp'];
				  $pastp=explode(',',$pp);
				}
			      
				  
			     
			if(isset($_GET['pg'])||($_GET['pg']=="vr"))
              { 
	  
				$this->idShift =$this->getShiftByStudentId($this->student_id)->id;
				$this->section_id =$this->getSectionByStudentId($this->student_id)->id;
				$this->idLevel =$this->getLevelByStudentId($this->student_id)->id;
				$this->room_id =$this->getRoomByStudentId($this->student_id)->id;
				  
              } 
				
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
									 $room=$this->getRoomName($this->room_id);
									$level=$this->getLevel($this->idLevel);
									$section=$this->getSection($this->section_id);
									$shift=$this->getShift($this->idShift);
									
									$evaluationPeriod=$this->getEvaluationPeriod($this->evaluation_id);
                               $acadPeriod_for_this_room = $this->getAcademicPeriodName_($acad_sess,$this->room_id);
                              
                              $name_acadPeriod_for_this_room=null;           
                              if(isset($acadPeriod_for_this_room))//!=null)
                               {       
                                 $name_acadPeriod_for_this_room=$acadPeriod_for_this_room->name_period;
                               }    
                                     //retire tout aksan yo    
                                         
		                                 $student_= strtr( $student, pa_daksan() );
		                                 $room_ = strtr( $room, pa_daksan() );
		                                 $level_ = strtr( $level, pa_daksan() );
		                                 $section_ = strtr( $section, pa_daksan() );
		                                 $shift_ = strtr( $shift, pa_daksan() );
		                                 $evaluationPeriod_ = strtr( $evaluationPeriod, pa_daksan() );
		                                 $name_acadPeriod_for_this_room_ = strtr( $name_acadPeriod_for_this_room, pa_daksan() );
                                        $period_exam_name_ = strtr( $period_exam_name, pa_daksan() );
								
								
								 $base = '';
								   
								if($siges_structure==1)	
									$base = '/'.Yii::app()->session['currentName_academic_year'];
							    elseif($siges_structure==0)	
							         $base = '';
									
								//   <!-- As we change SECTION TO NIVEAU, we should test $section and/or 'Fondamental' -->
								$path=$reportCard.$base.'/'.$name_acadPeriod_for_this_room_.'/'.$shift_.'/'.$section_.'/'.$level_.'/'.$room_;
								$path1=$reportCard.$base.'/'.$name_acadPeriod_for_this_room_.'/'.$shift_.'/Primaire/'.$level_.'/'.$room_;
									 
								                                       
                                         
                                         
                                         
                              if($name_acadPeriod_for_this_room!=null)
                               {  
   							      if($reportcard_structure==1) //One evaluation by Period
								    {
									   if($siges_structure==0)
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
												    	   
											                 echo'<h2>'.strtoupper(strtr(Yii::t('app','Report Card '), pa_daksan() )).'</h2></div> '; 
																					
															  echo '<table class="tb"> 
											                                                                     													  
																		  <tr><td></td></tr>
																		  <tr><td style="width:50%; "> '; 
																		    echo Yii::t('app','Reportcard is not yet available. Please, check later.'); 
																		  echo '</td></tr>
																		    </table>
																	         <br/> <br/> 
																	                      
																	    </div>';
											          } 
											        
								                }  
											elseif($siges_structure==1)
											  {
											  	
											  	if(file_exists(Yii::app()->basePath.'/../'.$path.'/'.$student_.'_'.$this->student_id.'_'.$evaluationPeriod_.'_'.$period_exam_name_.'_'.$name_acadPeriod_for_this_room_.'.pdf'))  // if pdf file exist, allowlink to print it 
									         {
									            
												 
												 $explode_baseurl= explode("protected",substr(Yii::app()->baseUrl, 0));
                         
												 $url=$student_.'_'.$this->student_id.'_'.$evaluationPeriod_.'_'.$period_exam_name_.'_'.$name_acadPeriod_for_this_room_.'.pdf';                                        
                                   
												 
												 echo '   
															<div class="bulletin" style="width:90%; height:1100px;">
																
															   <div id="pdf" style="width:100%; height:1100px;">
											<object width="100%" height="100%" type="application/pdf" data="'.Yii::app()->baseUrl.'/'.$path.'/'.$student_.'_'.$this->student_id.'_'.$evaluationPeriod_.'_'.$period_exam_name_.'_'.$name_acadPeriod_for_this_room_.'.pdf'.'#toolbar=0&navpanes=0&scrollbar=0&page=1&view=FitV">';
											
											echo '<p>'.Yii::t('app','It appears you don\'t have a PDF plugin for this browser.<br/> You can ').'<a href=\"'.Yii::app()->baseUrl.'/'.$path.'/'.$student_.'_'.$this->student_id.'_'.$evaluationPeriod_.'_'.$period_exam_name_.'_'.$name_acadPeriod_for_this_room_.'.pdf'.'\">'.Yii::t('app',' click here to download the PDF file.</a>'); echo '</p>';
											  echo '
											<!-- <!DOCTYPE html>
											<html moznomarginboxes="" mozdisallowselectionprint="" dir="ltr">   -->
											</object>
											</div>													 
											                </div>';
												
									        
									          }
										   elseif(file_exists(Yii::app()->basePath.'/../'.$path1.'/'.$student_.'_'.$this->student_id.'_'.$evaluationPeriod_.'_'.$period_exam_name_.'_'.$name_acadPeriod_for_this_room_.'.pdf'))  // if pdf file exist, allowlink to print it 
													         {
													            
																 
																 $explode_baseurl= explode("protected",substr(Yii::app()->baseUrl, 0));
				                         
																 $url=$student_.'_'.$this->student_id.'_'.$evaluationPeriod_.'_'.$period_exam_name_.'_'.$name_acadPeriod_for_this_room_.'.pdf';                                        
				                                   
																 
																 echo '   
															<div class="bulletin" style="width:90%; height:1100px;">
																
															   <div id="pdf" style="width:100%; height:1100px;">
											<object width="100%" height="100%" type="application/pdf" data="'.Yii::app()->baseUrl.'/'.$path1.'/'.$student_.'_'.$this->student_id.'_'.$evaluationPeriod_.'_'.$period_exam_name_.'_'.$name_acadPeriod_for_this_room_.'.pdf'.'#toolbar=0&navpanes=0&scrollbar=0&page=1&view=FitV">';
											
											echo '<p>'.Yii::t('app','It appears you don\'t have a PDF plugin for this browser.<br/> You can ').'<a href=\"'.Yii::app()->baseUrl.'/'.$path1.'/'.$student_.'_'.$this->student_id.'_'.$evaluationPeriod_.'_'.$period_exam_name_.'_'.$name_acadPeriod_for_this_room_.'.pdf'.'\">'.Yii::t('app',' click here to download the PDF file.</a>'); echo '</p>';
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
												    	   
											                 echo'<h2>'.strtoupper(strtr(Yii::t('app','Report Card '), pa_daksan() )).'</h2></div> '; 
																					
															  echo '<table class="tb"> 
											                                                                     													  
																		  <tr><td></td></tr>
																		  <tr><td style="width:50%; "> '; 
																		    echo Yii::t('app','Reportcard is not yet available. Please, check later.'); 
																		  echo '</td></tr>
																		    </table>
																	         <br/> <br/> 
																	                      
																	    </div>';
											          } 
											  	
											  	
											  	}
											                                             
		                                       $this->noStud = 1; //people enrolled this room pour cette annee academic
                                       
  									  
									  }
								  elseif($reportcard_structure==2)  //Many evaluations in ONE Period
									{
									   if($siges_structure==0)
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
											    	   
										                 echo'<h2>'.strtoupper(strtr(Yii::t('app','Report Card '), pa_daksan() )).'</h2></div> '; 
																				
														  echo '<table class="tb"> 
										                                                                     													  
																	  <tr><td></td></tr>
																	  <tr><td style="width:50%; "> '; 
																	    echo Yii::t('app','Reportcard is not yet available. Please, check later.'); 
																	  echo '</td></tr>
																	    </table>
																         <br/> <br/> 
																                      
																    </div>';
										          } 
										
										
										       }  
											elseif($siges_structure==1)
											  {
											  	 if(file_exists(Yii::app()->basePath.'/../'.$path.'/'.$student_.'_'.$this->student_id.'_'.$evaluationPeriod_.'_'.$period_exam_name_.'_'.$eval_date.'_'.$name_acadPeriod_for_this_room_.'.pdf'))  // if pdf file exist, allowlink to print it 
									         {
									            
												 
												 $explode_baseurl= explode("protected",substr(Yii::app()->baseUrl, 0));
                         
												 $url=$student_.'_'.$this->student_id.'_'.$evaluationPeriod_.'_'.$period_exam_name_.'_'.$eval_date.'_'.$name_acadPeriod_for_this_room_.'.pdf';                                        
                                   
												 
												 echo '   
															<div class="bulletin" style="width:90%; height:1100px;">
																
															   <div id="pdf" style="width:100%; height:1100px;">
											<object width="100%" height="100%" type="application/pdf" data="'.Yii::app()->baseUrl.'/'.$path.'/'.$student_.'_'.$this->student_id.'_'.$evaluationPeriod_.'_'.$period_exam_name_.'_'.$eval_date.'_'.$name_acadPeriod_for_this_room_.'.pdf'.'#toolbar=0&navpanes=0&scrollbar=0&page=1&view=FitV">';
											
											echo '<p>'.Yii::t('app','It appears you don\'t have a PDF plugin for this browser.<br/> You can ').'<a href=\"'.Yii::app()->baseUrl.'/'.$path.'/'.$student_.'_'.$this->student_id.'_'.$evaluationPeriod_.'_'.$period_exam_name_.'_'.$eval_date.'_'.$name_acadPeriod_for_this_room_.'.pdf'.'\">'.Yii::t('app',' click here to download the PDF file.</a>'); echo '</p>';
											  echo '
											<!-- <!DOCTYPE html>
											<html moznomarginboxes="" mozdisallowselectionprint="" dir="ltr">   -->
											</object>
											</div>													 
											                </div>';
												
									        
									          }
										   elseif(file_exists(Yii::app()->basePath.'/../'.$path1.'/'.$student_.'_'.$this->student_id.'_'.$evaluationPeriod_.'_'.$period_exam_name_.'_'.$eval_date.'_'.$name_acadPeriod_for_this_room_.'.pdf'))  // if pdf file exist, allowlink to print it 
													         {
													            
																 
																 $explode_baseurl= explode("protected",substr(Yii::app()->baseUrl, 0));
				                         
																 $url=$student_.'_'.$this->student_id.'_'.$evaluationPeriod_.'_'.$period_exam_name_.'_'.$eval_date.'_'.$name_acadPeriod_for_this_room_.'.pdf';                                        
				                                   
																 
																 echo '   
															<div class="bulletin" style="width:90%; height:1100px;">
																
															   <div id="pdf" style="width:100%; height:1100px;">
											<object width="100%" height="100%" type="application/pdf" data="'.Yii::app()->baseUrl.'/'.$path1.'/'.$student_.'_'.$this->student_id.'_'.$evaluationPeriod_.'_'.$period_exam_name_.'_'.$eval_date.'_'.$name_acadPeriod_for_this_room_.'.pdf'.'#toolbar=0&navpanes=0&scrollbar=0&page=1&view=FitV">';
											
											echo '<p>'.Yii::t('app','It appears you don\'t have a PDF plugin for this browser.<br/> You can ').'<a href=\"'.Yii::app()->baseUrl.'/'.$path1.'/'.$student_.'_'.$this->student_id.'_'.$evaluationPeriod_.'_'.$period_exam_name_.'_'.$eval_date.'_'.$name_acadPeriod_for_this_room_.'.pdf'.'\">'.Yii::t('app',' click here to download the PDF file.</a>'); echo '</p>';
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
											    	   
										                 echo'<h2>'.strtoupper(strtr(Yii::t('app','Report Card '), pa_daksan() )).'</h2></div> '; 
																				
														  echo '<table class="tb"> 
										                                                                     													  
																	  <tr><td></td></tr>
																	  <tr><td style="width:50%; "> '; 
																	    echo Yii::t('app','Reportcard is not yet available. Please, check later.'); 
																	  echo '</td></tr>
																	    </table>
																         <br/> <br/> 
																                      
																    </div>';
										          } 
										
											  	
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
	    	   
                 echo'<h2>'.strtoupper(strtr(Yii::t('app','Report Card '), pa_daksan() )).'</h2></div> '; 
										
				  echo '<table class="tb"> 
                                                                     													  
							  <tr><td></td></tr>
							  <tr><td style="width:50%; "> '; 
							   
							  echo '</td></tr>
							    </table>
						         <br/> <br/> 
						                      
						    </div>';
	}			
				
				

?>