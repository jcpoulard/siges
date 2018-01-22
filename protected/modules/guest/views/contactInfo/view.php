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



?>


		
<div id="dash">
		<div class="span3"><h2>
 <?php echo Yii::t("app","Update personal info"); ?> </h2> </div>
      <div class="span3">
             <div class="span4">
                  <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';


                               // build the link in Yii standard

                     if(isset($_GET['pers'])&&($_GET['pers']!=""))
                      {   if(isset($_GET['from']))
				           { if($_GET['from']=='stud')
				                   echo CHtml::link($images,array('/guest/persons/viewForReport?id='.$_GET['pers'].'&pg=lr&isstud=1&from=stud'));
				             elseif($_GET['from']=='teach')
				                 echo CHtml::link($images,array('/guest/persons/viewForReport?id='.$_GET['pers'].'&pg=lr&isstud=0&from=teach'));
				                 elseif($_GET['from']=='emp')
				                     echo CHtml::link($images,array('/guest/persons/viewForReport?id='.$_GET['pers'].'&pg=lr&from=emp')); 
				                     
				           }   
				                   
                      }
                      else        
                        echo CHtml::link($images,array('../site/index')); 

                   ?>

            </div> 

       </div>

</div>
 
<div style="clear:both"></div>	


<?php 

if(isset($_GET['id'])){
    $id_person = $_GET['id'];
    $data = User::model()->findAllBySql("SELECT id FROM users where person_id = (SELECT person from contact_info where id = $id_person)");
    
    $compteur=0;
    foreach($data as $d){
       
        if($d->id == Yii::app()->user->userid){
            
            $compteur = 1;
        }
    }
   
    
}

if($compteur==1){

 $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		
		array('label'=>Yii::t('app','Student name'),'name'=>'person0.fullName'),
		'contact_name',
		'contactRelationship.relation_name',
				
	),
)); 

 $this->widget('editable.EditableDetailView', array(
	
	'data'=>$model,
	'url'=>$this->createUrl('contactInfo/updateParent'), // Action dans le controller pour enregistrer
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
 
}else
{
   
    Yii::app()->user->setFlash(Yii::t('app','Violation'), Yii::t('app','{name}, You tried to violate your access level !',array('{name}'=>Yii::app()->user->fullname)));
   $this->redirect(Yii::app()->user->returnUrl);
}
 
 ?>
