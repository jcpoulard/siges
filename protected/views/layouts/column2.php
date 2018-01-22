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

<?php /* @var $this Controller */ 

  
$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',));
  

?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="row-fluid">
  <div class="wrapper">

    <input type="checkbox" id="navigation" />
    <div class="side_label">
   <a> <label for="navigation">
        
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>  
            <span class="icon-bar"></span> 
        
    </label> </a>

    </div>
    	 <div class="nav_side">
			<?php 
			         /*
			        $menu_a = array(
			                'sset'=>array('academicperiods/index','academicperiods/create','academicperiods/view','academicperiods/update')
			        );
			          */
			
			
			        $mod_name = $this->module->name;   
			        if($mod_name != null)
			        {
			          switch($mod_name)
			          {
			              case 'configuration':
			                {  
			                   $explode_url= explode("/",substr($_SERVER['REQUEST_URI'],1));
		                       $controller=$explode_url[3];
		                       $action=$explode_url[4];
		                          //print_r($explode_url);
		                          
				                switch($controller)
				                   {
				                   	  case 'devises':
				                   	          require_once('latMenuBillings.php');
		                   	          
		                   	                    break;
		                   	          
		                   	          case 'fees':
				                   	          require_once('latMenuBillings.php');
		                   	          
		                   	                    break;
		                   	          
		                   	          case 'paymentmethod':
				                   	          require_once('latMenuBillings.php');
		                   	          
		                   	                    break;
		                   	         		                   	      
		                   	           case 'partners':
				                   	          require_once('latMenuAcademicSetting.php');
		                   	          
		                   	                    break;
		                   	          
		                   	          default:
		                   	                 require_once('latMenuSchoolSetting.php'); 
			                                  break;
			                                  
				                    }
			                        
			                  }
			              case 'academic':
			               {
		                     $explode_url= explode("/",substr($_SERVER['REQUEST_URI'],1));
		                       $controller=$explode_url[3];
		                       $action=$explode_url[4];
		                          //print_r($explode_url);
		                          
		                          switch($controller)
		                            {
		                            	case 'postulant':
		                            	
		                            	 if(isset($_GET['part'])&&($_GET['part']=='rec'))
		                            	    require_once('latMenuBillings.php');
		                            	 else
		                                     require_once('latMenuAcademicSetting.php');
		                                     
		                                   break;
		                               
		                               case 'examenMenfp':
		                            	
		                            	 require_once('latMenuAcademicSetting.php');
		                                     
		                                   break;
		                               
		                               case 'menfpGrades':
		                            	
		                            	 require_once('latMenuAcademicSetting.php');
		                                     
		                                   break;
		                                
		                            }
		                          
		                          switch($action)
		                            {
		                            	case 'admission':
		                                     require_once('latMenuAcademicSetting.php');
		                                   break;
		                                   
		                               case 'admissionSearch':
		                                     require_once('latMenuAcademicSetting.php');
		                                   break;
		                                  
		                                case 'viewListAdmission':
		                                     require_once('latMenuAcademicSetting.php');
		                                   break;
		                                   
		                                case 'viewDetailAdmission':
		                                     require_once('latMenuAcademicSetting.php');
		                                   break;
		                                   
		                                case 'roomAffectation':
		                                     require_once('latMenuAcademicSetting.php');
		                                   break;
		                                   
		                                case 'transcriptNotes':
		                                     require_once('latMenuStudent.php');
		                                   break;
										   
										case 'levelRoomAffectation':
		                                       require_once('latMenuAcademicSetting.php');
		                                   break;
		                                   
		                                 case 'mouvement':
		                                       require_once('latMenuAcademicSetting.php');
		                                   break;
		                                   
		                                case 'disableStudents':
		                                       require_once('latMenuAcademicSetting.php');
		                                   break;
		                                   
		                                case 'batchemail':
		                                       require_once('latMenuAcademicSetting.php');
		                                   break;
		                                   
		                                case 'mailbox':
		                                       require_once('latMenuAcademicSetting.php');
		                                   break;
		                                   
		                                case 'classSetup':
		                                     require_once('latMenuAcademicSetting.php');
		                                   break;
		                                   
		                                 case 'viewForReport':
		                                      {
		                                      	  if(isset($_GET['from1']) && $_GET['from1']=='rpt')
												   {
													       require_once('latMenuReports.php');
														               		                                                         																	break; 
												   }
												 else
												   { if(isset($_GET['pg']))
									                   {
									                      switch($_GET['pg'])
									                      {
									                          case 'lfc':
									                                 require_once('latMenuAcademicSetting.php');
									                          
									                                break;
									                                
									                          case 'l':
			                                                       if(isset($_GET['from1']) && $_GET['from1']=='rpt')
														              {
														               require_once('latMenuReports.php');
														               }		                                                         																	break; 
	
									                                
									                      }
								                      }
												   }
		                                          
		                                      }
		                                      
		                                       break;
		                                   
		                                 case 'viewForUpdate':
		                                         require_once('latMenuSchoolSetting.php');
		                                   break;
		                                   
		                              }
		                
		                if(isset($_GET['from']))
		                  {
		                      $from = $_GET['from'];
		                      switch($from)
		                      {
		                          case 'ds':
		                                 require_once('latMenuAcademicSetting.php');
		                          
		                                break;
		                          
                                  case 'lr_af':
		                                 require_once('latMenuAcademicSetting.php');
		                          
		                                break;
		                          
		                          case 'emp':
		                              require_once('latMenuEmployee.php');
		                              if(!isset($_GET['isstud']))
		                              {
		                                 require_once('latMenuEmployee.php'); 
		                              }
		                              break;
		                          
		                          case 'stud':
		                              require_once('latMenuStudent.php');
		                              
		                              break;
		                              
		                           case 'teach':
		                              require_once('latMenuTeacher.php');
		                              break;
		                          
		                          case 'rpt':
		                              require_once('latMenuReports.php');
		                              
		                              break; 
		                              
		                          case 'user':
		                              require_once('latMenuSchoolSetting.php');
		                              
		                              break; 
		                              
		                           case 'adm':
		                              require_once('latMenuAcademicSetting.php');
		                              
		                              break;    
		
		                      }
		                  }
		                elseif(isset($_GET['from1']) && $_GET['from1']=='rpt')
		                  {
		                       require_once('latMenuReports.php');
		                  }
		                  
		                  elseif(isset($_GET['isstud']))
		                     {   if($_GET['isstud']==1)
				                    require_once('latMenuStudent.php');
				                 elseif($_GET['isstud']==0)
				                   require_once('latMenuTeacher.php');  
		                  }
		                  
		                  
		
		              }
		                break;
		             case 'schoolconfig':
		              {
		
		                $explode_url= explode("/",substr($_SERVER['REQUEST_URI'],1));
		                       $controller=$explode_url[3];
		                       $action=$explode_url[4];
		                          //print_r($explode_url);
		                          
		                switch($controller)
		                   {
		                   	  case 'subjects':
		                   	          require_once('latMenuAcademicSetting.php');
		                   	          
		                   	         break;
		                   	  case 'courses':
		                   	        if(isset($_GET['from']))
					                  { if($_GET['from']=='teach')
					                      {
					                           require_once('latMenuTeacher.php');
					                      }
					                    elseif($_GET['from']=='emp')
					                      {
					                           require_once('latMenuEmployee.php');
					                      }
					                    elseif($_GET['from']=='mana')
					                      {
					                           require_once('latMenuAcademicSetting.php');
					                      }
					                      
					                   }
					                else
		                   	           require_once('latMenuAcademicSetting.php');
		                   	           
		                   	         break;
		                   	  case 'schedules':
		                   	          if($action=='viewForTeacher')
		                   	            require_once('latMenuStudent.php');
		                   	          else
		                   	             require_once('latMenuAcademicSetting.php');
		                   	          
		                   	         break;
		                   	  case 'evaluationbyyear':
                                     if(isset($_GET['from']))
					                  { if($_GET['from']=='teach')
					                      {
					                           require_once('latMenuStudent.php');
					                      }
									  }
									 else
										 require_once('latMenuSchoolSetting.php');
		                   	         break;							  
		                   	  case 'scheduleAgenda':
		                   	         if(isset($_GET['from']))
					                  { if($_GET['from']=='teach')
					                      {
                                              require_once('latMenuTeacher.php');
					                      }
					                  }
		                   	          else
									  {   
								         if(Yii::app()->user->profil =='Teacher')
										    require_once('latMenuStudent.php');
									     else
											 require_once('latMenuAcademicSetting.php');
		                   	          }
									  
		                   	         break;
		                   	         
		                   	  case 'calendar':
		                   	          require_once('latMenuAcademicSetting.php');
		                   	          
		                   	         break;
		                   	  case 'announcements':
		                   	          require_once('latMenuAcademicSetting.php');
		                   	          
		                   	         break;
		                   	  case 'documents':
		                   	          if(isset($_GET['from']) &&($_GET['from']=='stud'))
									   {
										   require_once('latMenuStudent.php');
									    }  
									  else
										  require_once('latMenuAcademicSetting.php');
		                   	          
		                   	         break;
		                   	  default:
			                       if(isset($_GET['from']))
					                 { if($_GET['from']=='teach')
					                      {
					                           require_once('latMenuTeacher.php');
					                      }
					                    elseif($_GET['from']=='emp')
					                      {
					                           require_once('latMenuEmployee.php');
					                      }
					                     elseif($_GET['from']=='mana')
					                      {
					                           require_once('latMenuAcademicSetting.php');
					                      }
					                     else 
					                         require_once('latMenuSchoolSetting.php');
					                      
					                  }
					                else 
					                    require_once('latMenuSchoolSetting.php');
		                           
		                           break;
		                   }
		                  
		                  
		              }
		                  break;
		             
		              case 'billings':
		                 { 
		                 	if(isset($_GET['part'])&&($_GET['part']=='rec'))
		                 	    require_once('latMenuBillings.php');
		                 	elseif(isset($_GET['part'])&&(($_GET['part']=='bill')||($_GET['part']=='reserv')) )
		                 	   require_once('latMenuAcademicSetting.php');
		                 	else
		                 	    require_once('latMenuBillings.php');
		                 
		                  }
		                  break;
		              
		              case 'reports':
		                   {
			                  $explode_url= explode("/",substr($_SERVER['REQUEST_URI'],1));
		                       $action=$explode_url[4];
		                          //print_r($explode_url);
		                          
		                          switch($action)
		                            {
		                            	case 'endYearDecision':
		                                     require_once('latMenuAcademicSetting.php');
		                                   break;
		                                   
		                                case 'updateEndYearDecision':
		                                     require_once('latMenuAcademicSetting.php');
		                                   break;
		                                   
		                                case 'viewDecision':
		                                     require_once('latMenuAcademicSetting.php');
		                                   break;
		                                
		                                case 'yearMigrationCheck':
		                                     require_once('latMenuSchoolSetting.php');
		                                   break;
		                                   
		                                
		                                   
                                default:
                           if(isset($_GET['from']))
			                  {
			                      $from = $_GET['from'];
			                      switch($from)
			                      {
			                          case 'teach':
			                              require_once('latMenuTeacher.php');
			                              break;
			                          case 'emp':
			                              require_once('latMenuEmployee.php');
			                              if(!isset($_GET['isstud']))
			                              {
			                                 require_once('latMenuEmployee.php'); 
			                              }
			                              break;
			                          case 'stud':
			                              require_once('latMenuStudent.php'); 
			                              
			                              break;
			                              
			                           case 'rpt':
			                              require_once('latMenuReports.php'); 
			                              
			                              break;
					
					                      }
					             }
					          
					          if(isset($_GET['from1']) && ($_GET['from1']=='rpt'))
					                  {
					                       require_once('latMenuReports.php');
					                  }
					                  
					          if(isset($_GET['isstud'])&& ($_GET['isstud']==1))
					                  {
					                    require_once('latMenuStudent.php');  
					                  }
					              
					                break;
				                 }
				                 
		                   }
		                  
		                  break; 
		               
		             case 'guest':    
		                   
		                         $explode_url= explode("/",substr($_SERVER['REQUEST_URI'],1));//$explode_url= explode("/",substr($_SERVER['REQUEST_URI'], 17));
		                          $controller=$explode_url[3];
		                          //print_r($explode_url);
		                          
		                          switch($controller)
		                            {
		                            	case 'academicperiods':
		
		                 						 require_once('latMenuSchoolSetting.php');
		                                       break;
		                            	
		                            	case 'paymentmethod': 
		                            	
		                 						 require_once('latMenuSchoolSetting.php');
		                                       break;
		                            	
		                            	case 'fees': 
		                            	        { if($explode_url[4]=='index')
		                            	           {
		                 						       require_once('latMenuBillings.php');
		                                      
		                            	           }
		                            	          else
		                            	             require_once('latMenuSchoolSetting.php');
		                            	        }
		                                       break;
		                            	
		                            	case 'passinggrades': 
		                            	
		                 						 require_once('latMenuSchoolSetting.php');
		                                       break;
		                            	
		                            	case 'grades': 
		                            	
		                 						 require_once('latMenuAcademicSetting.php');
		                                       break;
		                            	
		                            	case 'homework': 
		                            	
		                 						 require_once('latMenuAcademicSetting.php');
		                                       break;
		                            	
		                            	case 'homeworkSubmission': 
		                            	
		                 						 require_once('latMenuAcademicSetting.php');
		                                       break;
		                            	
		                            	case 'evaluationbyyear': 
		                            	
		                 						 require_once('latMenuAcademicSetting.php');
		                                       break;
		                            	
		                            	case 'scheduleAgenda':
										
										          require_once('latMenuAcademicSetting.php');
		                                       break;
										
										case 'subjects':
		                            	
		                 						 require_once('latMenuAcademicSetting.php');
		                                       break;
		                            	
		                            	case 'courses':
		                            	
		                 						 require_once('latMenuAcademicSetting.php');
		                                       break;
		                            	
		                            	case 'mails':
		                            	
		                 						 require_once('latMenuAcademicSetting.php');
		                                       break;
		                            	
		                            	case 'schedules': 
		                            	
		                 						 require_once('latMenuAcademicSetting.php');
		                                       break;
		                            	
		                                case 'scheduleagenda':
					                   	         /*if(isset($_GET['from']))
								                  { if($_GET['from']=='teach')
								                      {
			                                              require_once('latMenuTeacher.php');
								                      }
								                  }
					                   	          else
					                   	            */ require_once('latMenuAcademicSetting.php');
					                   	          
					                   	         break;
		                   	         
		                   	         case 'studentOtherInfo':
		                            	
		                 						 require_once('latMenuStudent.php');
		                                       break;
		                            	
		                            	case 'grades': 
		                            	
		                 						 require_once('latMenuStudent.php');
		                                       break;
		                            	
		                            	case 'reportcard':
		                            	         if(isset($_GET['from1']) && ($_GET['from1']=='rpt'))
									                  {
									                       require_once('latMenuReports.php');
									                  }
                                                 else
		                 						      require_once('latMenuStudent.php');
		                 						      
		                                       break;
		                            	
		                            	case 'persons':
		                            	         
		                 						    require_once('latMenuSchoolSetting.php');
		                 						                                        break;
		                            	
		                            	case 'contactInfo': 
		                            	
		                 						 require_once('latMenuSchoolSetting.php');
		                                       break;
		                            	
		                            	case 'billings': 
		                            	
		                 						 require_once('latMenuBillings.php');
		                                       break;
		                            	
		                            	case 'balance':    
		                            	
		                 						 require_once('latMenuBillings.php');
		                                       break;
		                                       
		                                case 'user':   
		                            	
		                 						 require_once('latMenuSchoolSetting.php');
		                                       break;
		                                       
		                                case 'homework':   
		                            	
		                 						 require_once('latMenuStudent.php');
		                                       break;
		                                       
		                                 case 'homeworkSubmission':   
										 	require_once('latMenuStudent.php');
		                                       break;
		                                       
		                                       
		                                    case 'recordInfraction':   
										 	require_once('latMenuDiscipline.php');
		                                       break;


		                            	
		                            	
		                            }
		                   
		                   
		                   
		                   break;
		                 
		                 case 'users':
		                    require_once('latMenuSchoolSetting.php');
		                  break;
                                
                         
                         case 'discipline':
                                 {
                                 	 $explode_url= explode("/",substr($_SERVER['REQUEST_URI'],1));//$explode_url= explode("/",substr($_SERVER['REQUEST_URI'], 17));
		                          $controller=$explode_url[3];
		                          //print_r($explode_url);
		                          
		                          switch($controller)
		                            {
		                            	case 'infractionType':
		
		                 						 require_once('latMenuSchoolSetting.php');
		                                       break;
		                                       
		                                 default:
		                                       require_once('latMenuDiscipline.php');
		                                         break;
		                             }
		                              
		                            	  
                                                                    
                                 }
                                 
                                 break;
						
		                case 'portal':
		                          
		                          //if(Yii::app()->user->profil=='Information')
		                             require_once('latMenuAcademicSetting.php');
		                         // else
		                         //    require_once('latMenuSchoolSetting.php');
		                             
		                             
		                            break;			
		          }
		        }
		        else 
		        {
		            echo "404: Error";
		        }
		       
		         ?>
				
   </div>
		
 
			
			

   
 
   
    <section>
			    <div class="span12">
			    
			    <?php if(isset($this->breadcrumbs)):?>
					<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			            'links'=>$this->breadcrumbs,
						'homeLink'=>CHtml::link('Dashboard'),
						'htmlOptions'=>array('class'=>'breadcrumb')
			        )); ?><!-- breadcrumbs -->
			    <?php endif?>
			    
			    <!-- Include content pages -->
			    <?php echo $content; ?>
			
				</div><!--/span-->
	
	
	  </section>
    </div>
  </div>
</div><!--/row-->


<?php $this->endContent(); ?>



