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
$this->pageTitle = Yii::app()->name . ' - '.Yii::t('app','Create School Departments');


?>



 


<!-- Menu of CRUD  -->

<div id="dash">
          
          <div class="span3"><h2>
               <?php echo Yii::t('app','Create School Departments'); ?>
               
          </h2> </div>
          
          
      <div class="span3">
             <div class="span4">

                                        <?php
                        $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard

                     echo CHtml::link($images,array('/configuration/departmentInSchool/index')); 
                      $this->back_url='/configuration/departmentInSchool/index';
                   ?>
              </div>
        </div>
 </div>

 
 
<div style="clear:both"></div>



<!--IMPORTANT-->
<!-- pa efase sa, sinon lyen peryod academic nan update lan pap mache-->
<!--	<div class="span3"></div> -->
<div style="clear:both"></div>

</br>
<div class="b_mail">
	
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'departmentInSchool-form',
	
)); 
echo $this->renderPartial('_form', array(
	'model'=>$model,
	'form' =>$form
	)); ?>


<?php $this->endWidget(); ?>

</div> 

</div>




