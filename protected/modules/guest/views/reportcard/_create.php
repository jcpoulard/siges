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
				  else{$idShift = Yii::app()->session['Shifts'];
				  $this->idShift=$idShift;}
				  
			      if(isset($_GET['sec'])) $this->section_id=$_GET['sec'];
				  else{$section = Yii::app()->session['Sections'];
				  $this->section_id=$section;}
				  
				  if(isset($_GET['lev'])) $this->idLevel=$_GET['lev'];
				  else{$level = Yii::app()->session['LevelHasPerson'];
				  $this->idLevel=$level;}
				  
				  if(isset($_GET['roo'])) $this->room_id=$_GET['roo'];
				  
				  
				  if(isset($_GET['ev'])) $this->evaluation_id=$_GET['ev'];
				  else{$eval = Yii::app()->session['EvaluationByYear'];
				  $this->evaluation_id=$eval;}
				  
				  if(isset($_GET['stud'])) $this->student_id=$_GET['stud'];
				  
				  				 
     
     
				  

?>





<div style="width:100%; padding:0 0 10px 0;">
	     		
	<div>			
					 
		    <!--evaluation-->
			<div class="left" style="margin-right:5px;">
			<label for="Evaluation_name"><?php echo Yii::t('app','Evaluation Period'); ?></label><?php //echo $form->labelEx($model,'Evaluation Period'); ?>
			           <?php 
					
					         $modelEvaluation= new EvaluationByYear();
							    if(isset($this->evaluation_id))
							       echo $form->dropDownList($modelEvaluation,'evaluation',$this->loadEvaluation(), array('onchange'=> 'submit()', 'options' => array($this->evaluation_id=>array('selected'=>true)))); 
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
			<div class="left" style="margin-left:5px;">
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
			<div class="left" style="margin-left:5px;">
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
			<div class="left" style="margin-left:5px;">
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
		 $dataProvider=Persons::model()->searchStudentsForCreateReportcard($this->evaluation_id,$this->idShift,$this->section_id,$this->idLevel,$this->room_id,$acad); 
	
	 
		 if($dataProvider->getItemCount()==0)
			{ if(($this->room_id==null)&&($this->idLevel!=null)&&($this->section_id!=null)&&($this->idShift!=null))
			    echo "";//"Just pick an other room or move ....";
			 
		    }
         else
		   {  $this->tot_stud=$dataProvider->getItemCount();
			    $this->noStud=1;
			}
            			       Yii::app()->session['tot_stud'] = $this->tot_stud; 
    
        //error message
	    if(($this->message)||($this->messageView)||($this->success)||($this->messageEvaluation_id)||(($this->noStud ===0) && ($this->room_id != null)))
	        { echo '<div class="" style=" width:45%; margin-top:10px; margin-bottom:10px; background-color:#F8F8c9; ';		
			      if(($this->message)||($this->messageView)||($this->messageEvaluation_id)||(($this->noStud ===0) && ($this->room_id != null)))
				     echo 'color:red;">';
				  elseif($this->success)
				      echo 'color:green;">';
				   	
				    	
				   if($this->message)
				     echo Yii::t('app','You must check all students.').'<br/>';
				   
				   if($this->messageView)
				     echo Yii::t('app','You must check a student.').'<br/>';
				   
				   if($this->success)
				     echo Yii::t('app','You have successfully created all the reportcards.').'<br/>';
					  
				   if($this->messageEvaluation_id)
				      echo Yii::t('app','Please fill the Evaluation Period field.').'<br/>';
				   elseif(($this->noStud ===0) && ($this->room_id != null))
				      echo Yii::t('app','No student in this room.').'<br/>';
					
					
           echo '</div>';
	        }

		     		  
				
						$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'reportCard',
	'dataProvider'=>$dataProvider,
	'showTableOnEmpty'=>'true',
	'selectableRows' =>2,
	
    'columns'=>array(
	  //'id',
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

<div class="clear"></div>

<div class="row" style="height:auto;background-color:#EFF4F8;">
	<?php  
	       if($dataProvider->getItemCount()!=0)
			{				   
					$period=Grades::model()->searchPeriodForReportCard($acad,$this->evaluation_id);
					$last_period = array();
					
					$modelPastEval= new Evaluations();
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
				if($last_period!=null)
				 {	   
                                                               
           ?>
				
		
			<div class="" style="float:left; margin-left:30px; margin-top:10px; background-color:#EFF4F8;">
			<label for="Past_evaluation_name"><?php echo Yii::t('app','Include Past evalution period'); ?></label>
			<br/>
			<?php
	          echo CHtml::activecheckBoxList($modelPastEval, 'evaluation_name', $last_period, array('separator' => ' ', 'id' => 'chk_peval_id','template'=>'<li><i>{label}</i>{input}</li>'));	
	          
	          ?>
	          </div>
	       <?php   		      	                  	
			
				 }
			   	?> 
				 <div class="" style=" float:left;   margin-left:30px; margin-top:10px; background-color:#EFF4F8;">
				 <label for="Past_evaluation_name"><?php echo Yii::t('app','This is the FINAL PERIOD'); ?></label>
			
			<?php
	          echo CHtml::checkBox('final_period',false,array()); 	
	          
	          ?>
	          </div>	    
				 
		<?php		 
			}
			?>
			  
		
	
	
</div>


	
</div>
	
  </div>
    