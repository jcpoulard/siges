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
/* @var $this OtherIncomesController */
/* @var $model OtherIncomes */

$acad_sess=acad_sess();

$acad=Yii::app()->session['currentId_academic_year'];


$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); 


?>



<div id="dash">
          
          <div class="span3"><h2>
              <?php echo Yii::t('app','View of an other incomes'); ?>
              
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
                 echo CHtml::link($images,array('/billings/otherIncomes/create/part/rec/from/stud')); 
               ?>
   </div>

 <?php
        }
      
      ?>       
   
   <div class="span4">
                  <?php

                 $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                           // build the link in Yii standard
                 echo CHtml::link($images,array('/billings/billings/index/part/rec/from/stud')); 
               ?>
  </div>  


  </div>

</div>



<div style="clear:both"></div>

<?php

if(isset(Yii::app()->user->profil))
{   $profil=Yii::app()->user->profil;

if($profil!='Guest')
{ 
	             
?>
<div class="search-form">
    <?php
    echo $this->renderPartial('//layouts/navBaseBilling',NULL,true);	
    ?>
</div>


<div class="clear"></div>

<?php

}}

?>


<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id',
		'idIncomeDescription.income_description',
		'amount',
		'income_date',
		'description',
		'created_by',
		'updated_by',
	),
)); ?>
