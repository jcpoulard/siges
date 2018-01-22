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


 
$this->pageTitle=Yii::app()->name." - ".Yii::t('app','Update User: {name}',array('{name}'=>$model->full_name));
?>



<div id="dash">
		<div class="span3"><h2> <?php echo Yii::t('app','Update User: {name}',array('{name}'=>$model->full_name)); ?> </h2> </div>
    <div class="span3">
         
                  <div class="span4">

                  <?php
                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                               // build the link in Yii standard
                     echo CHtml::link($images,array('/users/user/index')); 
                     $this->back_url='/users/user/index';
                   ?>
            </div> 
          </div>
          
 </div>

<div style="clear:both"></div>

<div class="search-form">
    <?php
    echo $this->renderPartial('//layouts/navBaseUser',NULL,true);	
    ?>
</div>



<div style="clear:both"></div>

         
          
<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	Yii::t('app','Users')=>array('index'),
	$model->full_name=>array('view','id'=>$model->id),
	Yii::t('app','Update'),
);


?>

</br>
<div class="b_mail">

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	
)); 

   
if(!isset($_GET['activity']))
  echo $this->renderPartial('_formUpdate', array(
							'user'=>$model,
							'form'=>$form,
							
							
							)); 
elseif($_GET['activity']==1)
    echo $this->renderPartial('_formActive', array(
							'user'=>$model,
							'form'=>$form,
							
							));
    


$this->endWidget();
    
?>



</div>

</div>

      

