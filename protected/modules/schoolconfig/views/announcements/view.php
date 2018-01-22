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

$acad_sess=acad_sess();
$acad=Yii::app()->session['currentId_academic_year'];

?>
    

<div id="dash">
          
          <div class="span3"><h2> <?php echo Yii::t('app','Announcements'); ?> </h2> </div>
     
		   <div class="span3">
               
        <?php 
               if(!isAchiveMode($acad_sess))
                 {         
        ?>
               
                <div class="span4">

                  <?php

                     $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';

                               // build the link in Yii standard

                     echo CHtml::link($images,array('announcements/create')); 

                   ?>

              </div>    
            <div class="span4">

                      <?php

                     $images = '<i class="fa fa-edit">&nbsp;'.Yii::t('app','Update').'</i>';

                               // build the link in Yii standard

                     echo CHtml::link($images,array('announcements/update/','id'=>$model->id)); 

                     ?>

              </div>    


      <?php
                 }
      
      ?>       

     <div class="span4">

                  <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                               // build the link in Yii standard

                     echo CHtml::link($images,array('announcements/index')); 

                   ?>

            </div> 



       </div>
</div>

<div style="clear:both"></div>
<div id="dash" style="width:auto; float:left;">
		<h2><span class="fa fa-2y" style="font-size: 19px;">
                    <?php echo $model->title; ?></span></h2> </div>

<div style="clear:both"></div>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
        
	'attributes'=>array(
		
		'title',
                array('name'=>'description','type'=>'html'),
		
		'create_by',
		
	),
)); ?>
