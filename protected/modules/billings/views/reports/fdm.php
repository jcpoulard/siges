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
	
			

	

	
<!-- Menu of CRUD  -->

		
<div id="dash">
		<div class="span3"><h2>
      
       <?php  
         echo Yii::t('app','Monthly declaration sheet'); 
		?>
         
        </h2> </div>
           
           
    
 </div>


<div style="clear:both"></div>


<br/>


    <?php
    echo $this->renderPartial('//layouts/navBaseBillingReport',NULL,true);	
    ?>



<div class="b_m">
<div class="form">

<?php 

 $form=$this->beginWidget('CActiveForm', array(
	'id'=>'reports-form',
	'enableAjaxValidation'=>true,
)); 

echo $this->renderPartial('_fdm', array(
	'model'=>$model,
	'form' =>$form
	)); ?>

<?php $this->endWidget(); ?>

</div>
</div>
