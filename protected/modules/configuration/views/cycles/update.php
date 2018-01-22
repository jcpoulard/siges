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


	/* @var $this CyclesController */
/* @var $model Cycles */

$acad_sess=acad_sess();

?>


<div id="dash">
          
          <div class="span3"><h2>
                 <?php echo Yii::t('app','Update Cycle'); ?>
                 
           </h2> </div>
           
    <div class="span3">
<?php 
     if(!isAchiveMode($acad_sess))
        {     
        
   ?>        
         <div class="span4">
             <?php
                    $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';
                     echo CHtml::link($images,array('/configuration/cycles/create')); 
                   ?>
        </div>
<?php
        }
?>        
       <div class="span4">
           <?php
                    $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                     echo CHtml::link($images,array('/configuration/cycles/index')); 
                     $this->back_url='/configuration/cycles/index';
                    ?>
        </div>
    </div>
</div>
 


<!-- Menu of CRUD  -->


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

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cycles-form',
	'enableAjaxValidation'=>false,
)); 

echo $this->renderPartial('_form', array(
	'model'=>$model,
	'form' =>$form
	)); ?>


<?php $this->endWidget(); ?>

</div>



