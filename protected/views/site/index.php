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


/* @var $this SiteController */
$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',));


$this->pageTitle=Yii::app()->name;
$baseUrl = Yii::app()->baseUrl; 
?>
<?php
/* @var $this SiteController */
// Set the page title at the index (dashboard) with the profil name and the user name of the login user.
$this->pageTitle=Yii::app()->name;//.' - '.Yii::app()->user->profil. ' '.Yii::app()->user->name;
?>

<?php // echo Yii::t('app','Welcome to {name}', array('{name}'=>Yii::app()->name));?>

	<?php
	     $acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
$siges_structure = infoGeneralConfig('siges_structure_session');
      
     $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
     
 if($current_acad==''){
        $condition = '';
          $condition1 ='';
 }
    else
    {  if($acad!=$current_acad->id)
       {  $condition = 'p.active IN(1,2) AND ';
          $condition1 ='active IN(1,2) AND ';
        }
      else
        {  $condition = 'p.active IN(1,2) AND ';
          $condition1 ='active IN(1,2) AND ';
        }
    }


	
$modelAcad=new AcademicPeriods;


$lastAcadYear=AcademicPeriods::model()->denyeAneAkademikNanSistemLan();
if(isset($lastAcadYear)&&($lastAcadYear!=null))
 { 
	if($acad==$lastAcadYear['id'])
	  {
	  	
		$num_month = date_diff ( date_create(date('Y-m-d'))  , date_create($lastAcadYear['date_end']))->format('%R%a');
		
		$message = Yii::t('app','Please run "End Year Decision", {name} day(s) left to move to a new academic year.',array('{name}'=>substr($num_month,1) ));
 	
		if(($num_month < 15))
		  Yii::app()->user->setFlash(Yii::t('app','Warning'), $message);
	  
	  	}
	
  } 

	
	
	
	
	$school_name = infoGeneralConfig('school_name');
	
	//echo $school_name;
     $school_acronym = infoGeneralConfig('school_acronym');
     
      
      $path=null;
   
     $explode_basepath= explode("protected",substr(Yii::app()->basePath, 0)); 
     echo '<input type="hidden" id="basePath" value="'.$explode_basepath[0].'" />';
        
?>
	


    <div class="container-fluid" style="text-align:center;" id="index_dash1">
 
    <div class="row-fluid"> 
     <div class="span12" style="text-align:center;" id="index_dash">

						<!-- ================================================== -->
						
						                    
						 <!-- Name School -->
						      <div id="dash" class="dash_home">
								<h2>  <?php echo $school_name; ?></h2>
                                                                <div id="acronym"><?php echo $school_acronym; ?></div>
						       
						          <!-- select academic year -->
						          
						   
						    
						       <?php 
						     if(isset(Yii::app()->user->profil))
						      {  
						       if((Yii::app()->user->profil!='Guest')&&(Yii::app()->user->profil!='Teacher')) 
						            {
						            	
						            	$path='/schoolconfig/calendar/calendarEvents';
						            	$view='/schoolconfig/calendar/viewForIndex/id/';
						     
						          

						     		?>  
						             
						      
						         <div class="acade_year" style="float:right; <?php if($siges_structure==1) echo 'width: 37%'; ?>">  
						       
						       <label for="AcademicPeriods"><?php echo Yii::t('app', 'Academic year'); ?></label>
						           <?php 
						           
						                   	$model=new AcademicPeriods;
						                   	$model1=new AcademicPeriods;  // for session
										
										$form=$this->beginWidget('CActiveForm', array(
											'id'=>'academic-year-form',
											'enableAjaxValidation'=>true,
												)); 					
														$criteria = new CDbCriteria(array('condition'=>'is_year=1','order'=>'date_end DESC',));
														
														echo $form->dropDownList($model, 'name_period',
														CHtml::listData(AcademicPeriods::model()->findAll($criteria),'id','name_period'),
														array('options' => array(($acad)=>array('selected'=>true)),'onchange'=> 'submit()' )
														);
										
										if($siges_structure==1)
										  {			
													$criteria = new CDbCriteria(array('condition'=>'is_year=0 AND year='.$acad,'order'=>'date_end DESC',));
														
														echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$form->dropDownList($model1, '[1]name_period',
														CHtml::listData(AcademicPeriods::model()->findAll($criteria),'id','name_period'),
														array('options' => array(($acad_sess)=>array('selected'=>true)),'onchange'=> 'submit()' )
														);	
										    }
										  
										    $this->endWidget();				
											
						            ?>  
						              </div>
						               
						               
						    <?php  	

						                 						           
						            }
						          elseif((Yii::app()->user->profil=='Teacher')) 
						               {
						               	     $path='/schoolconfig/calendar/calendarEvents';
						            	     $view='/schoolconfig/calendar/viewForIndex/id/';
						                 }
							          else
							            {
							            	$path='/guest/calendar/calendarEvents';
							            	$view='/guest/calendar/viewForIndex/id/';
							            	
							            	}
						       }
						      ?>  
						 
						              
						              
						            
						</div>


          <!--Sidebar content-->
        </div>




<div style="clear:both"></div>	
<div class="span12" style="text-align:justify;padding-left:30px;" id="index_dash">				
							
             	
	 
				<!-- ================================================== -->
							
	 <?php
							            
      
						        
							 
							 
							            $criteria = new CDbCriteria;
							            $criteria->select = 'count(*) as total_stud';
							          
							          
							              $criteria->condition= $condition1.' is_student=:item_name ';
							              
							            $criteria->params=array(':item_name'=>1,);
							            $total_stud = Persons::model()->find($criteria)->count();
							           
							
							            
							            
							      
							        $tot_stud_s=0;
							        $female_s = 0;
							        $male_s = 0;
							
							        $tot_stud=0;
							        $female = 0;
							        $male = 0;
							        //teachers
							        $tot_teach_s=0;
							        $female1_s = 0;
							        $male1_s = 0;
							
							        $tot_teach=0;
							        $female1 = 0;
							        $male1 = 0;
							        //employees									   
							        $tot_emp_s=0;
							        $female2_s = 0;
							        $male2_s = 0;
							
							        $tot_emp=0;
							        $female2 = 0;
							        $male2 = 0;
							
							         $level = array();
							
							
							
							
							        // Student data 
							       $dataProvider= Persons::model()->searchStudentsReport($condition,$acad_sess);
							
							        if($dataProvider->getItemCount()!=0)
							            $tot_stud =$dataProvider->getItemCount();
							
							
							        //reccuperer la qt des diff. sexes
							        $person=$dataProvider->getData();
							
							        foreach($person as $stud)
							         {
								        if($stud->gender==1)
								            $female++;
								        elseif($stud->gender==0)
								            $male++;
							         }
							        // Fin student data 
							
							        // Teachers data 
							
							        $dataProvider1= Persons::model()->searchTeacherReport($condition,$acad_sess);
							
							        if($dataProvider1->getItemCount()!=0)
							        $tot_teach =$dataProvider1->getItemCount();
							
							
							        //reccuperer la qt des diff. sexes
							        $person=$dataProvider1->getData();
							
							        foreach($person as $teacher)
							         {
								        if($teacher->gender==1)
								             $female1++;
								        elseif($teacher->gender==0)
								              $male1++;
							         }
							        // Fin teachers
							
							        // debut Employes 
							        $dataProvider2= Persons::model()->searchEmployeeReport($condition,$acad_sess);
							
							        if($dataProvider2->getItemCount()!=0)
							           $tot_emp =$dataProvider2->getItemCount();
							
							
							        //reccuperer la qt des diff. sexes
							        $person=$dataProvider2->getData();
							
							        foreach($person as $employee)
							         {
								        if($employee->gender==1)
								             $female2++;
								        elseif($employee->gender==0)
								            $male2++;
							          }
							
							// fin employes 
							
							
							// Total pesonnes 
							$tot_pers = $tot_stud + $tot_emp + $tot_teach;
							      				
							//reccuperer la qt des diff. sexes
							$tot_fem = $female  + $female1 + $female2;
							$tot_mal = $male  + $male1 + $male2;
							// fin total personne 
							
							// Stat sur Rooms 
							$tot_rooms=0; 
							$countRooms = Rooms::model()->searchReport(); 
							if($countRooms->getItemCount()!=0)
							    $tot_rooms = $countRooms->getItemCount();
							
							// Stat sur Subjects 
							$tot_sub=0; 
							$countSubjects = Subjects::model()->searchReport(); 
							if($countSubjects->getItemCount()!=0)
							    $tot_sub = $countSubjects->getItemCount();
							
							// Stat sur Courses 
							 $countCourses = null;
							$tot_course=0; 
							if($acad!='')
							  $countCourses = Courses::model()->searchReport($condition1,$acad_sess); 
							
							   
							 
							if($countCourses->getItemCount()!=0)
							    $tot_course = $countCourses->getItemCount();
							
							 ?>
							 
							 
							   
			 <!--===========================================-->


<div class="row">
 
		
	
			<div class="span8" >
				
							
						
	    
						 
						
							<div class="span2">
							
										 <div class="box2 box2-default">
							               <div class="box-header with-border">
							                 <h5 class="box-title"> <?php echo Yii::t('app','Rooms'); ?></h5>
							              <div class="box-tools pull-right">
							                    
							             </div>
							        </div>
							    
							    <div class="box2-body" style="vertical-align: center; alignment-adjust: middle;  color:#EE6539; clear: both;">           
								    
							                <i class="fa fa-building-o "></i>
							               <div class="box-tools pull-right"> <?php echo $tot_rooms; ?>  </div>
							                <!--<i class="fa fa-building-o "></i> -->
							
							            
							    </div>
							                
							</div>                 
							
							</div>
							
							
							
							
							
							
							<div class="span2">
							
							<div class="box2 box2-default">
							        <div class="box-header with-border">
							            <h5 class="box-title"><?php echo Yii::t('app','Subjects'); ?></h5>
							                  <div class="box-tools pull-right">
							                    
							                  </div>
							        </div>
							    
							    <div class="box2-body" style="vertical-align: center; alignment-adjust: middle;  color:#EE6539; clear: both;">           
								    
							                <i class="fa fa-file-o "></i>
							               <div class="box-tools pull-right"> <?php echo $tot_sub; ?>  </div>
							                <!--<i class="fa fa-building-o fa-2x"></i> -->
							
							            
							    </div>
							                
							</div>                 
							
							</div>
							
							
							
							
							
							
							
							<div class="span2">
							
							<div class="box2 box2-default">
							        <div class="box-header with-border">
							            <h5 class="box-title">
											<?php echo Yii::t('app','Courses'); ?></h5>
							                  <div class="box-tools pull-right">
							                    
							                  </div>
							        </div>
							    
							    <div class="box2-body" style="vertical-align: center; alignment-adjust: middle;  color:#EE6539; clear: both;">           
								    
							                <i class="fa fa-folder-open"></i>
							               <div class="box-tools pull-right"> <?php echo $tot_course; ?>  </div>
							                <!--<i class="fa fa-building-o fa-2x"></i> -->
							
							            
							    </div>
							                
							</div>                 
							
							</div>
							
							
							
							
							
							
							
							<div class="span2">
							
										<div class="box2 box2-default">
							               <div class="box-header with-border">
											 <h5 class="box-title"> <?php echo $tot_stud." ".Yii::t('app','Students'); ?></h5>
							           
							              <div class="box-tools pull-right">
							                    
							             </div>
							            </div>
							    
								    <div class="box2-body" style="vertical-align: center; alignment-adjust: middle;  color:#EE6539; clear: both;">           
								               <span>
								               <i class="fa fa-female">:</i><?php echo $female; ?> 
								               <div class="box-tools pull-right">   </div> 
								                <!--<i class="fa fa-building-o fa-2x"></i> -->
								               
								               <div class="box-tools pull-right"> <i class="fa fa-male ">:</i><?php echo $male; ?>   </div>
								               </span>	
								    </div>
							                
							 </div>
							
							</div>
							
							
							
							
							
							<div class="span2">
							
										<div class="box2 box2-default">
							               <div class="box-header with-border">
											 <h5 class="box-title">  <?php echo $tot_teach." ".Yii::t('app','Teachers'); ?></h5>
							           
							              <div class="box-tools pull-right">
							                    
							             </div>
							            </div>
							    
								    <div class="box2-body" style="vertical-align: center; alignment-adjust: middle;  color:#EE6539; clear: both;">           
								                
								               <span>
								               <i class="fa fa-female">:</i><?php echo $female1; ?> 
								               <div class="box-tools pull-right">   </div> 
								                <!--<i class="fa fa-building-o fa-2x"></i> -->
								               
								               <div class="box-tools pull-right"> <i class="fa fa-male">:</i><?php echo $male1; ?>   </div>
								               </span>	
								    </div>
							                
							 </div>
							
							</div>
							
							
							
							
							
							
							<div class="span2">
							
										<div class="box2 box2-default">
							               <div class="box-header with-border">
											<h5 class="box-title"> <?php echo $tot_pers." ".Yii::t('app','Persons'); ?></h5>
							              <div class="box-tools pull-right">
							                    
							             </div>
							            </div>
							    
								    <div class="box2-body" style="vertical-align: center; alignment-adjust: middle; color:#EE6539; clear: both;">           
								                
								               <span>
								               <i class="fa fa-female">:</i><?php echo $tot_fem; ?> 
								               <div class="box-tools pull-right">   </div> 
								                <!--<i class="fa fa-building-o fa-2x"></i> -->
								            
								               <div class="box-tools pull-right">    <i class="fa fa-male">:</i><?php echo $tot_mal; ?>   </div>
								               </span>	
								    </div>
							                
						</div>
							
							
							
							
							    </div> <!--end fluid 2-->
							

							
 			



<div class="span12" style=" float: left; margin-left: 0px;" >




					<!-- =====================================================-->



						   <!--fluid 1-->
						  
						
						    
						<!-- <div class="span2" style="border:1px solid red;"> //pou LOGO LEKOL LA, AK TI ENFO DE BAZ SOULI//pou LOGO LEKOL LA, AK TI ENFO DE BAZ SOULI//pou LOGO LEKOL LA, AK TI ENFO DE BAZ SOULI//pou LOGO LEKOL LA, AK TI ENFO DE BAZ SOULI//pou LOGO LEKOL LA, AK TI ENFO DE BAZ SOULI//pou LOGO LEKOL LA, AK TI ENFO DE BAZ SOULI//pou LOGO LEKOL LA, AK TI ENFO DE BAZ SOULI//pou LOGO LEKOL LA, AK TI ENFO DE BAZ SOULI//pou LOGO LEKOL LA, AK TI ENFO DE BAZ SOULI//pou LOGO LEKOL LA, AK TI ENFO DE BAZ SOULI//pou LOGO LEKOL LA, AK TI ENFO DE BAZ SOULI//pou LOGO LEKOL LA, AK TI ENFO DE BAZ SOULI//pou LOGO LEKOL LA, AK TI ENFO  
						 </div>  
						 -->
						 <!--end class2 -->
						  
						
					

						  
						<?php
						        //pou GWOSE EKRITI TIT LA
						      /* cheche liy sa nan bootstrap.min.css: "h2{font-size:30px;line-height:40px}"
						         ranplasel p[a liy sa: "h2{font-size:18px;line-height:27px}"
						         
						         */
						    $this->widget('ext.fullcalendar.FullCalendar', array(
						    'themeCssFile'=>'cupertino/jquery-ui.min.css',
						      'lang'=>Yii::app()->language,//'fr',
						     // raw html tags
						    'htmlOptions'=>array(
						        // you can scale it down as well, try 80%
						        'style'=>'width:100%, background: #ECF0F5'	
						         ),
						         
						       'options'=>array(
						        'header'=>array(
						            'left'=>'prev,next,today',
						            'center'=>'title',
						            'right'=>'month,agendaWeek,agendaDay',
						        ),
						        'editable'=>true,
						        'selectable' =>false, 
						        'events'=> $this->createUrl($path), 
						          
						        'eventClick'=>'js:function(calEvent, jsEvent, view) { //alert(\'Event: \' + calEvent.title + \'\nStart Time: \' + calEvent.start);
						         $("#myModalHeader").html("'.Yii::t("app","Event Detail").'");
						         $("#myModalBody").load("'.Yii::app()->createUrl("$view").'/"+ calEvent.id +"?asModal=true");
						         $("#myModal").modal();
						           
						    		}',
						     
						    )
						));
						
						 
						
						?>
			</div>			
	    
	</div>

		<div class="span4">

				<?php require_once('announcement.php')?>



          <!--Body content-->
	        </div>


	                
</div>                 
	
<!-- ================================================== -->	
	      
	    
	
	 
	</br>
	</br>
	

<div style="clear:both"></div>	










<script>
			
			$(document).ready( function() {
				
				var basePath=document.getElementById("basePath").value;
				
				$('#fileTreeDemo_1').fileTree({ root: '../images/', script: 'connectors/jqueryFileTree.php' }, function(file) { 
					alert(file);
				});
				
								
			});
		</script>    

    
 
     
                           
       
		
		
		             
		
		
