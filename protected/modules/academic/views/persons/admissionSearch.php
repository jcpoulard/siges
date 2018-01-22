
<?php 
/*
 * © 2010 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
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


$acad=Yii::app()->session['currentId_academic_year'];


$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); 




Yii::app()->clientScript->registerScript('searchExStudents_', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('persons-grid', {
data: $(this).serialize()
});
				return false;
				});
			");



?>


	

	
<!-- Menu of CRUD  -->

<div id="dash">
          
          <div class="span3"><h2>

       <?php
     
		echo Yii::t('app','Add new admission'); 
		
		?>
           </h2> </div>
           
      <div class="span3">
             <div class="span4">

                      <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard
                      
                     
                      echo CHtml::link($images,array('/academic/persons/viewListAdmission'));
					
					$this->back_url='/academic/persons/viewListAdmission';

                   ?>

                  </div>  


         </div>

 </div>
 


<div style="clear:both"></div>			
				




<div class="form">

<?php 

  
  $form=$this->beginWidget('CActiveForm', array(
	'id'=>'admission-search-form',
	
	'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
      ),
)); 
echo $this->renderPartial('_admissionSearch', array(
	'model'=>$model,
	'form' =>$form
	)); ?>


<?php $this->endWidget(); ?>

</div>
