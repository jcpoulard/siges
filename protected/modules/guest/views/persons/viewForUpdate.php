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

<div id="dash">
		<div class="span3"><h2> <?php  echo ''.Yii::t('app','Basic info update').'';  ?>
</h2> </div>
    	
 </div>	
 <div style="clear:both"></div>

			
			
<?php




?>




<?php

if(isset($_GET['id'])){
    $id_person = $_GET['id'];
    $data = User::model()->findAllBySql("SELECT id FROM users where person_id = $id_person");
    
    $compteur=0;
    foreach($data as $d){
       // echo $d->id;
        if($d->id == Yii::app()->user->userid){
            
            $compteur = 1;
        }
    }
   
    
}

if($compteur==1){

  echo '<div class="CDetailView_photo" >';
		    
		     $this->widget('zii.widgets.CDetailView', array(
				'data'=>$model,
				'attributes'=>array(
					'last_name',
					'first_name',
					array(
							'name'=>'gender',
							'value'=>$model->getGenders1(),
						),
					
					
				),
			)); 
          
     
			$this->widget('editable.EditableDetailView', array(
				
				'data'=>$model,
				'url'=>$this->createUrl('persons/updateMyInfo'), // Action dans le controller pour enregistrer
				'params'=>array('YII_CSRF_TOKEN'=>Yii::app()->request->csrfToken),
				'emptytext'=>Yii::t('app','no value'),
				'apply'=>true,
				'attributes'=>array(
					'phone',
					'adresse',
					'email',
					
				),
			));      

		    
		    
		         echo '</div> ';
}else
{
   
    Yii::app()->user->setFlash(Yii::t('app','Violation'), Yii::t('app','{name}, You tried to violate your access level !',array('{name}'=>Yii::app()->user->fullname)));
    $this->redirect(Yii::app()->user->returnUrl);
}
?>
    
