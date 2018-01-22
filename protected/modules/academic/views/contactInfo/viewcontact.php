
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
/* @var $this ContactInfoController */
/* @var $model ContactInfo */

$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

        
?>



<div id="dash">
          
          <div class="span3"><h2>
               <?php echo Yii::t("app",'My contacts info'); ?>
           
           </h2> </div>
     
		   <div class="span3">
             
    
   
              
              <div class="span4">

                  <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
   
                          	   $from='';
                         if(isset($_GET['from']))
					      { if($_GET['from']=='teach'){
								  $from ='teach'; 
                                              }
						     
					      }
                        
                         echo CHtml::link($images,array('/academic/persons/listForReport?isstud=0&from='.$from)); 
                           
                  
                   ?>

            </div> 


    
       </div>
  </div>


<div style="clear:both"></div>
	




<?php
//Select * the contact info 
$pers=User::model()->getPersonByUserId(Yii::app()->user->userid);
 $pers=$pers->getData();
 foreach($pers as $p)
      $pers_id=$p->id;



$person_contact = ContactInfo::model()->findAll(array('select'=>'*',
                                     'condition'=>'person ='.$pers_id,
                                     
                               ));

  foreach($person_contact as $contact)
  {    
  	echo '<div style="width:45%; " >';
  	 $this->widget('zii.widgets.CDetailView', array(
            'data'=>$contact,
            'attributes'=>array(
                   
                    'contact_name',
                    'contactRelationship.relation_name',
                    
                ),
          )); 
          
 
   
    if(!isAchiveMode($acad_sess))
       {       

    
			$this->widget('editable.EditableDetailView', array(
				
				'data'=>$contact,
				'url'=>$this->createUrl('contactInfo/updateMyContacts'), // Action dans le controller pour enregistrer
				'params'=>array('YII_CSRF_TOKEN'=>Yii::app()->request->csrfToken),
				'emptytext'=>Yii::t('app','no value'),
				'apply'=>true,
				'attributes'=>array(
					'profession',
					'phone',
					'address',
					'email',
					
				),
			)); 
       }
    else
      {
    	$this->widget('zii.widgets.CDetailView', array(
            'data'=>$contact,
            'attributes'=>array(
                   
                    'profession',
					'phone',
					'address',
					'email',
                    
                ),
          )); 

        } 
            
         echo '<br/>'; 
         
      echo '</div>';
            
      }
    


?>
