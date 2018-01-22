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
           
$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 


 $template1 ='';
 $template ='';         
          
  $groupid=Yii::app()->user->groupid;
                   $group=Groups::model()->findByPk($groupid);
                   
                          $group_name=$group->group_name;
            
 
       ?>




<!-- Menu of CRUD  -->



<div id="dash">
          
          <div class="span3"><h2>
          
       <?php  $drop=0;
      if(isset($_GET['from']))
        { if($_GET['from']=='stud'){ $drop=1; echo Yii::t('app','Students').' ('.$model->fullName.')'; }
           elseif($_GET['from']=='lr_af'){ $drop=1; echo Yii::t('app','Students').' ('.$model->fullName.')'; }
           elseif($_GET['from']=='ds'){ $drop=1; echo Yii::t('app','Students').' ('.$model->fullName.')'; }
			elseif($_GET['from']=='teach'){ $drop=2;  echo Yii::t('app','Teachers').' ('.$model->fullName.')';}
			elseif($_GET['from']=='emp'){ $drop=2;  echo Yii::t('app','Employees').' ('.$model->fullName.')';}
			elseif($_GET['from']=='adm'){ $drop=2;  echo Yii::t('app','Add new admission');} 
			elseif($_GET['from']=='rpt'){   if(isset($_GET['isstud'])&&($_GET['isstud']==1))
			                                     echo Yii::t('app','Students').' ('.$model->fullName.')'.' - '.Yii::t('app','Enable ?');
			                                else
			                                  {  if(isset($_GET['pg']))
										         {  if($_GET['pg']=='la')
										                echo Yii::t('app','Enable ?');
										             else
					                                  	{  if(isset($_GET['tea'])&&($_GET['tea']=="yea"))
						                                       echo Yii::t('app','Teachers').' ('.$model->fullName.')';
						                                     else
						                                        echo Yii::t('app','Employees').' ('.$model->fullName.')';
					                                  	  }
										           }
			                                    } 
										  }
			                                        
		}
     else		
	   {   if(isset($_GET['isstud']))
			{  
				if($_GET['isstud']==1) 
			      echo Yii::t('app','Students').' ('.$model->fullName.')';
			    elseif($_GET['isstud']==0) 
			      echo Yii::t('app','Teachers').' ('.$model->fullName.')';
			
			
			}
	      else 
			echo Yii::t('app','Employees').' ('.$model->fullName.')';
	   
	   }
	   
		?>
                 
             </h2> </div>
             
             
      <div class="span3">
 
         <?php 
               if(!isAchiveMode($acad_sess))
                 {     $template1 = $template;    
        ?>
        
          
      <?php   
             
           if(((Yii::app()->user->profil=='Admin')||(Yii::app()->user->profil=='Manager'))&&($group_name!='Discipline'))
            { 
           
            if(isset($_GET['from'])&&($_GET['from']!='lr_af')&&($_GET['from']!='ds')&&($_GET['from']!='adm') )
              { 
                     $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';

                               // build the link in Yii standard
                   if(isset($_GET['from'])) 
                     { 
                     	if($_GET['from']!='rpt')
	                     {	if(isset($_GET['isstud'])) 
			                     {  if($_GET['isstud']==1)
			                           { 
				                          if(!isset($_GET['pg'])||($_GET['pg']!='parlis') )
				                            { 	 echo ' <div class="span4">';
				                           	      echo CHtml::link($images,array('persons/create?isstud=1&pg=lr&from=stud')); 
				                           	    echo ' </div>';  
				                            }   
			                           }
								    elseif($_GET['isstud']==0)
									     {
									     	echo ' <div class="span4">';
									     	  echo CHtml::link($images,array('persons/create?isstud=0&from=teach'));
									        echo ' </div>';
									     }
								   }
							   else      
								  {        echo ' <div class="span4">';
								  		    echo CHtml::link($images,array('persons/create?from=emp')); 
								  		  echo ' </div>';  
								  }
	                     }

                     }
                    

                   ?>

             

             

                  <?php

                     $images = '<i class="fa fa-edit">&nbsp;'.Yii::t('app','Update').'</i>';

                               // build the link in Yii standard
                   if(!isset($_GET['from1'])) 
                     {
		               if(isset($_GET['isstud'])) 
		                     {  if($_GET['isstud']==1)
		                          {       
		                             if(isset($_GET['pg']))
										 {  if($_GET['pg']=='lr')
											 {  
											 	if(isset($_GET['from'])) 
											 	 {
											 	   echo ' <div class="span4">';
											 	   echo CHtml::link($images,array('persons/update','id'=>$model->id,'pg'=>'vrlr','isstud'=>1,'from'=>$_GET['from']));
											 	echo ' </div>'; 
											 	   }
											 	else
											 	  {
											 	echo ' <div class="span4">';
											 	   echo CHtml::link($images,array('persons/update','id'=>$model->id,'pg'=>'vrlr','isstud'=>1));
											 	echo ' </div>';  
											 	
											 	  }
											 	   
											 }
											elseif($_GET['pg']=='l')
												 {
												 	echo ' <div class="span4">';
												 	    echo CHtml::link($images,array('persons/update','id'=>$model->id,'pg'=>'vrl','isstud'=>1));
												 	 echo ' </div>';   
												 }
												
										 }
									   else
										 {  
										 	echo ' <div class="span4">';
										 	      echo CHtml::link($images,array('persons/update','id'=>$model->id,'pg'=>'vr','isstud'=>1)); 
										    echo ' </div>';
										 }
							       }
							    elseif($_GET['isstud']==0)
								   {     if(isset($_GET['from'])) 
						                     { 
						                     	      if($_GET['from']=='teach')
						                     	         {
						                     	         	 echo ' <div class="span4">';
						                     	         	     echo CHtml::link($images,array('persons/update','isstud'=>0,'from'=>'teach','id'=>$model->id,'from1'=>'view'));
						                     	         	 echo ' </div>';    
						                     	         }
						                     	       elseif($_GET['from']=='emp')
						                     	           {
						                     	           	  echo ' <div class="span4">';
						                     	           	      echo CHtml::link($images,array('persons/update','from'=>'emp','id'=>$model->id,'from1'=>'view'));
						                     	           	   echo ' </div>';   
						                     	           }
						                     }
						                    elseif(!isset($_GET['from1'])) 
						                        { 
						                        	echo ' <div class="span4">';
						                        	     echo CHtml::link($images,array('persons/update','id'=>$model->id,'isstud'=>0,'from'=>'teach','from1'=>'teach_view'));
						                        	   echo ' </div>';  
						                        }
								   
								   }
								   
							   }
						   else      
							{	    if(isset($_GET['from'])) 
				                     { 
				                     	 if($_GET['from']=='rpt') 
				                     	    echo '';
				                     	  elseif($_GET['from']=='stud')
				                     	    { 
				                     	    	echo ' <div class="span4">';
				                     	    	     echo CHtml::link($images,array('persons/update','isstud'=>1,'from'=>'stud','id'=>$model->id,'from1'=>'view'));
				                     	    	echo ' </div>';     
				                     	    }
				                     	 elseif($_GET['from']=='teach')
				                     	    {
				                     	    	echo ' <div class="span4">';
				                     	    	     echo CHtml::link($images,array('persons/update','from'=>'teach','id'=>$model->id,'from1'=>'view'));
				                     	    	echo ' </div>';     
				                     	    }
				                         elseif($_GET['from']=='emp')
				                     	        {
				                     	        	echo ' <div class="span4">';
				                     	        	     echo CHtml::link($images,array('persons/update','from'=>'emp','id'=>$model->id,'from1'=>'view'));
				                     	        	echo ' </div>';     
				                     	        }
				                     }
				                    else 
				                       {
				                       	 echo ' <div class="span4">';
				                       	    echo CHtml::link($images,array('persons/update','id'=>$model->id,'from1'=>'view')); 
				                       	  echo ' </div>';
				                       }
											
							
							
							}
							
                       }
		                 

                   ?>

               
              
     <?php        }
             
              }//fen if((Yii::app()->user->profil=='Admin'))
            
            ?>
  
  
      <?php
                 }
      
      ?>       
  
              
              <div class="span4">

                      <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard
  
                      
                      if(isset($_GET['from']))
                        {
                            
                          if($_GET['from']=='teach')
                          {
                               
                             	 if(isset($_GET['pg'])&&($_GET['pg']!=''))
                             	  { if($_GET['pg']=='ci')
								     echo CHtml::link($images,array('contactInfo/index','from'=>'stud')); 
								    // Au cas d'un besoin de retour 
                                                                    
                             	  }
								echo CHtml::link($images, array('persons/listForReport','isstud'=>0,'from'=>'teach'));
                             
                                  
                          }
                        elseif($_GET['from']=='lr_af') 
                          {
                          	   echo CHtml::link($images,array('/academic/persons/levelRoomAffectation/isstud/1/pg/lr/mn/std'));
                          	    
                            } 
                         elseif($_GET['from']=='ds') 
                          {
                          	   echo CHtml::link($images,array('/academic/persons/disableStudents'));
                          	    
                            }
                         elseif($_GET['from']=='adm') 
                          {
                          	   $pn='';$n='';
                          	   $from=$_GET['from'];
                          	   if(isset($_GET['n']))
                          	      $n=$_GET['n'];
                          	   if(isset($_GET['pn']))
                          	      $pn=$_GET['pn'];
                          	   echo CHtml::link($images,array("/academic/persons/admissionSearch/from/$from/pg/adm/n/$n/pn/$pn/vi/9"));
                          	    
                            }
                           else{
                              if(($drop==1)||($_GET['from']=='stud'))
                                { 
								    if(isset($_GET['pg']))
										 {  if($_GET['pg']=='lr')
											  echo CHtml::link($images,array('listForReport','isstud'=>1,'from'=>'stud'));
											elseif($_GET['pg']=='l')
												   echo CHtml::link($images,array('list','isstud'=>1,'from'=>'stud'));
												elseif($_GET['pg']=='ci')
								                   echo CHtml::link($images,array('contactInfo/index','from'=>'stud'));
								                     elseif($_GET['pg']=='lfc')
								                   echo CHtml::link($images,array('/academic/persons/classSetup/isstud/1/pg/lr/mn/std'));
								                     elseif($_GET['pg']=='parlis')
								                       echo CHtml::link($images,array('/academic/menfpGrades/view/id/'.$_GET["id"].'/part/parlis/from1/parlis'));
												 
												
										 }
									   else
										 echo CHtml::link($images,array('persons/listForReport?isstud=1&from=stud'));
						 
								}
                              elseif($_GET['from']=='emp')
                                {  
                                	     echo CHtml::link($images,array('persons/listForReport','from'=>'emp')); 
                                    
                                }
                                
                               elseif($_GET['from']=='rpt')
                                {    
                                	        if(isset($_GET['isstud'])&&($_GET['isstud']==1))
			                                     echo CHtml::link($images,array('/academic/persons/listArchive','from1'=>'rpt'));
			                                else
			                                  { if(isset($_GET['pg']))
										         {  if($_GET['pg']=='la')
										                echo CHtml::link($images,array('persons/listArchive','from1'=>'rpt'));
										             else
					                                  	{   if(isset($_GET['tea'])&&($_GET['tea']=="yea"))
					                                            echo CHtml::link($images,array('/academic/persons/listArchive','from1'=>'rpt'));
					                                            
					                                        else
					                                	        echo CHtml::link($images,array('/academic/persons/listArchive','from1'=>'rpt')); 
					                                  	}
										          }
			                                  }
                                } 
                                  
                          }
                      }
                      else  //$_GET['from'] not set
                       {
                         if(!isset($_GET['from1'])) 
                            { if($drop==1)
                                { 
								    if(isset($_GET['pg']))
										 {  if($_GET['pg']=='lr')
											  echo CHtml::link($images,array('listForReport','isstud'=>1));
											elseif($_GET['pg']=='l')
												   echo CHtml::link($images,array('list','isstud'=>1));
												
										 }
									   else
										 echo CHtml::link($images,array('persons/listForReport?isstud=1'));
						 
								}
                              elseif($drop==2)
                                  {
                                  	    if(isset($_GET['pg']))
										 {  if($_GET['pg']=='lr')
											  echo CHtml::link($images,array('listForReport','isstud'=>0));
											elseif($_GET['pg']=='l')
												   echo CHtml::link($images,array('list','isstud'=>0));
												 elseif($_GET['pg']=='ext')
												     echo CHtml::link($images,array('/academic/persons/listArchive','isstud'=>0));
												
										 }
									   else
										 echo CHtml::link($images,array('persons/listForReport?isstud=0'));
                                    } 
                                  else 
                                    {  
                                    	if(isset($_GET['pg']))
										 {  if($_GET['pg']=='lr')
											  echo CHtml::link($images,array('listForReport' ));
											elseif($_GET['pg']=='l')
												   echo CHtml::link($images,array('list' ));
												 elseif($_GET['pg']=='la')
												     echo CHtml::link($images,array('persons/listArchive' ));
												
										 }
									   else
										 {   if(isset($_GET['from1'])&&($_GET['from1']=='rpt'))
										       {  
										       	  if(isset($_GET['isstud']))
										             { 	 
										             	if($_GET['isstud']==0)
							                                 echo CHtml::link($images,array('persons/listForReport','isstud'=>0,'from1'=>'rpt'));
										              	
										              	}
										         }
										   
										 
                                          
										 }
                                     
                                    }

                                
                               }
                             elseif(isset($_GET['from1']))
                               {
                               	     if(isset($_GET['isstud']))
                               	       {  
                               	        	if(isset($_GET['pg']))
										     {  if($_GET['pg']=='ext')
										          {
										          	if($_GET['isstud']==1)
		                               	                echo CHtml::link($images,array('/academic/persons/listArchive?from1=rpt'));
		                               	            elseif($_GET['isstud']==0)
		                               	               echo CHtml::link($images,array('/academic/persons/listArchive?from1=rpt'));
										          	
										          	}
										          elseif($_GET['pg']=='lr')
										             {  if($_GET['isstud']==1)
										                   echo CHtml::link($images,array('persons/listForReport','isstud'=>1,'from1'=>'rpt'));
										                   
										              }
										            elseif($_GET['pg']=='l')
										             {  if($_GET['isstud']==1)
										                   echo CHtml::link($images,array('/academic/persons/list','isstud'=>1,'pg'=>'lr','from1'=>'rpt','mn'=>'std'));
										                   
										              }
										              
										      }
										    else
                               	        	  {
		                               	        	if($_GET['isstud']==1)
		                               	                echo CHtml::link($images,array('persons/listForReport','isstud'=>1,'from1'=>'rpt'));
		                               	            elseif($_GET['isstud']==0)
		                               	               echo CHtml::link($images,array('persons/listForReport','isstud'=>0,'from1'=>'rpt'));
                               	        	    
                               	        	    }
	                               	               
                               	       }
                               	     else
                               	       {   if(isset($_GET['pg']))
										     {  if($_GET['pg']=='ext')
                               	       	            echo CHtml::link($images,array('/academic/persons/listArchive?from1=rpt'));
                               	       	            
										       }
										     else
										        echo CHtml::link($images,array('persons/listForReport','from1'=>'rpt'));    
										       
                               	         
                               	        }
                               	 }
                               
                        }
                       
                     
                   ?>

                  </div>  
    
        </div>
 </div>	


<div style="clear:both"></div>
			
<div id="dash">
		<div class="student1">

<?php 
        
        
         echo $model->fullName; 

?> </div> 




</div>

<div style="clear:both"></div>

<?php


if((isset($_GET['isstud']))&&($_GET['isstud']==1)) //STUDENTS 
   { 
?>
<!--  ************************** STUDENT *************************    -->
<div>
  <ul class="nav nav-tabs">
    <!--  ************************** STUDENT INFO *************************    -->
    <li class="active"><a data-toggle="tab" href="#studentinfo"><?php echo Yii::t('app','Student info'); ?></a></li>
    
    <!--  ************************** STUDENT MORE INFO *************************    -->
    <?php 
       if(isset($_GET['isstud'])&&($_GET['isstud']==1)) //STUDENTS
	    { 
	      if((Yii::app()->user->profil=='Admin')||(Yii::app()->user->profil=='Manager')||(Yii::app()->user->profil=='Billing'))
            { 
           	  
	    ?>
	        <li><a data-toggle="tab" href="#studentmoreinfo"><?php echo Yii::t('app','Student more info'); ?></a></li>
    <?php } } ?>
    
    <!--  ************************** CONTACT INFO STUDENT *************************    -->
     <?php 
             if((isset($_GET['from1'])&&($_GET['from1']=='rpt'))||((Yii::app()->user->profil=='Admin')||(Yii::app()->user->profil=='Manager'))&&($group_name!='Discipline')||(Yii::app()->user->profil=='Billing'))
               {
             ?> 
             
               <li><a data-toggle="tab" href="#contactinfostudent"><?php echo Yii::t('app','Contact info'); ?></a></li>
    <?php  } ?>
    
    <!--  ************************** STUDENT GRADE *************************    -->
       <?php 
       if(isset($_GET['isstud'])&&($_GET['isstud']==1)) //STUDENTS
	    { 
	      if((Yii::app()->user->profil=='Admin')||(Yii::app()->user->profil=='Billing')||(Yii::app()->user->profil=='Manager')||(Yii::app()->user->profil=='Teacher'))
             
           	  
	    ?>
	     <li><a data-toggle="tab" href="#studentgrade"><?php echo Yii::t('app','Grade'); ?></a></li>
	     
	     <?php 
        if((Yii::app()->user->profil=='Admin')||(Yii::app()->user->profil=='Manager')||(Yii::app()->user->profil=='Billing'))
            {

     		 $display_schedule_agenda = infoGeneralConfig('display_schedule_agenda');	 
						 
                    		if($display_schedule_agenda!=1)	
                    		  {	   ?>
	     <li><a data-toggle="tab" href="#studentschedules"><?php echo Yii::t('app','Schedules'); ?></a></li>
      <?php 
                    		  }
           ?>
         <li><a data-toggle="tab" id="doc" href="#studentdocuments"><?php echo Yii::t('app','Document'); ?></a></li>         		  
       <?php             		  
      
           } 
	  
	  
	    } ?>
      
  </ul>


  <div class="tab-content">
    
    <!--  ************************** STUDENT INFO *************************    -->

<div id="studentinfo" class="tab-pane fade in active">
       
      
<?php       

          if(isset($_GET['ural'])&&($_GET['ural']=='y'))
             $this->useRoomAffectation_level=true;
             
          if(isset($_GET['urar'])&&($_GET['urar']=='y'))
             $this->useRoomAffectation_room=true;
          

             //error message    		
	        	if(($this->useRoomAffectation_room)||($this->useRoomAffectation_level))//||($this->success_==1))		
			      { 
			      	echo '<br/><div class="" style=" width:54%; padding-left:0px;margin-top:-60px;margin-left:0px; margin-bottom:-10px; ';//-20px; ';
				      echo '">';
				      	
				      
				    echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
					   <tr>
					    <td style="text-align:center;">';				      
			       }			      
				  				     	
				  if($this->useRoomAffectation_room)
				     { 
				     	echo '<span style="color:red;" >'.Yii::t('app','Go to "Room Affectation" and use "Sort By Level" option to set ROOM for this student.').'</span><br/>';
				     
				         echo'</td>
							    </tr>
								</table>
							</div>
							<div style="clear:both"></div>';
				    
				     }
				     
				   
				   if($this->useRoomAffectation_level)
				     { 
				     	echo '<span style="color:red;" >'.Yii::t('app','Go to "Room Affectation" to set LEVEL AND ROOM for this student.').'</span><br/>';
				       
				    		 echo'</td>
							    </tr>
								</table>
							</div>
							<div style="clear:both"></div>';	
				    			
				     }
				  
	
?>

      <div class="span6">
        <div class="activat">

   <?php		
       echo '<div class="CDetailView_photo" >';
	         if($model->getUsername($model->id)!=null){
                         $user_name = $model->getUsername($model->id); 
                     }else {
                         $user_name = 'N/A';
                     }	 
		 
		 
    if((isset($_GET['isstud']))&&($_GET['isstud']==1)) //STUDENTS 
	  { 
		 $condition_fee_status = 'fl.status IN(0,1) AND ';
		 
		 $health_state=null;
		 $father_full_name=null;
		 $mother_full_name=null;
		 $person_liable=null;
		 $modelStudentOtherInfo = StudentOtherInfo::model()->find('student=:IdStudent',array(':IdStudent'=>$model->id ));
		 
		 if($modelStudentOtherInfo!=null)
		   { $health_state=$modelStudentOtherInfo->health_state;
			 $father_full_name=$modelStudentOtherInfo->father_full_name;
			 $mother_full_name=$modelStudentOtherInfo->mother_full_name;
			 $person_liable=$modelStudentOtherInfo->person_liable;
			 
			 
		   }
		 
		 if((Yii::app()->user->profil=='Admin')||(Yii::app()->user->profil=='Manager')||(Yii::app()->user->profil=='Billing'))
          { 
                     
                     
		   	$this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				
				
                                array('name'=>'birthday','value'=>$model->birthday_),
                                
                                'sexe',
                                array(     'header'=>Yii::t('app','Blood Group'),
		                    'name'=>Yii::t('app','Blood Group'),
		                    'value'=>$model->getBlood_group(),
		                ),  
				'adresse',
				'phone',
				'email',
                             
				array(     'header'=>Yii::t('app','Health state'),
		                    'name'=>Yii::t('app','Health state'),
		                    'value'=>$health_state,
		                ), 
			    
			    array(     'header'=>Yii::t('app','Person liable'),
		                    'name'=>Yii::t('app','Person liable'),
		                    'value'=>$person_liable,
		                ), 
		                
				array(     'header'=>Yii::t('app','Username'),
		                    'name'=>Yii::t('app','Username'),
		                    'value'=>$user_name,
		                ), 
				'status',
				
				array(     'header'=>Yii::t('app','Scholarship holder '),
		                    'name'=>Yii::t('app','Scholarship holder '),
		                    'value'=>($model->getIsScholarshipHolder($model->id,$acad_sess)==1)? Yii::t('app','Yes') : Yii::t('app','No'),
		                ), 
                           
		       array(     'header'=>Yii::t('app','Room'),
		                    'name'=>Yii::t('app','Room'),
		                    'value'=>$model->getRooms($model->id,$acad_sess).' ('.$model->getLevel($model->id,$acad_sess).')',
		                ), 
		        array(     'header'=>Yii::t('app','Section'),
		                    'name'=>Yii::t('app','Section'),
		                    'value'=>$model->getSections($model->id,$acad_sess),
		                ), 
		         array(     'header'=>Yii::t('app','Shift'),
		                    'name'=>Yii::t('app','Shift'),
		                    'value'=>$model->getShifts($model->id,$acad_sess),
		                ), 
				
					),
				));
				
	           }//fen if((Yii::app()->user->profil=='Admin'))
	         else
	           { 
		           	   $this->widget('zii.widgets.CDetailView', array(
				'data'=>$model,
				'attributes'=>array(
				
	                                'sexe',
	             
					'email',
	                                array('label'=>Yii::t('app','Birth place'),'name'=>'cities0.city_name'),
					
					array(     'header'=>Yii::t('app','Level'),
			                    'name'=>Yii::t('app','Level'),
			                    'value'=>$model->getLevel($model->id,$acad_sess),
			                ), 
			       array(     'header'=>Yii::t('app','Room'),
			                    'name'=>Yii::t('app','Room'),
			                    'value'=>$model->getRooms($model->id,$acad_sess),
			                ), 
			       array(     'header'=>Yii::t('app','Section'),
		                    'name'=>Yii::t('app','Section'),
		                    'value'=>$model->getSections($model->id,$acad_sess),
		                ), 
		         array(     'header'=>Yii::t('app','Shift'),
		                    'name'=>Yii::t('app','Shift'),
		                    'value'=>$model->getShifts($model->id,$acad_sess),
		                ), 

			       
					
						),
					));
	           	
	           	 }//fen tout lot profil
				
				
		    }
		
		      ?>
		   	

                             <!--  ************************** QUICK ACTIVATION *************************    -->

<?php 
  if(!isAchiveMode($acad_sess))
       {      
        
    ?>
        
                             		   	
<?php    if((!isset($_GET['from1']))&&((Yii::app()->user->profil=='Admin')||(Yii::app()->user->profil=='Manager'))) 
			 { 
       ?>
		   	   <div class="activation">
					
			        <?php    if((isset($_GET['pg'])&&($_GET['pg']=='ext')) && ((isset($_GET['isstud']))&&($_GET['isstud']==1))  )
			                    echo Yii::t('app','Enable or Exclude {first} {last}',array('{first}'=>$model->first_name,'{last}'=>$model->last_name));
			                 else
			                    echo Yii::t('app','Enable or Disable {first} {last}',array('{first}'=>$model->first_name,'{last}'=>$model->last_name));
			                    
			                    
			                echo '';
			                $form=$this->beginWidget('CActiveForm', array(
										'id'=>'persons-form',
										'enableAjaxValidation'=>true,
										'htmlOptions' => array(
									        'enctype' => 'multipart/form-data',
									      ),
									)); 
									
				
			               if((isset($_GET['pg'])&&($_GET['pg']=='ext')) && ((isset($_GET['isstud']))&&($_GET['isstud']==1))  )
			                 {					
									
							?>
									<div class="checkbox_view" style="margin-left:20px;margin-top:5px;">
									
									   <?php			
											   //echo Yii::t('app','Active');
											   
										 if(($model->active==0)||($model->active==3))
										   {  
										   	   if($model->active==0)
										   	        echo Yii::t('app','Active').'&nbsp;&nbsp;&nbsp;<input type="radio" id="active" name="active" value="1" >&nbsp;&nbsp;&nbsp;'.Yii::t('app','Not active').'&nbsp;&nbsp;&nbsp;<input type="radio" id="active" name="active" value="1" checked="checked" >&nbsp;&nbsp;&nbsp;'.Yii::t('app','Exclude').'&nbsp;&nbsp;&nbsp;<input type="radio" id="exclude" name="active"  value="3" >';
										   	   elseif($model->active==3)
										   	         echo Yii::t('app','Active').'&nbsp;&nbsp;&nbsp;<input type="radio" id="active" name="active" value="1" >&nbsp;&nbsp;&nbsp;'.Yii::t('app','Exclude').'&nbsp;&nbsp;&nbsp;<input type="radio" id="exclude" name="active"  value="3" checked="checked" >';
										    }
									     else
									           echo Yii::t('app','Not active').'&nbsp;&nbsp;&nbsp;'.CHtml::checkBox('active',$model);//<input type="checkbox" id="active" name="active" checked="checked" >';
											   
											   echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.CHtml::submitButton(Yii::t('app','Apply'), array('name'=>'apply','class'=>'btn btn-warning' ));
											   
											?>
										</div>
						<?php
						
						     	  	                 	
			                   }
			                else
			                  {
			            
						   ?>
									<div class="checkbox_view" style="margin-left:20px;margin-top:5px;">
									
									   <?php			
											   echo Yii::t('app','Active');
											   
										 if($model->active==0)
											  echo '&nbsp;&nbsp;&nbsp;<input type="checkbox" id="active" name="active" value="1" >';
									     else
									           echo '&nbsp;&nbsp;&nbsp;'.CHtml::checkBox('active',$model);//<input type="checkbox" id="active" name="active" checked="checked" >';
											   
											   echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.CHtml::submitButton(Yii::t('app','Apply'), array('name'=>'apply','class'=>'btn btn-warning' ));
											   
											?>
										</div>
						<?php
						
			                  }
			                  
			                  
						   $this->endWidget();
					 ?>
			    
		     </div>
		     
<?php     
			 }
       ?>


	     
      <?php
                 }
      
      ?>       
	     
	     
	 
	 	<?php

			 echo '</div> ';
			 ?>
			 
			 
			 
	       </div>
       </div>
   	<?php

			 
 echo '<div class="photo_&_menu" >';
	          echo '<div class="photo_view" >';



               echo '<div class="student" >';


         
// **********student name*************
 
 if(($model->is_student==1)&&(Yii::app()->user->profil!='Teacher'))
         {  
         	if($model->ageCalculator($model->birthday)!=null)
         	  echo $model->fullName.' ('.$model->ageCalculator($model->birthday).Yii::t('app',' yr old').')';
         	else
         	  echo $model->fullName.' ( )';
         	
         }
        else 
         echo $model->fullName;

    echo '</div>';  
 if($model->image!=null)
                    
                                     echo CHtml::image(Yii::app()->request->baseUrl.'/documents/photo-Uploads/1/'.$model->image);
                                else         
                                    echo CHtml::image(Yii::app()->request->baseUrl.'/css/images/no_pic.png');
	                 
			
 ?>
 </div>  </div>

	 
			 
    </div>
    
    
    <!--  ************************** STUDENT MORE INFO *************************    -->
    <?php 
       if(isset($_GET['isstud'])&&($_GET['isstud']==1)) //STUDENTS
	    { 
	      if((Yii::app()->user->profil=='Admin')||(Yii::app()->user->profil=='Manager')||(Yii::app()->user->profil=='Billing'))
            { 
            	$health_state=null;
				 $father_full_name=null;
				 $mother_full_name=null;
				 $person_liable=null;
				 $modelStudentOtherInfo = StudentOtherInfo::model()->find('student=:IdStudent',array(':IdStudent'=>$model->id ));
				 
				 if($modelStudentOtherInfo!=null)
				   { $health_state=$modelStudentOtherInfo->health_state;
					 $father_full_name=$modelStudentOtherInfo->father_full_name;
					 $mother_full_name=$modelStudentOtherInfo->mother_full_name;
					 $person_liable=$modelStudentOtherInfo->person_liable;
					 
					 
				   }
           	 
	    ?>
         <div id="studentmoreinfo" class="tab-pane fade">
            <div class="span8">
             <div class="CDetailView_photo" >
              <div style="margin-top:-7px;"> 
               
              <!-- Additional INFO for student -->    
              <?php
                $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				
                                array('label'=>Yii::t('app','Birth place'),'name'=>'cities0.city_name'),
				
			    array(     'header'=>Yii::t('app','Father full name'),
		                    'name'=>Yii::t('app','Father full name'),
		                    'value'=>$father_full_name,
		                ), 
			   	
			    array(     'header'=>Yii::t('app','Mother full name'),
		                    'name'=>Yii::t('app','Mother full name'),
		                    'value'=>$mother_full_name,
		                ), 
			    
				array(     'header'=>Yii::t('app','Level'),
		                    'name'=>Yii::t('app','Level'),
		                    'value'=>$model->getLevel($model->id,$acad_sess),
		                ),
                           
					),
				));
            
            ?>
                                
              <!-- Debut affichage des champs personalisables -->
              <?php
                    $criteria = new CDbCriteria;
                    $criteria->condition = "field_related_to='stud'";
                    $data_custom_label = CustomField::model()->findAll($criteria);
                    $id_student = $_GET['id'];
                    $konte_liy=0;
                    /*
                    function evenOdd($num)
                        {
                            ($num % 2==0) ? $class = 'odd' : $class = 'even';
                            return $class;
                        }
                     * 
                     */
              ?>
              <table class="detail-view">
                  <tbody>
                      <?php  foreach($data_custom_label as $dcl){ ?>
                      <tr class="<?php ($konte_liy % 2==0) ? $class = 'odd' : $class = 'even'; echo $class;  ?>">
                          <th> <?php echo $dcl->field_label ?></th>
                          <td><?php echo CustomFieldData::model()->getCustomFieldValue($id_student,$dcl->id); ?></td>
                      </tr>
                      <?php 
                      $konte_liy++;
                      
                      } ?>
                  </tbody>
              </table>
              
              <!-- Fin affichage des champs personalisables  -->
              
	         
		<?php
		         $create_student_moreInfo=false;
		         
		         $dataProvider=StudentOtherInfo::model()->searchForOneStudent($_GET['id']);
		         $data=$dataProvider->getData();
		        
		       				           
				        $gridWidget=$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'student-other-info-grid',
				'dataProvider'=>  StudentOtherInfo::model()->searchForOneStudent($_GET['id']),
				
				'emptyText'=>Yii::t('app','No more info found'),
				'summaryText'=>'',
				'columns'=>array(
					
					'school_date_entry',
					
					array(
			           'header'=>Yii::t('app','Previous school'),
			           'name'=>'previous_school',
			           'value'=>'$data->previous_school',
			              'htmlOptions'=>array('width'=>'200px'),
									),
					array(
			           'header'=>Yii::t('app','Previous level name'),
			           'name'=>'previous_level',
			           'value'=>'$data->getPreviousLevel($data->previous_level)',
			              'htmlOptions'=>array('width'=>'200px'),
									),				
					'leaving_date',
					
	),
));		
		    ?>
		    </div>
	        </div>
	      </div>
         </div>
    <?php } } 
    
   
     ?>
    
    <!--  ************************** CONTACT INFO STUDENT *************************    -->
     <?php 
         if((isset($_GET['from1'])&&($_GET['from1']=='rpt'))||((Yii::app()->user->profil=='Admin')||(Yii::app()->user->profil=='Manager')||(Yii::app()->user->profil=='Billing')))
          {
      ?> 
          <div id="contactinfostudent" class="tab-pane fade">
             <div class="span8">
              <div class="CDetailView_photo" >
                
                 <div style="margin-top:-7px;"> 
		           
			<?php          
			      if((isset($_GET['from1'])&&($_GET['from1']=='rpt'))||((Yii::app()->user->profil=='Manager')||(Yii::app()->user->profil=='Billing')) )
			        { 
			        	$value='$data->contact_name';
			            $gridWidget=$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'contact-info-grid',
				'dataProvider'=> ContactInfo::model()->searchByPersonId($_GET['id']),
				
			        'emptyText'=>Yii::t('app','No contact found'),
			        'summaryText'=>'',
			        
				'columns'=>array(
					
					array(
                                    'name' => 'contact_name',
                                    'type' => 'raw',
                                    'value'=>$value,
                                    
                                ),
				
					
			                'phone',
			               
				 
			            )
			            ));
			        }
			      else
			        {  
			         if((Yii::app()->user->profil=='Admin'))
			           {
			           	 $from='';
			            $url_part='';
			            if(isset($_GET['from'])&&($_GET['from']!=''))
			              $from=$_GET['from'];
			        
                       if(isset($_GET['isstud'])&&($_GET['isstud']==1))
			              {   $isstud=$_GET['isstud'];
			                  $value='CHtml::link($data->contact_name,Yii::app()->createUrl("/academic/contactInfo/view",array("id"=>$data->id,"pg"=>"lr","isstud"=>'.$isstud.',"pers"=>'.$_GET['id'].',"from"=>"'.$from.'")))';
			                  
			                  	
						        	$template='{update}';
						        	
						         $gridWidget=$this->widget('zii.widgets.grid.CGridView', array(
							'id'=>'contact-info-grid',
							'dataProvider'=> ContactInfo::model()->searchByPersonId($_GET['id']),
							
						        'emptyText'=>Yii::t('app','No contact found'),
						        'summaryText'=>'',
						        
							'columns'=>array(
								
								array(
			                                    'name' => 'contact_name',
			                                    'type' => 'raw',
			                                    'value'=>$value,
			                                   
			                                ),
							
								
						                'phone',
						               
							 array( 'class'=>'CButtonColumn',
						                    'template'=>$template1, 
						                 'buttons'=>array (
						        'update'=> array(
						            'label'=>'<i class="fa fa-pencil-square-o"></i>',
						            'imageUrl'=>false,
						            'url'=>'Yii::app()->createUrl("academic/contactInfo/update?id=$data->id&pers='.$_GET['id'].'&from='.$from.'&isstud='.$isstud.'&pg=lr")',
						            'options'=>array( 'title'=>Yii::t('app','Update') ),
						        ),
						           ),
						                 ),
						            )
						            ));
			               }
			             
			               
			               	  
			               	  
			            }//fen if((Yii::app()->user->profil=='Admin')) 
			              			        	
			    }
			         
			         
			
             ?>
             </div>
            </div>
          </div>
        </div>
    <?php  } 
              
     ?>
    
     <!--  ************************** STUDENT GRADE *************************    -->
      <?php 
       if(isset($_GET['isstud'])&&($_GET['isstud']==1)) //STUDENTS
	    { 
	      if((Yii::app()->user->profil=='Admin')||(Yii::app()->user->profil=='Billing')||(Yii::app()->user->profil=='Manager')||(Yii::app()->user->profil=='Teacher'))
            { 
           	  
	    ?>
	    
	    <!--  ************************** STUDENT GRADE *************************    -->
	    
        <div id="studentgrade" class="tab-pane fade">
           <div class="span8">
             <div class="CDetailView_photo" >
             <div style="margin-top:-7px;"> 
       
        <?php 
 
                //$template='';
		   	  
		   	 if(isset($_GET['from']))
		   	   { 
                            $columns=array(
					array('header'=>Yii::t('app','Exam Name'),'name'=>'examName','value'=>'$data->evaluation0->examName','htmlOptions'=>array('style'=>'vertical-align: top')),
					array('header'=>Yii::t('app','Course name'),'name'=>'course_name','value'=>'$data->course0->courseName'),
				
			                'grade_value',
			                'course0.weight',
							array('header'=>Yii::t('app','Class Average'),'name'=>'Class Average','value'=>'course_average($data->course0->id,$data->evaluation0->id)'),
			                'comment',
					            
					       
                               
			            );
		   	      
		   	   }
		   	 else
		   	   { 
                             
                             $columns=array(
		            array('header'=>Yii::t('app','Exam Name'),'name'=>'examName','value'=>'$data->evaluation0->examName','htmlOptions'=>array('style'=>'vertical-align: top')),
					array('header'=>Yii::t('app','Course name'),'name'=>'course_name','value'=>'$data->course0->courseName'),
					
			                'grade_value',
			                'course0.weight',
							array('header'=>Yii::t('app','Class Average'),'name'=>'Class Average','value'=>'course_average($data->course0->id,$data->evaluation0->id)'),
			                'comment',
                          
					
			            
			            );
		   	    
		   	   }
    
	            if((Yii::app()->user->profil=='Admin')||(Yii::app()->user->profil=='Billing')||(Yii::app()->user->profil=='Manager'))
                           $dataProvider=  Grades::model()->searchByStudentId_forViewForReport($_GET['id'],$acad_sess);
			    elseif((Yii::app()->user->profil=='Teacher'))
				   {  
				      $teacher_id = '';
					  $userid = Yii::app()->user->userid;
                  	    //get the person ID
			            	$personInfo = Persons::model()->getIdPersonByUserID($userid);
			            	
			            	$personInfo = $personInfo->getData();
			            	foreach($personInfo as $p)
			            	 {
			            	 	$teacher_id = $p->id;
			            	 	}
					  $dataProvider=  Grades::model()->searchByStudentId_teacherId_forViewForReport($_GET['id'],$teacher_id,$acad_sess);
					  
				    }
						   
			    $gridWidget=$this->widget('groupgridview.GroupGridView', array(
				'id'=>'grades-grid',
				'dataProvider'=> $dataProvider,
			        'emptyText'=>Yii::t('app','No grade found'),
			        'summaryText'=>'',
				
                                'mergeColumns'=>'examName',
				'columns'=>$columns,
			        
                          
					));
			 ?>
		    </div>
	     </div>   
         </div>
        </div>
        
   
        <!--  ************************** STUDENT SCHEDULES *************************    -->
        
          <div id="studentschedules" class="tab-pane fade">
           <div class="" style="width:90%;">
             <div class="CDetailView_photo" >
             <div style="margin-top:-7px;"> 
       
        <?php 
 
                
		         	$this->messageNoSchedule=false;
		         	
		         	$this->student_id=$_GET['id'];
		         	    
		         	     //get room ID in which this child enrolled
				                $modelRoom=Rooms::model()->getRoom($this->student_id, $acad_sess)->getData();
				                
				                foreach($modelRoom as $r)
				                   $this->room_id=$r->id;

								  
								  if(($this->room_id!=""))
								  {  
								     
									   
								          $room=$this->getRoom($this->room_id);
											$level=$this->getLevel($this->idLevel);
											$section=$this->getSection($this->section_id);
											$shift=$this->getShift($this->idShift);
											
										//to show update link and create_pdf button only when there records for the room
										$courses=$this->getCoursesAndTimes($this->room_id,$acad_sess);
										if((isset($courses))&&($courses!=null)) 
										  {  //foreach($courses as $course)
										     $this->temoin_data=true;
										     $this->messageNoSchedule=false;
										  }
										 else
											$this->messageNoSchedule=true;	
												
								     
								  }
								         	
                    		  
		         
		         	
     
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
										 
										 
										 
									
                    		  	          $times=$this->getTimes($this->room_id, $acad_sess);
										  if(isset($times))
										     $times=$times->getData();
											 
										  $courses=$this->getCoursesAndTimes($this->room_id, $acad_sess);
										  
										   
										   
										   
										     
										 	   
											
										   
										 
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

                                        }
                                    
                                           
                  ?>
		  
		    </div>
	     </div>   
         </div>
        </div>
        
        
        
        <!--  ************************** STUDENT DOCUMENTS *************************    -->
        

<script type="text/javascript">


function docDisplay(id) {

var path=document.getElementById(id).value;
			
			$('#view_display').html('<div id="pdf" style="padding:5px; width:100%; height:708px; "><object width="100%" height="100%" type="application/pdf" data="'+path+'#toolbar=0&navpanes=0&scrollbar=0&page=1&view=FitV"> <p>"Viewer" sila pa ka li tip fichye sa. <br/><br/> Ce "Viewer" ne supporte pas cette extension. <br/><br/> This extension is not supported by the "Viewer"</p> </div>');

}


function ConfirmDelete()
        {
        	var message=document.getElementById("message").value;
          var x = confirm(message);
          if (x)
              return true;
          else
            return false;
        }





</script>		
		        
          <div id="studentdocuments" class="tab-pane fade">
   
           <div class="" style="width:90%;">
             <div class="CDetailView_photo" >
             <div style="margin-top:0px;"> 
             
                              
	           
	              <div  style="float:left; width:31%; margin-right:5px; ">
	                   							
	                 <?php $sql__ = 'SELECT id, file_name, description FROM student_documents WHERE id_student='.$model->id;
															
							  $command__ = Yii::app()->db->createCommand($sql__);
							  $result__ = $command__->queryAll(); 
								
								$line_number = 1;
																		       	   
								if($result__!=null) 
								 { 
								 	echo ' <table class="items" >
				                            <thead>
												<tr>
													<td style="background-color:#E6F2F9;" >'.Yii::t('app','#').'</td>
													<td style="background-color:#E6F2F9;" >'.Yii::t('app','Description').'</td>
													<td style="background-color:#E6F2F9;" > </td>
													<td style="background-color:#E6F2F9;" > </td>
													
														        
												 </tr>    
											</thead>
											<tbody>';
               
								 	
				echo'<input type="hidden" id="message" value="'.Yii::t("app","Are you sure you want to delete this file?") .'" />';
				
				echo'<input type="hidden" id="baseUrl_path" value="'.Yii::app()->baseUrl.'/academic/persons/'.'" />';
				
								 	foreach($result__ as $r)
								     { 
								        ?>
										    <tr class="<?php echo evenOdd($line_number); ?>">
										        <td><?php echo $line_number; ?></td>
										        <td><?php $file_name = $r['file_name']; 
										                   $folder_name = $model->first_name.'_'.$model->last_name;
										                  $images = '<i >&nbsp;'.$r['description'].'</i>';	
    									                  
    							 echo'<input type="hidden" id="'.$r['id'].'" value="'.Yii::app()->baseUrl.'/documents/students_doc/'.$folder_name.'/'.$file_name.'" />';
    									             echo '<a href="#doc" onclick="docDisplay('.$r['id'].');"> '.$images.' </a>';
    									             
	                               						 ?></td>
										        
										        <td><?php  $images1 = '<span class="fa fa-trash-o"></span>';	
		    									         
		    									           echo '<a Onclick="return ConfirmDelete()" href="'.Yii::app()->baseUrl.'/index.php/academic/persons/deletedoc/id/'.$r['id'].'/elif/'.$folder_name.'/'.$file_name.'/ " title="'.Yii::t('app','Delete').'#doc"  > '.$images1.' </a>';
		    									           
		    									  ?></td>
										       
										        <td><?php  $images2 = '<span class="fa fa-download"></span>';	
		    									         
	echo '<a  href="'.Yii::app()->baseUrl.'/download.php?fol='.$folder_name.'&val='.$file_name.'" target="_blank" title="'.Yii::t('app','Download').'"  > '.$images2.' </a>';
		    									           
		    									  ?></td>
										       
										      
										    </tr>  
										            
									<?php 
									            
										 $line_number++; 
										 
										    
								      }
								      
								  }
						?>
						
					          </tbody>
						</table>
               </div>
              
              <div  style="float:left; width:68%; height:auto;"> 
	              		  <div id="view_display" ></div> 
															

               </div>
          
       
       		 
       		  <div style="clear:both"></div>
	              <br/>
             		
             		 <?php $form=$this->beginWidget('CActiveForm', array(
						'id'=>'person-document-form',
						
						'htmlOptions' => array(
					        'enctype' => 'multipart/form-data',
					      ),
					)); 
    	       ?>
					    <div style="width:30%; ">
		                     <div  style="width:10%;float:left;" >
		                        <label >
		                    
		                             <input size="60" name="document" type="file" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10pt" />
		                             
		                        </label>
		                     </div>
		                     
		                     
		               <div class="clear"></div>   
		               
		                  
		                      <div style="width:10%;float:left;">
                                  <label >
                                      
                                      <input size="60" name="description" placeholder="<?php echo Yii::t('app', 'Description'); ?>" >
                               
                                 </label>
                              </div>

		               
		                 <div  style="width:10%; float:right; ">
		                  <label >       
		                     <?php echo CHtml::submitButton(Yii::t('app', 'Save'),array('name'=>'saveDoc','class'=>'btn btn-warning')); ?>
		                     
		                   </label>
		                     </div>
				    
				      </div>
				                  
                  
                   <?php $this->endWidget(); ?> 
                   
                   
       
       
      		  </div>
	     </div>   
         </div>
        </div>
               
        
        
        
        
        
        
        
      <?php  }  } 
      
      
      
      ?>
        

       <!--  ************************** PETIT MENU FLOTTANT DROIT *************************    -->
     
<?php 
  if(!isAchiveMode($acad_sess))
     {        
       
      ?>
 
 <?php
  if(((Yii::app()->user->profil=='Admin')||(Yii::app()->user->profil=='Manager'))&&($group_name!='Discipline')||(Yii::app()->user->profil=='Billing'))
     { 
                                  
  echo '<div class="student_side">';
    
   
 	 if(isset($_GET['from']))
       { if($_GET['from']=="stud") //STUDENTS
           {  
                     $create_student_moreInfo=false;
                     $id_moreInfo = '';
          if((Yii::app()->user->profil!='Billing'))
             {            
              echo '<span class="btn btn-link fa fa-phone" style="padding: 10px"> '.CHtml::link(Yii::t('app','Create contact info'), array('contactInfo/create','pers'=>$_GET['id'],'pg'=>'vr','isstud'=>1,'from'=>'stud')).'  </span><br/> ';  
              
              $dataProvider=StudentOtherInfo::model()->searchForOneStudent($_GET['id']);
        $data_=$dataProvider->getData();
      
        if((!isset($data_))||($data_==null))
             $create_student_moreInfo=true;
        else
           {   foreach($data_ as $r)
                {
                	$id_moreInfo = $r->id;
                	 }
           	
           	 }
           	        
        if($create_student_moreInfo)
           {  $text=Yii::t('app','Create more info');
              $url=array('studentOtherInfo/create','stud'=>$_GET['id'],'isstud'=>1,'pg'=>'vr','from'=>'stud');
           }
        else
           { $text=Yii::t('app','Update more info');
             $url=array('studentOtherInfo/update','id'=>$id_moreInfo,'stud'=>$_GET['id'],'isstud'=>1,'pg'=>'vr','from'=>'stud');
           }
             echo '<span class="btn btn-link fa fa-plus-square-o" style="padding: 10px" > '.CHtml::link($text,$url ).'</span> <br/>';   
        
             
      echo '<span class="btn btn-link fa fa-list-alt" style="padding: 10px" > '.CHtml::link(Yii::t('app','Create grade'), array('grades/create','stud'=>$_GET['id'],'pg'=>'vr','isstud'=>1,'from'=>'stud')).'  </span><br/>'; 
      
             }
         
      echo '<span class="btn btn-link fa fa-print" style="padding: 10px" > '.CHtml::link(Yii::t('app','View reportcard'), array('../reports/reportcard/report','stud'=>$_GET['id'],'pg'=>'vr','isstud'=>1,'from'=>'stud')).'  </span><br/>';
      
      
        echo '<span class="btn btn-link fa fa-legal" style="padding: 10px" data-toggle="modal" data-target="#myModal"><a> '.Yii::t('app','Discipline summary').'</a></span><br/>';
        
        $last_bill_id =0;
          $result = Billings::model()->getLastTransactionID($_GET['id'],$condition_fee_status, $acad_sess);
          if($result!=null)
            $last_bill_id = $result;
        
        if($last_bill_id!=0)
          {
         echo '<span class="btn btn-link fa fa-usd" style="padding-left: 15px; padding-right: 10px; " > '.CHtml::link(Yii::t('app','Billing'), array('/billings/billings/view','id'=>$last_bill_id,'stud'=>$_GET['id'], 'ri'=>0,'part'=>'rec','from1'=>'vfr','from'=>'stud')).'  </span><br/>'; 
         
           }
      
      if($model->email == null || $model->email == ""){
        
        echo '<span class="btn btn-link fa fa-envelope" style="padding: 10px" > '.CHtml::link(Yii::t('app','Add email'), array('persons/update','id'=>$model->id,'pg'=>'vrlr','isstud'=>1,'from'=>'stud')).'  </span><br/>';
        
      }
      else{
       echo '<span class="btn btn-link fa fa-envelope" style="padding: 10px" > '.CHtml::link(Yii::t('app','Send email'), array('mails/create','stud'=>$model->id,'pg'=>'vr','isstud'=>1,'from'=>'stud')).'  </span><br/>';
            }  
            
                           
        
        }
         
     }
         
 
  echo '</div>';
   
      }//fen if((Yii::app()->user->profil=='Admin'))
 
?>	 

      <?php
                 }
      
      ?>       
		

  </div>
</div>

<!--  ************************** END STUDENT *************************    -->

<?php


   }
 elseif((isset($_GET['isstud']))&&($_GET['isstud']==0)) //TEACHER
   {
   	

?>
 
<!--  ************************** TEACHER *************************    -->
<div>
  <ul class="nav nav-tabs">
    <!--  ************************** TEACHER INFO *************************    -->
    <li class="active"><a data-toggle="tab" href="#teacherinfo"><?php echo Yii::t('app','Teacher info'); ?></a></li>
    
    <!--  ************************** TEACHER MORE INFO *************************    -->
    <?php
       if((Yii::app()->user->profil=='Admin')||(Yii::app()->user->profil=='Manager'))
          { 
      ?>
      <li><a data-toggle="tab" href="#teachermoreinfo"><?php echo Yii::t('app','Teacher more info'); ?></a></li>
    <?php  } ?>
    
    <!--  ************************** CONTACT INFO TEACHER *************************    -->
    <?php 
             if((isset($_GET['from1'])&&($_GET['from1']=='rpt'))||((Yii::app()->user->profil=='Admin')||(Yii::app()->user->profil=='Manager'))&&($group_name!='Discipline'))
       {
       ?>
      <li><a data-toggle="tab" href="#contactinfoteacher"><?php echo Yii::t('app','Contact info'); ?></a></li>
    <?php  } ?>
    
    <!--  ************************** LIST COURSES BELONGS *************************    -->
        <li><a data-toggle="tab" href="#coursesbelong"><?php echo Yii::t('app','List Courses belongs'); ?></a></li>
    
    <!--  ************************** SCHEDULES BELONG *************************    -->
    <?php
     if(!isset($_GET['pg']))
        {
        	 $display_schedule_agenda = infoGeneralConfig('display_schedule_agenda');	 
						 
                    		if($display_schedule_agenda!=1)	
                    		  {	   
	 ?>
	      <li><a data-toggle="tab" href="#schedulesbelong"><?php echo Yii::t('app','Schedules belong'); ?></a></li>
	  <?php  
                    		  }
	  } ?>
	   
  </ul>




  <div class="tab-content">
    
    <!--  ************************** TEACHER INFO *************************    -->

<div id="teacherinfo" class="tab-pane fade in active">
       


       <div class="span6">
     		<div class="activat">

      <?php	
   echo '<div class="CDetailView_photo" >';
	if($model->getUsername($model->id)!=null){
                         $user_name = $model->getUsername($model->id); 
                     }else {
                         $user_name = 'N/A';
                     }	 
		 
		 
    if((isset($_GET['isstud']))&&($_GET['isstud']==0)) //TEACHER 
	  {  $create_moreInfo=false;
		   	  
		   	if(((Yii::app()->user->profil=='Admin')||(Yii::app()->user->profil=='Manager'))&&($group_name!='Discipline'))
			  {
			    $this->widget('zii.widgets.CDetailView', array(
				'data'=>$model,
				'attributes'=>array(
					
					array(     'header'=>Yii::t('app','Blood Group'),
			                    'name'=>Yii::t('app','Blood Group'),
			                    'value'=>$model->getBlood_group(),
			                ), 
			                 array('name'=>'birthday','value'=>$model->birthday_),
					
	                                'sexe',
                                        'nif_cin',
					'adresse',
	                                
					'phone',
					'email',
					array('label'=>Yii::t('app','City'),'name'=>'cities0.city_name'),
					array(     'header'=>Yii::t('app','Username'),
			                    'name'=>Yii::t('app','Username'),
			                    'value'=>$user_name,
			                ), 
					'status',
					array(     'header'=>Yii::t('app','Working department'),
			                    'name'=>Yii::t('app','Working department'),//'Working department',
			                    'value'=>$model->getWorkingDepartment($model->id,$acad),  ///depatman sou tout ane akademik lan
			                ), 
			        array(     'header'=>Yii::t('app','Title'),
			                    'name'=>Yii::t('app','Title'),
			                    'value'=>$model->getTitles($model->id,$acad),   //tit sou tout ane akademik lan
			                ),
			                
					
						),
					));
					
			      }//fen if((Yii::app()->user->profil=='Admin'))
			    else
			       { 
				       	  $this->widget('zii.widgets.CDetailView', array(
					'data'=>$model,
					'attributes'=>array(
					
		                'sexe',
						
		                                
						'phone',
						'email',
						array('label'=>Yii::t('app','City'),'name'=>'cities0.city_name'),
						
					//	'status',
						array(     'header'=>Yii::t('app','Working department'),
				                    'name'=>Yii::t('app','Working department'),//'Working department',
				                    'value'=>$model->getWorkingDepartment($model->id,$acad),  //depatman sou tout aneakademik lan
				                ), 
				        array(     'header'=>Yii::t('app','Title'),
				                    'name'=>Yii::t('app','Title'),
				                    'value'=>$model->getTitles($model->id,$acad), //tit sou tout ane akademik lan
				                ),
				                
						
							),
						));
			       	
			       	 }//fen tout lot profil
		   	
		   	}   ?>
		   	

                             <!--  ************************** QUICK ACTIVATION *************************    -->

<?php 
  if(!isAchiveMode($acad_sess))
     {        
       
      ?>
                              		   	
<?php    if((!isset($_GET['from1']))&&((Yii::app()->user->profil=='Admin')||(Yii::app()->user->profil=='Manager'))) 
			 { 
       ?>
		   	   <div class="activation">
					
			        <?php   echo Yii::t('app','Enable or Disable {first} {last}',array('{first}'=>$model->first_name,'{last}'=>$model->last_name));
			                echo '';
			                $form=$this->beginWidget('CActiveForm', array(
										'id'=>'persons-form',
										'enableAjaxValidation'=>true,
										'htmlOptions' => array(
									        'enctype' => 'multipart/form-data',
									      ),
									)); 
							?>
						<div class="checkbox_view" style="margin-left:20px;margin-top:5px;">
						
						   <?php			
								   echo Yii::t('app','Active');
								   
							 if($model->active==0)
								  echo '&nbsp;&nbsp;&nbsp;<input type="checkbox" id="active" name="active" value="1" >';
						     else
						           echo '&nbsp;&nbsp;&nbsp;'.CHtml::checkBox('active',$model);//<input type="checkbox" id="active" name="active" checked="checked" >';
								   
								   echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.CHtml::submitButton(Yii::t('app','Apply'), array('name'=>'apply','class'=>'btn btn-warning' ));
								   
								?>
							</div>
						<?php
								   
						   $this->endWidget();
					 ?>
			    
		     </div>
		     
<?php     
			 }
      ?>
 
<?php              
    
      }
   ?>
 
 
 <?php
			 echo '</div> ';
    ?>
			 
			      
		</div>
       </div>

<?php
		 
 echo '<div class="photo_&_menu" >';
	          echo '<div class="photo_view" >';



               echo '<div class="student" >';


         
// **********student name*************
 
 if(($model->is_student==1)&&(Yii::app()->user->profil!='Teacher'))
         {  
         	if($model->ageCalculator($model->birthday)!=null)
         	  echo $model->fullName.' ('.$model->ageCalculator($model->birthday).Yii::t('app',' yr old').')';
         	else
         	  echo $model->fullName.' ( )';
         	
         }
        else 
         echo $model->fullName;

    echo '</div>';  
 if($model->image!=null)
                   
                                     echo CHtml::image(Yii::app()->request->baseUrl.'/documents/photo-Uploads/1/'.$model->image);
                                else         
                                    echo CHtml::image(Yii::app()->request->baseUrl.'/css/images/no_pic.png');
	                
			
 ?>
 </div>  </div>

			 
  
   </div>
    
    
    <!--  ************************** TEACHER MORE INFO *************************    -->
    <?php 
       
	      if((Yii::app()->user->profil=='Admin')||(Yii::app()->user->profil=='Manager'))
            { 
           	  
	    ?>
         <div id="teachermoreinfo" class="tab-pane fade">
          <div class="span8">
            <div class="CDetailView_photo" >
              <div style="margin-top:-7px;"> 
	         
		<?php
		         $create_moreInfo=false;
		        $id_moreInfo = '';
		         
		       
		     $model_emp_info=EmployeeInfo::model()->findByattributes(array('employee'=>$_GET['id']));
		         
		         if($model_emp_info!=null) 
		           {
		           	        $id_moreInfo = $model_emp_info->id;
		           	         
		                  $this->widget('zii.widgets.CDetailView', array(
							'data'=>$model_emp_info,
							'attributes'=>array(
								//'id',
								'employee0.fullName',
								'hire_date',
								'country_of_birth',
								'university_or_school',
								'number_of_year_of_study',
								'fieldStudy.field_name',
								'qualification0.qualification_name',
								'jobStatus.status_name',
								'permis_enseignant',
								'leaving_date',
								'comments',
								
							),
						)); 
						
				      	 }
		          else
		            {
		            	 $create_moreInfo=true;
		            	 echo '<br/>'.Yii::t('app','Create more info').'.';
		              }

		    ?>

		    
	        </div>
	      </div>
         </div>
         </div>
    <?php  }  ?>
    
    <!--  ************************** CONTACT INFO TEACHER *************************    -->
     <?php 
         if((isset($_GET['from1'])&&($_GET['from1']=='rpt'))||((Yii::app()->user->profil=='Admin')||(Yii::app()->user->profil=='Manager'))&&($group_name!='Discipline'))
           {
      ?> 
          <div id="contactinfoteacher" class="tab-pane fade">
             <div class="span8">
             <div class="CDetailView_photo" >
                
                 <div style="margin-top:-7px;"> 
		                  
			<?php          
			      if((isset($_GET['from1'])&&($_GET['from1']=='rpt'))||((Yii::app()->user->profil=='Manager')&&($group_name=='Pedagogie')) )
			        { 
			        	$value='$data->contact_name';
			            $gridWidget=$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'contact-info-grid',
				'dataProvider'=> ContactInfo::model()->searchByPersonId($_GET['id']),
				
			        'emptyText'=>Yii::t('app','No contact found'),
			        'summaryText'=>'',
			        
				'columns'=>array(
					
					array(
                                    'name' => 'contact_name',
                                    'type' => 'raw',
                                    'value'=>$value,
                                    
                                ),
				
					
			                'phone',
			               
				 
			            )
			            ));
			        }
			      else
			        {  
			         if((Yii::app()->user->profil=='Admin'))
			           {
			        	 $isstud='';  $from='';
			            $url_part='';
			            if(isset($_GET['from'])&&($_GET['from']!=''))
			              $from=$_GET['from'];
			        
                       if(isset($_GET['isstud'])&&($_GET['isstud']==0))
			              {   $isstud=$_GET['isstud'];
			                  $value='CHtml::link($data->contact_name,Yii::app()->createUrl("/academic/contactInfo/view",array("id"=>$data->id,"pg"=>"lr","isstud"=>'.$isstud.',"pers"=>'.$_GET['id'].',"from"=>"'.$from.'")))';
			                  
			                  	
						        	$template='{update}';
						        	
						         $gridWidget=$this->widget('zii.widgets.grid.CGridView', array(
							'id'=>'contact-info-grid',
							'dataProvider'=> ContactInfo::model()->searchByPersonId($_GET['id']),
							
						        'emptyText'=>Yii::t('app','No contact found'),
						        'summaryText'=>'',
						        
							'columns'=>array(
								
								array(
			                                    'name' => 'contact_name',
			                                    'type' => 'raw',
			                                    'value'=>$value,
			                                   
			                                ),
							
								
						                'phone',
						               
							 array( 'class'=>'CButtonColumn',
						                    'template'=>$template1, 
						                 'buttons'=>array (
						        'update'=> array(
						            'label'=>'<i class="fa fa-pencil-square-o"></i>',
						            'imageUrl'=>false,
						            'url'=>'Yii::app()->createUrl("academic/contactInfo/update?id=$data->id&pers='.$_GET['id'].'&from='.$from.'&isstud='.$isstud.'&pg=lr")',
						            'options'=>array( 'title'=>Yii::t('app','Update') ),
						        ),
						           ),
						                 ),
						            )
						            ));
			               }
			             	  
			               	  
			            }//fen if((Yii::app()->user->profil=='Admin')) 
			              			        	
			    }
			         
			         
			
          ?>

		
            </div>
          </div>
        </div>
       </div>
    <?php  }  ?>
    
     <!--  ************************** LIST COURSES BELONGS *************************    -->
      

        <div id="coursesbelong" class="tab-pane fade">
          <div class="span8">
           <div class="CDetailView_photo" >
             <div style="margin-top:-7px;"> 
              <?php 
		         
	     if(isset($_GET['id'])&&($_GET['id']!=""))
           {
	         $dataProvider_course=Courses::model()->getCoursesForViewTeach($_GET['id'],$acad_sess);
           }                                        
	     else
		   { if(isset($_GET['pg']))
		       {
		       	  $dataProvider_course=Courses::model()->getAllCourses($_GET['id']);
		       }
		     else
		       {
		      $dataProvider_course=Courses::model()->getCoursesForViewTeach($_GET['id'],$acad_sess);
		       }
		       
		   }
        
        $this->widget('groupgridview.GroupGridView', array(
	'id'=>'courses-grid',
	'dataProvider'=>$dataProvider_course,
	'mergeColumns'=>array('subject_name','room_name'),
	
	'emptyText'=>Yii::t('app','No course found (or not yet scheduled)'),
	'summaryText'=>'',		        
	'columns'=>array(
		
		array('header'=>Yii::t('app','Subject name'),'name'=>'subject_name','value'=>'$data->subject0->subjectName'),
		array('header'=>Yii::t('app','Room name'),'name'=>'room_name','value'=>'$data->room0->short_room_name'),
		 
		'weight',
		
            	   		
		   ),
		  
     ));
     ?>

        </div>		    
	     </div>   
         </div>
        </div>
      
  <!--  ************************** SCHEDULES BELONG *************************    -->
      
 <?php
       if(!isset($_GET['pg']))
           {
	    ?>

        <div id="schedulesbelong" class="tab-pane fade">
          <div class="span8">
           <div class="CDetailView_photo" >
             <div style="margin-top:-7px;"> 
             
			<?php		 
				$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']); // set controller and model for that before
			   $gridWidget=$this->widget('groupgridview.GroupGridView', array(
				'id'=>'schedules-grid',
				'dataProvider'=>Schedules::model()->searchForOneTeacher($_GET['id'],$acad_sess),
				'mergeColumns'=>array('day',),
				
				'emptyText'=>Yii::t('app','No schedule found'),
				'summaryText'=>'',
				'columns'=>array(
					
					array('header'=>Yii::t('app','Day'),'name'=>'day'),
                                        'time_start',
					'time_end',
					array('name'=>'course','value'=>'$data->course0->courseName'),
					
						),
					));
		       ?>

        		    
	     </div>   
         </div>
        </div>
        </div>
 <?php  }  ?>     


        

       <!--  ************************** PETIT MENU FLOTTANT DROIT *************************    -->

<?php 
  if(!isAchiveMode($acad_sess))
     {        
       
      ?>

<?php   
  if(((Yii::app()->user->profil=='Admin')||(Yii::app()->user->profil=='Manager'))&&($group_name!='Discipline'))
     { 
                                  
    echo '<div class="student_side">';
    
   
 	 if(isset($_GET['from']))
            { if($_GET['from']=="teach") //TEACHERS
              {
        echo '<span class="btn btn-link fa fa-phone" style="padding: 10px;" > '.CHtml::link(Yii::t('app','Create contact info'), array('contactInfo/create','pers'=>$_GET['id'],'isstud'=>0,'from'=>'teach')).'</span><br/> '; 
        
        if($create_moreInfo)
           {  $text=Yii::t('app','Create more info');
              $url=array('employeeinfo/create','emp'=>$_GET['id'],'isstud'=>0,'pg'=>'vr','from'=>'teach');
           }
        else
           { $text=Yii::t('app','Update more info');
             $url=array('employeeinfo/update','id'=>$id_moreInfo,'emp'=>$_GET['id'],'isstud'=>0,'pg'=>'vr','from'=>'teach');
           }
             echo '<span class="btn btn-link fa fa-plus-square-o" style="padding 10px"> '.CHtml::link($text,$url ).' </span><br/>'; 
             
             echo '<span class="btn btn-link fa fa-folder-open-o" style="padding 10px"> '.CHtml::link(Yii::t('app','Add courses'), array('../schoolconfig/courses/create','emp'=>$_GET['id'],'isstud'=>0,'pg'=>'vr','from'=>'teach')).' </span><br/>'; 
             
             echo '<span class="btn btn-link fa fa-calendar" style="padding 10px"> '.CHtml::link(Yii::t('app','Add schedules'), array('../schoolconfig/schedules/create','emp'=>$_GET['id'],'isstud'=>0,'pg'=>'vr','from'=>'teach')).' </span><br/>';
             
         $last_pay_id =0;
         $month_=0;
         $year_=0;
         
          $result = Payroll::model()->getInfoLastPayrollForOne($_GET['id']);
          if($result!=null)
            {   $result = $result->getData();
            	foreach($result as $r)
            	  { $last_pay_id = $r->id;
                
                     $month_=$r->payroll_month;
                    $year_= getYear($r->payroll_date);
                    
            	  }
             }
            
        
        if($last_pay_id!=0)
          {
         echo '<span class="btn btn-link fa fa-usd" style="padding-left: 15px; padding-right: 10px; " > '.CHtml::link(Yii::t('app','Billing'), array('/billings/payroll/view','id'=>$last_pay_id,'emp'=>$_GET['id'], 'month_'=>$month_,'year_'=>$year_,'di'=>1,'part'=>'rec','from1'=>'vfr','from'=>'teach')).'  </span><br/>'; 
         
           }
       
             // Ajouter les boutons add email et send email
              if($model->email == null || $model->email == ""){
                 
                echo '<span class="btn btn-link fa fa-envelope" style="padding: 10px" > '.CHtml::link(Yii::t('app','Add email'), array('persons/update','id'=>$model->id,'from1'=>'view','isstud'=>0,'from'=>'teach')).'  </span><br/>';

              }
              else{
               echo '<span class="btn btn-link fa fa-envelope" style="padding: 10px" > '.CHtml::link(Yii::t('app','Send email'), array('mails/create','stud'=>$model->id,'from1'=>'view','isstud'=>0,'from'=>'teach')).'  </span><br/>';
              }      
         
         }
            
    }         
 
  echo '</div>';
   
      }//fen if((Yii::app()->user->profil=='Admin'))
 
 
?>	 


      <?php
                 }
      
      ?>       

		

  </div>
</div>

<!--  ************************** END TEACHER *************************    -->


<?php  	
   	
   	
   	  }
   else //EMPLOYEE
      {
  
  ?>
      	
 <!--  ************************** EMPLOYEE *************************    -->
<div>
  
  <ul class="nav nav-tabs">
    <!--  ************************** EMPLOYEE INFO *************************    -->
    <li class="active"><a data-toggle="tab" href="#employeeinfo"><?php echo Yii::t('app','Employee info'); ?></a></li>
    
    <!--  ************************** EMPLOYEE MORE INFO *************************    -->
    <?php  if((Yii::app()->user->profil=='Admin')||(Yii::app()->user->profil=='Manager'))
             { 
        ?>
      <li><a data-toggle="tab" href="#employeemoreinfo"><?php echo Yii::t('app','Employee More Info'); ?></a></li>
    <?php    } ?>
    
    <!--  ************************** CONTACT INFO *************************    -->
    <?php 
           if((isset($_GET['from1'])&&($_GET['from1']=='rpt'))||((Yii::app()->user->profil=='Admin')||(Yii::app()->user->profil=='Manager'))&&($group_name!='Discipline'))
               {
        ?>
      <li><a data-toggle="tab" href="#contactinfoemployee"><?php echo Yii::t('app','Contact info'); ?></a></li>
    <?php    
    
          //tcheke si anplwaaye sa fe kou
        
        //return 0 when employee, 1 when teacher; return 2 when employee-teacher; return -1 when either employee nor teacher
        $isEmpOrTeach = Persons::model()->isEmployeeOrTeacher($_GET['id'], $acad_sess);
        
        if(($isEmpOrTeach==1)||($isEmpOrTeach==2))
          {
         ?>
            <!--  ************************** LIST COURSES BELONGS *************************    -->
        <li><a data-toggle="tab" href="#coursesbelong"><?php echo Yii::t('app','List Courses belongs'); ?></a></li>
    
    <!--  ************************** SCHEDULES BELONG *************************    -->
    <?php
     if(!isset($_GET['pg']))
        {
        	
        	  $display_schedule_agenda = infoGeneralConfig('display_schedule_agenda');	 
						 
                    		if($display_schedule_agenda!=1)	
                    		  {	   
	 ?>
	      <li><a data-toggle="tab" href="#schedulesbelong"><?php echo Yii::t('app','Schedules belong'); ?></a></li>
	  <?php  
                    		  }
	         }

    
          }
    } ?>
    
    
  </ul>

 <div class="tab-content">
    
    <!--  ************************** EMPLOYEE INFO *************************    -->

<div id="employeeinfo" class="tab-pane fade in active">
       


       <div class="span6">
     		<div class="activat">

<?php		

 echo '<div class="CDetailView_photo" >';
	if($model->getUsername($model->id)!=null){
                         $user_name = $model->getUsername($model->id); 
                     }else {
                         $user_name = 'N/A';
                     }	 
		 
		 
    if(!isset($_GET['isstud'])) //STUDENTS 
	   {  $create_moreInfo=false;
		   	if(((Yii::app()->user->profil=='Admin')||(Yii::app()->user->profil=='Manager'))&&($group_name!='Discipline'))
			  {
			    $this->widget('zii.widgets.CDetailView', array(
				'data'=>$model,
				'attributes'=>array(
					
					array(     'header'=>Yii::t('app','Blood Group'),
			                    'name'=>Yii::t('app','Blood Group'),
			                    'value'=>$model->getBlood_group(),
			                ),
			                 array('name'=>'birthday','value'=>$model->birthday_), 
					
	                                'sexe',
	                'nif_cin',
					'adresse',
	                                
					'phone',
					'email',
					array('label'=>Yii::t('app','City'),'name'=>'cities0.city_name'),
					array(     'header'=>Yii::t('app','Username'),
			                    'name'=>Yii::t('app','Username'),
			                    'value'=>$user_name,
			                ), 
					'status',
					array(     'header'=>Yii::t('app','Working department'),
			                    'name'=>Yii::t('app','Working department'),//'Working department',
			                    'value'=>$model->getWorkingDepartment($model->id,$acad),   //depatman sou tout ane akademik lan
			                ), 
			        array(     'header'=>Yii::t('app','Title'),
			                    'name'=>Yii::t('app','Title'),
			                    'value'=>$model->getTitles($model->id,$acad),   //tit sou tout ane akademik lan
			                ),
			                
					
						),
					));
					
			      }//fen if((Yii::app()->user->profil=='Admin'))
			    else
			       { 
				       	  $this->widget('zii.widgets.CDetailView', array(
					'data'=>$model,
					'attributes'=>array(
                                                'sexe',
						'phone',
						'email',
						array('label'=>Yii::t('app','City'),'name'=>'cities0.city_name'),
						
						array(     'header'=>Yii::t('app','Working department'),
				                    'name'=>Yii::t('app','Working department'),//'Working department',
				                    'value'=>$model->getWorkingDepartment($model->id,$acad),   //depatman sou tout ane akademik lan
				                ), 
				        array(     'header'=>Yii::t('app','Title'),
				                    'name'=>Yii::t('app','Title'),
				                    'value'=>$model->getTitles($model->id,$acad), //tit sou tout ane akademik lan
				                ),
				                
						
							),
						));
			       	
			       	 }//fen tout lot profil
		   	
		   	}  
		   	
		  ?>
		   	

                             <!--  ************************** QUICK ACTIVATION *************************    -->

<?php 
  if(!isAchiveMode($acad_sess))
     {        
       
      ?>
                             		   	
<?php    if((!isset($_GET['from1']))&&((Yii::app()->user->profil=='Admin')||(Yii::app()->user->profil=='Manager'))) 
			 { 
       ?>
		   	   <div class="activation">
					
			        <?php   echo Yii::t('app','Enable or Disable {first} {last}',array('{first}'=>$model->first_name,'{last}'=>$model->last_name));
			                echo '';
			                $form=$this->beginWidget('CActiveForm', array(
										'id'=>'persons-form',
										'enableAjaxValidation'=>true,
										'htmlOptions' => array(
									        'enctype' => 'multipart/form-data',
									      ),
									)); 
							?>
						<div class="checkbox_view" style="margin-left:20px;margin-top:5px;">
						
						   <?php			
								   echo Yii::t('app','Active');
								   
							 if($model->active==0)
								  echo '&nbsp;&nbsp;&nbsp;<input type="checkbox" id="active" name="active" value="1" >';
						     else
						           echo '&nbsp;&nbsp;&nbsp;'.CHtml::checkBox('active',$model);//<input type="checkbox" id="active" name="active" checked="checked" >';
								   
								   echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.CHtml::submitButton(Yii::t('app','Apply'), array('name'=>'apply','class'=>'btn btn-warning' ));
								   
								?>
							</div>
						<?php
								   
						   $this->endWidget();
					 ?>
			    
		     </div>
		     
<?php     
			 }
         
?>


      <?php
                 }
      
      ?>       


<?php

	  echo '</div> ';

          ?>
			 
			      
		</div>
       </div>

<?php
		 
 echo '<div class="photo_&_menu" >';
	          echo '<div class="photo_view" >';



  echo '<div class="student" >';


         
// **********student name*************
 
 if(($model->is_student==1)&&(Yii::app()->user->profil!='Teacher'))
         {  
         	if($model->ageCalculator($model->birthday)!=null)
         	  echo $model->fullName.' ('.$model->ageCalculator($model->birthday).Yii::t('app',' yr old').')';
         	else
         	  echo $model->fullName.' ( )';
         	
         }
        else 
         echo $model->fullName;

    echo '</div>';  
 if($model->image!=null)
                    
                                     echo CHtml::image(Yii::app()->request->baseUrl.'/documents/photo-Uploads/1/'.$model->image);
                                else         
                                    echo CHtml::image(Yii::app()->request->baseUrl.'/css/images/no_pic.png');
	                
			
 ?>
 </div>  </div>

			 
  
   </div>
    
    
    <!--  ************************** EMPLOYEE MORE INFO *************************    -->
     <?php  if((Yii::app()->user->profil=='Admin')||(Yii::app()->user->profil=='Manager'))
             { 
        ?>
         <div id="employeemoreinfo" class="tab-pane fade">
            <div class="span8">
            <div class="CDetailView_photo" >
              <div style="margin-top:-7px;"> 
	         
		<?php
		         $create_moreInfo=false;
		         $id_moreInfo_ = '';
		         
		   
				
				 $model_emp_info=EmployeeInfo::model()->findByattributes(array('employee'=>$_GET['id']));
		         
		         if($model_emp_info!=null) 
		           {
		           	      $id_moreInfo_ = $model_emp_info->id;   
		                  $this->widget('zii.widgets.CDetailView', array(
							'data'=>$model_emp_info,
							'attributes'=>array(
								
								'hire_date',
								'country_of_birth',
								'university_or_school',
								'number_of_year_of_study',
								'fieldStudy.field_name',
								'qualification0.qualification_name',
								'jobStatus.status_name',
								'permis_enseignant',
								'leaving_date',
								'comments',
								
							),
						)); 
						
				      	 }
		          else
		            {
		            	 $create_moreInfo=true;
		            	 echo '<br/>'.Yii::t('app','Create more info').'.';
		              }

		
	     ?>	
		    </div>
	        </div>
	      </div>
         </div>
    <?php  }  ?>
    
    <!--  ************************** CONTACT INFO TEACHER *************************    -->
     <?php 
           if((isset($_GET['from1'])&&($_GET['from1']=='rpt'))||((Yii::app()->user->profil=='Admin')||(Yii::app()->user->profil=='Manager'))&&($group_name!='Discipline'))
               {
        ?>
          <div id="contactinfoemployee" class="tab-pane fade">
             <div class="span8">
               <div class="CDetailView_photo" >
                
                 <div style="margin-top:-7px;"> 
		                  
				<?php          
			      if((isset($_GET['from1'])&&($_GET['from1']=='rpt'))||((Yii::app()->user->profil=='Manager')&&($group_name=='Pedagogie')) )
			        { 
			        	$value='$data->contact_name';
			            $gridWidget=$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'contact-info-grid',
				'dataProvider'=> ContactInfo::model()->searchByPersonId($_GET['id']),
				
			        'emptyText'=>Yii::t('app','No contact found'),
			        'summaryText'=>'',
			        
				'columns'=>array(
					
					array(
                                    'name' => 'contact_name',
                                    'type' => 'raw',
                                    'value'=>$value,
                                   
                                ),
				
					
			                'phone',
			              
				 
			            )
			            ));
			        }
			      else
			        {  
			         if((Yii::app()->user->profil=='Admin'))
			           {
			        	  $from='';
			            $url_part='';
			            if(isset($_GET['from'])&&($_GET['from']!=''))
			              $from=$_GET['from'];
			        
                       if(!isset($_GET['isstud']))
			             {
			               	 $value='CHtml::link($data->contact_name,Yii::app()->createUrl("/academic/contactInfo/view",array("id"=>$data->id,"pg"=>"lr","pers"=>'.$_GET['id'].',"from"=>"'.$from.'")))';
			               	 
			               	 	
							        	$template='{update}';
							        	
							         $gridWidget=$this->widget('zii.widgets.grid.CGridView', array(
								'id'=>'contact-info-grid',
								'dataProvider'=> ContactInfo::model()->searchByPersonId($_GET['id']),
								
							        'emptyText'=>Yii::t('app','No contact found'),
							        'summaryText'=>'',
							        
								'columns'=>array(
									
									array(
				                                    'name' => 'contact_name',
				                                    'type' => 'raw',
				                                    'value'=>$value,
				                                   
				                                ),
								
									
							                'phone',
							               
								 array( 'class'=>'CButtonColumn',
							                    'template'=>$template1, 
							                 'buttons'=>array (
							        'update'=> array(
							            'label'=>'<i class="fa fa-pencil-square-o"></i>',
							            'imageUrl'=>false,
							            'url'=>'Yii::app()->createUrl("academic/contactInfo/update?id=$data->id&pers='.$_GET['id'].'&from='.$from.'&pg=lr")',
							            'options'=>array( 'title'=>Yii::t('app','Update') ),
							        ),
							           ),
							                 ),
							            )
							            ));

			               	  }
			               	  
			               	  
			            }//fen if((Yii::app()->user->profil=='Admin')) 
			              			        	
			    }
			         
			         
			
          ?>
		     </div>
            </div>
          </div>
        </div>
    <?php  }  ?>

 
 
     
 <?php 
        //tcheke si anplwaaye sa fe kou
        
        //return 0 when employee, 1 when teacher; return 2 when employee-teacher; return -1 when either employee nor teacher
        $isEmpOrTeach = Persons::model()->isEmployeeOrTeacher($_GET['id'], $acad_sess);
        
        if(($isEmpOrTeach==1)||($isEmpOrTeach==2))
          {
 ?>    
     <!--  ************************** LIST COURSES BELONGS *************************    -->
      

        <div id="coursesbelong" class="tab-pane fade">
          <div class="span8">
           <div class="CDetailView_photo" >
             <div style="margin-top:-7px;"> 
              <?php 
		         
	     if(isset($_GET['id'])&&($_GET['id']!=""))
           {
	         $dataProvider_course=Courses::model()->getCoursesForViewTeach($_GET['id'],$acad_sess);
           }                                        
	     else
		   { if(isset($_GET['pg']))
		       {
		       	  $dataProvider_course=Courses::model()->getAllCourses($_GET['id']);
		       }
		     else
		       {
		      $dataProvider_course=Courses::model()->getCoursesForViewTeach($_GET['id'],$acad_sess);
		       }
		       
		   }
        
        $this->widget('groupgridview.GroupGridView', array(
	'id'=>'courses-grid',
	'dataProvider'=>$dataProvider_course,
	'mergeColumns'=>array('subject_name','room_name'),
	
	'emptyText'=>Yii::t('app','No course found (or not yet scheduled)'),
	'summaryText'=>'',//		        
	'columns'=>array(
		
		array('header'=>Yii::t('app','Subject name'),'name'=>'subject_name','value'=>'$data->subject0->subjectName'),
		array('header'=>Yii::t('app','Room name'),'name'=>'room_name','value'=>'$data->room0->short_room_name'),
		
		'weight',
		
            	   		
		   ),
		  
     ));
     ?>

        </div>		    
	     </div>   
         </div>
        </div>
      
  <!--  ************************** SCHEDULES BELONG *************************    -->
      
 <?php
       if(!isset($_GET['pg']))
           {
	    ?>

        <div id="schedulesbelong" class="tab-pane fade">
          <div class="span8">
           <div class="CDetailView_photo" >
             <div style="margin-top:-7px;"> 
             
			<?php		 
				$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']); // set controller and model for that before
			   $gridWidget=$this->widget('groupgridview.GroupGridView', array(
				'id'=>'schedules-grid',
				'dataProvider'=>Schedules::model()->searchForOneTeacher($_GET['id'],$acad_sess),
				'mergeColumns'=>array('day',),
				
				'emptyText'=>Yii::t('app','No schedule found'),
				'summaryText'=>'',
				'columns'=>array(
					
					array('header'=>Yii::t('app','Day'),'name'=>'day'),
                                        'time_start',
					'time_end',
					array('name'=>'course','value'=>'$data->course0->courseName'),
					
						),
					));
		       ?>

        		    
	     </div>   
         </div>
        </div>
        </div>
 <?php  }  ?>     

 <?php  }  ?>    
     
     
     
     
     
     
     
     
     
     
     
     
       

       <!--  ************************** PETIT MENU FLOTTANT DROIT *************************    -->

<?php 
  if(!isAchiveMode($acad_sess))
     {        
       
      ?>
 
 
 <?php    
  
  if(((Yii::app()->user->profil=='Admin')||(Yii::app()->user->profil=='Manager'))&&($group_name!='Discipline'))
     { 
                                  
  echo '<div class="student_side">';
    
   
 	 if(isset($_GET['from']))
            { if($_GET['from']=="emp") //EMPLOYEES
              {
                                    echo '<span class="btn btn-link fa fa-phone" style="padding: 10px;"> '.CHtml::link(Yii::t('app','Create contact info'), array('contactInfo/create','pers'=>$_GET['id'],'pg'=>'r','from'=>'emp')).'</span><br/> '; 
        
          
        $dataProvider=EmployeeInfo::model()->searchForOneEmployee($_GET['id']);
        $data=$dataProvider->getData();
       
        if((!isset($data))||($data==null))
             $create_moreInfo=true;
           	        
        if($create_moreInfo)
           {  $text=Yii::t('app','Create more info');
              $url=array('employeeinfo/create','emp'=>$_GET['id'],'pg'=>'vr','from'=>'emp');
           }
        else
           { $text=Yii::t('app','Update more info');
             $url=array('employeeinfo/update','id'=>$id_moreInfo_ , 'emp'=>$_GET['id'],'pg'=>'vr','from'=>'emp');
           }
             echo '<span class="btn btn-link fa fa-plus-square-o" style="padding: 10px" > '.CHtml::link($text,$url ).'</span> <br/>';   
        
         
            echo '<span class="btn btn-link fa fa-folder-open-o" style="padding: 10px" > '.CHtml::link(Yii::t('app','Create courses'), array('../schoolconfig/courses/create','emp'=>$_GET['id'],'pg'=>'vr','from'=>'emp')).'</span><br/>';
            
         $last_pay_id =0;
         $month_=0;
         $year_=0;
         
          $result = Payroll::model()->getInfoLastPayrollForOne($_GET['id']);
          if($result!=null)
            {   $result = $result->getData();
            	foreach($result as $r)
            	  { $last_pay_id = $r->id;
                
                     $month_=$r->payroll_month;
                    $year_= getYear($r->payroll_date);
                    
            	  }
             }
            
        
        if($last_pay_id!=0)
          {
         echo '<span class="btn btn-link fa fa-usd" style="padding-left: 15px; padding-right: 10px; " > '.CHtml::link(Yii::t('app','Billing'), array('/billings/payroll/view','id'=>$last_pay_id,'emp'=>$_GET['id'], 'month_'=>1,'year_'=>2016,'di'=>1,'part'=>'rec','from1'=>'vfr','from'=>'emp')).'  </span><br/>'; 
         
           }
       

            // Ajouter les boutons add email et send email
              if($model->email == null || $model->email == ""){
                
                echo '<span class="btn btn-link fa fa-envelope" style="padding: 10px" > '.CHtml::link(Yii::t('app','Add email'), array('persons/update','id'=>$model->id,'from1'=>'view','from'=>'emp')).'  </span><br/>';

              }
              else{
               echo '<span class="btn btn-link fa fa-envelope" style="padding: 10px" > '.CHtml::link(Yii::t('app','Send email'), array('mails/create','stud'=>$model->id,'from'=>'emp')).'  </span><br/>';
              }  

          }
            
            
   }
         
 
  echo '</div>';
   
      }//fen if((Yii::app()->user->profil=='Admin'))
 
 
?>	 

      <?php
                 }
      
      ?>       


		

  </div>
</div>

<!--  ************************** END EMPLOYEE *************************    -->



<?php     	
      	
      	}

?>
   
		



        <!--  ************************** PETIT MENU FLOTTANT DROIT *************************    -->

<?php 
  if(!isAchiveMode($acad_sess))
     {        
       
      ?>

<?php     
  if(((Yii::app()->user->profil=='Admin')||(Yii::app()->user->profil=='Manager'))&&($group_name!='Discipline')||(Yii::app()->user->profil=='Billing'))
     { 
                                  
  echo '<div class="student_side2">';
    
   
 	 if(isset($_GET['from']))
            { if($_GET['from']=="stud") //STUDENTS
           {  
                     $create_student_moreInfo=false;
               if((Yii::app()->user->profil!='Billing'))
                {        
                     
              echo '<span class="btn btn-link fa fa-phone" style="padding: 10px"> '.CHtml::link(Yii::t('app','Create contact info'), array('contactInfo/create','pers'=>$_GET['id'],'pg'=>'vr','isstud'=>1,'from'=>'stud')).'  </span><br/> ';  
              
              $dataProvider=StudentOtherInfo::model()->searchForOneStudent($_GET['id']);
        $data_=$dataProvider->getData();
       
        if((!isset($data_))||($data_==null))
             $create_student_moreInfo=true;
           	        
        if($create_student_moreInfo)
           {  $text=Yii::t('app','Create more info');
              $url=array('studentOtherInfo/create','stud'=>$_GET['id'],'isstud'=>1,'pg'=>'vr','from'=>'stud');
           }
        else
           { $text=Yii::t('app','Update more info');
             $url=array('studentOtherInfo/update','stud'=>$_GET['id'],'isstud'=>1,'pg'=>'vr','from'=>'stud');
           }
             echo '<span class="btn btn-link fa fa-plus-square-o" style="padding: 10px" > '.CHtml::link($text,$url ).'</span> <br/>';   
        
             
      echo '<span class="btn btn-link fa fa-list-alt" style="padding: 10px" > '.CHtml::link(Yii::t('app','Create grade'), array('grades/create','stud'=>$_GET['id'],'pg'=>'vr','isstud'=>1,'from'=>'stud')).'  </span><br/>';    
      
                }
                
                
      echo '<span class="btn btn-link fa fa-print" style="padding: 10px" > '.CHtml::link(Yii::t('app','View reportcard'), array('../reports/reportcard/report','stud'=>$_GET['id'],'pg'=>'vr','isstud'=>1,'from'=>'stud')).'  </span><br/>';
      
       echo '<span class="btn btn-link fa fa-legal" style="padding: 10px" data-toggle="modal" data-target="#myModal"><a> '.Yii::t('app','Discipline summary').'</a></span><br/>'; 

    $last_bill_id =0;
          $result = Billings::model()->getLastTransactionID($_GET['id'], $condition_fee_status, $acad_sess);
          if($result!=null)
            $last_bill_id = $result;
        
        if($last_bill_id!=0)
          {
         echo '<span class="btn btn-link fa fa-usd" style="padding-left: 15px; padding-right: 10px; " > '.CHtml::link(Yii::t('app','Billing'), array('/billings/billings/view','id'=>$last_bill_id,'stud'=>$_GET['id'], 'ri'=>0,'part'=>'rec','from1'=>'vfr','from'=>'stud')).'  </span><br/>'; 
         
           }
      
      // Ajouter les boutons add email et send email
      if($model->email == null || $model->email == ""){
        
        echo '<span class="btn btn-link fa fa-envelope" style="padding: 10px" > '.CHtml::link(Yii::t('app','Add email'), array('persons/update','id'=>$model->id,'pg'=>'vrlr','isstud'=>1,'from'=>'stud')).'  </span><br/>';
        
      }
      else{
       echo '<span class="btn btn-link fa fa-envelope" style="padding: 10px" > '.CHtml::link(Yii::t('app','Send email'), array('mails/create','stud'=>$model->id,'pg'=>'vr','isstud'=>1,'from'=>'stud')).'  </span><br/>';
      }                 
           }
         elseif($_GET['from']=="teach") //TEACHERS
              {
              	   $create_teacher_moreInfo=false;
              	   
        echo '<span class="btn btn-link fa fa-phone" style="padding: 10px;" > '.CHtml::link(Yii::t('app','Create contact info'), array('contactInfo/create','pers'=>$_GET['id'],'isstud'=>0,'from'=>'teach')).'</span><br/> '; 
          
            $dataProvider=EmployeeInfo::model()->searchForOneEmployee($_GET['id']);
        $data=$dataProvider->getData();
       
        if((!isset($data_))||($data_==null))
             $create_teacher_moreInfo=true;
        
        if($create_teacher_moreInfo)
           {  $text=Yii::t('app','Create more info');
              $url=array('employeeinfo/create','emp'=>$_GET['id'],'isstud'=>0,'pg'=>'vr','from'=>'teach');
           }
        else
           { $text=Yii::t('app','Update more info');
             $url=array('employeeinfo/update','emp'=>$_GET['id'],'isstud'=>0,'pg'=>'vr','from'=>'teach');
           }
             echo '<span class="btn btn-link fa fa-plus-square-o" style="padding 10px"> '.CHtml::link($text,$url ).' </span><br/>'; 
             
             echo '<span class="btn btn-link fa fa-folder-open-o" style="padding 10px"> '.CHtml::link(Yii::t('app','Add courses'), array('../schoolconfig/courses/create','emp'=>$_GET['id'],'isstud'=>0,'pg'=>'vr','from'=>'teach')).' </span><br/>'; 
             
             echo '<span class="btn btn-link fa fa-calendar" style="padding 10px"> '.CHtml::link(Yii::t('app','Add schedules'), array('../schoolconfig/schedules/create','emp'=>$_GET['id'],'isstud'=>0,'pg'=>'vr','from'=>'teach')).' </span><br/>';
             
             $last_pay_id =0;
         $month_=0;
         $year_=0;
         
          $result = Payroll::model()->getInfoLastPayrollForOne($_GET['id']);
          if($result!=null)
            {   $result = $result->getData();
            	foreach($result as $r)
            	  { $last_pay_id = $r->id;
                
                     $month_=$r->payroll_month;
                    $year_= getYear($r->payroll_date);
                    
            	  }
             }
            
        
        if($last_pay_id!=0)
          {
         echo '<span class="btn btn-link fa fa-usd" style="padding-left: 15px; padding-right: 10px; " > '.CHtml::link(Yii::t('app','Billing'), array('/billings/payroll/view','id'=>$last_pay_id,'emp'=>$_GET['id'], 'month_'=>1,'year_'=>2016,'di'=>1,'part'=>'rec','from1'=>'vfr','from'=>'teach')).'  </span><br/>'; 
         
           }
      

             
             // Ajouter les boutons add email et send email
              if($model->email == null || $model->email == ""){
                  
                echo '<span class="btn btn-link fa fa-envelope" style="padding: 10px" > '.CHtml::link(Yii::t('app','Add email'), array('persons/update','id'=>$model->id,'from1'=>'view','isstud'=>0,'from'=>'teach')).'  </span><br/>';

              }
              else{
               echo '<span class="btn btn-link fa fa-envelope" style="padding: 10px" > '.CHtml::link(Yii::t('app','Send email'), array('mails/create','stud'=>$model->id,'from1'=>'view','isstud'=>0,'from'=>'teach')).'  </span><br/>';
              }      
              }
            elseif($_GET['from']=="emp") //EMPLOYEES
              {
                                    echo '<span class="btn btn-link fa fa-phone" style="padding: 10px;"> '.CHtml::link(Yii::t('app','Create contact info'), array('contactInfo/create','pers'=>$_GET['id'],'pg'=>'r','isstud'=>0,'from'=>'emp')).'</span><br/> '; 
        
            $create_employee_moreInfo=false;
        $dataProvider=EmployeeInfo::model()->searchForOneEmployee($_GET['id']);
        $data=$dataProvider->getData();
       
        if((!isset($data))||($data==null))
             $create_employee_moreInfo=true;
           	        
        if($create_employee_moreInfo)
           {  $text=Yii::t('app','Create more info');
              $url=array('employeeinfo/create','emp'=>$_GET['id'],'isstud'=>0,'pg'=>'vr','from'=>'emp');
           }
        else
           { $text=Yii::t('app','Update more info');
             $url=array('employeeinfo/update','emp'=>$_GET['id'],'isstud'=>0,'pg'=>'vr','from'=>'emp');
           }
             echo '<span class="btn btn-link fa fa-plus-square-o" style="padding: 10px" > '.CHtml::link($text,$url ).'</span> <br/>';   
        
         
            echo '<span class="btn btn-link fa fa-folder-open-o" style="padding: 10px" > '.CHtml::link(Yii::t('app','Create courses'), array('../schoolconfig/courses/create','emp'=>$_GET['id'],'isstud'=>0,'pg'=>'vr','from'=>'emp')).'</span><br/>';
            
            $last_pay_id =0;
         $month_=0;
         $year_=0;
         
          $result = Payroll::model()->getInfoLastPayrollForOne($_GET['id']);
          if($result!=null)
            {   $result = $result->getData();
            	foreach($result as $r)
            	  { $last_pay_id = $r->id;
                
                     $month_=$r->payroll_month;
                    $year_= getYear($r->payroll_date);
                    
            	  }
             }
            
        
        if($last_pay_id!=0)
          {
         echo '<span class="btn btn-link fa fa-usd" style="padding-left: 15px; padding-right: 10px; " > '.CHtml::link(Yii::t('app','Billing'), array('/billings/payroll/view','id'=>$last_pay_id,'emp'=>$_GET['id'], 'month_'=>1,'year_'=>2016,'di'=>1,'part'=>'rec','from1'=>'vfr','from'=>'emp')).'  </span><br/>'; 
         
           }
       

            // Ajouter les boutons add email et send email
              if($model->email == null || $model->email == ""){
                
                echo '<span class="btn btn-link fa fa-envelope" style="padding: 10px" > '.CHtml::link(Yii::t('app','Add email'), array('persons/update','id'=>$model->id,'from1'=>'view','from'=>'emp')).'  </span><br/>';

              }
              else{
               echo '<span class="btn btn-link fa fa-envelope" style="padding: 10px" > '.CHtml::link(Yii::t('app','Send email'), array('mails/create','stud'=>$model->id,'from'=>'emp')).'  </span><br/>';
              }  

        
              }
            
            
            
            
            }
         
 
  echo '</div></div>';
   
      }//fen if((Yii::app()->user->profil=='Admin'))
 
?>


      <?php
                 }
      
      ?>       



<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php echo Yii::t('app','Discipline summary for {name}',array('{name}'=>$model->fullName)); ?></h4>
        </div>
        <div class="modal-body">
        <?php
            $acad=Yii::app()->session['currentId_academic_year'];
            function evenOdd($num)
            {
                ($num % 2==0) ? $class = 'odd' : $class = 'even';
                return $class;
            }
            
            $modelInfraction = new RecordInfraction;
        ?> 
            
        <!-- Debut contenu modal  -->    
            
           <div>
  
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home"> <?php echo Yii::t('app','Discipline summary'); ?></a></li>
    <li><a data-toggle="tab" href="#menu1"><?php echo Yii::t('app','Last infractions reccord'); ?></a></li>
    <li><a data-toggle="tab" href="#menu2"><?php echo Yii::t('app','Last attendence record'); ?></a></li>
    
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      
            <div style="clear:both"></div>

<div class="grid-view">
    <table class="detail-view table table-striped table-condensed">
        <tr class="odd">
        <?php 
        echo '<th>';
        echo Yii::t('app','Discipline grade : ');
        echo '</th>';
           if($modelInfraction->searchCurrentExamPeriod(date('Y-m-d'))!=null)
              $exam_period = $modelInfraction->searchCurrentExamPeriod(date('Y-m-d'))->id;
           else
              $exam_period = '';
        echo '<td>';
        echo $modelInfraction->getDisciplineGradeByExamPeriod($model->id, $exam_period);
        echo '</td>';
        ?> 
         
        </tr>
        <tr class="even">
        <?php 
        echo '<th>';
        echo Yii::t('app','Number of tardy : '); 
        echo '</th>';
        
        $total_retard = RecordPresence::model()->getTotalRetardByExam($exam_period, $model->id, $acad_sess);
        echo '<td>';
        echo $total_retard;
        echo '</td>';
        ?> 
        </tr>
		
        
        <tr class="odd">
    
        <?php 
         echo '<th>';
        echo Yii::t('app','Number of absence : '); 
         echo '</th>';
        $total_absence = RecordPresence::model()->getTotalPresenceByExam($exam_period, $model->id, $acad_sess);
        echo '<td>';
        echo $total_absence;
        echo '</td>';
        ?> 
        </tr>
		
		<tr class="even">
    
		        <?php 
		         echo '<th>';
		        echo Yii::t('app','Number of infraction : '); 
		         echo '</th>';
		        $total_number_absence = RecordInfraction::model()->numberOfInfraction($model->id,$exam_period);
		        echo '<td>';
        
		        echo $total_number_absence;
		        echo '</td>';
		        ?> 
	</tr>
    </table>
    
</div>
     
    </div>
    <div id="menu1" class="tab-pane fade">
      
      <div style="clear:both"></div>
      
      <div>
    
    <?php
    
     $all_infraction = $modelInfraction->searchStudent($acad_sess, $model->id)->getData();
     $i=0;
         
    ?>
   <div class="grid-view">    
    <table class="items">
        <thead>
        <tr>
        <th>
           <?php echo Yii::t('app','#'); ?> 
        </th>
        
        <th>
           <?php echo Yii::t('app','Infraction type'); ?> 
        </th>
        
        <th>
           <?php echo Yii::t('app','Incident Date'); ?> 
        </th>
        
        <th>
           <?php echo Yii::t('app','Value Deduction'); ?> 
        </th>
        
        </tr>
        </thead>
        <?php
       
             foreach($all_infraction as $ai){
        ?>
        <tr class="<?php echo evenOdd($i); ?>">
            <td><?php echo $i+1; ?></td>
            <td><?php  echo $ai->infractionType->name; ?></td>
            <td><?php  echo ChangeDateFormat($ai->incident_date); ?></td>
            <td><?php  echo $ai->value_deduction; ?></td>
        </tr>
             <?php 
             $i++;
             
        } 
          ?>
     
    </table>
   </div>
</div>
      
    
    </div>
    <div id="menu2" class="tab-pane fade">
      
          <div style="clear:both"></div>
          
          <div>
    
    <?php
     $modelPresence = new RecordPresence;
     $all_presence = $modelPresence->searchStudent($acad_sess, $model->id)->getData();
     $j=0;
         
    ?>
   <div class="grid-view">    
    <table class="items">
        <thead>
        <tr>
        <th>
           <?php echo Yii::t('app','#'); ?> 
        </th>
        
        <th>
           <?php echo Yii::t('app','Presence type'); ?> 
        </th>
        
        <th>
           <?php echo Yii::t('app','Record date'); ?> 
        </th>
        
        
        </tr>
        </thead>
        <?php
       
             foreach($all_presence as $ap){
        ?>
        <tr class="<?php echo evenOdd($j); ?>">
            <td><?php echo $j+1; ?></td>
            <td><?php  echo $ap->presence; ?></td>
            <td><?php  echo ChangeDateFormat($ap->date_record); ?></td>
           
        </tr>
             <?php 
             $j++;
             
        } 
          ?>
     
    </table>
   </div>
</div>
 
    </div>
      
    
  </div>
</div> 
            
        <!-- Fin contenu modal -->  
        
        </div>
        <div class="modal-footer">
		<?php 
              $infrac_id='';
			  
			  if(($all_infraction!=null)&&(Yii::app()->user->profil!='Billing'))
			   { foreach($all_infraction as $r)
				   { $infrac_id=$r->id;
				      break;
				   }
				   
                 echo '<span class="btn btn-default fa fa-legal" style="padding: 9px" > '.CHtml::link(Yii::t('app','Show more'), array('../discipline/recordInfraction/view','id'=>$infrac_id)).'  </span>'; 
          
			   }
			   ?>
		  <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo Yii::t('app','Close'); ?></button>
        </div>
      </div>
    </div>
  </div>

     