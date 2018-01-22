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


/* @var $this UserController */
/* @var $model User */



?>


<div id="dash">
		<div class="span3"><h2> <?php echo Yii::t('app','Create User'); ?> </h2> </div>
    <div class="span3">
             <div class="span4">

                  <?php
                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                               // build the link in Yii standard
                               $this->back_url='/users/user/index';
                     echo CHtml::link($images,array('/users/user/index')); 
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

</br>
<div class="b_mail">

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	
)); 

 echo $this->renderPartial('_form', array('user'=>$user,'person'=>$person,'form'=>$form)); 
 
 $this->endWidget();
 ?>
 
 
</div>
</div>

 
 
 
 
 
 
 