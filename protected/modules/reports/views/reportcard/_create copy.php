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
   

 $acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

 
//Extract reportcard_structure (1:One evaluation by Period OR 2:Many evaluations in ONE Period)
         $reportcard_structure = infoGeneralConfig('reportcard_structure');
         
         $siges_structure=infoGeneralConfig('siges_structure'); 

  
  $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
     if($current_acad==null)
						          $condition = '';
						     else{
						     	   if($acad!=$current_acad->id)
							         $condition = '';
							      else
							         $condition = 'p.active IN(1,2) AND ';
						        }


      



	 if(isset($_GET['shi'])) $this->idShift=$_GET['shi'];
				  else{$idShift = Yii::app()->session['Shifts'];
				  $this->idShift=$idShift;}
				  
			      if(isset($_GET['sec'])) $this->section_id=$_GET['sec'];
				  else{$section = Yii::app()->session['Sections'];
				  $this->section_id=$section;}
				  
				  if(isset($_GET['lev'])) $this->idLevel=$_GET['lev'];
				  else{$level = Yii::app()->session['LevelHasPerson'];
				  $this->idLevel=$level;}
				  
				  if(!isset($_POST['Rooms']))
	                  if(isset($_GET['roo'])) $this->room_id=$_GET['roo'];
				  
				  
				  if(isset($_GET['ev'])) $this->evaluation_id=$_GET['ev'];
				  else{$eval = Yii::app()->session['EvaluationByYear'];
				  $this->evaluation_id=$eval;}
				  
				  if(isset($_GET['stud'])) $this->student_id=$_GET['stud'];
				  
				  				 
     
     
				  

?>
 


<div class="row" style="padding: 5px 10px;"> 
     
      <div class="span9" >
			
		

		    <!--evaluation-->
			<div class="span2" >
			<label for="Evaluation_name"><?php echo Yii::t('app','Evaluation Period'); ?></label><?php //echo $form->labelEx($model,'Evaluation Period'); ?>
			           <?php
			 		
					         $modelEvaluation= new EvaluationByYear();
							    if(isset($this->evaluation_id)&&($this->evaluation_id!=''))
							       echo $form->dropDownList($modelEvaluation,'evaluation',$this->loadEvaluation(), array('onchange'=> 'submit()', 'options' => array($this->evaluation_id=>array('selected'=>true)))); 
							    else
								  { 
									echo $form->dropDownList($modelEvaluation,'evaluation',$this->loadEvaluation(), array('onchange'=> 'submit()')); 
						           }					      
						  
						echo $form->error($modelEvaluation,'evaluation');  
						  						
					   ?>
				</div>
			
						
			<!--Shift(vacation)-->
        <div class="span2" >
		
			<?php $modelShift = new Shifts;
			echo $form->labelEx($modelShift,Yii::t('app','Shift'));?>
					 <?php 
					       
						
			      $default_vacation_name = infoGeneralConfig('default_vacation');
				   		
				   		$criteria2 = new CDbCriteria;
				   		$criteria2->condition='shift_name=:item_name';
				   		$criteria2->params=array(':item_name'=>$default_vacation_name,);
				   		$default_vacation = Shifts::model()->find($criteria2);
				   		
				   		
						
						  if(isset($this->idShift)&&($this->idShift!=''))
						        {   
					               echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('options' => array($this->idShift=>array('selected'=>true)),'onchange'=> 'submit()' )); 
					             }
							  else
								{ $this->idLevel=0;
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
							    echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevelByIdShiftSectionId($this->idShift,$this->section_id,$acad_sess), array('options' => array($this->idLevel=>array('selected'=>true)),'onchange'=> 'submit()', )); 
							 else
								{ $this->idLevel=0;
								  //$this->room_id=0;
								  echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevelByIdShiftSectionId($this->idShift,$this->section_id,$acad_sess), array('onchange'=> 'submit()' )); 
					              
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
						          echo $form->dropDownList($modelRoom,'room_name',$this->loadRoomByIdShiftSectionLevel($this->idShift,$this->section_id,$this->idLevel), array('onchange'=> 'submit()','options' => array($this->room_id=>array('selected'=>true)) )); 
					             }
							   else
							      { echo $form->dropDownList($modelRoom,'room_name',$this->loadRoomByIdShiftSectionLevel($this->idShift,$this->section_id,$this->idLevel), array('onchange'=> 'submit()')); 
							          
									 $this->room_id=0;
							      }
						echo $form->error($modelRoom,'room_name'); 
						
										
					   ?>
				</div>
          
          <!--room
			<div class="span2" >
			     <?php  // $modelRoom = new Rooms;
			                    // echo '<label>'.Yii::t('app','Category').'</label>'; ?>
			          <?php 
							/*					  
							  if(isset($this->reportcard_category_id)&&($this->reportcard_category_id!=''))
							       echo $form->dropDownList($model,'reportcard_category',$this->loadReportcardCategory(), array('options' => array($this->reportcard_category_id=>array('selected'=>true)),'onchange'=> 'submit()')); 
							    else
								  { 
									echo $form->dropDownList($model,'reportcard_category',$this->loadReportcardCategory(), array('onchange'=> 'submit()' )); 
						           }					      
						  
						echo $form->error($model,'reportcard_category');  
						*/
										
					   ?>
				</div>
				-->

     </div>			
				
</div>


<br/>


<div class="grid-view">


  											
   <?php 				  //And you can get values like this:
             
			  
			
        
		 $dataProvider=Persons::model()->searchStudentsForCreateReportcard($condition,$this->evaluation_id,$this->idShift,$this->section_id,$this->idLevel,$this->room_id,$acad_sess); 
	     
	     
	     switch($this->reportcard_category_id)
	      {
	      	case 0: //sans retenue
	      	        $condition_category = 'p.id NOT IN( SELECT student FROM balance where balance > 0) AND ';
	      	        $condition = $condition_category.$condition;
	      	        
	      	        $dataProvider=Persons::model()->searchStudentsForCreateReportcard($condition,$this->evaluation_id,$this->idShift,$this->section_id,$this->idLevel,$this->room_id,$acad_sess);
	      	      break;
	      	      
	      	case 1: //avec retenue
	      	        $condition_category = 'p.id IN( SELECT student FROM balance balance where balance > 0) AND ';
	      	        $condition = $condition_category.$condition;
	      	        $dataProvider=Persons::model()->searchStudentsForCreateReportcard($condition,$this->evaluation_id,$this->idShift,$this->section_id,$this->idLevel,$this->room_id,$acad_sess);
	      	
	      	      break;
	      	
	      	default: $dataProvider=Persons::model()->searchStudentsForCreateReportcard($condition,$this->evaluation_id,$this->idShift,$this->section_id,$this->idLevel,$this->room_id,$acad_sess);
	      	      break;
	        }
	     
	     
	     $tmwen=false;
	 
		 if($dataProvider->getItemCount()==0)
			{ 
				 $tmwen=false;
				if(($this->room_id==null)&&($this->idLevel!=null)&&($this->section_id!=null)&&($this->idShift!=null))
			    echo "";//"Just pick an other room or move ....";
			 
		    }
         else
		   {  $this->tot_stud=$dataProvider->getItemCount();
			    $this->noStud=1;
			    $tmwen=true;
			}
            			       Yii::app()->session['tot_stud'] = $this->tot_stud; 
    
        //error message 
	        	if(($tmwen==true)&&($this->room_id!=null)&&($this->idLevel!=null)&&($this->section_id!=null)&&($this->idShift!=null))		
			      { echo '<div class="" style=" padding-left:0px;margin-right:240px; margin-bottom:-45px; ';//-20px; ';
				      echo '">';
			      }			      
				 else 	
				   	{
				   		echo '<div class="" style=" padding-left:0px;margin-right:240px; margin-bottom:-13px; ';//-20px; ';
				      echo '">';
				   	  }
				   	  
				   	  
				   echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
					   <tr>
					    <td style="text-align:center;">';
					     	
				   if($this->message)
				     echo '<span style="color:red;" >'.Yii::t('app','You must check all students.').'</span>'.'<br/>';
				   
				   if($this->messageView)
				     echo '<span style="color:red;" >'.Yii::t('app','You must check a student.').'</span>'.'<br/>';
				   
				   if($this->success)
				     echo '<span style="color:green;" >'.Yii::t('app','You have successfully created reportcards.').'</span>'.'<br/>';
					  
				   if($this->messageEvaluation_id)
				      echo '<span style="color:red;" >'.Yii::t('app','Please fill the Evaluation Period field.').'</span>'.'<br/>';
				   elseif(($this->noStud ===0) && ($this->room_id != null))
				      echo '<span style="color:red;" >'.Yii::t('app','No student in this room.').'</span>'.'<br/>';
					
					 
					    echo '<span style="color:blue;" >'.Yii::t('app','- Students whose grades have not been validated will not have reportcard. -').'</span>';
					
					 echo'</td>
					    </tr>
						</table>';
					
           echo '</div>';
	      //  }

		     		  
				
						$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'reportCard',
	'dataProvider'=>$dataProvider,
	'showTableOnEmpty'=>'true',
	'selectableRows' =>2,
	
    'columns'=>array(
	 
	array('name'=>Yii::t('app','Code student'),'value'=>'$data->id_number'),
		
	  array('name'=>Yii::t('app','Student name'),
	        'value'=>'$data->first_name." ".$data->last_name'
			),
     
       array(             'class'=>'CCheckBoxColumn',   
                           'id'=>'chk',
                 ),           
		
    ),
));
				
				
		
		   
			 ?>


					

<br/>

<?php 
     
  //   if(!isAchiveMode($acad))
   //     {    
        
   ?>

  <div  style="float:left; width:100%;" >  

	<?php  
	      if($dataProvider->getItemCount()!=0)
			{	
				$last_eval_period = EvaluationByYear::model()->findByPk($this->evaluation_id);
         
				         if($last_eval_period->last_evaluation==1)
				          $this->final_period=true; 
		?>	
		                
		<?php 				   
				$period=Grades::model()->searchPeriodForReportCard($acad_sess,$this->evaluation_id);
				$last_period = array();
				
				$modelPastEval1= new EvaluationByYear();
				$last_eval_ = false; 
				$last_eval_date=null;
				
				$modelPastEval= new Evaluations();
							$acad_year=0; 
							$eval_date = '';
									  
				$array_past_period = array();
				$last_eval_date_for_each_period= array();
				 $period_id_and_average[]= array();
					
				if($reportcard_structure==1) //One evaluation by Period
				  {
				       //One evaluation by Period
					
					 //on ajoute les colonnes suivant le nbre d'etape anterieur
						if((isset($period)&&($period!=null)))
						  {  $period=$period->getData();//return a list of  objects
								foreach($period as $r)
								  {
									if($r->evaluation!=$this->evaluation_id)
									  { $last_period[$r->evaluation] = $r->name_period;
									    	
								      }															
								   }
						   }
						   
				      //end of   One evaluation by Period  
				      
				      	//One evaluation by Period	
						if($last_period!=null)           //(Many evaluations in ONE Period)
						 {	   
		                                                               
			             ?>
							
					
						<div class="" style="float:left; margin-left:30px; margin-top:10px; padding-bottom:-20px; ">
						<label for="Past_evaluation_name"><?php echo Yii::t('app','Include Past evalution period'); ?></label>
						
						<?php
				          //One evaluation by Period
				          echo CHtml::activecheckBoxList($modelPastEval, 'evaluation_name', $last_period, array('separator' => '','template'=>'<div class="rmodal" style="float:left; width:auto;"> <div class=""  style="margin-right:10px; float:left; width:auto;"> <div class="l" style="margin-right:-20px; width:auto;">{label}</div><div class="r" style="float:left;margin-right:0px; width:3%;">{input}</div></div></div>'));		
				          
				          
				          
				          ?>
				          </div>
     
				       <?php   		      	                  	
						
							 }
					   	 
					   	                             	
				   }
				elseif($reportcard_structure==2)  //Many evaluations in ONE Period
				   {
				        //Many evaluations in ONE Period				
		              
		
				        //find date of the current evaluation
						$result=EvaluationByYear::model()->searchPeriodName($this->evaluation_id);
							if(isset($result))
							 {  $result=$result->getData();//return a list of  objects
								 foreach($result as $r)
								   { $eval_date = $r->evaluation_date;
									  $acad_year = $r->academic_year;	   
									}
							   }
									          
						$result_last1=EvaluationByYear::model()->getLastEvaluationForAPeriod($acad_year, $acad_sess);
						    if(($result_last1!=null))
							  {  foreach($result_last1 as $r)
								   { $last_eval_date= $r["evaluation_date"];
										break;			   
									 }
								}
											  
							if($last_eval_date == $eval_date)
								$last_eval_ = true; 
								
								 //si wi, jwenn ID lot evalyasyon ki pase nan peryod sa deja
								
				 
							if($last_eval_)
								{ //find date of the current evaluation
								 //$last_eval_date_for_each_period= array();
								
								 
								 //tcheke tout last_eval ki pase deja
								 						          
									$result_last2=EvaluationByYear::model()->getLastEvaluationForEachPeriod($acad_sess);
									 if(($result_last2!=null))
									  {  foreach($result_last2 as $r)
										  { 
										  	if( strtotime($r["evaluation_date"]) < strtotime($eval_date)  )
										  	 {  
										  	 	$last_eval_date_for_each_period[$r["academic_year"]]= $r["name_period"];
										
										  	  } 			   
											}
																			     
										}
										
														      
								  }
							  //end of 	  Many evaluations in ONE Period
					
					        
					          	
								if($last_eval_date_for_each_period!=null) //(Many evaluations in ONE Period)
								 {	   
				                                                               
				           ?>
								
						
							<div class="" style="float:left; margin-left:30px; margin-top:10px; padding-bottom:-20px; ">
							<label for="Past_evaluation_name"><?php echo Yii::t('app','Include Past evalution period'); ?></label>
							
							<?php
					          //Many evaluations in ONE Period
					          echo CHtml::activecheckBoxList($modelPastEval1, '[1]academic_year', $last_eval_date_for_each_period, array('separator' => '','template'=>'<div class="rmodal" style="float:left; width:auto;"> <div class=""  style="margin-right:10px; float:left; width:auto;"> <div class="l" style="margin-right:-20px; width:auto;">{label}</div><div class="r" style="float:left;margin-right:0px; width:3%;">{input}</div></div></div>'));
					          
					          ?>
					          </div>
					       <?php   		      	                  	
							
								 }
			   

                                	
				     } 
				
				
					  
					   
					
				?>			   	
	
		  
			   <?php
			    if($reportcard_structure==1) //One evaluation by Period
                  {	
                  	 //Extract display_period_summary
				     $display_period_summary = infoGeneralConfig('display_period_summary');
				    
				     //Extract use_period_weight
				     $use_period_weight = infoGeneralConfig('use_period_weight');
				                                		  
					if( ($display_period_summary !=1) && ($use_period_weight!=1) )
					  {
						  if($last_period!=null)
							 {	   
			                                                               
			               ?>  
						                    
							      <div class="" style=" float:left;   margin-left:90px; margin-top:10px; ">
							      <label for="Past_evaluation_name"><?php echo Yii::t('app','Calculate general average'); ?></label>
						
						   <?php
				                  echo CHtml::checkBox('calculate_g_average',false,array()); 	
				          
				          ?>
				                  </div>	
				          <?php   		      	                  	
						
							 }
							 
					   }
					 elseif(($display_period_summary ==1)&&($this->final_period==true))
					  {
						  if($last_period!=null)
							 {	   
			                                                               
			               ?>  
						                    
							      <div class="" style=" float:left; text-align:center;  margin-left:90px; margin-top:10px; ">
							      <label for="summary"><?php echo Yii::t('app','Summary'); ?></label>
						
						   <?php
				                  echo CHtml::checkBox('summary',false,array()); 	
				          
				          ?>
				                  </div>	
				          <?php   		      	                  	
						
							 }
							 
					   }
                   
                   } 
						 //end of       One evaluation by Period
					   	?> 
	          
	          
	              
		
	         
		<?php		 
			}
			?>
			
 </div>			              
			              
<br/><br/>.

<div id="resp_form_siges">

        <form  id="resp_form">  
 	

<div class="col-submit">
		                
	 <?php 
	    if($dataProvider->getItemCount()!=0)
	     {
           if(($this->room_id!=null)&&($this->idLevel!=null)&&($this->section_id!=null)&&($this->idShift!=null))		
			      {
				      if($this->noStud===1)
						{              
		                      if(isset($_GET['from']))
		                       {  if($_GET['from']=='stud')
								    {   echo CHtml::submitButton(Yii::t('app', 'Create ReportCards for these students'),array('name'=>'enableguestview','class'=>'btn btn-warning')); 
								 
								 
								        if($this->allowLink)
									     {  
										   echo CHtml::submitButton(Yii::t('app', 'Create ReportCards for each student'),array('name'=>'create','class'=>'btn btn-warning'));
										   
										   
										 }
								 
								    }
								 
		                       }
		                       
		            		           
                          //back button   
                                              $url=Yii::app()->request->urlReferrer;
                                              $explode_url= explode("php",substr($url,0));
				             
                                              echo ' <a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';

                           		
                  
				 
			}
                        }
                        
                        
	     }                                                         

	?>
                
 </div>

 </form>
</div  >

 <?php
    //    }
      
      ?>       






            
         </div>
      </div>
      
  </div>
            
<script>



function msg()
{
    var msg1 = document.getElementById('msg_').value;
  if (document.getElementById('final_period').checked) 
  {
      alert(msg1);
  } 
  
}

</script>