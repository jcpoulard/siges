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
/* @var $this ExamenMenfpController */
/* @var $model ExamenMenfp */

// Uncomment the following line if AJAX validation is needed

$acad_sess=acad_sess();  		
?>

<div id="dash">
          
          <div class="span3"><h2>
              <?php echo Yii::t('app','Update MENFP subjects');?>
              
          </h2> </div>
   
    <div class="span3">
    
    <?php
        if(!isAchiveMode($acad_sess))
         {   
    ?>
        <div class="span4">
             
        
           <?php
                    $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Add').'</i>';
                     echo CHtml::link($images,array('/academic/examenMenfp/create/part/emlis')); 
                    
                    ?>
        </div>
  <?php
         }
  ?>

      <div class="span4">
             
        
           <?php
                    $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                     echo CHtml::link($images,array('/academic/examenMenfp/index/part/emlis')); 
                    
                    ?>
        </div>


    </div>
</div>


<div style="clear:both"></div>


<div class="b_mail">

<div class="form">

<?php 



$form=$this->beginWidget('CActiveForm', array(
	'id'=>'examen-menfp-form',
	
)); 
echo $this->renderPartial('_form_u', array(
	'model'=>$model,
	'form' =>$form
	)); ?>


<?php $this->endWidget(); ?>

</div>


</div>
