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
						
  
	
	
	if(isset(Yii::app()->user->userid))
                        {
                            $userid = Yii::app()->user->userid;
                        }
                        else 
                        {
                            $userid = null;
                        }
                        
              
?>

 <div class="coontainer">
 <ul class="nav nav-tabs" role="tablist">
 
<?php    
 
                         
if(isset(Yii::app()->user->profil))
{   $profil=Yii::app()->user->profil;

   switch($profil)
     {
       
          case 'Admin':
                 
                 if(isset(Yii::app()->user->name))
		            {    
		                  
		             if(Yii::app()->user->groupid==1)
		              {
		              	  
					  echo '<li role="presentation">';
              	 	  $images = '<span class="fa fa-plus-square"></span> '.Yii::t('app','Users');
			          echo CHtml::link($images,array('/users/user/index')); 
                      echo '</li>';
                      
                      echo '<li role="presentation">';
              	 	  $images = '<span class="fa fa-plus-square"></span> '.Yii::t('app','Online users');
			          echo CHtml::link($images,array('/users/user/viewOnlineUsers')); 
                      echo '</li>';
                      
                      echo '<li role="presentation">';
              	 	  $images = '<span class="fa fa-plus-square"></span> '.Yii::t('app','Disable Users');
			          echo CHtml::link($images,array('/users/user/disableusers')); 
                      echo '</li>';
                      
                      echo '<li role="presentation">';
              	 	  $images = '<span class="fa fa-plus-square"></span> '.Yii::t('app','Groups');
			          echo CHtml::link($images,array('/users/groups/index')); 
                      echo '</li>';
                      
                      echo '<li role="presentation">';
              	 	  $images = '<span class="fa fa-plus-square"></span> '.Yii::t('app','Modules');
			          echo CHtml::link($images,array('/users/modules/index')); 
                      echo '</li>';
                      
                      echo '<li role="presentation">';
              	 	  $images = '<span class="fa fa-plus-square"></span> '.Yii::t('app','Actions');
			          echo CHtml::link($images,array('/users/actions/index')); 
                      echo '</li>';
		
		               }
		              else
		                { 
				              if(Yii::app()->user->profil=='Admin')
					              {
					              	  
									  echo '<li role="presentation">';
				              	 	  $images = '<span class="fa fa-plus-square"></span> '.Yii::t('app','Users');
							          echo CHtml::link($images,array('/users/user/index')); 
				                      echo '</li>';
				                      
				                      echo '<li role="presentation">';
				              	 	  $images = '<span class="fa fa-plus-square"></span> '.Yii::t('app','Online users');
							          echo CHtml::link($images,array('/users/user/viewOnlineUsers')); 
				                      echo '</li>';
				                      
				                      echo '<li role="presentation">';
				              	 	  $images = '<span class="fa fa-plus-square"></span> '.Yii::t('app','Disable Users');
							          echo CHtml::link($images,array('/users/user/disableusers')); 
				                      echo '</li>';
				                      
				                      echo '<li role="presentation">';
				              	 	  $images = '<span class="fa fa-plus-square"></span> '.Yii::t('app','Groups');
							          echo CHtml::link($images,array('/users/groups/index')); 
				                      echo '</li>';
				                      
				                      					
					               }
				                 else
				                  {
				                	
									  echo '<li role="presentation">';
				              	 	  $images = '<span class="fa fa-plus-square"></span> '.Yii::t('app','Users');
							          echo CHtml::link($images,array('/users/user/index')); 
				                      echo '</li>';
				                      
				                      echo '<li role="presentation">';
				              	 	  $images = '<span class="fa fa-plus-square"></span> '.Yii::t('app','Online users');
							          echo CHtml::link($images,array('/users/user/viewOnlineUsers')); 
				                      echo '</li>';
				                      
				                      echo '<li role="presentation">';
				              	 	  $images = '<span class="fa fa-plus-square"></span> '.Yii::t('app','Disable Users');
							          echo CHtml::link($images,array('/users/user/disableusers')); 
				                      echo '</li>';
                      
                    

									
				                  }
				            
		                  
		                  }
		               
		            }
		                 
                 

                 break;
                 
          case 'Teacher':
                          $teacher_id=0;
                          
                          $person_ID=Persons::model()->getIdPersonByUserID($userid);
					      $person_ID= $person_ID->getData();
					                    
					         foreach($person_ID as $c)
					            $teacher_id= $c->id;
					                       
		                
						
						echo '<li role="presentation">';
              	 	  $images = '<span class="fa fa-plus-square"></span> '.Yii::t('app','Change password');
			          echo CHtml::link($images,array('/users/user/changePassword?id='.$userid.'&from=user')); 
                      echo '</li>';
                      
                      echo '<li role="presentation">';
              	 	  $images = '<span class="fa fa-plus-square"></span> '.Yii::t('app','Edit personal Info');
			          echo CHtml::link($images,array('/academic/persons/viewForUpdate?id='.$teacher_id.'&from=user')); 
                      echo '</li>';
                      
                      
                 break;

                 
          case 'Guest':
                          $contact=null;
                          
                          $contact_ID=ContactInfo::model()->getIdContactByUserID($userid);
					      $contact_ID= $contact_ID->getData();
					                    
					         foreach($contact_ID as $c)
					            $contact= $c->id;
					    if($contact!=null)                  
		                  {
			                
							
								echo '<li role="presentation">';
              	 	  $images = '<span class="fa fa-plus-square"></span> '.Yii::t('app','Change password');
			          echo CHtml::link($images,array('/users/user/changePassword?id='.$userid.'&from=guest')); 
                      echo '</li>';
                      
                      echo '<li role="presentation">';
              	 	  $images = '<span class="fa fa-plus-square"></span> '.Yii::t('app','Edit personal Info');
			          echo CHtml::link($images,array('/guest/contactInfo/view?id='.$contact.'&from=guest')); 
                      echo '</li>';
							
		                  }
		                else
		                  {
		                	     $person_ID=Persons::model()->getIdPersonByUserID($userid);
									   $person_ID= $person_ID->getData();
											                    
									     foreach($person_ID as $c)
											$person_id= $c->id;	    
					                       

								
										echo '<li role="presentation">';
              	 	  $images = '<span class="fa fa-plus-square"></span> '.Yii::t('app','Change password');
			          echo CHtml::link($images,array('/users/user/changePassword?id='.$userid.'&from=guest')); 
                      echo '</li>';
                      
                      echo '<li role="presentation">';
              	 	  $images = '<span class="fa fa-plus-square"></span> '.Yii::t('app','Edit personal Info');
			          echo CHtml::link($images,array('/guest/persons/viewForUpdate?id='.$person_id.'&from=guest')); 
                      echo '</li>';
                      
                      
		                	}
                 break;
                 
          }

}//fen issetProfil   
    
    
?>    
    
  </ul>     
 </div>
<!-- </div> -->
