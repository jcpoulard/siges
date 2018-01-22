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
 *//* @var $this ScholarshipholderController */
/* @var $model ScholarshipHolder */

   
	
	$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

?>


<div id="dash">
          
          <div class="span3"><h2>
               <?php 
               
               echo CHtml::link($model->student0->fullName,Yii::app()->createUrl("/academic/persons/viewForReport",array("id"=>$model->student0->id,"pg"=>"lr","pi"=>"no","isstud"=>1,"from"=>"stud")));
                         
                  ?>
               
          </h2> </div>
     
		   <div class="span3">
  <?php 
     
     if(!isAchiveMode($acad_sess))
        {     
        
   ?>
             
            <?php if(infoGeneralConfig('grid_creation')!=null){ ?>
 <div class="span4">
              <?php

                 $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';
                           // build the link in Yii standard
                  echo CHtml::link($images,array('/billings/scholarshipholder/massAddingScholarship'));//echo CHtml::link($images,array('/billings/scholarshipholder/create')); 
               ?>
   </div>
     <?php } ?>

              
              <div class="span4">

                      <?php

                     $images = '<i class="fa fa-edit">&nbsp;'.Yii::t('app','Update').'</i>';

                               // build the link in Yii standard

                     echo CHtml::link($images,array('/billings/scholarshipholder/update/','id'=>$model->id,'from'=>'v'));

                     ?>

              </div> 
   <?php
        }
      
      ?>       
            
              <div class="span4">

                  <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard

                     echo CHtml::link($images,array('/billings/scholarshipholder/index')); 

                   ?>

            </div> 

        </div>
  </div>



<div style="clear:both"></div>



<br/>
  <?php
    echo $this->renderPartial('//layouts/navBaseBilling',NULL,true);	
    ?>




<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		
		array('name'=>'sponsor',
			'value'=>$model->Partner,
			  
            ),
            
		'percentage_pay',
		'IsInternal',
		array('name'=>Yii::t('app','Room name'),// 'room_name',
			'header'=>Yii::t('app','Room name'), 
			'value'=>$model->student0->getRooms($model->student,$acad_sess)
			),
		'academicYear.name_period',
		'date_created',
		
		'create_by',
		
	),
));

?>
