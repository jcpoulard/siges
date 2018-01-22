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
<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
    
     <div class="container">
    
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          
     
          <!-- Be sure to leave the brand out there if you want it shown -->
          <!--
          <a class="brand" href="#">
                                         SIGES
                                         
                                         <small> </small>
                                         
                                         </a>
          -->
          
<div class="nav-collapse">


    <?php 


if(isset(Yii::app()->session['currentId_academic_year'])&&(Yii::app()->session['currentId_academic_year']!=''))
 {        
        if(Yii::app()->session['profil_selector']=='emp')
           { 
           	     Yii::app()->user->setState('profil', Yii::app()->session['main_profil'] );
           	     //Yii::app()->session['last_profil_selected']= Yii::app()->session['main_profil'];
           	     
           	    
                           	     
             }
         elseif(Yii::app()->session['profil_selector']=='teach')
           {  
           	        Yii::app()->user->setState('profil', 'Teacher' );
           	         //Yii::app()->session['last_profil_selected']= 'Teacher';
                   
             }
        
        
 
 	   if(isset(Yii::app()->user->profil))
               
		  {	

$acad=Yii::app()->session['currentId_academic_year']; 
$last_acad=AcademicPeriods::model()->searchLastAcademicPeriod();
		  	
		  	if($last_acad->id==$acad)
			  $dashbord = array('label'=>'<span class="fa fa-tachometer" aria-hidden="true"> '.Yii::t('app','Dashboard').'</span>', 'url'=>array('/reports/customReport/dashboard','from1'=>'rpt'),'visible'=>!Yii::app()->user->isGuest);
			else
			   $dashbord = array('label'=>''); 
					          	
					        
		  	  
		  $mail_unread = Mails::model()->getTotalUnreadMails(Yii::app()->user->userid);	   
		  	   $teacher_id=0;
                          	  	   
		  	   
		  	   if(isset(Yii::app()->user->userid))
                        {
                            $userid = Yii::app()->user->userid;
                        }
                        else 
                        {
                            $userid = null;
                        }
		  	
		  	
		  	 $person_ID=Persons::model()->getIdPersonByUserID($userid);
			   $person_ID= $person_ID->getData();
					                    
			     foreach($person_ID as $c)
					$person_id= $c->id;	
								
		  	          
		  	
		  	if(Yii::app()->user->profil=='Admin')
			    {  
			       
                 if(isset(Yii::app()->user->name))
		            {    
		                  
		            if((Yii::app()->user->name=='admin')||(Yii::app()->user->groupid==1))
		              {  
		              	 if(Yii::app()->user->groupid!=1)
		              	   {  $this->widget('zii.widgets.CMenu',array(
			                    'htmlOptions'=>array('class'=>'pull-right nav'),
			                    'submenuHtmlOptions'=>array('class'=>'dropdown-menu'),
								'itemCssClass'=>'item-test',
			                    'encodeLabel'=>false,
			                    'items'=>array(
			                        array('label'=>'<span class="fa fa-home"> '.Yii::t('app','SIGES').'</span>', 'url'=>array('/site/index'),'visible'=>!Yii::app()->user->isGuest),
			                        
						//array('label'=>'<span class="fa fa-gears"> '.Yii::t('app','School settings').'</span>', 'url'=>array('/configuration/academicperiods/index','mn'=>'sset'),'visible'=>!Yii::app()->user->isGuest),
			                        
			                       $dashbord,
			                        
			                         array('label'=>'<span class="fa fa-briefcase"> '.Yii::t('app','Academic settings').'</span>', 'url'=>array('/academic/postulant/viewListAdmission/part/enrlis/pg/'),'visible'=>!Yii::app()->user->isGuest),
			                       
			                        array('label'=>'<span class="fa fa-male"> '.Yii::t('app','Teachers').'</span>', 'url'=>array('/academic/persons/listForReport', 'from'=>'teach','isstud'=>0,'mn'=>'teach'),'visible'=>!Yii::app()->user->isGuest),
			                        
			                        
						            
						            array('label'=>'<span class="fa fa-user"> '.Yii::t('app','Employees').'</span>', 'url'=>array('/academic/persons/listForReport', 'from'=>'emp','mn'=>'emp'),'visible'=>!Yii::app()->user->isGuest),
			                        
			                        array('label'=>'<span class="fa fa-group"> '.Yii::t('app','Students').'</span>', 'url'=>array('/academic/persons/listForReport', 'from'=>'stud','isstud'=>1,'mn'=>'std'),'visible'=>!Yii::app()->user->isGuest),
						            
						            array('label'=>'<span class="fa fa-legal"> '.Yii::t('app','Discipline').'</span>','url'=>array('/discipline/recordInfraction/index','mn'=>'std','from'=>'stud')),
						            
						            array('label'=>'<span class="fa fa-usd"> '.Yii::t('app','Billings').'</span>', 'url'=>array('/billings/billings/index/part/rec/from/stud'),'visible'=>!Yii::app()->user->isGuest),
						            
						            array('label'=>'<span class="fa fa-bar-chart"> '.Yii::t('app','Reports').'</span>', 'url'=>array('/reports/reportcard/generalReport','from1'=>'rpt'),'visible'=>!Yii::app()->user->isGuest),
									
			                        array('label'=>'<span class="fa fa-gears"> </span>', 'url'=>array('/configuration/academicperiods/index','mn'=>'sset'),'linkOptions'=> array('title' => Yii::t('app','School settings'),),'visible'=>!Yii::app()->user->isGuest),
			                        
			                        array('label'=>'<span class="fa fa-envelope" style="font-size:14px;" > ('.$mail_unread.')</span> ','url'=>array('/academic/mails/mailbox/mn/std/from/stud/loc/inb')),
			                        
			                      
			                      array('label'=>'<span class="fa fa-globe"> </span>', 'url'=>array('/portal'),'linkOptions'=> array('title' => Yii::t('app','Site web'),),'visible'=>!Yii::app()->user->isGuest),
			                        
			                        //Laisser cette partie inchange au cas ou nous allons implementer quelques choses pour les utilisateurs
	                        array('label'=>'<span class="fa fa-sign-out" style="font-size:14px;" > '.Yii::app()->user->partname.'</span><span class="caret"></span>', 'url'=>array('#'),'itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
	                            'visible'=>!Yii::app()->user->isGuest && $mail_unread==0,
	                            'items'=>array(
	                            
	                            array('label'=>Yii::t('app','Change password'),'url'=>array('/users/user/changePassword','id'=>$userid,'from'=>'oth')),
	                            array('label'=>Yii::t('app','Edit personal Info'),'url'=>array('/academic/persons/viewForUpdate?id='.$person_id.'&from=user')),
	                            array('label'=>Yii::t('app','Mailbox').' ('.$mail_unread.')','url'=>array('/academic/mails/mailbox/mn/std/from/stud/loc/inb')),
                                    array('label'=>'<span class="fa fa-sign-out" > '.Yii::t('app','Logout').' ('.Yii::app()->user->name.')'.'</span>', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
	                             
	                        )),
                                                
                                 array('label'=>Yii::app()->user->partname.'</span><span class="caret"></span>', 'url'=>array('#'),'itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
	                            'visible'=>!Yii::app()->user->isGuest && $mail_unread!=0,
	                            'items'=>array(
	                            
	                            array('label'=>Yii::t('app','Change password'),'url'=>array('/users/user/changePassword','id'=>$userid,'from'=>'oth')),
	                            array('label'=>Yii::t('app','Edit personal Info'),'url'=>array('/academic/persons/viewForUpdate?id='.$person_id.'&from=user')),
                                    array('label'=>Yii::t('app','Mailbox').' ('.$mail_unread.')','url'=>array('/academic/mails/mailbox/mn/std/from/stud/loc/inb')),    
	                            array('label'=>'<span class="fa fa-sign-out" > '.Yii::t('app','Logout').' ('.Yii::app()->user->name.')'.'</span>', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
	                             
	                        )),
	                        
			                    ),
			                ));    
		              	   }
		              	 else //end Yii::app()->user->groupid !=1
		              	   {
		              	   	    $this->widget('zii.widgets.CMenu',array(
		                    'htmlOptions'=>array('class'=>'pull-right nav'),
		                    'submenuHtmlOptions'=>array('class'=>'dropdown-menu'),
							'itemCssClass'=>'item-test',
		                    'encodeLabel'=>false,
		                    'items'=>array(
		                          array('label'=>'<span class="fa fa-home"> '.Yii::t('app','SIGES').'</span>', 'url'=>array('/site/index'),'visible'=>!Yii::app()->user->isGuest),
		                        
		                        // array('label'=>'<span class="fa fa-gears"> '.Yii::t('app','School settings').'</span>', 'url'=>array('/configuration/academicperiods/index','mn'=>'sset'),'visible'=>!Yii::app()->user->isGuest),
			                        
			                       $dashbord,
			                        
			                    array('label'=>'<span class="fa fa-briefcase"> '.Yii::t('app','Academic settings').'</span>', 'url'=>array('/academic/postulant/viewListAdmission/part/enrlis/pg/'),'visible'=>!Yii::app()->user->isGuest),
		                       
		                        array('label'=>'<span class="fa fa-male"> '.Yii::t('app','Teachers').'</span>', 'url'=>array('/academic/persons/listForReport', 'from'=>'teach','isstud'=>0,'mn'=>'teach'),'visible'=>!Yii::app()->user->isGuest),
		                        
		                        
					            
					            array('label'=>'<span class="fa fa-user"> '.Yii::t('app','Employees').'</span>', 'url'=>array('/academic/persons/listForReport', 'from'=>'emp','mn'=>'emp'),'visible'=>!Yii::app()->user->isGuest),
		                        
		                        array('label'=>'<span class="fa fa-group"> '.Yii::t('app','Students').'</span>', 'url'=>array('/academic/persons/listForReport', 'from'=>'stud','isstud'=>1,'mn'=>'std'),'visible'=>!Yii::app()->user->isGuest),
					            
					            array('label'=>'<span class="fa fa-legal"> '.Yii::t('app','Discipline').'</span>','url'=>array('/discipline/recordInfraction/index','mn'=>'std','from'=>'stud')),
					            
					            array('label'=>'<span class="fa fa-usd"> '.Yii::t('app','Billings').'</span>', 'url'=>array('/billings/billings/index/part/rec/from/stud'),'visible'=>!Yii::app()->user->isGuest),
					            
					            array('label'=>'<span class="fa fa-bar-chart"> '.Yii::t('app','Reports').'</span>', 'url'=>array('/reports/reportcard/generalReport','from1'=>'rpt'),'visible'=>!Yii::app()->user->isGuest),
								
		                       array('label'=>'<span class="fa fa-gears"> </span>', 'url'=>array('/configuration/academicperiods/index','mn'=>'sset'),'linkOptions'=> array('title' => Yii::t('app','School settings'),),'visible'=>!Yii::app()->user->isGuest),
		                        
		                        array('label'=>'<span class="fa fa-globe"> </span>', 'url'=>array('/portal'),'linkOptions'=> array('title' => Yii::t('app','Site web'),),'visible'=>!Yii::app()->user->isGuest),
			                        
		                       //Laisser cette partie inchange au cas ou nous allons implementer quelques choses pour les utilisateurs
                        array('label'=>'<span class="fa fa-sign-out" style="font-size:14px;" > '.Yii::app()->user->partname.'</span><span class="caret"></span>', 'url'=>array('#'),'itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
                            'visible'=>!Yii::app()->user->isGuest,
                            'items'=>array(
                            
                            array('label'=>Yii::t('app','Change password'),'url'=>array('/users/user/changePassword','id'=>$userid,'from'=>'oth')),
                            array('label'=>'<span class="fa fa-sign-out" > '.Yii::t('app','Logout').' ('.Yii::app()->user->name.')'.'</span>', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
                             
                        )),
                        
		                    ),
		                )); 
		              	   	}
		              	 
		              	 

		              	
		                }
		              else
		                {
					       $this->widget('zii.widgets.CMenu',array(
		                    'htmlOptions'=>array('class'=>'pull-right nav'),
		                    'submenuHtmlOptions'=>array('class'=>'dropdown-menu'),
							'itemCssClass'=>'item-test',
		                    'encodeLabel'=>false,
		                    'items'=>array(
		                          array('label'=>'<span class="fa fa-home"> '.Yii::t('app','SIGES').'</span>', 'url'=>array('/site/index'),'visible'=>!Yii::app()->user->isGuest),
		                       
							    //array('label'=>'<span class="fa fa-gears"> '.Yii::t('app','School settings').'</span>', 'url'=>array('/configuration/academicperiods/index','mn'=>'sset'),'visible'=>!Yii::app()->user->isGuest),
			                        
			                      $dashbord,
			                        
			                    array('label'=>'<span class="fa fa-briefcase"> '.Yii::t('app','Academic settings').'</span>', 'url'=>array('/academic/postulant/viewListAdmission/part/enrlis/pg/'),'visible'=>!Yii::app()->user->isGuest),
		                       
		                        array('label'=>'<span class="fa fa-male"> '.Yii::t('app','Teachers').'</span>', 'url'=>array('/academic/persons/listForReport','from'=>'teach', 'isstud'=>0,'mn'=>'teach'),'visible'=>!Yii::app()->user->isGuest),
		                        
		                        					            
					            array('label'=>'<span class="fa fa-user"> '.Yii::t('app','Employees').'</span>', 'url'=>array('/academic/persons/listForReport', 'from'=>'emp','mn'=>'emp'),'visible'=>!Yii::app()->user->isGuest),
		                        
		                        array('label'=>'<span class="fa fa-group"> '.Yii::t('app','Students').'</span>', 'url'=>array('/academic/persons/listForReport', 'from'=>'stud','isstud'=>1,'mn'=>'std'),'visible'=>!Yii::app()->user->isGuest),
					            
					            array('label'=>'<span class="fa fa-legal"> '.Yii::t('app','Discipline').'</span>','url'=>array('/discipline/recordInfraction/index','mn'=>'std','from'=>'stud')),
					            
					            array('label'=>'<span class="fa fa-usd"> '.Yii::t('app','Billings').'</span>', 'url'=>array('/billings/billings/index/part/rec/from/stud'),'visible'=>!Yii::app()->user->isGuest),
					            
					            array('label'=>'<span class="fa fa-bar-chart"> '.Yii::t('app','Reports').'</span>', 'url'=>array('/reports/reportcard/generalReport','from1'=>'rpt'),'visible'=>!Yii::app()->user->isGuest),
							
							    array('label'=>'<span class="fa fa-gears"> </span>', 'url'=>array('/configuration/academicperiods/index','mn'=>'sset'),'linkOptions'=> array('title' => Yii::t('app','School settings'),),'visible'=>!Yii::app()->user->isGuest),
		                        
		                        array('label'=>'<span class="fa fa-envelope" style="font-size:14px;" > ('.$mail_unread.')</span> ','url'=>array('/academic/mails/mailbox/mn/std/from/stud/loc/inb')),
			                        
			                       
								array('label'=>'<span class="fa fa-globe"> </span>', 'url'=>array('/portal'),'linkOptions'=> array('title' => Yii::t('app','Site web'),),'visible'=>!Yii::app()->user->isGuest),
			                        
			                        
			                        //Laisser cette partie inchange au cas ou nous allons implementer quelques choses pour les utilisateurs
                        array('label'=>'<span class="fa fa-sign-out" style="font-size:14px;" > '.Yii::app()->user->partname.'</span><span class="caret"></span>', 'url'=>array('#'),'itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
                            'visible'=>!Yii::app()->user->isGuest,
                            'items'=>array(
                            
                            array('label'=>Yii::t('app','Change password'),'url'=>array('/users/user/changePassword','id'=>$userid,'from'=>'oth')),
                            array('label'=>Yii::t('app','Edit personal Info'),'url'=>array('/academic/persons/viewForUpdate?id='.$person_id.'&from=user')),
                            array('label'=>'<span class="fa fa-sign-out" > '.Yii::t('app','Logout').' ('.Yii::app()->user->name.')'.'</span>', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
                             
                        )),

		                      
		                    ),
		                )); 
		                
		               }
		               
		               
		               
		            }
			      
			      			      
			      }
			    elseif(Yii::app()->user->profil=='Manager')
			       {
			      	   //get the person ID
			            	$personInfo = Persons::model()->getIdPersonByUserID($userid);
			            	
			            	$personInfo = $personInfo->getData();
			            	foreach($personInfo as $p)
			            	 {
			            	 	$personId = $p->id;
			            	 	}
			            	 	
			            	$last_pay_id =0;
					         $month_=0;
					         $year_=0;
					         
					          $result = Payroll::model()->getInfoLastPayrollForOne($personId);
					          if($result!=null)
					            {   $result = $result->getData();
					            	foreach($result as $r)
					            	  { $last_pay_id = $r->id;
					                
					                     $month_=$r->payroll_month;
					                     
					                     $time = strtotime($month_);
                                         $year_=date("Y",$time);
					                    
					                    
					            	  }
					             }
					            
					      
					        if($last_pay_id!=0)
					          {
					          	
					          	$url = array('/billings/payroll/view/id/'.$last_pay_id.'/month_/'.$month_.'/year_/'.$year_.'/di/1/from/stud');
					          	$billings = array('label'=>'<span class="fa fa-usd"> '.Yii::t('app','Billings').'</span>', 'url'=>$url, 'visible'=>!Yii::app()->user->isGuest);
					          	
					         
					         
					           }
					         else
					           {
					           	    $billings = array('label'=>''); 
					          	
					           	 }
					         

			            	
			            	
			            	
			            	$groupid=Yii::app()->user->groupid;
					                   $group=Groups::model()->findByPk($groupid);
					                    //$group= $group->getData();
					                    
					                     //foreach($group as $g)
					                          $group_name=$group->group_name;
					   if($group_name=='Discipline')
					      {
						       $this->widget('zii.widgets.CMenu',array(
			                    'htmlOptions'=>array('class'=>'pull-right nav'),
			                    'submenuHtmlOptions'=>array('class'=>'dropdown-menu'),
								'itemCssClass'=>'item-test',
			                    'encodeLabel'=>false,
			                    'items'=>array(
			                        array('label'=>'<span class="fa fa-home"> '.Yii::t('app','SIGES').'</span>', 'url'=>array('/site/index'),'visible'=>!Yii::app()->user->isGuest),
			                        
			                        array('label'=>'<span class="fa fa-briefcase"> '.Yii::t('app','Academic settings').'</span>', 'url'=>array('/academic/postulant/viewListAdmission/part/enrlis/pg/'),'visible'=>!Yii::app()->user->isGuest),
			                       
			                        array('label'=>'<span class="fa fa-male"> '.Yii::t('app','Teachers').'</span>', 'url'=>array('/academic/persons/listForReport', 'from'=>'teach','isstud'=>0,'mn'=>'teach'),'visible'=>!Yii::app()->user->isGuest),
			                        
			                        
						            
						            array('label'=>'<span class="fa fa-user"> '.Yii::t('app','Employees').'</span>', 'url'=>array('/academic/persons/listForReport', 'from'=>'emp','mn'=>'emp'),'visible'=>!Yii::app()->user->isGuest),
			                        
			                        array('label'=>'<span class="fa fa-group"> '.Yii::t('app','Students').'</span>', 'url'=>array('/academic/persons/listForReport', 'from'=>'stud','isstud'=>1,'mn'=>'std'),'visible'=>!Yii::app()->user->isGuest),
						            
						            array('label'=>'<span class="fa fa-legal"> '.Yii::t('app','Discipline').'</span>','url'=>array('/discipline/recordInfraction/index','mn'=>'std','from'=>'stud')),
						            
						            $billings,
									
									array('label'=>'<span class="fa fa-bar-chart"> '.Yii::t('app','Reports').'</span>', 'url'=>array('/reports/reportcard/generalReport','from1'=>'rpt'),'visible'=>!Yii::app()->user->isGuest),
									
			                       array('label'=>'<span class="fa fa-envelope" style="font-size:14px;" > ('.$mail_unread.')</span> ','url'=>array('/academic/mails/mailbox/mn/std/from/stud/loc/inb')),
			                        
			                      
			                      array('label'=>'<span class="fa fa-globe"> </span>', 'url'=>array('/portal'),'linkOptions'=> array('title' => Yii::t('app','Site web'),),'visible'=>!Yii::app()->user->isGuest),
			                        
			                          //Laisser cette partie inchange au cas ou nous allons implementer quelques choses pour les utilisateurs
	                        array('label'=>'<span class="fa fa-sign-out" style="font-size:14px;" > '.Yii::app()->user->partname.'</span><span class="caret"></span>', 'url'=>array('#'),'itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
	                            'visible'=>!Yii::app()->user->isGuest && $mail_unread==0,
	                            'items'=>array(
	                            
	                            array('label'=>Yii::t('app','Change password'),'url'=>array('/users/user/changePassword','id'=>$userid,'from'=>'oth')),
	                            array('label'=>Yii::t('app','Edit personal Info'),'url'=>array('/academic/persons/viewForUpdate?id='.$person_id.'&from=user')),
	                            array('label'=>Yii::t('app','Mailbox').' ('.$mail_unread.')','url'=>array('/academic/mails/mailbox/mn/std/from/stud/loc/inb')),
                                    array('label'=>'<span class="fa fa-sign-out" > '.Yii::t('app','Logout').' ('.Yii::app()->user->name.')'.'</span>', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
	                             
	                        )),
                                                
                                 array('label'=>Yii::app()->user->partname.'</span><span class="caret"></span>', 'url'=>array('#'),'itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
	                            'visible'=>!Yii::app()->user->isGuest && $mail_unread!=0,
	                            'items'=>array(
	                            
	                            array('label'=>Yii::t('app','Change password'),'url'=>array('/users/user/changePassword','id'=>$userid,'from'=>'oth')),
	                            array('label'=>Yii::t('app','Edit personal Info'),'url'=>array('/academic/persons/viewForUpdate?id='.$person_id.'&from=user')),
                                    array('label'=>Yii::t('app','Mailbox').' ('.$mail_unread.')','url'=>array('/academic/mails/mailbox/mn/std/from/stud/loc/inb')),    
	                            array('label'=>'<span class="fa fa-sign-out" > '.Yii::t('app','Logout').' ('.Yii::app()->user->name.')'.'</span>', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
	                             
	                        )),
	                        
			                    ),
			                ));
			                
			                			                
			               }  //end Goup = Discipline
			             elseif(($group_name=='Pedagogie'))
					      {
						       $this->widget('zii.widgets.CMenu',array(
			                    'htmlOptions'=>array('class'=>'pull-right nav'),
			                    'submenuHtmlOptions'=>array('class'=>'dropdown-menu'),
								'itemCssClass'=>'item-test',
			                    'encodeLabel'=>false,
			                    'items'=>array(
			                       array('label'=>'<span class="fa fa-home"> '.Yii::t('app','SIGES').'</span>', 'url'=>array('/site/index'),'visible'=>!Yii::app()->user->isGuest),
			                        
			                        array('label'=>'<span class="fa fa-gears"> '.Yii::t('app','School settings').'</span>', 'url'=>array('/configuration/academicperiods/index','mn'=>'sset'),'visible'=>!Yii::app()->user->isGuest),
			                        
			                        array('label'=>'<span class="fa fa-briefcase"> '.Yii::t('app','Academic settings').'</span>', 'url'=>array('/academic/postulant/viewListAdmission/part/enrlis/pg/'),'visible'=>!Yii::app()->user->isGuest),
			                       
			                        array('label'=>'<span class="fa fa-male"> '.Yii::t('app','Teachers').'</span>', 'url'=>array('/academic/persons/listForReport', 'from'=>'teach','isstud'=>0,'mn'=>'teach'),'visible'=>!Yii::app()->user->isGuest),
			                        
			                        
						            
						            array('label'=>'<span class="fa fa-user"> '.Yii::t('app','Employees').'</span>', 'url'=>array('/academic/persons/listForReport', 'from'=>'emp','mn'=>'emp'),'visible'=>!Yii::app()->user->isGuest),
			                        
			                        array('label'=>'<span class="fa fa-group"> '.Yii::t('app','Students').'</span>', 'url'=>array('/academic/persons/listForReport', 'from'=>'stud','isstud'=>1,'mn'=>'std'),'visible'=>!Yii::app()->user->isGuest),
						            
						            array('label'=>'<span class="fa fa-legal"> '.Yii::t('app','Discipline').'</span>','url'=>array('/discipline/recordInfraction/index','mn'=>'std','from'=>'stud')),
						            
						            $billings,
			                       
			                       array('label'=>'<span class="fa fa-bar-chart"> '.Yii::t('app','Reports').'</span>', 'url'=>array('/reports/reportcard/generalReport','from1'=>'rpt'),'visible'=>!Yii::app()->user->isGuest),
									
			                       array('label'=>'<span class="fa fa-envelope" style="font-size:14px;" > ('.$mail_unread.')</span> ','url'=>array('/academic/mails/mailbox/mn/std/from/stud/loc/inb')),
			                        
			                      
			                      array('label'=>'<span class="fa fa-globe"> </span>', 'url'=>array('/portal'),'linkOptions'=> array('title' => Yii::t('app','Site web'),),'visible'=>!Yii::app()->user->isGuest),
			                        
			                          //Laisser cette partie inchange au cas ou nous allons implementer quelques choses pour les utilisateurs
	                        array('label'=>'<span class="fa fa-sign-out" style="font-size:14px;" > '.Yii::app()->user->partname.'</span><span class="caret"></span>', 'url'=>array('#'),'itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
	                            'visible'=>!Yii::app()->user->isGuest && $mail_unread==0,
	                            'items'=>array(
	                            
	                            array('label'=>Yii::t('app','Change password'),'url'=>array('/users/user/changePassword','id'=>$userid,'from'=>'oth')),
	                            array('label'=>Yii::t('app','Edit personal Info'),'url'=>array('/academic/persons/viewForUpdate?id='.$person_id.'&from=user')),
	                            array('label'=>Yii::t('app','Mailbox').' ('.$mail_unread.')','url'=>array('/academic/mails/mailbox/mn/std/from/stud/loc/inb')),
                                    array('label'=>'<span class="fa fa-sign-out" > '.Yii::t('app','Logout').' ('.Yii::app()->user->name.')'.'</span>', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
	                             
	                        )),
                                                
                                 array('label'=>Yii::app()->user->partname.'</span><span class="caret"></span>', 'url'=>array('#'),'itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
	                            'visible'=>!Yii::app()->user->isGuest && $mail_unread!=0,
	                            'items'=>array(
	                            
	                            array('label'=>Yii::t('app','Change password'),'url'=>array('/users/user/changePassword','id'=>$userid,'from'=>'oth')),
	                            array('label'=>Yii::t('app','Edit personal Info'),'url'=>array('/academic/persons/viewForUpdate?id='.$person_id.'&from=user')),
                                    array('label'=>Yii::t('app','Mailbox').' ('.$mail_unread.')','url'=>array('/academic/mails/mailbox/mn/std/from/stud/loc/inb')),    
	                            array('label'=>'<span class="fa fa-sign-out" > '.Yii::t('app','Logout').' ('.Yii::app()->user->name.')'.'</span>', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
	                             
	                        )),
	                        
			                    ),
			                ));
			                
			                			                
			               }  //end Goup = Pedagogie
			             else
			              {
						       $this->widget('zii.widgets.CMenu',array(
			                    'htmlOptions'=>array('class'=>'pull-right nav'),
			                    'submenuHtmlOptions'=>array('class'=>'dropdown-menu'),
								'itemCssClass'=>'item-test',
			                    'encodeLabel'=>false,
			                    'items'=>array(
			                        array('label'=>'<span class="fa fa-home"> '.Yii::t('app','SIGES').'</span>', 'url'=>array('/site/index'),'visible'=>!Yii::app()->user->isGuest),
			                        
			                       $dashbord,
			                        
			                        array('label'=>'<span class="fa fa-briefcase"> '.Yii::t('app','Academic settings').'</span>', 'url'=>array('/academic/postulant/viewListAdmission/part/enrlis/pg/'),'visible'=>!Yii::app()->user->isGuest),
			                       
			                        array('label'=>'<span class="fa fa-male"> '.Yii::t('app','Teachers').'</span>', 'url'=>array('/academic/persons/listForReport', 'from'=>'teach','isstud'=>0,'mn'=>'teach'),'visible'=>!Yii::app()->user->isGuest),
			                        
			                        
						            
						            array('label'=>'<span class="fa fa-user"> '.Yii::t('app','Employees').'</span>', 'url'=>array('/academic/persons/listForReport', 'from'=>'emp','mn'=>'emp'),'visible'=>!Yii::app()->user->isGuest),
			                        
			                        array('label'=>'<span class="fa fa-group"> '.Yii::t('app','Students').'</span>', 'url'=>array('/academic/persons/listForReport', 'from'=>'stud','isstud'=>1,'mn'=>'std'),'visible'=>!Yii::app()->user->isGuest),
						            
						            array('label'=>'<span class="fa fa-legal"> '.Yii::t('app','Discipline').'</span>','url'=>array('/discipline/recordInfraction/index','mn'=>'std','from'=>'stud')),
						            
						            array('label'=>'<span class="fa fa-usd"> '.Yii::t('app','Billings').'</span>', 'url'=>array('/billings/billings/index/part/rec/from/stud'),'visible'=>!Yii::app()->user->isGuest),
						            
						            array('label'=>'<span class="fa fa-bar-chart"> '.Yii::t('app','Reports').'</span>', 'url'=>array('/reports/reportcard/generalReport','from1'=>'rpt'),'visible'=>!Yii::app()->user->isGuest),
                                                array('label'=>'<span class="fa fa-gears"> </span>', 'url'=>array('/configuration/academicperiods/index','mn'=>'sset'),'visible'=>!Yii::app()->user->isGuest),
			                       array('label'=>'<span class="fa fa-envelope" style="font-size:14px;" > ('.$mail_unread.')</span> ','url'=>array('/academic/mails/mailbox/mn/std/from/stud/loc/inb')),
			                        
			                      
			                      array('label'=>'<span class="fa fa-globe"> </span>', 'url'=>array('/portal'),'linkOptions'=> array('title' => Yii::t('app','Site web'),),'visible'=>!Yii::app()->user->isGuest),
			                        
			                          //Laisser cette partie inchange au cas ou nous allons implementer quelques choses pour les utilisateurs
	                        array('label'=>'<span class="fa fa-sign-out" style="font-size:14px;" > '.Yii::app()->user->partname.'</span><span class="caret"></span>', 'url'=>array('#'),'itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
	                            'visible'=>!Yii::app()->user->isGuest && $mail_unread==0,
	                            'items'=>array(
	                            
	                            array('label'=>Yii::t('app','Change password'),'url'=>array('/users/user/changePassword','id'=>$userid,'from'=>'oth')),
	                            array('label'=>Yii::t('app','Edit personal Info'),'url'=>array('/academic/persons/viewForUpdate?id='.$person_id.'&from=user')),
	                            array('label'=>Yii::t('app','Mailbox').' ('.$mail_unread.')','url'=>array('/academic/mails/mailbox/mn/std/from/stud/loc/inb')),
                                    array('label'=>'<span class="fa fa-sign-out" > '.Yii::t('app','Logout').' ('.Yii::app()->user->name.')'.'</span>', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
	                             
	                        )),
                                                
                                 array('label'=>Yii::app()->user->partname.'</span><span class="caret"></span>', 'url'=>array('#'),'itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
	                            'visible'=>!Yii::app()->user->isGuest && $mail_unread!=0,
	                            'items'=>array(
	                            
	                            array('label'=>Yii::t('app','Change password'),'url'=>array('/users/user/changePassword','id'=>$userid,'from'=>'oth')),
	                            array('label'=>Yii::t('app','Edit personal Info'),'url'=>array('/academic/persons/viewForUpdate?id='.$person_id.'&from=user')),
                                    array('label'=>Yii::t('app','Mailbox').' ('.$mail_unread.')','url'=>array('/academic/mails/mailbox/mn/std/from/stud/loc/inb')),    
	                            array('label'=>'<span class="fa fa-sign-out" > '.Yii::t('app','Logout').' ('.Yii::app()->user->name.')'.'</span>', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
	                             
	                        )),
	                       
			                    ),
			                ));
			                
			                			                
			               }
			               
			      	
			        }
			       elseif(Yii::app()->user->profil=='Billing')
			          {
			          	$this->widget('zii.widgets.CMenu',array(
			                    'htmlOptions'=>array('class'=>'pull-right nav'),
			                    'submenuHtmlOptions'=>array('class'=>'dropdown-menu'),
								'itemCssClass'=>'item-test',
			                    'encodeLabel'=>false,
			                    'items'=>array(
			                        array('label'=>'<span class="fa fa-home"> '.Yii::t('app','SIGES').'</span>', 'url'=>array('/site/index'),'visible'=>!Yii::app()->user->isGuest),
			                       /* */
			                       
                                   $dashbord,
			                        
			                        array('label'=>'<span class="fa fa-envelope" style="font-size:14px;" > '.Yii::t('app','Messages').' ('.$mail_unread.')</span> ','url'=>array('/academic/mails/mailbox/mn/std/from/stud/loc/inb')),
			                        
			                        array('label'=>'<span class="fa fa-briefcase"> '.Yii::t('app','Academic settings').'</span>', 'url'=>array('/academic/postulant/viewListAdmission/part/enrlis/pg/'),'visible'=>!Yii::app()->user->isGuest),
			                       
			                        
			                        array('label'=>'<span class="fa fa-male"> '.Yii::t('app','Teachers').'</span>', 'url'=>array('/academic/persons/listForReport', 'from'=>'teach','isstud'=>0,'mn'=>'teach'),'visible'=>!Yii::app()->user->isGuest),
			                        
			                        
						            
						            array('label'=>'<span class="fa fa-user"> '.Yii::t('app','Employees').'</span>', 'url'=>array('/academic/persons/listForReport', 'from'=>'emp','mn'=>'emp'),'visible'=>!Yii::app()->user->isGuest),
			                        
			                        array('label'=>'<span class="fa fa-group"> '.Yii::t('app','Students').'</span>', 'url'=>array('/academic/persons/listForReport', 'from'=>'stud','isstud'=>1,'mn'=>'std'),'visible'=>!Yii::app()->user->isGuest),
						            
						            array('label'=>'<span class="fa fa-usd"> '.Yii::t('app','Billings').'</span>', 'url'=>array('/billings/billings/index/part/rec/from/stud'),'visible'=>!Yii::app()->user->isGuest),
						            
						            array('label'=>'<span class="fa fa-bar-chart"> '.Yii::t('app','Reports').'</span>', 'url'=>array('/reports/reportcard/generalReport','from1'=>'rpt'),'visible'=>!Yii::app()->user->isGuest),
								
								    
			                       
									array('label'=>'<span class="fa fa-globe"> '.Yii::t('app','Site web').' </span>', 'url'=>array('/portal'),'linkOptions'=> array('title' => Yii::t('app','Portal'),),'visible'=>!Yii::app()->user->isGuest),
			                        
			                        
			                        //Laisser cette partie inchange au cas ou nous allons implementer quelques choses pour les utilisateurs
	                        array('label'=>'<span class="fa fa-sign-out" style="font-size:14px;" > '.Yii::app()->user->partname.'</span><span class="caret"></span>', 'url'=>array('#'),'itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
                            'visible'=>!Yii::app()->user->isGuest,
                            'items'=>array(
                            
                            array('label'=>Yii::t('app','Change password'),'url'=>array('/users/user/changePassword','id'=>$userid,'from'=>'oth')),
                            array('label'=>Yii::t('app','Edit personal Info'),'url'=>array('/academic/persons/viewForUpdate?id='.$person_id.'&from=user')),
                            array('label'=>'<span class="fa fa-sign-out" > '.Yii::t('app','Logout').' ('.Yii::app()->user->name.')'.'</span>', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
                             
                        )),
	
			                      
			                    ),
			                )); 
			          	
			          }
			         elseif(Yii::app()->user->profil=='Teacher')
			            {
			            	//get the person ID
			            	$personInfo = Persons::model()->getIdPersonByUserID($userid);
			            	
			            	$personInfo = $personInfo->getData();
			            	foreach($personInfo as $p)
			            	 {
			            	 	$personId = $p->id;
			            	 	}
			            	 	
			            	$last_pay_id =0;
					         $month_=0;
					         $year_=0;
					         
					          $result = Payroll::model()->getInfoLastPayrollForOne($personId);
					          if($result!=null)
					            {   $result = $result->getData();
					            	foreach($result as $r)
					            	  { $last_pay_id = $r->id;
					                
					                     $month_=$r->payroll_month;
					                     
					                     $time = strtotime($month_);
                                         $year_=date("Y",$time);
					                    
					                    
					            	  }
					             }
					            
					      
					        if($last_pay_id!=0)
					          {
					          	
					          	$url = array('/billings/payroll/view/id/'.$last_pay_id.'/month_/'.$month_.'/year_/'.$year_.'/di/1/from/stud');
					          	$billings = array('label'=>'<span class="fa fa-usd"> '.Yii::t('app','Billings').'</span>', 'url'=>$url, 'visible'=>!Yii::app()->user->isGuest);
					          	
					         
					         
					           }
					         else
					           {
					           	    $billings = array('label'=>''); 
					          	
					           	 }
					         

			            	
			            	
			            	
			            	
			            	
			            	
			            	
			            	$this->widget('zii.widgets.CMenu',array(
			                    'htmlOptions'=>array('class'=>'pull-right nav'),
			                    'submenuHtmlOptions'=>array('class'=>'dropdown-menu'),
								'itemCssClass'=>'item-test',
			                    'encodeLabel'=>false,
			                    'items'=>array(
			                        array('label'=>'<span class="fa fa-home"> '.Yii::t('app','SIGES').'</span>', 'url'=>array('/site/index'),'visible'=>!Yii::app()->user->isGuest),
			                        array('label'=>'<span class="fa fa-envelope" style="font-size:14px;" > '.Yii::t('app','Messages').' ('.$mail_unread.')</span> ','url'=>array('/academic/mails/mailbox/mn/std/from/stud/loc/inb')),
			                        array('label'=>'<span class="fa fa-male"> '.Yii::t('app','Teachers').'</span>', 'url'=>array('/academic/persons/listForReport', 'from'=>'teach','isstud'=>0,'mn'=>'teach'),'visible'=>!Yii::app()->user->isGuest),
			                       
						            array('label'=>'<span class="fa fa-group"> '.Yii::t('app','Students').'</span>', 'url'=>array('/academic/persons/listForReport', 'from'=>'stud','isstud'=>1,'mn'=>'std'),'visible'=>!Yii::app()->user->isGuest),//la fe kou pou yo
						            
						           $billings,
								  
								  array('label'=>'<span class="fa fa-bar-chart"> '.Yii::t('app','Statistics').'</span>', 'url'=>array('/reports/reportcard/generalReport','from1'=>'rpt'),'visible'=>!Yii::app()->user->isGuest),
								
								  
								  
			                      
			                      array('label'=>'<span class="fa fa-globe"> '.Yii::t('app','Portal').'</span>', 'url'=>array('/portal'),'linkOptions'=> array('title' => Yii::t('app','Site web'),),'visible'=>!Yii::app()->user->isGuest),
			                         
									//Laisser cette partie inchange au cas ou nous allons implementer quelques choses pour les utilisateurs
	                        array('label'=>'<span class="fa " style="font-size:14px;"> '.$mail_unread.' </span><span class="fa fa-envelope" style="font-size:14px;" > '.Yii::app()->user->partname.'</span><span class="caret"></span>', 'url'=>array('#'),'itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
                                        'visible'=>!Yii::app()->user->isGuest && $mail_unread!=0,
                                        'items'=>array(
                            
                            array('label'=>Yii::t('app','Change password'),'url'=>array('/users/user/changePassword','id'=>$userid,'from'=>'oth')),
                            array('label'=>Yii::t('app','Edit personal Info'),'url'=>array('/academic/persons/viewForUpdate?id='.$person_id.'&from=user')),
                            
                                                        array('label'=>'<span class="fa fa-sign-out" > '.Yii::t('app','Logout').' ('.Yii::app()->user->name.')'.'</span>', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
                             
                        )),
                        array('label'=>'<span class="fa fa-sign-out" style="font-size:14px;" > '.Yii::app()->user->partname.'</span><span class="caret"></span>', 'url'=>array('#'),'itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
                                        'visible'=>!Yii::app()->user->isGuest && $mail_unread==0,
                                        'items'=>array(
                            
                            array('label'=>Yii::t('app','Change password'),'url'=>array('/users/user/changePassword','id'=>$userid,'from'=>'oth')),
                            array('label'=>Yii::t('app','Edit personal Info'),'url'=>array('/academic/persons/viewForUpdate?id='.$person_id.'&from=user')),
                            
                                                        array('label'=>'<span class="fa fa-sign-out" > '.Yii::t('app','Logout').' ('.Yii::app()->user->name.')'.'</span>', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
                             
                        )),                        
	
			                   
			                    ),
			                )); 
			            	
			            }
			           elseif(Yii::app()->user->profil=='Guest')
			               {   $contact='';
			               	   if(isset(Yii::app()->user->groupid))
					            {    
					                   $groupid=Yii::app()->user->groupid;
					                   $group=Groups::model()->findByPk($groupid);
					                    //$group= $group->getData();
					                    
					                     //foreach($group as $g)
					                          $group_name=$group->group_name;
					            if($group_name=='Parent')
					              {
					              	   $contact=null;
					              	   $contact_ID=ContactInfo::model()->getIdContactByUserID($userid);
					              	   $contact_ID= $contact_ID->getData();
					                    
					                     foreach($contact_ID as $c)
					                       $contact= $c->id;
					                       
					                       
              					$this->widget('zii.widgets.CMenu',array(
			                    'htmlOptions'=>array('class'=>'pull-right nav'),
			                    'submenuHtmlOptions'=>array('class'=>'dropdown-menu'),
								'itemCssClass'=>'item-test',
			                    'encodeLabel'=>false,
			                    'items'=>array(
				                       array('label'=>'<span class="fa fa-home"> '.Yii::t('app','SIGES').'</span>', 'url'=>array('/site/index'),'visible'=>!Yii::app()->user->isGuest),
                                                      
				                        
				                        array('label'=>'<span class="fa fa-briefcase"> '.Yii::t('app','Academic info').'</span>', 'url'=>array('/guest/grades/index','mn'=>'aset'),'visible'=>!Yii::app()->user->isGuest),
							            
							            
							           // array('label'=>'<span class="fa fa-list-alt"> '.Yii::t('app','Grade & Homework').'</span>', 'url'=>array('/guest/grades/index','mn'=>'std'),'visible'=>!Yii::app()->user->isGuest),
							            
							            array('label'=>'<span class="fa fa-legal"> '.Yii::t('app','Discipline').'</span>', 'url'=>array('/guest/recordInfraction/viewParent','mn'=>'std'),'visible'=>!Yii::app()->user->isGuest),
							            
							            array('label'=>'<span class="fa fa-usd"> '.Yii::t('app','Billings').'</span>', 'url'=>array('/guest/fees/index'),'visible'=>!Yii::app()->user->isGuest),
							            
							             array('label'=>'<span class="fa fa-bar-chart"> '.Yii::t('app','Statistics').'</span>', 'url'=>array('/guest/reportcard/generalReport','from1'=>'rpt'),'visible'=>!Yii::app()->user->isGuest),
								
							
				                        array('label'=>'<span class="fa fa-globe"> '.Yii::t('app','Site web').'</span>', 'url'=>array('/portal'),'linkOptions'=> array('title' => Yii::t('app','Portal'),),'visible'=>!Yii::app()->user->isGuest),
			                        
			                        
			                        //Laisser cette partie inchange au cas ou nous allons implementer quelques choses pour les utilisateurs
                        array('label'=>'<span class="fa fa-sign-out" style="font-size:14px;" > '.Yii::app()->user->partname.'</span><span class="caret"></span>', 'url'=>array('#'),'itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
                            'visible'=>!Yii::app()->user->isGuest,
                            'items'=>array(
                            
                            array('label'=>Yii::t('app','Change password'),'url'=>array('/users/user/changePassword?id='.$userid.'&from=guest')),
                            array('label'=>Yii::t('app','Edit personal Info'),'url'=>array('/guest/contactInfo/view?id='.$contact.'&from=guest')),
							array('label'=>Yii::t('app','Contact Info'),'url'=>array('/guest/contactInfo/viewcontact?id='.$contact.'&from=user')),
                            array('label'=>'<span class="fa fa-sign-out"> '.Yii::t('app','Logout').' ('.Yii::app()->user->name.')'.'</span>', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
                             
                        )),
                        
                        

				                    ),
				                )); 
			               	
					              }
					            elseif($group_name=='Student')
					              {  $person_id='';
					                 $contact= '';
					              
					              
					              	 $contact_ID=ContactInfo::model()->getIdContactByUserID($userid);
					              	   $contact_ID= $contact_ID->getData();
					                    
					                     foreach($contact_ID as $c)
					                       $contact= $c->id;
					                   
					                   $person_ID=Persons::model()->getIdPersonByUserID($userid);
									   $person_ID= $person_ID->getData();
											                    
									     foreach($person_ID as $c)
											$person_id= $c->id;	    
					                       
					            $this->widget('zii.widgets.CMenu',array(
			                    'htmlOptions'=>array('class'=>'pull-right nav'),
			                    'submenuHtmlOptions'=>array('class'=>'dropdown-menu'),
								'itemCssClass'=>'item-test',
			                    'encodeLabel'=>false,
			                    'items'=>array(
				                        array('label'=>'<span class="fa fa-home"> '.Yii::t('app','SIGES').'</span>', 'url'=>array('/site/index'),'visible'=>!Yii::app()->user->isGuest),
                                                        array('label'=>'<span class="fa fa-envelope" style="font-size:14px;" > '.Yii::t('app','Messages').' ('.$mail_unread.')</span> ','url'=>array('/academic/mails/mailbox/mn/std/from/stud/loc/inb')),
				                      
				                        
				                        array('label'=>'<span class="fa fa-briefcase"> '.Yii::t('app','Academic info').'</span>', 'url'=>array('/guest/grades/index','mn'=>'aset'),'visible'=>!Yii::app()->user->isGuest),
							            
							           // array('label'=>'<span class="fa fa-list-alt"> '.Yii::t('app','Grade & Homework').'</span>', 'url'=>array('/guest/grades/index', 'mn'=>'std'),'visible'=>!Yii::app()->user->isGuest),
							            
							            array('label'=>'<span class="fa fa-legal"> '.Yii::t('app','Discipline').'</span>', 'url'=>array('/guest/recordInfraction/view','mn'=>'std'),'visible'=>!Yii::app()->user->isGuest),
							            
							            array('label'=>'<span class="fa fa-usd"> '.Yii::t('app','Billings').'</span>', 'url'=>array('/guest/billings/index'),'visible'=>!Yii::app()->user->isGuest),
							            
							            array('label'=>'<span class="fa fa-bar-chart"> '.Yii::t('app','Statistics').'</span>', 'url'=>array('/guest/reportcard/generalReport','from1'=>'rpt'),'visible'=>!Yii::app()->user->isGuest),
							
				                      			                       
                                      array('label'=>'<span class="fa fa-globe"> '.Yii::t('app','Site web').'</span>', 'url'=>array('/portal'),'linkOptions'=> array('title' => Yii::t('app','Portal'),),'visible'=>!Yii::app()->user->isGuest),
			                        
			                        
			                         //Laisser cette partie inchange au cas ou nous allons implementer quelques choses pour les utilisateurs
                        array('label'=>'<span class="fa fa-sign-out" style="font-size:14px;" > '.Yii::app()->user->partname.'</span><span class="caret"></span>', 'url'=>array('#'),'itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
                            'visible'=>!Yii::app()->user->isGuest && $mail_unread==0,
                            'items'=>array(
                            
                            array('label'=>Yii::t('app','Change password'),'url'=>array('/users/user/changePassword?id='.$userid.'&from=guest')),
                            array('label'=>Yii::t('app','Edit personal Info'),'url'=>array('/guest/persons/viewForUpdate?id='.$person_id.'&from=user')),
							array('label'=>Yii::t('app','Contact Info'),'url'=>array('/guest/contactInfo/viewcontact?id='.$person_id.'&from=user')),
                            
                                                        array('label'=>'<span class="fa fa-sign-out"> '.Yii::t('app','Logout').' ('.Yii::app()->user->name.')'.'</span>', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
                             
                        )),
                        array('label'=>'<span class="fa " style="font-size:14px;"> '.$mail_unread.' </span><span class="fa fa-envelope" style="font-size:14px;" > '.Yii::app()->user->partname.'</span><span class="caret"></span>', 'url'=>array('#'),'itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
                            'visible'=>!Yii::app()->user->isGuest && $mail_unread!=0,
                            'items'=>array(
                            
                            array('label'=>Yii::t('app','Change password'),'url'=>array('/users/user/changePassword?id='.$userid.'&from=guest')),
                            array('label'=>Yii::t('app','Edit personal Info'),'url'=>array('/guest/persons/viewForUpdate?id='.$person_id.'&from=user')),
							array('label'=>Yii::t('app','Contact Info'),'url'=>array('/guest/contactInfo/viewcontact?id='.$person_id.'&from=user')),
                            
                                                        array('label'=>'<span class="fa fa-sign-out"> '.Yii::t('app','Logout').' ('.Yii::app()->user->name.')'.'</span>', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
                             
                        )), 
                                              

				                    ),
				                )); 

					              	
					                }
			               	    elseif($group_name=='Default Group')
					              {     
					                       
							            $this->widget('zii.widgets.CMenu',array(
					                    'htmlOptions'=>array('class'=>'pull-right nav'),
					                    'submenuHtmlOptions'=>array('class'=>'dropdown-menu'),
										'itemCssClass'=>'item-test',
					                    'encodeLabel'=>false,
					                    'items'=>array(
						                       array('label'=>'<span class="fa fa-home"> '.Yii::t('app','SIGES').'</span>', 'url'=>array('/site/index'),'visible'=>!Yii::app()->user->isGuest),
						                     
						                array('label'=>'<span class="fa fa-globe"> '.Yii::t('app','Site web').'</span>', 'url'=>array('/portal'),'linkOptions'=> array('title' => Yii::t('app','Portal'),),'visible'=>!Yii::app()->user->isGuest),
			                        
			                               //Laisser cette partie inchange au cas ou nous allons implementer quelques choses pour les utilisateurs
		                        array('label'=>'<span class="fa fa-sign-out" style="font-size:14px;" > '.Yii::app()->user->partname.'</span><span class="caret"></span>', 'url'=>array('#'),'itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
		                            'visible'=>!Yii::app()->user->isGuest,
		                            'items'=>array(
		                            
		                            array('label'=>'<span class="fa fa-sign-out"> '.Yii::t('app','Logout').' ('.Yii::app()->user->name.')'.'</span>', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
		                             
		                        )),
		 
						                    ),
						                )); 

					              	
					                }
			               	
			               	
					     
					     }        	
			               	
			       
			       }
			    elseif(Yii::app()->user->profil=='Information') 
			      {
			    	    
			                
			                
			                $this->widget('zii.widgets.CMenu',array(
			                    'htmlOptions'=>array('class'=>'pull-right nav'),
			                    'submenuHtmlOptions'=>array('class'=>'dropdown-menu'),
								'itemCssClass'=>'item-test',
			                    'encodeLabel'=>false,
			                    'items'=>array(
			                        array('label'=>'<span class="fa fa-home"> '.Yii::t('app','SIGES').'</span>', 'url'=>array('/site/index'),'visible'=>!Yii::app()->user->isGuest),
			                         array('label'=>'<span class="fa fa-briefcase"> '.Yii::t('app','Academic settings').'</span>', 'url'=>array('/schoolconfig/calendar/index'),'visible'=>!Yii::app()->user->isGuest),
								
								  
			                      array('label'=>'<span class="fa fa-globe"> '.Yii::t('app','Portal').'</span>', 'url'=>array('/portal'),'linkOptions'=> array('title' => Yii::t('app','Site web'),),'visible'=>!Yii::app()->user->isGuest),
			                      
			                      array('label'=>'<span class="fa fa-envelope"  > ('.$mail_unread.')</span> ','url'=>array('/academic/mails/mailbox/mn/std/from/stud/loc/inb')),
			                        
			                         
									//Laisser cette partie inchange au cas ou nous allons implementer quelques choses pour les utilisateurs
	                        array('label'=>'<span class="fa fa" style="font-size:14px;" > '.Yii::app()->user->partname.'</span><span class="caret"></span>', 'url'=>array('#'),'itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
                                        'visible'=>!Yii::app()->user->isGuest,
                                        'items'=>array(
                            
                            array('label'=>Yii::t('app','Change password'),'url'=>array('/users/user/changePassword','id'=>$userid,'from'=>'oth')),
                            array('label'=>Yii::t('app','Edit personal Info'),'url'=>array('/academic/persons/viewForUpdate?id='.$person_id.'&from=user')),
                            
                                                        array('label'=>'<span class="fa fa-sign-out" > '.Yii::t('app','Logout').' ('.Yii::app()->user->name.')'.'</span>', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
                             
                        )),
                                               
	
			                   
			                    ),
			                )); 
  



			    	}
                
               
               
               
               
               
               
               
		    }
 }
 else
 {
 	$partname =  '';
 	
 	 if(isset(Yii::app()->user->partname))
 	    $partname = Yii::app()->user->partname;
 	 
 	$this->widget('zii.widgets.CMenu',array(
					                    'htmlOptions'=>array('class'=>'pull-right nav'),
					                    'submenuHtmlOptions'=>array('class'=>'dropdown-menu'),
										'itemCssClass'=>'item-test',
					                    'encodeLabel'=>false,
					                    'items'=>array(
						                       
						                       			                               //Laisser cette partie inchange au cas ou nous allons implementer quelques choses pour les utilisateurs
		                        array('label'=>'<span class="fa fa-sign-out" style="font-size:14px;" > '.$partname.'</span><span class="caret"></span>', 'url'=>array('#'),'itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
		                            'visible'=>!Yii::app()->user->isGuest,
		                            'items'=>array(
		                            
		                            array('label'=>'<span class="fa fa-sign-out"> '.Yii::t('app','Logout').' ('.Yii::app()->user->name.')'.'</span>', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
		                             
		                        )),
		 
						                    ),
						                )); 


 	}            
                ?>
                
                
    	</div>
    	
    	
          
          
          
    </div>
	</div>
</div>

<div class="subnav navbar navbar-fixed-top">


    <div class="navbar-inner">
    	<div class="container">
    	
        
        <!-- 	
           <form class="navbar-search pull-right" action="">
           	 
           <input type="text" class="search-query span2" placeholder="Search">
           
           </form> -->
           
           
           
    	</div>
    	<!-- container -->
    	
    </div>
    <!-- navbar-inner -->
 <div class="rt_academic">
 

    

    
 	<div  id="language-selector">
           
                                    <?php 
                                   
                                        $this->widget('application.components.widgets.LanguageSelector');
                                        
                                    ?>
            
	</div> 
     

    
                                    
    
   <div  id="a_academic"> <?php 
   
                      $siges_structure = infoGeneralConfig('siges_structure_session');  
                      $sess_name='';
                      
                      if($siges_structure==1)
                        {  if($this->noSession)
                             {  Yii::app()->session['currentName_academic_session']=null;
                                Yii::app()->session['currentId_academic_session']=null;
                             	$sess_name=' / ';
                             }
                           else
                             $sess_name=' / '.Yii::app()->session['currentName_academic_session'];
                        }
                      
                      $acad_name=Yii::app()->session['currentName_academic_year'];
                     if($acad_name!='') echo '<i>'.Yii::t('app','Academic year').' '.$acad_name.$sess_name.'</i>';
       ?>
  </div>
  
  <?php 
        
        
        if(Yii::app()->session['employee_teacher']==1)
          {  
          	 if(Yii::app()->session['main_profil']!='Teacher')
          	   {
  ?>
  	<div  id="language-selector" >
                                    <?php 
                                        $this->widget('application.components.widgets.ProfilSelector');
                                    ?>
	</div> 
  
  <?php 
          	   }
          
          }
  
  ?>     
       
       
   <div>   
    
</div>
<!-- subnav -->

