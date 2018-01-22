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


/* @var $this StudentOtherInfoController */
/* @var $model StudentOtherInfo */



?>

<!-- Menu of CRUD  -->
<div id="dash">
          
          <div class="span3"><h2>
              <?php echo Yii::t('app','Create more info for student'); ?> 
          </h2> </div>
          
      <div class="span3">
             <div class="span4">
                      <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                               // build the link in Yii standard
                     
                     if(isset($_GET['from']))
                      {
                        if($_GET['from']=='view')
                          {
                            echo CHtml::link($images,array('/academic/studentOtherInfo/view','id'=>$_GET['id'],'from'=>'stud'));
                            $this->back_url='/academic/studentOtherInfo/view?id='.$_GET['id'].'&from=stud';
                          }
                        elseif($_GET['from']=='stud')
                          {
                          	 if(isset($_GET['stud'])&&($_GET['stud']!=""))
                          	   { echo CHtml::link($images,array('/academic/persons/viewForReport?id='.$_GET['stud'].'&pg=lr&isstud=1&from=stud'));
                          	      $this->back_url='/academic/persons/viewForReport?id='.$_GET['stud'].'&pg=lr&isstud=1&from=stud';
                          	   }
                          	 
                          	}
                         
                          
                      }
                      else
                       {  echo CHtml::link($images,array('/academic/studentOtherInfo/index?from=stud'));
                         $this->back_url='/academic/studentOtherInfo/index?from=stud';   
                       }
                        
 
                   ?>
      </div> 
    </div>
</div>


<div style="clear:both"></div>


<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'student-other-info-form',
	
)); 

 echo $this->renderPartial('_form', array(
	'model'=>$model,
	'form' =>$form
	)); ?>


<?php $this->endWidget(); ?>

</div>


