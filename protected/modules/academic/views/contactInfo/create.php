<?php 
/*
 * © 2015 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
 * 
 * This file is part of SIGES.

    SIGES is a free software: you can redistribute it and/or modify
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



?>





<div id="dash">
          
         <div class="span3"><h2><?php 
          if(isset($_GET['pers'])&&($_GET['pers']!=""))
            {  $reference_lan= Persons::model()->findByPk($_GET['pers']);
            	
            	echo Yii::t('app','Create contact info for : {name}',array('{name}'=>$reference_lan->fullName)); 
            }
          else
           echo Yii::t('app','Create contact info'); 
           
      ?>
      
      </h2> </div>
     
		   <div class="span3">
             <div class="span4">

                      <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                               // build the link in Yii standard
                     if(isset($_GET['pers'])&&($_GET['pers']!=""))
                       {   
                       	    if(isset($_GET['from']))
				           { if($_GET['from']=='stud')
				                {   echo CHtml::link($images,array('/academic/persons/viewForReport?id='.$_GET['pers'].'&pg=lr&isstud=1&from=stud'));
				                    $this->back_url='/academic/persons/viewForReport?id='.$_GET['pers'].'&pg=lr&isstud=1&from=stud';
				                }
				             elseif($_GET['from']=='teach')
				               {  echo CHtml::link($images,array('/academic/persons/viewForReport?id='.$_GET['pers'].'&isstud=0&from=teach'));
				                  $this->back_url='/academic/persons/viewForReport?id='.$_GET['pers'].'&pg=lr&isstud=0&from=teach';
				               }
				                 elseif($_GET['from']=='emp')
				                    { echo CHtml::link($images,array('/academic/persons/viewForReport?id='.$_GET['pers'].'&pg=lr&from=emp')); 
				                       $this->back_url='/academic/persons/viewForReport?id='.$_GET['pers'].'&pg=lr&from=emp';
				                    }
				                     
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
                        
                         echo CHtml::link($images,array('/academic/contactInfo/index?from='.$from)); 
                       	  $this->back_url='/academic/contactInfo/index?from='.$from;                      	   
                       }
                     
                   ?>
      </div> 
    </div>
 </div>


<div style="clear:both"></div>
	

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contact-info-form',
	
)); 
echo $this->renderPartial('_form', array(
	'model'=>$model,
	'form' =>$form
	)); ?>


<?php $this->endWidget(); ?>

</div>





