
<?php 
/*
 * © 2010 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
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
		<div class="span3"><h2>
    
  <?php
			if((isset($_GET['isstud'])) && ($_GET['isstud']==1)) echo Yii::t('app','List Students'); 
			 ?>   
   </h2> </div>
   
      <div class="span3">
           


            
			 

          <div class="span4">


                      <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard

                   
                      
                      echo CHtml::link($images,array('/reports/reportcard/generalreport?from1=rpt'));
                      
                   ?>

                  </div>  

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



<?php $this->endWidget(); ?>

	
</div>