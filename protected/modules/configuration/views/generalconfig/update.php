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
/* @var $this GeneralconfigController */
/* @var $model GeneralConfig */



?>


<div id="dash">
		<div class="span3"><h2>
		     <?php echo Yii::t('app','Manage General Config'); ?> 
		     
		</h2> </div>
     
		   <div class="span3">
             <div class="span4">
                  <?php

                      $images = '<i class="fa fa-eye">&nbsp;'.Yii::t('app','View').'</i>';
                           // build the link in Yii standard
                 
                 echo CHtml::link($images,array('/configuration/generalconfig/index')); 
                    
                 
                   ?>
   </div>
               
                      
		        <div class="span4">
              <?php

                 $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                           // build the link in Yii standard
                 echo CHtml::link($images,array('/configuration/generalconfig/index'));
                 $this->back_url='/configuration/generalconfig/index';

               ?>
          </div>
   </div>

</div>

<div style="clear:both"></div>


<div class="search-form">
    <?php
    echo $this->renderPartial('//layouts/navBaseConfiguration',NULL,true);	
    ?>
</div>

	
<!--IMPORTANT-->
<!-- pa efase sa, sinon lyen peryod academic nan update lan pap mache-->
<!--	<div class="span3"></div> -->
<div style="clear:both"></div>


</br>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'general-config-form',
	'enableAjaxValidation'=>true,
)); 
       if(!isset($_GET['all']))
		  echo $this->renderPartial('_update', array(
									'model'=>$model,
									'form' =>$form
									)); 
	   elseif($_GET['all']==1)
	       echo $this->renderPartial('admin', array(
									'model'=>$model,
									'form' =>$form
									));

 ?>



<?php $this->endWidget(); ?>


</div><!-- form -->