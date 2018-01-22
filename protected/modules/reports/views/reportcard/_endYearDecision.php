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
 


    $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
     //if($current_acad==null)
						      //    $condition = '';
						    // else{
						     	   $condition = 'p.active IN(1,2) AND ';
						   //     }


      



                  if(isset($_GET['shi'])) $this->idShift=$_GET['shi'];
				  else{$idShift = Yii::app()->session['ShiftsAdmit'];
				  $this->idShift=$idShift;}
				  
			      if(isset($_GET['sec'])) $this->section_id=$_GET['sec'];
				  else{$section = Yii::app()->session['SectionsAdmit'];
				  $this->section_id=$section;}
				  
				  if(isset($_GET['lev'])) $this->idLevel=$_GET['lev'];
				  else{$level = Yii::app()->session['LevelHasPersonAdmit'];
				  $this->idLevel=$level;}
				  
				 
				  if(isset($_GET['stud'])) $this->student_id=$_GET['stud'];
				  
 
      
     
     	
?>



<div class="box box-info">
         <div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin">
                      
                      <tbody>
                        
                        <tr>
                          <td colspan="4">
<div style="padding:0px;">			

				 
		    <!--evaluation-->
			<div class="left" style="margin-left:10px;">
			<label for="Evaluation_name"></label>
			           
				</div>
			
			
			
			<!--Shift(vacation)-->
        <div class="left" style="margin-left:10px;">
		
			<?php $modelShift = new Shifts;
			echo $form->labelEx($modelShift,Yii::t('app','Shift'));?>
					 <?php 
							 $default_vacation=null;
					         $default_vacation_name = infoGeneralConfig('default_vacation');
						   		
						   		$criteria2 = new CDbCriteria;
						   								$criteria2->condition='shift_name=:item_name';
						   								$criteria2->params=array(':item_name'=>$default_vacation_name,);
						   		$default_vacation = Shifts::model()->find($criteria2);
						   		
				   		

						
						  if((isset($this->idShift))&&($this->idShift!=''))
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
					
					    
							    if((isset($this->section_id))&&($this->section_id!=0))
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
					 
					   
						if((isset($this->idLevel))&&($this->idLevel!=0))
							    echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevelByIdShiftSectionId($this->idShift,$this->section_id,$acad_sess), array('options' => array($this->idLevel=>array('selected'=>true)),'onchange'=> 'submit()', )); 
							 else
								{ $this->idLevel=0;
								  echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevelByIdShiftSectionId($this->idShift,$this->section_id,$acad_sess), array('onchange'=> 'submit()' )); 
					              $this->room_id=0;
							      }
						echo $form->error($modelLevelPerson,'level'); 
					 
					  ?>
				</div>
			
			<!--room-->
			<div class="left" style="margin-left:10px;">
			     <?php  $modelRoom = new Rooms;
			      
			                     echo $form->labelEx($modelRoom,Yii::t('app','Room')); ?>
			          <?php 
					
					
						    
							  
							  if((isset($this->room_id))&&($this->room_id!=0))
							   { 
						          echo $form->dropDownList($modelRoom,'room_name',$this->loadRoomByIdShiftSectionLevel($this->idShift,$this->section_id,$this->idLevel), array('onchange'=> 'submit()','options' => array($this->room_id=>array('selected'=>true)) )); 
					             }
							   else
							      { $this->room_id=0;
							      	echo $form->dropDownList($modelRoom,'room_name',$this->loadRoomByIdShiftSectionLevel($this->idShift,$this->section_id,$this->idLevel), array('onchange'=> 'submit()')); 
							          
									 
							      }
						echo $form->error($modelRoom,'room_name'); 
						
					   ?>
				</div>
		 	
		
													   
    </div>

						 </td>
	       
					       
					    </tr>
					    
					    <tr>
					       <td colspan="4"> 

			<?php	 
			
			
$display_name=false;
	                                                                                                                                             

 //Extract use automatic mention
 $use_automatic_mention = infoGeneralConfig('use_automatic_mention');
  //si classe la nan ekzamen ofisyel pa bay mention otomatik
	   	  $menfp = '';
	   	   
			         
	   	   
			   
if((isset($this->room_id))&&($this->room_id!=0))
   {     
	   	$model_menfp=isLevelExamenMenfp($this->idLevel,$acad_sess);
			      
			      if($model_menfp !=null)
			        $menfp = $model_menfp['id'];
			      
	   	 
	   	 if( ($use_automatic_mention==0) ) //mansyon an pa otomatik
	   	   echo $this->renderPartial('_endYD1', array('model'=>$model, 'form' =>$form));
	   	 elseif( ($use_automatic_mention==1)&&($menfp!='') ) //mansyon an pa otomatik
	   	    echo $this->renderPartial('_endYD1', array('model'=>$model, 'form' =>$form));
	   	    else //mansyon an otomatik
	   	     echo $this->renderPartial('_endYD2', array('model'=>$model, 'form' =>$form));
   	
   	
   	}//end room_id !=''		
			
			
			?> 
			
						        	  </td>
                                 </tr>
                                
                                
		<?php	
			//Submit button
		 if((isset($this->room_id))&&($this->room_id!=""))//if((isset($this->idLevel))&&($this->idLevel!=""))//
		   { 
			   	if((!$this->lastReportcardNotSet)&&(!$this->messageNoStud)&&(!$this->messageNoPassingGradeSet))
		  		 { 
	  		 	
	  		 ?>
                        <tr>
                                 <td colspan="4">
          <?php
			 
            if((!$this->messageDecisionDone)&&(!$display_name))
             {
	  		 	//if(!isAchiveMode($acad))
	  		 	    echo CHtml::submitButton(Yii::t('app', 'Execute Decision '),array('name'=>'execute','class'=>'btn btn-warning')); 
	            
	           
			   echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary')); //'Cancel ' avec espace a la fin POUR AVOIR UNE TRADUCTION "Annuler"/ sans espace=>'Retour'
                                         
                                           //back button   
                                              $url=Yii::app()->request->urlReferrer;
                                              $explode_url= explode("php",substr($url,0));
				             
                                              echo ' <a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';
              }
           else
              echo CHtml::submitButton(Yii::t('app', 'Update Decision Of Student In This Room'),array('name'=>'update','class'=>'btn btn-warning'));
              
                                      
                  echo CHtml::submitButton(Yii::t('app', 'View Decision For This Level'),array('name'=>'view','class'=>'btn btn-warning'));
          
          ?>
                                      </td>
                        </tr>
          <?php
			        }	
			 
		      }																	
																	
	  ?>
	  
	         
							       
 
 
                       </tbody>
                    </table>
                  </div><!-- /.table-responsive -->
                </div><!-- /.box-body -->
                
              </div>

  	
           	
     
	  
 
 						

  