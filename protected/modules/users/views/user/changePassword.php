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


<div id="dash">
  <div class="span3"><h2> <?php 
  
  if($_GET['id']!=Yii::app()->user->userid) {
      
  }else{
      echo Yii::t('app','Change password for user: {name}',array('{name}'=>$model->username));
  }
  
  ?> </h2> </div>
   
   
          
 </div>

<?php
if(isset(Yii::app()->user->profil))
  {   $profil=Yii::app()->user->profil;
     
     if(($profil!='Teacher')&&($profil!='Guest'))
      {
?>
<div style="clear:both"></div>

<div class="search-form">
    <?php
    echo $this->renderPartial('//layouts/navBaseUser',NULL,true);	
    ?>
</div>
<?php
      }
}
?>

<div style="clear:both"></div>

         
</br>
<div class="b_mail">
<div class="form">
<?php 
    
    $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	
)); 


  if($_GET['id']!=Yii::app()->user->userid)
    echo $this->renderPartial('_errorPassword', array(
							'user'=>$model,
							
							'form' =>$form
							)); 
else
    echo $this->renderPartial('_changePassword', array(
							'user'=>$model,
							
							'form' =>$form
							));
							
							

    
?>



<?php $this->endWidget(); 

?>
    


</div>

 </div>     

