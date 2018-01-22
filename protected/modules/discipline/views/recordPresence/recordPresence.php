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
	      echo Yii::t('app','Record attendance '); 
		?>
              
        </h2> </div>
          <?php if($this->room_atten!=null) {?>
    <div class="span3">
             <div class="span4">

                      <?php
                        
                     $images = '<i class="fa fa-file-o"> &nbsp;'.Yii::t('app','Attendance Journal').'</i>';

                               // build the link in Yii standard

                                echo CHtml::link($images,array("/discipline/recordPresence/admin?room=$this->room_atten")); 
                                $this->back_url='/discipline/recordPresence/index';   
                     
                   ?>

                  </div> 
    
         </div>
    
          <?php } ?>       
      <div class="span3">
             <div class="span4">

                      <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard

                                echo CHtml::link($images,array('/discipline/recordPresence/index')); 
                                $this->back_url='/discipline/recordPresence/index';   
                     
                   ?>

                  </div> 
    
         </div>
 </div>
 





<div style="clear:both"></div>				
				

</br>
<div class="b_mail">
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'reportCard-form',
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
	
)); 
echo $this->renderPartial('_recordPresence', array(
	'model'=>$model,
	'form' =>$form
	)); ?>


<?php $this->endWidget(); ?>

</div>
</div>
