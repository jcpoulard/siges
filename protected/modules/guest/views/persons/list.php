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
$this->breadcrumbs=array(
     Yii::t('app','Persons')=>array('index'),
	  Yii::t('app', 'List'),
);


?>




<?php

		Yii::app()->clientScript->registerScript('search', "
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
    
  <?php
			if((isset($_GET['isstud'])) && ($_GET['isstud']==1)) echo '<div class="span3"><h2>'.Yii::t('app','List Students').'</h2> </div>'; 
			 ?>   
   
                  <div class="icon-dash">

                      <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';


                               // build the link in Yii standard

                     if(isset($_GET['pg']))
					     {  if($_GET['pg']=='lr')
							  echo CHtml::link($images,array('listForReport','isstud'=>1,'from'=>'stud'));
							elseif($_GET['pg']=='ralr')
							       echo CHtml::link($images,array('roomAffectation','isstud'=>1,'pg'=>'lr','from'=>'stud'));
							    
						 }
					   else
						 echo CHtml::link($images,array('persons/listForReport?isstud=1&from=stud')); 

                   ?>

                  </div>  



			  
  
			  
 		  
			  
			  
 <div class="icon-dash">

                  <?php

                     $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';

                               // build the link in Yii standard
                    if((isset($_GET['isstud'])) && ($_GET['isstud']==1)) 
                     { 
                        echo CHtml::link($images,array('persons/create?isstud=1')); 
					 }
					 else
					   {
						    echo CHtml::link($images,array('persons/create')); 
					   }

                   ?>

              </div> 
			 


 </div>




<div style="clear:both"></div>	
			
			
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'persons-form',
	'enableAjaxValidation'=>true,
)); 
   
echo $this->renderPartial('_list', array(
	'model'=>$model,
	'form' =>$form
	)); ?>

<div class="row buttons">
	
</div>

<?php $this->endWidget(); ?>

	
</div>