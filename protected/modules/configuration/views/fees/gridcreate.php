<?php

/*
 * © 2016 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
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

<div id="dash">
          
          <div class="span3"><h2>
              <?php echo Yii::t('app','Create Fees');?>
              
          </h2> </div>
   
    <div class="span3">
        <div class="span4">
             
        
           <?php
                    $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                     echo CHtml::link($images,array('/configuration/fees/index')); 
                    // $this->back_url='/configuration/reportcardObservation/index';
                    ?>
        </div>
    </div>
</div>




<div style="clear:both"></div>

</br>
<div class="b_mail">


    
    
<?php echo $this->renderPartial('_gridcreate', array('model'=>$model)); ?>

</div>