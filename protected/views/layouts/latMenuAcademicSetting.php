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
 
$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

$siges_structure = infoGeneralConfig('siges_structure_session'); 
						
if($acad!=null){  
	
	$display_schedule_agenda = 0;
	$item_ageda_guest=null;
	$item_ageda_others=null;
	$item_name_guest=null;
	$item_name_others = null;
	$item_url_guest=null;
	$item_url_others = null;
	
	 
	$display_schedule_agenda_ = infoGeneralConfig('display_schedule_agenda');
	
	if($display_schedule_agenda_=='')
	  $display_schedule_agenda = 0;
	else
	   $display_schedule_agenda =$display_schedule_agenda_;
	   
	    switch($display_schedule_agenda)
	      {
	      	case 0:  $item_name_guest = Yii::t('app','Schedules');
	      	         $item_url_guest = array('/guest/schedules/index');
	      	         $item_ageda_guest=  array('label'=>'', );
	      	         
	      	         $item_name_others = Yii::t('app','Schedules');
	      	         $item_url_others = array('/schoolconfig/schedules/index');
	      	         
	      	         $item_ageda_others=  array('label'=>'', );
	      	         
	      	         
	      	  break;
	      	  
	      	  case 1:  $item_name_guest = Yii::t('app','Agenda');
	      	         $item_url_guest = array('/guest/scheduleAgenda/index');
	      	         $item_ageda_guest=  array('label'=>'', );
	      	         
	      	         $item_name_others = Yii::t('app','Agenda');
	      	         $item_url_others = array('/schoolconfig/scheduleAgenda/index');
	      	         
	      	         $item_ageda_others= array('label'=>'', );
	      	         
	      	         
	      	         
	      	  break;
	      	  
	      	  case 2:  $item_name_guest = Yii::t('app','Schedules');
	      	         $item_url_guest = array('/guest/schedules/index');
	      	         
	      	         $item_ageda_guest= array('label'=>'<span class="fa fa-calendar-check-o"> '.Yii::t('app','Agenda').'</span>', 'url'=>array('/guest/scheduleAgenda/index'));
	      	         
	      	         $item_name_others = Yii::t('app','Schedules');
	      	         $item_url_others = array('/schoolconfig/schedules/index');
	      	         
	      	         $item_ageda_others= array('label'=>'<span class="fa fa-calendar-check-o"> '.Yii::t('app','Agenda').'</span>', 'url'=>array('/schoolconfig/scheduleAgenda/index'));
	      	         
	      	         
	      	  break;
	      	
	      		      	  
	      	  
	      	  
	      	  
	      	}

	
	
	
	if(isset(Yii::app()->user->userid))
                        {
                            $userid = Yii::app()->user->userid;
                        }
                        else 
                        {
                            $userid = null;
                        }
                        
							
if(isset(Yii::app()->user->profil))
{   $profil=Yii::app()->user->profil;
   switch($profil)
     {
        case 'Guest':
                  if(isset(Yii::app()->user->groupid))
            {    
                   $groupid=Yii::app()->user->groupid;
                   $group=Groups::model()->findByPk($groupid);
                    
                    
                          $group_name=$group->group_name;
            if($group_name=='Parent')
              {
              	   $this->widget('zii.widgets.CMenu', array(
					'activeCssClass'=>'active',
					'encodeLabel'=>false,     
					'activateParents'=>true,
					'items'=>array(
					
					array('label'=>'<span class="fa fa-2y" style="font-size: 23px;">  '.Yii::t('app','Academic info').'</span>', 
					//'linkOptions'=>array('id'=>'menuAcademicSettings'),
					//'itemOptions'=>array('id'=>'itemAcademicSettings'),
					
					'items'=>array(
					array('label'=>'<span class="fa fa-table"> '.Yii::t('app','Grade').'</span>','url'=>array('grades/index','mn'=>'std')),
					
					array('label'=>'<span class="fa fa-folder-open-o"> '.Yii::t('app','Homework').'</span>', 'url'=>array('/guest/homework/index','mn'=>'std'),'visible'=>!Yii::app()->user->isGuest),
					
					array('label'=>'<span class="fa fa-folder-open-o"> '.Yii::t('app','Submited Homework').'</span>', 'url'=>array('/guest/homeworkSubmission/index','mn'=>'std'),'visible'=>!Yii::app()->user->isGuest),
					
					//array('label'=>'<span class="fa fa-print"> '.Yii::t('app','Transcript').'</span>','url'=>array('reportcard/report','from'=>'stud','mn'=>'std')),

					array('label'=>'<span class="fa fa-check-square-o"> '.Yii::t('app','Evaluation by period').'</span>','url'=>array('/guest/evaluationbyyear/index')),
					   array('label'=>'<span class="fa fa-folder-open-o"> '.Yii::t('app','Courses').'</span>', 'url'=>array('/guest/courses/index')),
					    array('label'=>'<span class="fa fa-calendar"> '.$item_name_guest.'</span>', 'url'=>$item_url_guest),
							    
						$item_ageda_guest,
					    
					    
					        )),
					        
					 
					))); 

               }
              elseif($group_name=='Student')
                {   
                	 $this->widget('zii.widgets.CMenu', array(
					'activeCssClass'=>'active',
					'encodeLabel'=>false,     
					'activateParents'=>true,
					'items'=>array(
					
					array('label'=>'<span class="fa fa-2y" style="font-size: 23px;">  '.Yii::t('app','Academic settings').'</span>', 
					//'linkOptions'=>array('id'=>'menuAcademicSettings'),
					//'itemOptions'=>array('id'=>'itemAcademicSettings'),
					
					'items'=>array(
						array('label'=>'<span class="fa fa-table"> '.Yii::t('app','Grade').'</span>','url'=>array('grades/index','mn'=>'std')),
					
					array('label'=>'<span class="fa fa-folder-open-o"> '.Yii::t('app','Homework').'</span>', 'url'=>array('/guest/homework/index','mn'=>'std'),'visible'=>!Yii::app()->user->isGuest),
					
					array('label'=>'<span class="fa fa-folder-open-o"> '.Yii::t('app','Submited Homework').'</span>', 'url'=>array('/guest/homeworkSubmission/index','mn'=>'std'),'visible'=>!Yii::app()->user->isGuest),
					
					array('label'=>'<span class="fa fa-check-square-o"> '.Yii::t('app','Evaluation by period').'</span>','url'=>array('/guest/evaluationbyyear/index')),
						 array('label'=>'<span class="fa fa-folder-open-o"> '.Yii::t('app','Courses').'</span>', 'url'=>array('/guest/courses/index')),
					    array('label'=>'<span class="fa fa-calendar"> '.$item_name_guest.'</span>', 'url'=>$item_url_guest),
							    
						$item_ageda_guest,
					    
					    
					        )),
					        
					 
					))); 
            
                  
                  }
               
            }

               
               break;
               
          case 'Admin':
                      
                    if(Yii::app()->user->groupid==1)
		              {  
		                    $items=array();
		                    $last_eval_date=null;
		                    
		                    $last_eval = EvaluationByYear::model()->getLastEvaluationSet($acad_sess);//return id and eval_date if nort null
		                    
		                    if($last_eval!=null)
		                      {
		                      	foreach($last_eval as $l)
		                      	 {
		                      		$last_eval_date = $l['evaluation_date'];
		                      		
		                      	  }
		                      }
         
				        

          		
          		$modelAcad=new AcademicPeriods;
						   $greater_date=null;
						   
						   //get  date_end of the last academic period
                         if($siges_structure==0)
                            $lastPeriodDate=$modelAcad->lastDateAcademicPeriod($acad);
                         elseif($siges_structure==1)
                            {   
                            	$last_eval_dat = EvaluationByYear::model()->getLastEvaluationDate($acad_sess);//return id and eval_date if nort null
		                    
			                    if($last_eval_dat!=null)
			                      {
			                      	foreach($last_eval_dat as $l)
			                      	 {
			                      		$greater_date = $l['evaluation_date'];
			                      		
			                      	  }
			                      }
			                      
			                     
			                      
                            }
                            
                            
							if(isset($lastPeriodDate))
							 { 
							      $result=$lastPeriodDate->getData();
							     foreach($result as $r)
							      { 
							      	 
							      
								    if($greater_date<$r->date_end)
								      $greater_date=$r->date_end;
							      }
							 } 
							 
						  if( ($greater_date!=null) || ($last_eval_date !=null) )	   
							{	 
								 $groupid=Yii::app()->user->groupid;
                                 $group=Groups::model()->findByPk($groupid);
                                 $group_name=$group->group_name;
 								
 							
 								 if( (date('Y-m-d') >= $greater_date)|| ( ($last_eval_date!=null)&&(date('Y-m-d') >= $last_eval_date) )|| (isAchiveMode($acad_sess))  )
									{  $items=array(
								array('label'=>'<span class="fa fa-sort-amount-asc"> '.Yii::t('app','Admission').'</span>','url'=>array('/academic/postulant/viewListAdmission','part'=>'enrlis','pg'=>'')),
								
								array('label'=>'<span class="fa fa-download"> '.Yii::t('app','Level/Room affectation').'</span>','url'=>array('/academic/persons/levelRoomAffectation','isstud'=>1,'pg'=>'lr','mn'=>'std')),
								
								//array('label'=>'<span class="fa fa-download"> '.Yii::t('app','Movement').'</span>','url'=>array('/academic/persons/mouvement','isstud'=>1,'pg'=>'lr','mn'=>'std')),
								
								array('label'=>'<span class="fa fa-sort-amount-asc"> '.Yii::t('app','Class Setup List').'</span>','url'=>array('/academic/persons/classSetup','isstud'=>1,'pg'=>'lr','mn'=>'std')),
						    
		                        array('label'=>'<span class="fa fa-file-o"> '.Yii::t('app','Subjects').'</span>','url'=>array('/schoolconfig/subjects/index')),
							    array('label'=>'<span class="fa fa-folder-open-o"> '.Yii::t('app','Courses').'</span>', 'url'=>array('/schoolconfig/courses/index')),
							     array('label'=>'<span class="fa fa-folder"> '.Yii::t('app','Archives').'</span>', 'url'=>array('/schoolconfig/documents/index/pos/home/pos/home')),
							      array('label'=>'<span class="fa fa-calendar"> '.$item_name_others.'</span>', 'url'=>$item_url_others),
							    
							    $item_ageda_others,
							     
							    array('label'=>'<span class="fa fa-calendar"> '.Yii::t('app','Calendar').'</span>', 'url'=>array('/schoolconfig/calendar/index')),
							    
								array('label'=>'<span class="fa fa-globe"> '.Yii::t('app','Portal').'</span>','url'=>array('/portal/cmsArticle/index')),
                        
								array('label'=>'<span class="fa fa-bell"> '.Yii::t('app','Announcements').'</span>', 'url'=>array('/schoolconfig/announcements/index')),
							    
							    array('label'=>'<span class="fa fa-envelope"> '.Yii::t('app','Groups mails').'</span>','url'=>array('/academic/mails/batchemail','mn'=>'std')),
							    
							    array('label'=>'<span class="fa fa-child"> '.Yii::t('app','Partners').'</span>','url'=>array('/configuration/partners/index')),
							    
							    array('label'=>'<span class="fa fa-check-square-o"> '.Yii::t('app','Disable students').'</span>','url'=>array('/academic/persons/disableStudents','isstud'=>1,'pg'=>'lr','mn'=>'std')),
								
								array('label'=>'<span class="fa fa-anchor"> '.Yii::t('app','Examen MENFP').'</span>','url'=>array('/academic/menfpGrades/index','part'=>'parlis','from'=>'')),
								
								array('label'=>'<span class="fa fa-anchor"> '.Yii::t('app','End Year Decision').'</span>','url'=>array('/reports/reportcard/endYearDecision','mn'=>'std','from'=>'stud')),
					
					                       
			            
		
							    
							        );
							        
							        
									
									 }
							     else
							       { 
							       	  $items=array(
								array('label'=>'<span class="fa fa-sort-amount-asc"> '.Yii::t('app','Admission').'</span>','url'=>array('/academic/postulant/viewListAdmission','part'=>'enrlis','pg'=>'')),
								
								array('label'=>'<span class="fa fa-download"> '.Yii::t('app','Level/Room affectation').'</span>','url'=>array('/academic/persons/levelRoomAffectation','isstud'=>1,'pg'=>'lr','mn'=>'std')),
								
								
								//array('label'=>'<span class="fa fa-download"> '.Yii::t('app','Movement').'</span>','url'=>array('/academic/persons/mouvement','isstud'=>1,'pg'=>'lr','mn'=>'std')),
								
								array('label'=>'<span class="fa fa-sort-amount-asc"> '.Yii::t('app','Class Setup List').'</span>','url'=>array('/academic/persons/classSetup','isstud'=>1,'pg'=>'lr','mn'=>'std')),
						    
		                      array('label'=>'<span class="fa fa-file-o"> '.Yii::t('app','Subjects').'</span>','url'=>array('/schoolconfig/subjects/index')),
							    array('label'=>'<span class="fa fa-folder-open-o"> '.Yii::t('app','Courses').'</span>', 'url'=>array('/schoolconfig/courses/index')),
							      array('label'=>'<span class="fa fa-folder"> '.Yii::t('app','Archives').'</span>', 'url'=>array('/schoolconfig/documents/index/pos/home')),
							      array('label'=>'<span class="fa fa-calendar"> '.$item_name_others.'</span>', 'url'=>$item_url_others),
							    
							    $item_ageda_others,
							     
							    array('label'=>'<span class="fa fa-calendar"> '.Yii::t('app','Calendar').'</span>', 'url'=>array('/schoolconfig/calendar/index')),
							    
								array('label'=>'<span class="fa fa-globe"> '.Yii::t('app','Portal').'</span>','url'=>array('/portal/cmsArticle/index')),
                        
								array('label'=>'<span class="fa fa-bell"> '.Yii::t('app','Announcements').'</span>', 'url'=>array('/schoolconfig/announcements/index')),
							    
							    array('label'=>'<span class="fa fa-envelope"> '.Yii::t('app','Groups mails').'</span>','url'=>array('/academic/mails/batchemail','mn'=>'std')),
							    
							    array('label'=>'<span class="fa fa-child"> '.Yii::t('app','Partners').'</span>','url'=>array('/configuration/partners/index')), 
							    
							    array('label'=>'<span class="fa fa-check-square-o"> '.Yii::t('app','Disable students').'</span>','url'=>array('/academic/persons/disableStudents','isstud'=>1,'pg'=>'lr','mn'=>'std')),
								
								array('label'=>'<span class="fa fa-anchor"> '.Yii::t('app','Examen MENFP').'</span>','url'=>array('/academic/menfpGrades/index','part'=>'parlis','from'=>'')),
								
								array('label'=>'<span class="fa fa-anchor" style="color:#939893"> '.Yii::t('app','End Year Decision').'</span>', 'linkOptions'=> array(
                                 'title' => Yii::t('app','Link will be available at the end of last period.'), 
                          ),    ),
					
					                      
			            
		
							    
							        );
							       	
							        }              
								   
						
 							  
 							
						
						
						}	 
          		     else // $greater_date==null
          		      {
          		      	   $items=array(
								array('label'=>'<span class="fa fa-sort-amount-asc"> '.Yii::t('app','Admission').'</span>','url'=>array('/academic/postulant/viewListAdmission','part'=>'enrlis','pg'=>'')),
								
								array('label'=>'<span class="fa fa-download"> '.Yii::t('app','Level/Room affectation').'</span>','url'=>array('/academic/persons/levelRoomAffectation','isstud'=>1,'pg'=>'lr','mn'=>'std')),
								
							//	array('label'=>'<span class="fa fa-download"> '.Yii::t('app','Movement').'</span>','url'=>array('/academic/persons/mouvement','isstud'=>1,'pg'=>'lr','mn'=>'std')),
								
								
								array('label'=>'<span class="fa fa-sort-amount-asc"> '.Yii::t('app','Class Setup List').'</span>','url'=>array('/academic/persons/classSetup','isstud'=>1,'pg'=>'lr','mn'=>'std')),
						    
		                      array('label'=>'<span class="fa fa-file-o"> '.Yii::t('app','Subjects').'</span>','url'=>array('/schoolconfig/subjects/index')),
							    array('label'=>'<span class="fa fa-folder-open-o"> '.Yii::t('app','Courses').'</span>', 'url'=>array('/schoolconfig/courses/index')),
							     array('label'=>'<span class="fa fa-folder"> '.Yii::t('app','Archives').'</span>', 'url'=>array('/schoolconfig/documents/index/pos/home')),
							      array('label'=>'<span class="fa fa-calendar"> '.$item_name_others.'</span>', 'url'=>$item_url_others),
							    
							    $item_ageda_others,
							     
							    array('label'=>'<span class="fa fa-calendar"> '.Yii::t('app','Calendar').'</span>', 'url'=>array('/schoolconfig/calendar/index')),
							  
							  array('label'=>'<span class="fa fa-globe"> '.Yii::t('app','Portal').'</span>','url'=>array('/portal/cmsArticle/index')),
                        		
								array('label'=>'<span class="fa fa-bell"> '.Yii::t('app','Announcements').'</span>', 'url'=>array('/schoolconfig/announcements/index')),
							    
							    array('label'=>'<span class="fa fa-envelope"> '.Yii::t('app','Groups mails').'</span>','url'=>array('/academic/mails/batchemail','mn'=>'std')),
							    
							    array('label'=>'<span class="fa fa-child"> '.Yii::t('app','Partners').'</span>','url'=>array('/configuration/partners/index')),
							    
							    array('label'=>'<span class="fa fa-check-square-o"> '.Yii::t('app','Disable students').'</span>','url'=>array('/academic/persons/disableStudents','isstud'=>1,'pg'=>'lr','mn'=>'std')),
								
								array('label'=>'<span class="fa fa-anchor"> '.Yii::t('app','Examen MENFP').'</span>','url'=>array('/academic/menfpGrades/index','part'=>'parlis','from'=>'')),
								
								array('label'=>'<span class="fa fa-anchor" style="color:#939893"> '.Yii::t('app','End Year Decision').'</span>', 'linkOptions'=> array(
                                 'title' => Yii::t('app','Link will be available at the end of last period.'), 
                          ),    ),
					
					                      
			            
		
							    
							        );
          		      }
          		

		                  
		                    $this->widget('zii.widgets.CMenu', array(
							'activeCssClass'=>'active',
							'encodeLabel'=>false,     
							'activateParents'=>true,
							'items'=>array(
							
							array('label'=>'<span class="fa fa-2y" style="font-size: 23px;"> '.Yii::t('app','Academic settings').'</span>', 
							//'linkOptions'=>array('id'=>'menuAcademicSettings'),
							//'itemOptions'=>array('id'=>'itemAcademicSettings'),
							
							'items'=>$items),
							        
							 
							))); 
							
						}
		              else
		                { 
				           if(Yii::app()->user->profil=='Admin')
					         {
					              $items=array();
					              
					              $last_eval_date=null;
					              
					              $last_eval = EvaluationByYear::model()->getLastEvaluationSet($acad_sess);//return id and eval_date if nort null
		                    
		                    if($last_eval!=null)
		                      {
		                      	foreach($last_eval as $l)
		                      	 {
		                      		$last_eval_date = $l['evaluation_date'];
		                      		
		                      	  }
		                      }
					              
          		
          		$modelAcad=new AcademicPeriods;
						   $greater_date=null;
						   
						   //get  date_end of the last academic period
                            
                            if($siges_structure==0)
                            $lastPeriodDate=$modelAcad->lastDateAcademicPeriod($acad);
                         elseif($siges_structure==1)
                            $lastPeriodDate=$modelAcad->lastAcademicSession($acad);
                            
                            $result=$lastPeriodDate->getData();
							if(($result!=null))
							 { 
							 
							     foreach($result as $r)
							      { 
							      	if($greater_date<$r->date_end)
								      $greater_date=$r->date_end;
							      }
							 } 
							 
						  if(($greater_date!=null) || ($last_eval_date !=null) ) 	   
							{	 
								 $groupid=Yii::app()->user->groupid;
                                 $group=Groups::model()->findByPk($groupid);
                                 $group_name=$group->group_name;
 								
 							
 								 if( (date('Y-m-d') >= $greater_date)|| ( ($last_eval_date!=null)&&(date('Y-m-d') >= $last_eval_date) )|| (isAchiveMode($acad_sess)) )
									{  $items=array(
								array('label'=>'<span class="fa fa-sort-amount-asc"> '.Yii::t('app','Admission').'</span>','url'=>array('/academic/postulant/viewListAdmission','part'=>'enrlis','pg'=>'')),
								
								array('label'=>'<span class="fa fa-download"> '.Yii::t('app','Level/Room affectation').'</span>','url'=>array('/academic/persons/levelRoomAffectation','isstud'=>1,'pg'=>'lr','mn'=>'std')),
								
							//	array('label'=>'<span class="fa fa-download"> '.Yii::t('app','Movement').'</span>','url'=>array('/academic/persons/mouvement','isstud'=>1,'pg'=>'lr','mn'=>'std')),
								
								
								array('label'=>'<span class="fa fa-sort-amount-asc"> '.Yii::t('app','Class Setup List').'</span>','url'=>array('/academic/persons/classSetup','isstud'=>1,'pg'=>'lr','mn'=>'std')),
						    
		                      array('label'=>'<span class="fa fa-file-o"> '.Yii::t('app','Subjects').'</span>','url'=>array('/schoolconfig/subjects/index')),
							    array('label'=>'<span class="fa fa-folder-open-o"> '.Yii::t('app','Courses').'</span>', 'url'=>array('/schoolconfig/courses/index')),
							     array('label'=>'<span class="fa fa-folder"> '.Yii::t('app','Archives').'</span>', 'url'=>array('/schoolconfig/documents/index/pos/home')),
							       array('label'=>'<span class="fa fa-calendar"> '.$item_name_others.'</span>', 'url'=>$item_url_others),
							    
							    $item_ageda_others,
							     
							    array('label'=>'<span class="fa fa-calendar"> '.Yii::t('app','Calendar').'</span>', 'url'=>array('/schoolconfig/calendar/index')),
							   
							   array('label'=>'<span class="fa fa-globe"> '.Yii::t('app','Portal').'</span>','url'=>array('/portal/cmsArticle/index')),
                        
         						array('label'=>'<span class="fa fa-bell"> '.Yii::t('app','Announcements').'</span>', 'url'=>array('/schoolconfig/announcements/index')),
							    
							    array('label'=>'<span class="fa fa-envelope"> '.Yii::t('app','Groups mails').'</span>','url'=>array('/academic/mails/batchemail','mn'=>'std')),
							    
							    array('label'=>'<span class="fa fa-child"> '.Yii::t('app','Partners').'</span>','url'=>array('/configuration/partners/index')),  
							    
							    array('label'=>'<span class="fa fa-check-square-o"> '.Yii::t('app','Disable students').'</span>','url'=>array('/academic/persons/disableStudents','isstud'=>1,'pg'=>'lr','mn'=>'std')),
								
								array('label'=>'<span class="fa fa-anchor"> '.Yii::t('app','Examen MENFP').'</span>','url'=>array('/academic/menfpGrades/index','part'=>'parlis','from'=>'')),
								
								array('label'=>'<span class="fa fa-anchor"> '.Yii::t('app','End Year Decision').'</span>','url'=>array('/reports/reportcard/endYearDecision','mn'=>'std','from'=>'stud')),
					
					                    
			            
		
							    
							        );
							        
							        
									
									 }
							     else
							       { 
							       	  $items=array(
								array('label'=>'<span class="fa fa-sort-amount-asc"> '.Yii::t('app','Admission').'</span>','url'=>array('/academic/postulant/viewListAdmission','part'=>'enrlis','pg'=>'')),
								
								array('label'=>'<span class="fa fa-download"> '.Yii::t('app','Level/Room affectation').'</span>','url'=>array('/academic/persons/levelRoomAffectation','isstud'=>1,'pg'=>'lr','mn'=>'std')),
								
							//	array('label'=>'<span class="fa fa-download"> '.Yii::t('app','Movement').'</span>','url'=>array('/academic/persons/mouvement','isstud'=>1,'pg'=>'lr','mn'=>'std')),
								
								
								array('label'=>'<span class="fa fa-sort-amount-asc"> '.Yii::t('app','Class Setup List').'</span>','url'=>array('/academic/persons/classSetup','isstud'=>1,'pg'=>'lr','mn'=>'std')),
						    
		                       array('label'=>'<span class="fa fa-file-o"> '.Yii::t('app','Subjects').'</span>','url'=>array('/schoolconfig/subjects/index')),
							    array('label'=>'<span class="fa fa-folder-open-o"> '.Yii::t('app','Courses').'</span>', 'url'=>array('/schoolconfig/courses/index')),
							     array('label'=>'<span class="fa fa-folder"> '.Yii::t('app','Archives').'</span>', 'url'=>array('/schoolconfig/documents/index/pos/home')),
							       array('label'=>'<span class="fa fa-calendar"> '.$item_name_others.'</span>', 'url'=>$item_url_others),
							    
							    $item_ageda_others,
							     
							    array('label'=>'<span class="fa fa-calendar"> '.Yii::t('app','Calendar').'</span>', 'url'=>array('/schoolconfig/calendar/index')),
							    
								array('label'=>'<span class="fa fa-globe"> '.Yii::t('app','Portal').'</span>','url'=>array('/portal/cmsArticle/index')),
                                
								array('label'=>'<span class="fa fa-bell"> '.Yii::t('app','Announcements').'</span>', 'url'=>array('/schoolconfig/announcements/index')),
							    
							    array('label'=>'<span class="fa fa-envelope"> '.Yii::t('app','Groups mails').'</span>','url'=>array('/academic/mails/batchemail','mn'=>'std')),
							    
							    array('label'=>'<span class="fa fa-child"> '.Yii::t('app','Partners').'</span>','url'=>array('/configuration/partners/index')), 
							    
							    array('label'=>'<span class="fa fa-check-square-o"> '.Yii::t('app','Disable students').'</span>','url'=>array('/academic/persons/disableStudents','isstud'=>1,'pg'=>'lr','mn'=>'std')),
								
								array('label'=>'<span class="fa fa-anchor"> '.Yii::t('app','Examen MENFP').'</span>','url'=>array('/academic/menfpGrades/index','part'=>'parlis','from'=>'')),
								
								array('label'=>'<span class="fa fa-anchor" style="color:#939893"> '.Yii::t('app','End Year Decision').'</span>', 'linkOptions'=> array(
                                 'title' => Yii::t('app','Link will be available at the end of last period.'), 
                          ),    ),
					
					                     
			            
		
							    
							        );
							       	
							        }              
								   
						
 							  
 							
						
						
						}	 
          		     else // $greater_date==null
          		      {
          		      	   $items=array(
								array('label'=>'<span class="fa fa-sort-amount-asc"> '.Yii::t('app','Admission').'</span>','url'=>array('/academic/postulant/viewListAdmission','part'=>'enrlis','pg'=>'')),
								
								array('label'=>'<span class="fa fa-download"> '.Yii::t('app','Level/Room affectation').'</span>','url'=>array('/academic/persons/levelRoomAffectation','isstud'=>1,'pg'=>'lr','mn'=>'std')),
								
							//	array('label'=>'<span class="fa fa-download"> '.Yii::t('app','Movement').'</span>','url'=>array('/academic/persons/mouvement','isstud'=>1,'pg'=>'lr','mn'=>'std')),
								
								
								array('label'=>'<span class="fa fa-sort-amount-asc"> '.Yii::t('app','Class Setup List').'</span>','url'=>array('/academic/persons/classSetup','isstud'=>1,'pg'=>'lr','mn'=>'std')),
						    
		                       array('label'=>'<span class="fa fa-file-o"> '.Yii::t('app','Subjects').'</span>','url'=>array('/schoolconfig/subjects/index')),
							    array('label'=>'<span class="fa fa-folder-open-o"> '.Yii::t('app','Courses').'</span>', 'url'=>array('/schoolconfig/courses/index')),
							     array('label'=>'<span class="fa fa-folder"> '.Yii::t('app','Archives').'</span>', 'url'=>array('/schoolconfig/documents/index/pos/home')),
							       array('label'=>'<span class="fa fa-calendar"> '.$item_name_others.'</span>', 'url'=>$item_url_others),
							    
							    $item_ageda_others,
							     
							    array('label'=>'<span class="fa fa-calendar"> '.Yii::t('app','Calendar').'</span>', 'url'=>array('/schoolconfig/calendar/index')),
							    
								array('label'=>'<span class="fa fa-globe"> '.Yii::t('app','Portal').'</span>','url'=>array('/portal/cmsArticle/index')),
                                
								array('label'=>'<span class="fa fa-bell"> '.Yii::t('app','Announcements').'</span>', 'url'=>array('/schoolconfig/announcements/index')),
							    
							    array('label'=>'<span class="fa fa-envelope"> '.Yii::t('app','Groups mails').'</span>','url'=>array('/academic/mails/batchemail','mn'=>'std')),
							    
							    array('label'=>'<span class="fa fa-child"> '.Yii::t('app','Partners').'</span>','url'=>array('/configuration/partners/index')), 
							    
							    array('label'=>'<span class="fa fa-check-square-o"> '.Yii::t('app','Disable students').'</span>','url'=>array('/academic/persons/disableStudents','isstud'=>1,'pg'=>'lr','mn'=>'std')),
								
								array('label'=>'<span class="fa fa-anchor"> '.Yii::t('app','Examen MENFP').'</span>','url'=>array('/academic/menfpGrades/index','part'=>'parlis','from'=>'')),
								
								array('label'=>'<span class="fa fa-anchor" style="color:#939893"> '.Yii::t('app','End Year Decision').'</span>', 'linkOptions'=> array(
                                 'title' => Yii::t('app','Link will be available at the end of last period.'), 
                          ),    ),					
					            
					                      
			            
		
							    
							        );
          		      }
          		
                                 
                                 $this->widget('zii.widgets.CMenu', array(
									'activeCssClass'=>'active',
									'encodeLabel'=>false,     
									'activateParents'=>true,
									'items'=>array(
									
									array('label'=>'<span class="fa fa-2y" style="font-size: 23px;"> '.Yii::t('app','Academic settings').'</span>', 
									//'linkOptions'=>array('id'=>'menuAcademicSettings'),
									//'itemOptions'=>array('id'=>'itemAcademicSettings'),
									
									'items'=>$items),
									        
									 
									))); 
								
					           }
					              
		                  }
                 break;
                 
          case 'Manager':
                     
					  $items=array();
					  
          		      $groupid=Yii::app()->user->groupid;
                      $group=Groups::model()->findByPk($groupid);
                      $group_name=$group->group_name;
 								
                  if($group_name=='Discipline')
                    {
                    	$items=array(
								array('label'=>'<span class="fa fa-sort-amount-asc"> '.Yii::t('app','Admission').'</span>','url'=>array('/academic/postulant/viewListAdmission','part'=>'enrlis','pg'=>'')),
								
								array('label'=>'<span class="fa fa-sort-amount-asc"> '.Yii::t('app','Class Setup List').'</span>','url'=>array('/academic/persons/classSetup','isstud'=>1,'pg'=>'lr','mn'=>'std')),
						    
		                        array('label'=>'<span class="fa fa-file-o"> '.Yii::t('app','Subjects').'</span>','url'=>array('/schoolconfig/subjects/index','from'=>'mana')),
							    array('label'=>'<span class="fa fa-folder-open-o"> '.Yii::t('app','Courses').'</span>', 'url'=>array('/schoolconfig/courses/index','from'=>'mana')),
							     array('label'=>'<span class="fa fa-calendar"> '.$item_name_others.'</span>', 'url'=>$item_url_others),
							    
							    $item_ageda_others,
							     
							    array('label'=>'<span class="fa fa-calendar"> '.Yii::t('app','Calendar').'</span>', 'url'=>array('/schoolconfig/calendar/index','from'=>'mana')),
							    array('label'=>'<span class="fa fa-bell"> '.Yii::t('app','Announcements').'</span>', 'url'=>array('/schoolconfig/announcements/index','from'=>'mana')),
							    
							    array('label'=>'<span class="fa fa-envelope"> '.Yii::t('app','Groups mails').'</span>','url'=>array('/academic/mails/batchemail','mn'=>'std')),
							    
							    array('label'=>'<span class="fa fa-child"> '.Yii::t('app','Partners').'</span>','url'=>array('/configuration/partners/index')),
							    
							    array('label'=>'<span class="fa fa-check-square-o"> '.Yii::t('app','Disable students').'</span>','url'=>array('/academic/persons/disableStudents','isstud'=>1,'pg'=>'lr','mn'=>'std')),
								
								           
			            
		
							    
							        );
							        
                    }
                  elseif($group_name=='Pedagogie')
                    {
                    	$items=array(
								array('label'=>'<span class="fa fa-sort-amount-asc"> '.Yii::t('app','Admission').'</span>','url'=>array('/academic/postulant/viewListAdmission','part'=>'enrlis','pg'=>'')),
								
								array('label'=>'<span class="fa fa-sort-amount-asc"> '.Yii::t('app','Class Setup List').'</span>','url'=>array('/academic/persons/classSetup','isstud'=>1,'pg'=>'lr','mn'=>'std')),
						    
		                        array('label'=>'<span class="fa fa-file-o"> '.Yii::t('app','Subjects').'</span>','url'=>array('/schoolconfig/subjects/index','from'=>'mana')),
							    array('label'=>'<span class="fa fa-folder-open-o"> '.Yii::t('app','Courses').'</span>', 'url'=>array('/schoolconfig/courses/index','from'=>'mana')),
							     array('label'=>'<span class="fa fa-folder"> '.Yii::t('app','Archives').'</span>', 'url'=>array('/schoolconfig/documents/index/pos/home')),
							       array('label'=>'<span class="fa fa-calendar"> '.$item_name_others.'</span>', 'url'=>$item_url_others),
							    
							    $item_ageda_others,
							     
							    array('label'=>'<span class="fa fa-calendar"> '.Yii::t('app','Calendar').'</span>', 'url'=>array('/schoolconfig/calendar/index','from'=>'mana')),
							    
								array('label'=>'<span class="fa fa-globe"> '.Yii::t('app','Portal').'</span>','url'=>array('/portal/cmsArticle/index')),
                        
						       array('label'=>'<span class="fa fa-bell"> '.Yii::t('app','Announcements').'</span>', 'url'=>array('/schoolconfig/announcements/index','from'=>'mana')),
							    
							    array('label'=>'<span class="fa fa-envelope"> '.Yii::t('app','Groups mails').'</span>','url'=>array('/academic/mails/batchemail','mn'=>'std')),
							    
							    array('label'=>'<span class="fa fa-child"> '.Yii::t('app','Partners').'</span>','url'=>array('/configuration/partners/index')),           
			            
		
							    
							        );
							        
                    }
                  else  //end Group = Discipline
                    {
          		           $modelAcad=new AcademicPeriods;
						   $greater_date=null;
						   
						   $last_eval_date = null;
						   
						   $last_eval = EvaluationByYear::model()->getLastEvaluationSet($acad_sess);//return id and eval_date if nort null
		                    
		                    if($last_eval!=null)
		                      {
		                      	foreach($last_eval as $l)
		                      	 {
		                      		$last_eval_date = $l['evaluation_date'];
		                      		
		                      	  }
		                      }
		                      
						   //get  date_end of the last academic period
                            $lastPeriodDate=$modelAcad->lastDateAcademicPeriod($acad);
							if(isset($lastPeriodDate))
							 { 
							      $result=$lastPeriodDate->getData();
							     foreach($result as $r)
							      { 
								    if($greater_date<$r->date_end)
								      $greater_date=$r->date_end;
							      }
							 } 
						  if( ($greater_date!=null) || ($last_eval_date !=null) )	   
							{	 
								 
 							
 								 if((date('Y-m-d') >= $greater_date) || ( ($last_eval_date!=null)&&(date('Y-m-d') >= $last_eval_date) ) )
									{  $items=array(
								array('label'=>'<span class="fa fa-sort-amount-asc"> '.Yii::t('app','Admission').'</span>','url'=>array('/academic/postulant/viewListAdmission','part'=>'enrlis','pg'=>'')),
								
								array('label'=>'<span class="fa fa-download"> '.Yii::t('app','Level/Room affectation').'</span>','url'=>array('/academic/persons/levelRoomAffectation','isstud'=>1,'pg'=>'lr','mn'=>'std')),
								
							//	array('label'=>'<span class="fa fa-download"> '.Yii::t('app','Movement').'</span>','url'=>array('/academic/persons/mouvement','isstud'=>1,'pg'=>'lr','mn'=>'std')),
								
								
								array('label'=>'<span class="fa fa-sort-amount-asc"> '.Yii::t('app','Class Setup List').'</span>','url'=>array('/academic/persons/classSetup','isstud'=>1,'pg'=>'lr','mn'=>'std')),
						    
		                        array('label'=>'<span class="fa fa-file-o"> '.Yii::t('app','Subjects').'</span>','url'=>array('/schoolconfig/subjects/index')),
							    array('label'=>'<span class="fa fa-folder-open-o"> '.Yii::t('app','Courses').'</span>', 'url'=>array('/schoolconfig/courses/index')),
							     array('label'=>'<span class="fa fa-folder"> '.Yii::t('app','Archives').'</span>', 'url'=>array('/schoolconfig/documents/index/pos/home')),
							       array('label'=>'<span class="fa fa-calendar"> '.$item_name_others.'</span>', 'url'=>$item_url_others),
							    
							    $item_ageda_others,
							     
							    array('label'=>'<span class="fa fa-calendar"> '.Yii::t('app','Calendar').'</span>', 'url'=>array('/schoolconfig/calendar/index')),
							    
								array('label'=>'<span class="fa fa-globe"> '.Yii::t('app','Portal').'</span>','url'=>array('/portal/cmsArticle/index')),
                                
								array('label'=>'<span class="fa fa-bell"> '.Yii::t('app','Announcements').'</span>', 'url'=>array('/schoolconfig/announcements/index')),
							    
							    array('label'=>'<span class="fa fa-envelope"> '.Yii::t('app','Groups mails').'</span>','url'=>array('/academic/mails/batchemail','mn'=>'std')),
							    
							    array('label'=>'<span class="fa fa-child"> '.Yii::t('app','Partners').'</span>','url'=>array('/configuration/partners/index')),
							    
							    array('label'=>'<span class="fa fa-check-square-o"> '.Yii::t('app','Disable students').'</span>','url'=>array('/academic/persons/disableStudents','isstud'=>1,'pg'=>'lr','mn'=>'std')),
								
								array('label'=>'<span class="fa fa-anchor"> '.Yii::t('app','Examen MENFP').'</span>','url'=>array('/academic/menfpGrades/index','part'=>'parlis','from'=>'')),
								
								array('label'=>'<span class="fa fa-anchor"> '.Yii::t('app','End Year Decision').'</span>','url'=>array('/reports/reportcard/endYearDecision','mn'=>'std','from'=>'stud')),
					
					            
					                       
			            
		
							    
							        );
							        
							        
									
									 }
							     else
							       { 
							       	  $items=array(
								array('label'=>'<span class="fa fa-sort-amount-asc"> '.Yii::t('app','Admission').'</span>','url'=>array('/academic/postulant/viewListAdmission','part'=>'enrlis','pg'=>'')),
								
								array('label'=>'<span class="fa fa-download"> '.Yii::t('app','Level/Room affectation').'</span>','url'=>array('/academic/persons/levelRoomAffectation','isstud'=>1,'pg'=>'lr','mn'=>'std')),
								
							//	array('label'=>'<span class="fa fa-download"> '.Yii::t('app','Movement').'</span>','url'=>array('/academic/persons/mouvement','isstud'=>1,'pg'=>'lr','mn'=>'std')),
								
								
								array('label'=>'<span class="fa fa-sort-amount-asc"> '.Yii::t('app','Class Setup List').'</span>','url'=>array('/academic/persons/classSetup','isstud'=>1,'pg'=>'lr','mn'=>'std')),
						    
		                       array('label'=>'<span class="fa fa-file-o"> '.Yii::t('app','Subjects').'</span>','url'=>array('/schoolconfig/subjects/index')),
							    array('label'=>'<span class="fa fa-folder-open-o"> '.Yii::t('app','Courses').'</span>', 'url'=>array('/schoolconfig/courses/index')),
							     array('label'=>'<span class="fa fa-folder"> '.Yii::t('app','Archives').'</span>', 'url'=>array('/schoolconfig/documents/index/pos/home')),
							      array('label'=>'<span class="fa fa-calendar"> '.$item_name_others.'</span>', 'url'=>$item_url_others),
							    
							    $item_ageda_others,
							     
							    array('label'=>'<span class="fa fa-calendar"> '.Yii::t('app','Calendar').'</span>', 'url'=>array('/schoolconfig/calendar/index')),
							    
								array('label'=>'<span class="fa fa-globe"> '.Yii::t('app','Portal').'</span>','url'=>array('/portal/cmsArticle/index')),
                                
								array('label'=>'<span class="fa fa-bell"> '.Yii::t('app','Announcements').'</span>', 'url'=>array('/schoolconfig/announcements/index')),
							    
							    array('label'=>'<span class="fa fa-envelope"> '.Yii::t('app','Groups mails').'</span>','url'=>array('/academic/mails/batchemail','mn'=>'std')),
							    
							    array('label'=>'<span class="fa fa-child"> '.Yii::t('app','Partners').'</span>','url'=>array('/configuration/partners/index')),
							    
							    array('label'=>'<span class="fa fa-check-square-o"> '.Yii::t('app','Disable students').'</span>','url'=>array('/academic/persons/disableStudents','isstud'=>1,'pg'=>'lr','mn'=>'std')),
								
								           
			            
		
							    
							        );
							       	
							        }              
								   
						
 							  
 							
						
						
						}	 
          		     else // $greater_date==null
          		      {
          		      	   $items=array(
								array('label'=>'<span class="fa fa-sort-amount-asc"> '.Yii::t('app','Admission').'</span>','url'=>array('/academic/postulant/viewListAdmission','part'=>'enrlis','pg'=>'')),
								
								array('label'=>'<span class="fa fa-download"> '.Yii::t('app','Level/Room affectation').'</span>','url'=>array('/academic/persons/levelRoomAffectation','isstud'=>1,'pg'=>'lr','mn'=>'std')),
								
							//	array('label'=>'<span class="fa fa-download"> '.Yii::t('app','Movement').'</span>','url'=>array('/academic/persons/mouvement','isstud'=>1,'pg'=>'lr','mn'=>'std')),
								
								
								array('label'=>'<span class="fa fa-sort-amount-asc"> '.Yii::t('app','Class Setup List').'</span>','url'=>array('/academic/persons/classSetup','isstud'=>1,'pg'=>'lr','mn'=>'std')),
						    
		                       
							array('label'=>'<span class="fa fa-file-o"> '.Yii::t('app','Subjects').'</span>','url'=>array('/schoolconfig/subjects/index')),
							    array('label'=>'<span class="fa fa-folder-open-o"> '.Yii::t('app','Courses').'</span>', 'url'=>array('/schoolconfig/courses/index')),
							     array('label'=>'<span class="fa fa-folder"> '.Yii::t('app','Archives').'</span>', 'url'=>array('/schoolconfig/documents/index/pos/home')),
							       array('label'=>'<span class="fa fa-calendar"> '.$item_name_others.'</span>', 'url'=>$item_url_others),
							    
							    $item_ageda_others,
							     
							    array('label'=>'<span class="fa fa-calendar"> '.Yii::t('app','Calendar').'</span>', 'url'=>array('/schoolconfig/calendar/index')),
							   
							   array('label'=>'<span class="fa fa-globe"> '.Yii::t('app','Portal').'</span>','url'=>array('/portal/cmsArticle/index')),
                        
    						   array('label'=>'<span class="fa fa-bell"> '.Yii::t('app','Announcements').'</span>', 'url'=>array('/schoolconfig/announcements/index')),
							    
							    array('label'=>'<span class="fa fa-envelope"> '.Yii::t('app','Groups mails').'</span>','url'=>array('/academic/mails/batchemail','mn'=>'std')),
							    
							    array('label'=>'<span class="fa fa-child"> '.Yii::t('app','Partners').'</span>','url'=>array('/configuration/partners/index')),  
							    
							    array('label'=>'<span class="fa fa-check-square-o"> '.Yii::t('app','Disable students').'</span>','url'=>array('/academic/persons/disableStudents','isstud'=>1,'pg'=>'lr','mn'=>'std')),
								
								         
			            
		
							    
							        );
          		            }
          		
                       } //end Group != Discipline      
                            
                            
                            
                            
                                 $this->widget('zii.widgets.CMenu', array(
									'activeCssClass'=>'active',
									'encodeLabel'=>false,     
									'activateParents'=>true,
									'items'=>array(
									
									array('label'=>'<span class="fa fa-2y" style="font-size: 23px;"> '.Yii::t('app','Academic settings').'</span>', 
									//'linkOptions'=>array('id'=>'menuAcademicSettings'),
									//'itemOptions'=>array('id'=>'itemAcademicSettings'),
									
									'items'=>$items),
									        
									 
									))); 
								
					           
                 break;
                 
          case 'Billing':
                       $items=array(
								array('label'=>'<span class="fa fa-sort-amount-asc"> '.Yii::t('app','Admission').'</span>','url'=>array('/academic/postulant/viewListAdmission','part'=>'enrlis','pg'=>'')),
								
								array('label'=>'<span class="fa fa-sort-amount-asc"> '.Yii::t('app','Class Setup List').'</span>','url'=>array('/academic/persons/classSetup','isstud'=>1,'pg'=>'lr','mn'=>'std')),
						    
		                         array('label'=>'<span class="fa fa-calendar"> '.$item_name_others.'</span>', 'url'=>$item_url_others),
							    
							    $item_ageda_others,
							     
							    array('label'=>'<span class="fa fa-calendar"> '.Yii::t('app','Calendar').'</span>', 'url'=>array('/schoolconfig/calendar/index','from'=>'mana')),
							    array('label'=>'<span class="fa fa-bell"> '.Yii::t('app','Announcements').'</span>', 'url'=>array('/schoolconfig/announcements/index','from'=>'mana')),
							    
							    array('label'=>'<span class="fa fa-envelope"> '.Yii::t('app','Groups mails').'</span>','url'=>array('/academic/mails/batchemail','mn'=>'std')),
							    
							    array('label'=>'<span class="fa fa-child"> '.Yii::t('app','Partners').'</span>','url'=>array('/configuration/partners/index')),           
			            
		
							    
							        );
							     
							       $this->widget('zii.widgets.CMenu', array(
									'activeCssClass'=>'active',
									'encodeLabel'=>false,     
									'activateParents'=>true,
									'items'=>array(
									
									array('label'=>'<span class="fa fa-2y" style="font-size: 23px;"> '.Yii::t('app','Academic settings').'</span>', 
									//'linkOptions'=>array('id'=>'menuAcademicSettings'),
									//'itemOptions'=>array('id'=>'itemAcademicSettings'),
									
									'items'=>$items),
									        
									 
									))); 
								   
							        
							        
          
                 break;
                 
          case 'Teacher':
                 
                 break;
                 
                 
                 
           case 'Information':
                     
					  $items=array();
					  
          		     
                    	$items=array(
								
								
						     array('label'=>'<span class="fa fa-calendar"> '.Yii::t('app','Calendar').'</span>', 'url'=>array('/schoolconfig/calendar/index','from'=>'mana')),
							    array('label'=>'<span class="fa fa-globe"> '.Yii::t('app','Portal').'</span>','url'=>array('/portal/cmsArticle/index')),
		                        array('label'=>'<span class="fa fa-bell"> '.Yii::t('app','Announcements').'</span>', 'url'=>array('/schoolconfig/announcements/index','from'=>'mana')),
							    
							    array('label'=>'<span class="fa fa-envelope"> '.Yii::t('app','Groups mails').'</span>','url'=>array('/academic/mails/batchemail','mn'=>'std')),
							    
							    
			            
		
							    
							        );
							        
                 
                       
                            
                            
                                 $this->widget('zii.widgets.CMenu', array(
									'activeCssClass'=>'active',
									'encodeLabel'=>false,     
									'activateParents'=>true,
									'items'=>array(
									
									array('label'=>'<span class="fa fa-2y" style="font-size: 23px;"> '.Yii::t('app','Academic settings').'</span>', 
									//'linkOptions'=>array('id'=>'menuAcademicSettings'),
									//'itemOptions'=>array('id'=>'itemAcademicSettings'),
									
									'items'=>$items),
									        
									 
									))); 
								
					           
                 break;
                 

                 
          }

}//fen issetProfil


}
?>		


                  