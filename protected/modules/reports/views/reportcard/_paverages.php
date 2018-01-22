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


  $this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',));
   
	
 $acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

 


//Extract reportcard_structure (1:One evaluation by Period OR 2:Many evaluations in ONE Period)
         $criteria_ = new CDbCriteria;
		 $criteria_->condition='item_name=:item_name';
		 $criteria_->params=array(':item_name'=>'reportcard_structure',);
		 $reportcard_structure = GeneralConfig::model()->find($criteria_)->item_value;

 
  $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
    if($current_acad==null)
						          $condition = '';
						     else{
						     	   if($acad!=$current_acad->id)
							         $condition = '';
							      else
							         $condition = 'p.active IN(1,2) AND ';
						        }




				  

?>




</br>
<div class="b_mail">

<div class="box box-info">
         <div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin">
                      
                      <tbody>
                        
                        <tr>
                          <td colspan="2" style="width:50%;">
<div style="padding:0px;">			

		   
			<!--Shift(vacation)-->
        <div class="left" style="margin-left:10px;">
		
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
			<div class="left" style="margin-left:10px;">
			<?php $modelSection = new Sections;
			                   echo $form->labelEx($modelSection,Yii::t('app','Section')); ?>
			           <?php 
					
					    
							    if($this->section_id!='')
							       echo $form->dropDownList($modelSection,'section_name',$this->loadSectionByIdShift($this->idShift), array('options' => array($this->section_id=>array('selected'=>true)),'onchange'=> 'submit()')); 
							    else
								  { 
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
					 
					   
						if(isset($this->idLevel)&&($this->idLevel!=''))
							    echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevelByIdShiftSectionId($this->idShift,$this->section_id,$acad_sess), array('options' => array($this->idLevel=>array('selected'=>true)),'onchange'=> 'submit()', )); 
							 else
								{ 
								  echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevelByIdShiftSectionId($this->idShift,$this->section_id,$acad_sess), array('onchange'=> 'submit()' )); 
					              
							      }
						echo $form->error($modelLevelPerson,'level'); 
					 
					  ?>
				</div>
			
						
				
</div>

						 </td>
						 <td colspan="2">
		<?php 				   
				 $last_period = array();
				 $last_eval_date_for_each_period= array();
					$modelPastEvaluations= new Evaluations;
					$modelPastEval= new EvaluationByYear;
					
					
					if($reportcard_structure==1) //One evaluation by Period
					  {
					       $periods = ReportCard::searchPeriodForPA($acad_sess);
                 		
                 		if($periods!=null)
				                     {  
					                   foreach($periods as $id_period)
					                      {
			 	                                $eval_period = $this->searchPeriodName($id_period["evaluation_by_year"]);
			 	                                
										        $last_period[$id_period["evaluation_by_year"]] = $eval_period;
										        						
											}
											
								       }
                              
                             if($last_period!=null)
								{	   
					                                                               
					           ?>
									
							
								<div class="" style="float:left; margin-left:0px; margin-top:10px; padding-bottom:-20px; ">
								<label for="Past_evaluation_name"><?php echo Yii::t('app','Choose evalution period'); ?></label>
								
								<?php
						          echo CHtml::activecheckBoxList($modelPastEvaluations, 'evaluation_name', $last_period, array('separator' => '', 'id' => 'chk_peval_id','template'=>'<div class="rmodal"> <div class=""  style="float:left; width:auto;"> <div class="l">{label}</div><div class="r" style="margin-right:40px;">{input}</div></div></div>'));	
						          
						          ?>
						          </div>
						       <?php   		      	                  	
								
									 }
                               	
					   }
					elseif($reportcard_structure==2)  //Many evaluations in ONE Period
					   {
					          $result_last2=EvaluationByYear::model()->getLastEvaluationForEachPeriod($acad_sess);
							 if(($result_last2!=null))
							  {  foreach($result_last2 as $r)
								  { 
								  	  
								  	 	$last_eval_date_for_each_period[$r["academic_year"]]= $r["name_period"];
								
								  	  			   
									}
																	     
								}

                               if($last_eval_date_for_each_period!=null)
								 {	   
				                                                               
				           ?>
								
						
							<div class="" style="float:left; margin-left:0px; margin-top:10px; padding-bottom:-20px; ">
							<label for="Past_evaluation_name"><?php echo Yii::t('app','Choose evalution period'); ?></label>
							
							<?php
					          echo CHtml::activecheckBoxList($modelPastEval, 'academic_year', $last_eval_date_for_each_period, array('separator' => '','template'=>'<div class="rmodal" style="float:left; width:auto;"> <div class=""  style="margin-right:22px; float:left; width:auto;"> <div class="l" style="margin-right:-100px; width:70%;">{label}</div><div class="r" style="margin-right:40px; width:3%;">{input}</div></div></div>'));
					          
					
					          
					          ?>
					          </div>
					       <?php   		      	                  	
							
								 }
				 	
					     } 
					     
					     
				
										 
				
			   	?> 
			   	
			   	
			             </td>
	                   
					       
					    </tr>
					    
					    <tr>
					       <td colspan="4">


  <div class="list_secondaire">
											
   <?php 		
           
	     
	     $dataProvider=Persons::model()->searchStudentsForPAverage($condition,$this->idShift,$this->section_id,$this->idLevel,$acad_sess); 
	     
	     $tmwen=false;
	 
		 if($dataProvider->getItemCount()==0)
			{ 
				 $tmwen=false;
				
		    }
         else
		   {  $this->tot_stud=$dataProvider->getItemCount();
			    $this->noStud=1;
			    $tmwen=true;
			}
            			       Yii::app()->session['tot_stud'] = $this->tot_stud; 
    
        //error message 
	        	if(($this->messageEvaluationNotSet)||($this->messageNoStudChecked)||($this->messageWrongPeriodChoosen))			
			      { echo '<div class="" style=" padding-left:0px;margin-right:240px; margin-bottom:-45px; ';//-20px; ';
				      echo '">';
				      
				       echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
					   <tr>
					    <td style="text-align:center;">';
				       
			      }
			    elseif(($this->noStud==0)&&($this->idLevel!=''))
				    { echo '<div class="" style=" padding-left:0px;margin-right:240px; margin-bottom:-13px; ';//-20px; ';
					      echo '">';
					      
					       echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
						   <tr>
						    <td style="text-align:center;">';
					       
				      }			      
				 
				   				   
				   if($this->messageEvaluationNotSet)
				    { echo '<span style="color:red;" >'.Yii::t('app','Choose evalution period').'</span>'.'<br/>';
				       		
						
				        }
				        
				     if($this->messageNoStudChecked)
				    { echo '<span style="color:red;" >'.Yii::t('app','You must check at least one student.').'</span>'.'<br/>';
				       		
						
				        }
				  				     
				   if((($this->noStud==0)&&($this->idLevel!='')))
				     { echo '<span style="color:red;" >'.Yii::t('app','No student available for this level. Make sure report card for the last period is already done.').'</span>'.'<br/>';
				        	
										     
				        }
				        
				    if($this->messageWrongPeriodChoosen)
				    { echo '<span style="color:red;" >'.Yii::t('app','You have choosen wrong evaluations. General average is wrong.').'</span>'.'<br/>';
				       		
						
				        }

					
								     
				        
					  
					if(($this->messageEvaluationNotSet)||($this->messageNoStudChecked)||($this->messageWrongPeriodChoosen)||(($this->noStud==0)&&($this->idLevel!='')))	
					   { 
					   	   echo'</td>
					    </tr>
						</table>'; 
						
					   	echo'</div>';  
					   
					     }
					
					
                  
	        

		     		  
				
	$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'reportCard',
	'dataProvider'=>$dataProvider,
	'showTableOnEmpty'=>'true',
	'selectableRows' =>2,
	
    'columns'=>array(
	
		
	  array('name'=>Yii::t('app','First name'),
	        'value'=>'$data->first_name'
			),

      array('name'=>Yii::t('app','Last name'),
	        'value'=>'$data->last_name'
			),

     array('name'=>Yii::t('app','Sexe'),
	        'value'=>'$data->sexe'
			),
			
	'identifiant', 
	'matricule',

       array(             'class'=>'CCheckBoxColumn',   
                           'id'=>'chk',
                 ),           
		
    ),
));
				
				
		
		   
			 ?>

</div>
						 </td>
	       
					       
					    </tr>
					    
					   


			              <tr>
					       <td colspan="4">
		                
	 <?php 
           if(($this->idLevel!=null)&&($this->section_id!=null)&&($this->idShift!=null))		
			      {
				      if($this->noStud===1)
						{              
		                       
								    	echo CHtml::submitButton(Yii::t('app', 'Create PDF'),array('name'=>'createPdf','class'=>'btn btn-warning')); 
						
		            		           
                          //back button   
                                              $url=Yii::app()->request->urlReferrer;
                                              $explode_url= explode("php",substr($url,0));
				             
                                              echo ' <a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';

                           		
                  
				 
			           }
                      
            }
                        
                        
                                                                  

	?>
	
                          </td>
                           </tr>

 
 
                       </tbody>
                    </table>
                  </div><!-- /.table-responsive -->
                </div><!-- /.box-body -->
                
              </div>
 
 
 </div>
    