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
          
               <?php echo Yii::t("app","View contact info for {name}",array('{name}'=>$model->person0->fullName)); ?>
               
          </h2> </div>
     
		   <div class="span3">
        
        <?php 
               if(!isAchiveMode($acad_sess))
                 {         
        ?>
            
               <div class="span4">

                  <?php

                     $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';

                               // build the link in Yii standard

                          $from='';
		                         if(isset($_GET['from']))
							      { if($_GET['from']=='stud')
										  $from ='stud';      
								     elseif($_GET['from']=='teach')
										    $from ='teach';           
										 elseif($_GET['from']=='emp')
										     $from ='emp';
							      }
							      
							  echo CHtml::link($images,array('contactInfo/create/','from'=>$from)); 

                   ?>

              </div>

          <div class="span4">

                      <?php

                     $images = '<i class="fa fa-edit">&nbsp;'.Yii::t('app','Update').'</i>';

                               // build the link in Yii standard

                      if(isset($_GET['pers'])&&($_GET['pers']!=""))
                      {   if(isset($_GET['from']))
				           { if($_GET['from']=='stud')
				                   echo CHtml::link($images,array('/academic/contactInfo/update/','id'=>$_GET['id'],'pers'=>$_GET['pers'],'from'=>'stud'));
				             elseif($_GET['from']=='teach')
				                 echo CHtml::link($images,array('/academic/contactInfo/update/','id'=>$_GET['id'],'pers'=>$_GET['pers'],'from'=>'teach'));
				                 elseif($_GET['from']=='emp')
				                     echo CHtml::link($images,array('/academic/contactInfo/update/','id'=>$_GET['id'],'pers'=>$_GET['pers'],'from'=>'emp')); 
				                     
				           }   
				                   
                      }
                      else        
                        {
                        	   $from='';
		                         if(isset($_GET['from']))
							      { if($_GET['from']=='stud')
										  $from ='stud';      
								     elseif($_GET['from']=='teach')
										    $from ='teach';           
										 elseif($_GET['from']=='emp')
										     $from ='emp';
							      }
			 
			 			   echo CHtml::link($images,array('contactInfo/update/','id'=>$model->id,'from'=>$from)); 
                        	  
                        }

                     ?>

              </div>    
      <?php
                 }
      
      ?>       
              
              <div class="span4">

                  <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard

                     if(isset($_GET['pers'])&&($_GET['pers']!=""))
                      {   if(isset($_GET['from']))
				           { if($_GET['from']=='stud')
				                   echo CHtml::link($images,array('/academic/persons/viewForReport?id='.$_GET['pers'].'&pg=lr&isstud=1&from=stud'));
				             elseif($_GET['from']=='teach')
				                 echo CHtml::link($images,array('/academic/persons/viewForReport?id='.$_GET['pers'].'&pg=lr&isstud=0&from=teach'));
				                 elseif($_GET['from']=='emp')
				                     echo CHtml::link($images,array('/academic/persons/viewForReport?id='.$_GET['pers'].'&pg=lr&from=emp')); 
				                     
				           }   
				                   
                      }
                      else        
                        { 
                          
                       	   $from='';
                         if(isset($_GET['from']))
					      { if($_GET['from']=='stud'){
								  $from ='stud'; 
                                              }
						     elseif($_GET['from']=='teach'){
                                                     $from ='teach'; }          
								 elseif($_GET['from']=='emp'){
                                                                 $from ='emp';
                                                                 
                                                                 }
					      }
                        
                         echo CHtml::link($images,array('contactInfo/index?from='.$from)); 
                           
                       	                          	   
                       }


                   ?>

            </div> 


    
       </div>
  </div>


<div style="clear:both"></div>
	


<?php 

if(isset($_GET['from']))
  { if($_GET['from']=='stud')
      {

		   $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				
				
				'contact_name',
				'contactRelationship.relation_name',
				'profession',
				'phone',
				'address',
				'email',
				array(     'header'=>Yii::t('app','Username'),
				                    'name'=>Yii::t('app','Username'),
				                    'value'=>$model->getUsername($model->id),
				                ), 
				'activeContact',
		
				
			  ),
		  ));
      }
    elseif(($_GET['from']=='teach')||($_GET['from']=='emp'))
       {
       	  $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				
				
				'contact_name',
				'contactRelationship.relation_name',
				'profession',
				'phone',
				'address',
				'email',
						
				
			  ),
		  ));
       	
       	
       	}
  }	  

 ?>
