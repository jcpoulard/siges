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

$userid = null;
if(isset(Yii::app()->user->userid))
                        {
                            $userid = Yii::app()->user->userid;
                        }
                        else 
                        {
                            $userid = null;
                        }

						
if($acad!=null){  
							
if(isset(Yii::app()->user->profil))
{   $profil=Yii::app()->user->profil;
   switch($profil)
     {
        case 'Guest':
           if(isset(Yii::app()->user->groupid))
            {    
                   $contact=null;
                   $person_id=null;
                          
                         
					   
					 
					       

                   $groupid=Yii::app()->user->groupid;
                   $group=Groups::model()->findByPk($groupid);
                    
                    
                          $group_name=$group->group_name;
            if($group_name=='Parent')
              {
				  
				   $contact_ID=ContactInfo::model()->getIdContactByUserID($userid);
					      $contact_ID= $contact_ID->getData();
					                    
					         foreach($contact_ID as $c)
					            $contact= $c->id;
								
								
				$this->widget('zii.widgets.CMenu', array(
					'activeCssClass'=>'active',
					'encodeLabel'=>false,
					'activateParents'=>true,
					'items'=>array(
					
					 
	
			
				array('label'=>'<span class="fa fa-gears" style="font-size: 23px;">  '.Yii::t('app','Users').'</span>', 
					//'linkOptions'=>array('id'=>'menuAcademicSettings'),
					//'itemOptions'=>array('id'=>'itemAcademicSettings'),
					
					'items'=>array(
					    
						array('label'=>'<span class=""> '.Yii::t('app','Change password').'</span>', 'url'=>array('/users/user/changePassword?id='.$userid.'&from=guest')),
								
								array('label'=>Yii::t('app','Edit personal Info'),'url'=>array('/guest/contactInfo/view?id='.$contact.'&from=guest')),

			                    array('label'=>Yii::t('app','Contact Info'),'url'=>array('/guest/contactInfo/viewcontact?id='.$contact.'&from=guest')),   
			            
						    )),
					
					))); 
               }
              elseif($group_name=='Student')
                { 
				           $person_ID=Persons::model()->getIdPersonByUserID($userid);
									   $person_ID= $person_ID->getData();
											                    
									     foreach($person_ID as $c)
											$person_id= $c->id;	 
											
                	$this->widget('zii.widgets.CMenu', array(
					'activeCssClass'=>'active',
					'encodeLabel'=>false,
					'activateParents'=>true,
					'items'=>array(
					
					 
					
					array('label'=>'<span class="fa fa-2y" style="font-size: 23px;">  '.Yii::t('app','Users').'</span> ',
					//'linkOptions'=>array('id'=>'menuAcademicSettings'),
					//'itemOptions'=>array('id'=>'itemAcademicSettings'),
					
					'items'=>array(
					    
						array('label'=>'<span class=""> '.Yii::t('app','Change password').'</span>', 'url'=>array('/users/user/changePassword?id='.$userid.'&from=guest')),
									
									array('label'=>Yii::t('app','Edit personal Info'),'url'=>array('/guest/persons/viewForUpdate?id='.$person_id.'&from=guest')),
									
									array('label'=>Yii::t('app','Contact Info'),'url'=>array('/guest/contactInfo/viewcontact?id='.$person_id.'&from=guest')),

			                       
			         
						    )),
					
					)));
                  
                  }
               
            }

               
               break; 
                
          case 'Admin':
                        /*
                           ////-1: migration not yet done; 1: migration is not completed 2: migration done; 0: no migration to do 
							//migration check to display link 
							$check= getYearMigrationCheck($acad_sess);
							
							if($check==1)
							  { //nap jere afichaj link lan pou 2 mwa
							      $start_date =''; // dat ane akademik lan t kreye
							      $nonb_de_jou =0;
							        $data_migrationCheck = YearMigrationCheck::model()->getValueYearMigrationCheck($acad_sess);
							    
							         if($data_migrationCheck!=null)
							           {  foreach($data_migrationCheck as $d){
							    	         if($d['date_created']!='')
							    	            $start_date = $d['date_created'];
							                    break;
							                       
							                }
							           }
							           
							       if($start_date!='')
							           $nonb_de_jou = date_diff ( date_create($start_date)  , date_create(date('Y-m-d') ))->format('%R%a');
								
								  if($nonb_de_jou <= 60) //60 jou
							         {  $item_year_migration= array('label'=>'<span class="fa fa-download"> '.Yii::t('app','New year data migration').'</span>', 'url'=>array('/reports/reportcard/yearMigrationCheck'));
							         } 
							      else
							  	     {  $item_year_migration= array('label'=>'<span class="fa fa-download" style="color:#939893"> '.Yii::t('app','New year data migration').'</span>', 'linkOptions'=> array( 'title' => Yii::t('app','All migration already done.'), 
							                          ), );
							  	     }
							  
							  }
							elseif($check==2)
							  {  $item_year_migration= array('label'=>'<span class="fa fa-download" style="color:#939893"> '.Yii::t('app','New year data migration').'</span>', 'linkOptions'=> array( 'title' => Yii::t('app','All migration already done.'), 
							                          ), );
							                          
							   }
							 elseif($check==0)
							  {  $item_year_migration= array('label'=>'<span class="fa fa-download" style="color:#939893"> '.Yii::t('app','New year data migration').'</span>', 'linkOptions'=> array( 'title' => Yii::t('app','No migration to do.'), 
							                          ), );
							                          
							   } 
							*/
							
                 $item_year_migration= array('label'=>'<span class="fa fa-exchange"> '.Yii::t('app','New year data migration').'</span>', 'url'=>array('/reports/reportcard/yearMigrationCheck'));
          
          
          
                           
                           if(($userid==2)||($userid==3) )
                             $migration_label = array('label'=>'<span class="fa fa-exchange"> '.Yii::t('app','Data migration').'</span>', 'url'=>array('/schoolconfig/datamigration/index'),'visible'=>!Yii::app()->user->isGuest);
                           else
                              $migration_label = array('label'=>'');
                              
                              
                  $this->widget('zii.widgets.CMenu', array(
					'activeCssClass'=>'active',
					'encodeLabel'=>false,
					'activateParents'=>true,
					'items'=>array(
					
					 
					
					array('label'=>'<span class="fa fa-2y" style="font-size: 23px;"> '.Yii::t('app','School settings').'</span> ',
					//'linkOptions'=>array('id'=>'menuAcademicSettings'),
					//'itemOptions'=>array('id'=>'itemAcademicSettings'),
					
					'items'=>array(
                            
                                                array('label'=>'<span class="fa fa-wrench"> '.Yii::t('app','General config').'</span>','url'=>array('/configuration/generalconfig/index','mn'=>'sset')),
						array('label'=>'<span class="fa fa-gear"> '.Yii::t('app','Custom fields').'</span>','url'=>array('/configuration/customField/index')),
                                                array('label'=>'<span class="fa fa-ban"> '.Yii::t('app','Infraction type').'</span>','url'=>array('/discipline/infractionType/index')),
						array('label'=>'<span class="fa fa-male"><span class="fa fa-male"> '.Yii::t('app','Relations').'</span></span>','url'=>array('/configuration/relations/index','mn'=>'sset')),
						array('label'=>'<span class="fa fa-sitemap"> '.Yii::t('app','Titles').'</span>','url'=>array('/configuration/titles/index','mn'=>'sset')),
						
						array('label'=>'<span class="fa fa-graduation-cap"> '.Yii::t('app','Qualifications').'</span>','url'=>array('/configuration/qualifications/index','mn'=>'sset')),
						array('label'=>'<span class="fa fa-book"> '.Yii::t('app','Field study').'</span>','url'=>array('/configuration/fieldstudy/index','mn'=>'sset')),
						array('label'=>'<span class="fa fa-adjust"> '.Yii::t('app','Job status').'</span>','url'=>array('/configuration/jobstatus/index','mn'=>'sset')),
						array('label'=>'<span class="fa fa-cog"> '.Yii::t('app','Users').'</span>', 'url'=>array('/users/user/index'),'visible'=>!Yii::app()->user->isGuest),
                        // array('label'=>'<span class="fa fa-globe"> '.Yii::t('app','Portal').'</span>','url'=>array('/portal/cmsArticle/index')),
                                                
                          
                          $item_year_migration, 
                          
                          $migration_label,
                          
                          
			            
					        )),
					
					
					
					
					))); 
                 break;
                 
          case 'Manager':
                    
                    $groupid=Yii::app()->user->groupid;
                      $group=Groups::model()->findByPk($groupid);
                      $group_name=$group->group_name;
 								
                  if(($group_name=='Discipline'))
                    {
                    	$teacher_id=0;
                          
                          $person_ID=Persons::model()->getIdPersonByUserID($userid);
					      $person_ID= $person_ID->getData();
					                    
					         foreach($person_ID as $c)
					            $teacher_id= $c->id;
                   
                   $this->widget('zii.widgets.CMenu', array(
					'activeCssClass'=>'active',
					'encodeLabel'=>false,
					'activateParents'=>true,
					'items'=>array(
					
					 
					
					array('label'=>'<span class="fa fa-2y" style="font-size: 23px;">  '.Yii::t('app','Users').'</span> ',
					//'linkOptions'=>array('id'=>'menuAcademicSettings'),
					//'itemOptions'=>array('id'=>'itemAcademicSettings'),
					
					'items'=>array(
					    
						array('label'=>'<span class=""> '.Yii::t('app','Change password').'</span>', 'url'=>array('/users/user/changePassword?id='.$userid.'&from=user')),
							
							array('label'=>Yii::t('app','Edit personal Info'),'url'=>array('/academic/persons/viewForUpdate?id='.$teacher_id.'&from=user')),

			                       
			            
			          )),
					
					)));

                     }
                   elseif(($group_name=='Pedagogie'))
                    {
                    	$teacher_id=0;
                          
                          $person_ID=Persons::model()->getIdPersonByUserID($userid);
					      $person_ID= $person_ID->getData();
					                    
					         foreach($person_ID as $c)
					            $teacher_id= $c->id;
                         
                            if(isset($_GET['from']))
                             {
				                if(($_GET['from']=='oth')||($_GET['from']=='user'))
				                  {   $this->widget('zii.widgets.CMenu', array(
									'activeCssClass'=>'active',
									'encodeLabel'=>false,
									'activateParents'=>true,
									'items'=>array(
									
									 
									
									array('label'=>'<span class="fa fa-2y" style="font-size: 23px;">  '.Yii::t('app','Users').'</span> ',
									//'linkOptions'=>array('id'=>'menuAcademicSettings'),
									//'itemOptions'=>array('id'=>'itemAcademicSettings'),
									
									'items'=>array(
									    
									    
										array('label'=>'<span class=""> '.Yii::t('app','Change password').'</span>', 'url'=>array('/users/user/changePassword?id='.$userid.'&from=user')),
											
											array('label'=>Yii::t('app','Edit personal Info'),'url'=>array('/academic/persons/viewForUpdate?id='.$teacher_id.'&from=user')),
				
							                       
							          
										    )),
									
									)));
									
                                   }
                                   
                               }
                             else
                               {
                               	$this->widget('zii.widgets.CMenu', array(
								'activeCssClass'=>'active',
								'encodeLabel'=>false,
								'activateParents'=>true,
								'items'=>array(
								 
								
								array('label'=>'<span class="fa fa-2y" style="font-size: 23px;"> '.Yii::t('app','School settings').'</span> ',
								//'linkOptions'=>array('id'=>'menuAcademicSettings'),
								//'itemOptions'=>array('id'=>'itemAcademicSettings'),
								
								'items'=>array(
			                            
			                        array('label'=>'<span class="fa fa-ban"> '.Yii::t('app','Infraction type').'</span>','url'=>array('/discipline/infractionType/index')),
			                        array('label'=>'<span class="fa fa-male"><span class="fa fa-male"> '.Yii::t('app','Relations').'</span></span>','url'=>array('/configuration/relations/index','mn'=>'sset')),
									array('label'=>'<span class="fa fa-sitemap"> '.Yii::t('app','Titles').'</span>','url'=>array('/configuration/titles/index','mn'=>'sset')),
									array('label'=>'<span class="fa fa-graduation-cap"> '.Yii::t('app','Qualifications').'</span>','url'=>array('/configuration/qualifications/index','mn'=>'sset')),
									array('label'=>'<span class="fa fa-book"> '.Yii::t('app','Field study').'</span>','url'=>array('/configuration/fieldstudy/index','mn'=>'sset')),
									
									//array('label'=>'<span class="fa fa-globe"> '.Yii::t('app','Portal').'</span>','url'=>array('/portal/cmsArticle/index')),
															            
								        )),
								
													
								  ))); 
                               	
                               	} 
                              

                     }
                   else
                     {
		                        
		                        
		            $this->widget('zii.widgets.CMenu', array(
					'activeCssClass'=>'active',
					'encodeLabel'=>false,
					'activateParents'=>true,
					'items'=>array(
					
					 
					
					array('label'=>'<span class="fa fa-2y" style="font-size: 23px;"> '.Yii::t('app','School settings').'</span> ',
					//'linkOptions'=>array('id'=>'menuAcademicSettings'),
					//'itemOptions'=>array('id'=>'itemAcademicSettings'),
					
					'items'=>array(
                            
                        array('label'=>'<span class="fa fa-wrench"> '.Yii::t('app','General config').'</span>','url'=>array('/configuration/generalconfig/index','mn'=>'sset')),
						 array('label'=>'<i class="fa fa-ban"></i> '.Yii::t('app','Infraction type'),'url'=>array('/discipline/infractionType/index')),
						array('label'=>'<span class="fa fa-male"><span class="fa fa-male"> '.Yii::t('app','Relations').'</span></span>','url'=>array('/configuration/relations/index','mn'=>'sset')),
						array('label'=>'<span class="fa fa-sitemap"> '.Yii::t('app','Titles').'</span>','url'=>array('/configuration/titles/index','mn'=>'sset')),
						
						array('label'=>'<span class="fa fa-graduation-cap"> '.Yii::t('app','Qualifications').'</span>','url'=>array('/configuration/qualifications/index','mn'=>'sset')),
						array('label'=>'<span class="fa fa-book"> '.Yii::t('app','Field study').'</span>','url'=>array('/configuration/fieldstudy/index','mn'=>'sset')),
						array('label'=>'<span class="fa fa-adjust"> '.Yii::t('app','Job status').'</span>','url'=>array('/configuration/jobstatus/index','mn'=>'sset')),
						//array('label'=>'<span class="fa fa-globe"> '.Yii::t('app','Portal').'</span>','url'=>array('/portal/cmsArticle/index')),
					        )),
					
										
					  ))); 
					  
                     }
                     
          
                 break;
                 
          case 'Billing':
          
                     $teacher_id=0;
                          
                          $person_ID=Persons::model()->getIdPersonByUserID($userid);
					      $person_ID= $person_ID->getData();
					                    
					         foreach($person_ID as $c)
					            $teacher_id= $c->id;
					            
                 $this->widget('zii.widgets.CMenu', array(
					'activeCssClass'=>'active',
					'encodeLabel'=>false,
					'activateParents'=>true,
					'items'=>array(
					
					 
					
					array('label'=>'<span class="fa fa-2y" style="font-size: 23px;">  '.Yii::t('app','Users').'</span> ',
					//'linkOptions'=>array('id'=>'menuAcademicSettings'),
					//'itemOptions'=>array('id'=>'itemAcademicSettings'),
					
					'items'=>array(
					    
						array('label'=>'<span class=""> '.Yii::t('app','Change password').'</span>', 'url'=>array('/users/user/changePassword?id='.$userid.'&from=user')),
							
							array('label'=>Yii::t('app','Edit personal Info'),'url'=>array('/academic/persons/viewForUpdate?id='.$teacher_id.'&from=user')),

			                       
			           
						    )),
					
					)));
          
                 break;
                 
          case 'Teacher':
                   $teacher_id=0;
                          
                          $person_ID=Persons::model()->getIdPersonByUserID($userid);
					      $person_ID= $person_ID->getData();
					                    
					         foreach($person_ID as $c)
					            $teacher_id= $c->id;
                   
                   $this->widget('zii.widgets.CMenu', array(
					'activeCssClass'=>'active',
					'encodeLabel'=>false,
					'activateParents'=>true,
					'items'=>array(
					
					 
					
					array('label'=>'<span class="fa fa-2y" style="font-size: 23px;">  '.Yii::t('app','Users').'</span> ',
					//'linkOptions'=>array('id'=>'menuAcademicSettings'),
					//'itemOptions'=>array('id'=>'itemAcademicSettings'),
					
					'items'=>array(
					    
						array('label'=>'<span class=""> '.Yii::t('app','Change password').'</span>', 'url'=>array('/users/user/changePassword?id='.$userid.'&from=user')),
							
							array('label'=>Yii::t('app','Edit personal Info'),'url'=>array('/academic/persons/viewForUpdate?id='.$teacher_id.'&from=user')),

			                       
			        
						    )),
					
					)));

                 break;
                 
                 
            case  'Information':
                   $teacher_id=0;
                          
                          $person_ID=Persons::model()->getIdPersonByUserID($userid);
					      $person_ID= $person_ID->getData();
					                    
					         foreach($person_ID as $c)
					            $teacher_id= $c->id;
                   
                   $this->widget('zii.widgets.CMenu', array(
					'activeCssClass'=>'active',
					'encodeLabel'=>false,
					'activateParents'=>true,
					'items'=>array(
					
					 
					
					array('label'=>'<span class="fa fa-2y" style="font-size: 23px;">  '.Yii::t('app','Users').'</span> ',
					//'linkOptions'=>array('id'=>'menuAcademicSettings'),
					//'itemOptions'=>array('id'=>'itemAcademicSettings'),
					
					'items'=>array(
					    
						array('label'=>'<span class=""> '.Yii::t('app','Change password').'</span>', 'url'=>array('/users/user/changePassword?id='.$userid.'&from=user')),
							
							array('label'=>Yii::t('app','Edit personal Info'),'url'=>array('/academic/persons/viewForUpdate?id='.$teacher_id.'&from=user')),

			                       
			        
						    )),
					
					)));

            
               
                 
          }

}//fen issetProfil




}

?>					 