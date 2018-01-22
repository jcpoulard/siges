
<?php 
/*
 * © 2010 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
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

    

$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
 

$couleur=1; //
$compt_taken_decision = 0;
$display_name=false;
$success_mention = infoGeneralConfig('success_mention');
	  
$failure_mention = infoGeneralConfig('failure_mention'); 

$menfp = null;
 $mention = null;
	   $average = 0;
	   $menfp_average =0;
	   $is_move_to_next_year=null;
	   //Extract average base
	   $average_base = infoGeneralConfig('average_base');
	   $menfp_passing_grade = round( ($average_base/2),2);
	   
	   $passing_grade=$this->getPassingGrade($_GET['le'],$acad_sess); //note de passage pour la classe

$model_menfp=isLevelExamenMenfp($_GET['le'],$acad_sess);
			      
			      if($model_menfp !=null)
			        $menfp = $model_menfp['id'];
 
 
  
           	
           	 $pers=User::model()->getPersonByUserId(Yii::app()->user->userid);
				 $pers=$pers->getData();
				 foreach($pers as $p)
				      $id_teacher=$p->id;
				
					    

 
 ?>
 

      
      
      
      <div class="box box-info">
         <div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin">
                      
                      <tbody>
                        
                        <tr>
                          <td colspan="4">
<div style="padding:0px;">			

				 
		   	<!--Shift(vacation)-->
        <div class="left" style="margin-left:10px;">
		
			
					  <?php echo $form->labelEx($model,'student_name'); ?>
								<?php 
									
								$criteria = new CDbCriteria(array('alias'=>'p', 'order'=>'last_name ASC','join'=>'left join room_has_person rh on(rh.students = p.id)', 'condition'=>'is_student=1 AND active IN(1,2) AND rh.academic_year ='.$acad_sess.' AND  rh.room='.$_GET['ro']));
								
							
							  	if($this->student_id!='')
							  	 {
								  	
								  	 echo $form->dropDownList($model,'student_name',$this->loadStudentByCriteria($criteria), array('onchange'=> 'submit()', 'options' => array($this->student_id=>array('selected'=>true)) ));
								  	 
								  	
							  	  }
							  	else
							  	  {
							  	  	
							  	  	  echo $form->dropDownList($model,'student_name',$this->loadStudentByCriteria($criteria), array('onchange'=> 'submit()', 'prompt'=>Yii::t('app','-- Please select student --') ));
							  	  	
							  	  	
							  	  }
								
								 ?>
								
				</div>
			 
		   										   
    </div>

						 </td>
	       
					       
					    </tr>
					    
					    <tr>
					       <td colspan="4"> 

  <div class="list_secondaire">
											
			<?php	 
			
						         
	   	   
			   
if((isset($this->student_id))&&($this->student_id!=0))
   {     
	$compt_stud_to_produce_last_reportcard = 0;
	   	$compt_taken_decision =0;
	   	$total_find=0;
	   	 
						 // record already in decision_finale table
						 $is_mention_set = $this->checkDecisionFinale($this->student_id, $acad_sess);                                                         
							
						//check if mention and/or is_move_to_next_year already set for a specific stud.(it means decision is already taken for him).	   
						 if((isset($is_mention_set))&&($is_mention_set!=null))
						   {  
							      foreach($is_mention_set as $result)
								   { $mention = $result["mention"];
								     $is_move_to_next_year = ["is_move_to_next_year"];
								   }
								if(($mention==null)&&($is_move_to_next_year==null))	 
				                   {
								      $total_find++;
											  
				                    }
				                   else
				                      $compt_taken_decision ++; 
		                    
						   }//end of checking if mention  already set for a specific stud.
						 else
						   {   						           
						   	   $compt_stud_to_produce_last_reportcard++;
						   	    //on n'a pas encore produit  le dernier bulletin
						   	  
						    }
						    
					


 if($compt_stud_to_produce_last_reportcard >0)		
			      { echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:0px; ';//-20px; ';
				      echo '">';
				      
				      echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
					   <tr>
					    <td style="text-align:center;">';	
				                  echo '<span style="color:red;" >'.Yii::t('app','Please make the Last Reportcard for this room, to be able to take decision.').'</span>';
				       
				       echo'</td>
					    </tr>
						</table>
						</div>';

				    }
	
	
$style_th='"text-align:center; vertical-align:middle; background-color:#E4E9EF; border-left: 1px solid  #E4E9EF;font-size: 1em; "';//'\'border-right: 1px solid #FFF; \'';
					    $style_td='"text-align:center; vertical-align:middle; border-left: 1px solid  #E4E9EF;font-size: 1em; "';//'\'border-right: 1px solid #FFF; \'';
					     $style_td_name='"text-align:left; vertical-align:middle; font-size: 1em; "';//'\'border-right: 1px solid #FFF; \'';
					   

	
 if($compt_stud_to_produce_last_reportcard ==0)	
  {
 	  

 	   
 	     if($compt_taken_decision==0) //decision an poko pran
 	      {
 	      	
 	      	}
 	     elseif($compt_taken_decision>0) //pran done yo nan tab decision_finale la
 	       {
 	       	      $is_mention_set = $this->checkDecisionFinale($this->student_id, $acad_sess);                                                         
							
						//check if mention and/or is_move_to_next_year already set for a specific stud.(it means decision is already taken for him).	   
						 if((isset($is_mention_set))&&($is_mention_set!=null))
						   {  
							 foreach($is_mention_set as $result)
							   { $mention = $result["mention"];
							     $is_move_to_next_year = $result["is_move_to_next_year"];
							     $average = $result["general_average"];
							   }
							  
							  if(($mention==null)&&($is_move_to_next_year==null))	 
		                          {
									if($menfp!=null)
	                                 { 
										 $menfp_data = MenfpDecision::model()->checkDecisionMenfp($this->student_id, $acad_sess);
										 foreach($menfp_data as $menfp_d)
										   {
										   	    $menfp_average = $menfp_d['average'];
										   	}
	                                 }
		                          }
		                          
						   }

 	       	}
 	     
       if($is_move_to_next_year==null)
		                  $this->isCheck=-1;
		             elseif($is_move_to_next_year==0)
		               $this->isCheck =0;
		             elseif($is_move_to_next_year==1)
		                $this->isCheck =1;	
            
               
             


	
	 echo '<div class=\'dataGrid\' id=\'page\'>
															<table  style="  width:100%; background-color:#EFF4F8; color: #1E65A4;">
														 <thead class="" >
														      <tr style="background-color:#E4E9EF;">
		
																						  <th  style='.$style_th.'><b>'.Yii::t('app','Name').'</b></th><th  style='.$style_th.'><b>'.Yii::t('app','Gender').'</b></th><th style='.$style_th.'><b> '.Yii::t('app','General Average').' </b></th>';
	
if($menfp!=null)
 echo '<th style='.$style_th.'><b>'.Yii::t('app','MENFP Average').' </b></th>';
	 
	
	
	
           														 	
																	echo '<th  style="text-align:center; vertical-align:middle; background-color:#E4E9EF; border-left: 1px solid  #E4E9EF;font-size: 1em; width:35px" ><b>'.Yii::t('app','Success').'</b><br/>';
																								
																					
																	echo '</th>'; 
																	
																	echo '<th  style="text-align:center; vertical-align:middle; background-color:#E4E9EF; border-left: 1px solid  #E4E9EF;font-size: 1em;  width:35px"><b>'.Yii::t('app','Failed').'</b><br/>';
																								
																					
																	echo '</th>';                                  
														 echo '</tr>
														 
														 </thead >
			   	
			   										<tbody class="">';
			   										
			 // record already in decision_finale table
						 $is_mention_set = $this->checkDecisionFinale($this->student_id, $acad_sess);                                                         
							
						//check if mention and/or is_move_to_next_year already set for a specific stud.(it means decision is already taken for him).	   
						 if((isset($is_mention_set))&&($is_mention_set!=null))
						   {  
							 foreach($is_mention_set as $result)
							   { $mention = $result["mention"];
							     $is_move_to_next_year = $result["is_move_to_next_year"];
							     $average = $result["general_average"];
							   }
							  
							 // if(($mention==null)&&($is_move_to_next_year==null))	 
		                      //    {
		                      	
		                      	$modelsStudent=Persons::model()->findByPk($this->student_id );
		                      	$student=$modelsStudent->getFullName();
		                      	$gender = $modelsStudent->getGenders1();
		                      	
									if($menfp!=null)
	                                 { 
										 $menfp_data = MenfpDecision::model()->checkDecisionMenfp($this->student_id, $acad_sess);
										 foreach($menfp_data as $menfp_d)
										   {
										   	    $menfp_average = $menfp_d['average'];
										   	}
	                                 }
										 
									  
										   //$birthday = $stud->birthday;   // student's birthday
										   //$city = $stud->cities;   // where student born
										   //$gender = $stud->getGenders1();   // sexe
										   
										   //$city_name= $this->getCityName($city); // return the name of the city
										   //$sexe = ($gender)...;
										   
										
									             
												  
										        //      $display_comment++; //for SUCCESSED stud
		                                            									  
							 			               
							 			               
		                                             												 
																
																//pour la couleur des lignes
																       $flag_color =null; 
																		
		                                                                if($couleur===1)  //choix de couleur
		                                                                {
																		    $style_tr='\'font-size: 1em; background-color: #F0F0F0; \'';
		                                                                     
		                                                                     if($flag_color==true)
		                                                                       $style_tr='\'font-size: 1em; background-color: #F0F0F0; color: #FF0000; \'';
		                                                                                                                                        
		                                                                }
																	    elseif($couleur===2)
		                                                                 {
																		    $style_tr='\'font-size: 1em; background-color: #FAFAFA; \'';
		                                                                                                                                    
		                                                                     if($flag_color==true)
		                                                                       $style_tr='\'font-size: 1em; background-color: #FAFAFA; color: #FF0000; \'';
		                                                                   }
													
		                                                               
		                                                               
		                                                                $flag_color = false;
											$this->comment = Yii::app()->session['comment_admit'];
																	
		                                                                     echo '<tr style='.$style_tr.'><td style='.$style_td_name.'>'.$student.'</td><td style='.$style_td.'>'.$gender.'</td><td style='.$style_td.'>';
		                                                                     
		                                                             if($average < $passing_grade)
		                                                               echo '<divclass="" style="color:red;">'.$average.'</div>';
		                                                             else
		                                                               echo $average;    
		                                                                    
		                                                             
		                                                             echo ' </td>';
		                                                             
		                                                             if($menfp!=null)
	                                                                  {  echo ' <td style='.$style_td.'>';
		                                                             
				                                                             if($menfp_average < $menfp_passing_grade)
				                                                               echo '<divclass="" style="color:red;">'.$menfp_average.'</div>';
				                                                             else
				                                                               echo $menfp_average;
		                                                                 echo '</td>';
	                                                                  }
	                                                                  
		              $success_mention1 = null;
		                                                          
		                                        
														 echo ' 
							
							<td style="width:35px;text-align:center; vertical-align:middle; border-left: 1px solid  #E4E9EF;font-size: 1em; ">';
							if($this->isCheck===-1) 
								echo '<input type="radio" name="success" value="1"  >';
								
						     elseif($this->isCheck===1) 
								{ echo '<input type="radio" name="success"  checked value="1"  >';
								      $success_mention1 = $success_mention;
								}
							 elseif($this->isCheck===0) 
								echo '<input type="radio" name="success"  value="1"  >';
							
							echo '</td>
							
							<td style="width:35px;text-align:center; vertical-align:middle; border-left: 1px solid  #E4E9EF;font-size: 1em; ">';
							if($this->isCheck===-1) 
								echo '<input type="radio" name="success"  value="0"  >';
							elseif($this->isCheck===1) 
								echo '<input type="radio" name="success"  value="0"  >'; 
							 elseif($this->isCheck===0) 
								{   echo '<input type="radio" name="success"  checked  value="0"  >';
						              $success_mention1 = $failure_mention;
								}
							echo '</td>
														
							</tr>'; 
			 	 			 
		               //$this->data_EYD3=array($this->student_id,$average,$success_mention1,$_GET['le']);
		               			Yii::app()->session['d_u_average'] = $average;
		               			Yii::app()->session['d_u_success_mention'] = $success_mention1;
		               			Yii::app()->session['d_u_level'] = $_GET['le'];				                   
		                    
						   }
						   
		 echo ' </tbody></table></div>';

		
    }
		
	
   	
   	
 }//end student_id !=''		
			
			
			?> 

	</div>				
	
			
						        	  </td>
                                 </tr>
                                
                                
		<?php	
			
		if( ((isset($this->student_id))&&($this->student_id!=null))&&($compt_stud_to_produce_last_reportcard ==0)   )
	           { 	  		 	
	  		 ?>
                        <tr>
                                 <td colspan="4">
         <div class="col-submit">
	    <?php 
		       
	           	
	           //	if(!isAchiveMode($acad_sess))
                       echo CHtml::submitButton(Yii::t('app', 'Save'),array('name'=>'update','class'=>'btn btn-warning'));
                     	             
	               //back button   
                                              $url=Yii::app()->request->urlReferrer;
                                              $explode_url= explode("php",substr($url,0));
				             
                                              echo ' <a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';
                                          
	    ?>
    </div>

                                      </td>
                        </tr>
          
	  <?php 
	        }

	  ?>
	         
							       
 
 
                       </tbody>
                    </table>
                  </div><!-- /.table-responsive -->
                </div><!-- /.box-body -->
                
              </div>

            
