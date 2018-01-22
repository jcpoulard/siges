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




$acad=Yii::app()->session['currentId_academic_year']; 
						
if($acad!=null){  

if(isset(Yii::app()->user->profil))
{   $profil=Yii::app()->user->profil;
   switch($profil)
     {
       /* case 'Guest':
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
				
				
				array('label'=>'<span class="fa fa-2y" style="font-size: 23px;"> '.Yii::t('app','Grade & Homework').'</span>', 
				//'linkOptions'=>array('id'=>'menuStudent'),
				//'itemOptions'=>array('id'=>'itemStudent'),
				
				'items'=>array(
				    
					array('label'=>'<span class="fa fa-table"> '.Yii::t('app','Grade').'</span>','url'=>array('grades/index','mn'=>'std')),
					
					array('label'=>'<span class="fa fa-folder-open-o"> '.Yii::t('app','Homework').'</span>', 'url'=>array('/guest/homework/index','mn'=>'std'),'visible'=>!Yii::app()->user->isGuest),
					
					array('label'=>'<span class="fa fa-folder-open-o"> '.Yii::t('app','Submited Homework').'</span>', 'url'=>array('/guest/homeworkSubmission/index','mn'=>'std'),'visible'=>!Yii::app()->user->isGuest),
					
					array('label'=>'<span class="fa fa-print"> '.Yii::t('app','Transcript').'</span>','url'=>array('reportcard/report','from'=>'stud','mn'=>'std')),
					
					
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
				
				array('label'=>'<span class="fa fa-2y" style="font-size: 23px;"> '.Yii::t('app','Grade & Homework').'</span>', 
				//'linkOptions'=>array('id'=>'menuStudent'),
				//'itemOptions'=>array('id'=>'itemStudent'),
				
				'items'=>array(
				    
					array('label'=>'<span class="fa fa-table"> '.Yii::t('app','Grade').'</span>', 'url'=>array('grades/index','mn'=>'std')),
				    
				    array('label'=>'<span class="fa fa-folder-open-o"> '.Yii::t('app','Homework').'</span>', 'url'=>array('/guest/homework/index','mn'=>'std'),'visible'=>!Yii::app()->user->isGuest),
					
					array('label'=>'<span class="fa fa-folder-open-o"> '.Yii::t('app','Submited Homework').'</span>', 'url'=>array('/guest/homeworkSubmission/index','mn'=>'std'),'visible'=>!Yii::app()->user->isGuest),
					
					array('label'=>'<span class="fa fa-print"> '.Yii::t('app','Transcript').'</span>','url'=>array('reportcard/report','from'=>'stud','mn'=>'std')),
					

				        )),
				 )));
                  
                  }
               
            }
               
               break;
               */
          case 'Admin':
          		$items=array();
           
          		    
          		      	   $items=array(
					array('label'=>'<span class="fa fa-group"> '.Yii::t('app','Students').'</span>', 'url'=>array('/academic/persons/listforreport','isstud'=>1,'from'=>'stud','mn'=>'std')),
					
									    
					array('label'=>'<span class="fa fa-folder-open-o"> '.Yii::t('app','Homework').'</span>','url'=>array('/academic/homework/index?from=stud&mn=std')),

                    array('label'=>'<span class="fa fa-folder-open-o"> '.Yii::t('app','Submited Homework').'</span>', 'url'=>array('/academic/homeworkSubmission/index','isstud'=>1,'mn'=>'std'),'visible'=>!Yii::app()->user->isGuest),
					
					array('label'=>'<span class="fa fa-list-alt"> '.Yii::t('app','Grade').'</span>','url'=>array('/academic/grades/index?from=stud&mn=std')),
					
					//array('label'=>'<span class="fa fa-table"> '.Yii::t('app','Grade').' & '.Yii::t('app','Grades By Room').'</span>','url'=>array('/academic/grades/listByRoom','from'=>'stud','mn'=>'std')),
								
					array('label'=>'<span class="fa fa-thumbs-up"> '.Yii::t('app','Validate grades').'</span>','url'=>array('/academic/grades/validatePublish','from'=>'stud','mn'=>'std')),
					
					array('label'=>'<span class="fa fa-table"> '.Yii::t('app','Grades By Room').'</span>','url'=>array('/academic/grades/listByRoom','from'=>'stud','mn'=>'std')),
					
					array('label'=>'<span class="fa fa-print"> '.Yii::t('app','Transcript').'</span>','url'=>array('/reports/reportcard/create','from'=>'stud','mn'=>'std')),
					
					array('label'=>'<span class="fa fa-folder"> '.Yii::t('app','Archives').'</span>', 'url'=>array('/schoolconfig/documents/index/pos/home/from/stud/pos/home')),
					 
					array('label'=>'<span class="fa fa-files-o"> '.Yii::t('app','Transcript of notes').'</span>','url'=>array('/academic/persons/transcriptNotes','isstud'=>1,'pg'=>'lr','mn'=>'std')),
						    
		            // array('label'=>'<span class="fa fa-files-o"> '.Yii::t('app','Transcript of notes').'/'.Yii::t('app','Certificate').'</span>','url'=>array('/academic/persons/transcriptNotes','isstud'=>1,'pg'=>'lr','mn'=>'std')),
						    
		            array('label'=>'<span class="fa fa-phone"> '.Yii::t('app','Contact info').'</span>','url'=>array('/academic/contactInfo/index','mn'=>'std','from'=>'stud')),
					
				   
				        );

          		     
          		
          		
          		
          		$this->widget('zii.widgets.CMenu', array(
				'activeCssClass'=>'active',
				'encodeLabel'=>false,    
				'activateParents'=>true,
				'items'=>array(
				
				
				array('label'=>'<span class="fa fa-2y" style="font-size: 23px;">  '.Yii::t('app','Students').'</span>', 
				//'linkOptions'=>array('id'=>'menuStudent'),
				//'itemOptions'=>array('id'=>'itemStudent'),
				
				'items'=>$items),
				
				))); 

                 break;
                 
          case 'Manager':
                         
                         $groupid=Yii::app()->user->groupid;
                      $group=Groups::model()->findByPk($groupid);
                      $group_name=$group->group_name;
 								
                  if($group_name=='Discipline')
                    { 
                         
                         
                          $this->widget('zii.widgets.CMenu', array(
							'activeCssClass'=>'active',
							'encodeLabel'=>false,    
							'activateParents'=>true,
							'items'=>array(
							
							
							array('label'=>'<span class="fa fa-2y" style="font-size: 23px;"> '.Yii::t('app','Students').'</span>', 
							//'linkOptions'=>array('id'=>'menuStudent'),
							//'itemOptions'=>array('id'=>'itemStudent'),
							
							'items'=>array(
										    
											array('label'=>'<span class="fa fa-group"> '.Yii::t('app','Students').'</span>', 'url'=>array('/academic/persons/listforreport','isstud'=>1,'from'=>'stud','mn'=>'std')),
								
								 				    
								array('label'=>'<span class="fa fa-phone"> '.Yii::t('app','Contact info').'</span>','url'=>array('/academic/contactInfo/index','mn'=>'std','from'=>'stud')),
								
								
																
								
							        )),
							 )));
							 
                          }
                        else
                          { 
                         
                         
                          $this->widget('zii.widgets.CMenu', array(
							'activeCssClass'=>'active',
							'encodeLabel'=>false,    
							'activateParents'=>true,
							'items'=>array(
							
							
							array('label'=>'<span class="fa fa-2y" style="font-size: 23px;"> '.Yii::t('app','Students').'</span>', 
							//'linkOptions'=>array('id'=>'menuStudent'),
							//'itemOptions'=>array('id'=>'itemStudent'),
							
							'items'=>array(
										    
											array('label'=>'<span class="fa fa-group"> '.Yii::t('app','Students').'</span>', 'url'=>array('/academic/persons/listforreport','isstud'=>1,'from'=>'stud','mn'=>'std')),
								
												    
								array('label'=>'<span class="fa fa-folder-open-o"> '.Yii::t('app','Homework').'</span>','url'=>array('/academic/homework/index?from=stud&mn=std')),

                                array('label'=>'<span class="fa fa-folder-open-o"> '.Yii::t('app','Submited Homework').'</span>', 'url'=>array('/academic/homeworkSubmission/index','isstud'=>1,'mn'=>'std'),'visible'=>!Yii::app()->user->isGuest),
					
					            array('label'=>'<span class="fa fa-list-alt"> '.Yii::t('app','Grade').'</span>','url'=>array('/academic/grades/index?from=stud&mn=std')),
								
								//array('label'=>'<span class="fa fa-table"> '.Yii::t('app','Grade').' & '.Yii::t('app','Grades By Room').'</span>','url'=>array('/academic/grades/listByRoom','from'=>'stud','mn'=>'std')),
								
							
							array('label'=>'<span class="fa fa-thumbs-up"> '.Yii::t('app','Validate grades').'</span>','url'=>array('/academic/grades/validatePublish','from'=>'stud','mn'=>'std')),
					
						
								array('label'=>'<span class="fa fa-table"> '.Yii::t('app','Grades By Room').'</span>','url'=>array('/academic/grades/listByRoom','from'=>'stud','mn'=>'std')),
								
								array('label'=>'<span class="fa fa-print"> '.Yii::t('app','Transcript').'</span>','url'=>array('/reports/reportcard/create','from'=>'stud','mn'=>'std')),
								
								array('label'=>'<span class="fa fa-folder"> '.Yii::t('app','Archives').'</span>', 'url'=>array('/schoolconfig/documents/index/pos/home/from/stud/pos/home')),
					 
					            array('label'=>'<span class="fa fa-files-o"> '.Yii::t('app','Transcript of notes').'</span>','url'=>array('/academic/persons/transcriptNotes','isstud'=>1,'pg'=>'lr','mn'=>'std')),
						    
								// array('label'=>'<span class="fa fa-files-o"> '.Yii::t('app','Transcript of notes').'/'.Yii::t('app','Certificate').'</span>','url'=>array('/academic/persons/transcriptNotes','isstud'=>1,'pg'=>'lr','mn'=>'std')),
										
								array('label'=>'<span class="fa fa-phone"> '.Yii::t('app','Contact info').'</span>','url'=>array('/academic/contactInfo/index','mn'=>'std','from'=>'stud')),
								
													
								
							        )),
							 )));
							 
                             }

                        
          
                 break;
                 
          case 'Billing':
                  $this->widget('zii.widgets.CMenu', array(
							'activeCssClass'=>'active',
							'encodeLabel'=>false,    
							'activateParents'=>true,
							'items'=>array(
							
							
							array('label'=>'<span class="fa fa-2y" style="font-size: 23px;"> '.Yii::t('app','Students').'</span>', 
							//'linkOptions'=>array('id'=>'menuStudent'),
							//'itemOptions'=>array('id'=>'itemStudent'),
							
							'items'=>array(
										    
											array('label'=>'<span class="fa fa-group"> '.Yii::t('app','Students').'</span>', 'url'=>array('/academic/persons/listforreport','isstud'=>1,'from'=>'stud','mn'=>'std')),
								
							    array('label'=>'<span class="fa fa-table"> '.Yii::t('app','Grades By Room').'</span>','url'=>array('/academic/grades/listByRoom','from'=>'stud','mn'=>'std')),
					
								array('label'=>'<span class="fa fa-folder"> '.Yii::t('app','Archives').'</span>', 'url'=>array('/schoolconfig/documents/index/pos/home/from/stud/pos/home')),
					 
								array('label'=>'<span class="fa fa-files-o"> '.Yii::t('app','Transcript of notes').'</span>','url'=>array('/academic/persons/transcriptNotes','isstud'=>1,'pg'=>'lr','mn'=>'std')),
										
								// array('label'=>'<span class="fa fa-files-o"> '.Yii::t('app','Transcript of notes').'/'.Yii::t('app','Certificate').'</span>','url'=>array('/academic/persons/transcriptNotes','isstud'=>1,'pg'=>'lr','mn'=>'std')),
										
								array('label'=>'<span class="fa fa-phone"> '.Yii::t('app','Contact info').'</span>','url'=>array('/academic/contactInfo/index','mn'=>'std','from'=>'stud')),
								
								
							        )),
							 )));
							 
          
                 break;
                 
          case 'Teacher':  
			               
                            	$display_schedule_agenda = 0;
								$item_ageda_others=null;
								$item_name_others = null;
								$item_url_others = null;
								
								
								$display_schedule_agenda_ = infoGeneralConfig('display_schedule_agenda');
								
								if($display_schedule_agenda_=='')
								  $display_schedule_agenda = 0;
								else
								   $display_schedule_agenda =$display_schedule_agenda_;
								   
									switch($display_schedule_agenda)
									  {
										case 0:  $item_name_others = Yii::t('app','Schedules');
												 $item_url_others = array('/schoolconfig/schedules/viewForTeacher','from'=>'teach');
												 
												 $item_ageda_others=  array('label'=>'', );
												 
												 
										  break;
										  
										  case 1:  $item_name_others = Yii::t('app','Agenda');
												   $item_url_others = array('/schoolconfig/scheduleAgenda/index');
												 
												   $item_ageda_others= array('label'=>'', );
												 
												 
												 
										  break;
										  
										  case 2:  
												 $item_name_others = Yii::t('app','Schedules');
												 $item_url_others = array('/schoolconfig/schedules/viewForTeacher','from'=>'teach');
												 
												 $item_ageda_others= array('label'=>'<span class="fa fa-calendar-check-o"> '.Yii::t('app','Agenda').'</span>', 'url'=>array('/schoolconfig/scheduleAgenda/index'));
												 
												 
										  break;
										
													  
										  
										  
										  
										}

	

						   $this->widget('zii.widgets.CMenu', array(
							'activeCssClass'=>'active',
							'encodeLabel'=>false,    
							'activateParents'=>true,
							'items'=>array(
							
							
							array('label'=>'<span class="fa fa-2y" style="font-size: 23px;"> '.Yii::t('app','Students').'</span>', //la fe kou pou yo
							//'linkOptions'=>array('id'=>'menuStudent'),
							//'itemOptions'=>array('id'=>'itemStudent'),
							
							'items'=>array(
							    
								array('label'=>'<span class="fa fa-group"> '.Yii::t('app','Students').'</span>', 'url'=>array('/academic/persons/listforreport','isstud'=>1,'from'=>'stud','mn'=>'std')), 
								
								array('label'=>'<span class="fa fa-folder-open-o"> '.Yii::t('app','Homework').'</span>','url'=>array('/academic/homework/index?from=stud&mn=std')),

                                array('label'=>'<span class="fa fa-folder-open-o"> '.Yii::t('app','Submited Homework').'</span>', 'url'=>array('/academic/homeworkSubmission/index','isstud'=>1,'mn'=>'std'),'visible'=>!Yii::app()->user->isGuest),
					
					            //array('label'=>'<span class="fa fa-list-alt"> '.Yii::t('app','Grades by Student').'</span>','url'=>array('/academic/grades/index?from=stud&mn=std')),
								array('label'=>'<span class="fa fa-check-square-o"> '.Yii::t('app','Evaluation by period').'</span>','url'=>array('/schoolconfig/evaluationbyyear/index','from'=>'teach')),
								
								//array('label'=>'<span class="fa fa-calendar"> '.Yii::t('app','Schedules').'</span>', 'url'=>array('/schoolconfig/schedules/viewForTeacher','from'=>'teach')),
						         array('label'=>'<span class="fa fa-calendar"> '.$item_name_others.'</span>', 'url'=>$item_url_others),
							    
							    $item_ageda_others,
								
						        array('label'=>'<span class="fa fa-folder-open-o"> '.Yii::t('app','Course').'</span>','url'=>array('/schoolconfig/courses/viewForTeacher','isstud'=>0,'from'=>'teach')),
						
								
								array('label'=>'<span class="fa fa-table"> '.Yii::t('app','Grades').'</span>','url'=>array('/academic/grades/listByRoom','from'=>'stud','mn'=>'std')),
								
													
								
							        )),
							 )));
          
                 break;
                 
          }

}//fen issetProfil



}



?>					 