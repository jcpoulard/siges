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
          
          <div class="span3"><h2>
<?php echo Yii::t('app','Course {name}',array('{name}'=>$model->courseName));?>
</h2> </div>     
		   <div class="span3">
           
        <?php 
               if(!isAchiveMode($acad_sess))
                 {     $template ='';    
        ?>
           
             <div class="span4">

                  <?php

                     $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';


                               // build the link in Yii standard
                    if((isset($_GET['from']))&&($_GET['from']=='teach'))
                        echo '';
                    else
                        echo CHtml::link($images,array('courses/create')); 

                   ?>

              </div>
              
        
	   <div class="span4">

                      <?php

                     $images = '<i class="fa fa-edit">&nbsp;'.Yii::t('app','Update').'</i>';

                               // build the link in Yii standard

                     if((isset($_GET['from']))&&($_GET['from']=='teach'))
					    echo CHtml::link($images,array('courses/update/','id'=>$model->id,'pers'=>$_GET['pers'],'isstud'=>0,'from'=>'teach'));
                       else
					    echo CHtml::link($images,array('courses/update/','id'=>$model->id,'from1'=>'view')); 

                     ?>

              </div>    

      <?php
                 }
      
      ?>       



             <div class="span4">
                  <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';


                               // build the link in Yii standard
                        if((isset($_GET['from']))&&($_GET['from']=='teach'))
					     echo CHtml::link($images,array('persons/viewForReport?id='.$_GET['pers'].'&isstud=0&from=teach'));
                            else
					    echo CHtml::link($images,array('courses/index'));

                   ?>

            </div> 


       </div>

</div>



<div style="clear:both"></div>




<?php 
     $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		
		'subject0.subject_name',
		'teacher0.fullName',
		'room0.room_name',
		'academicPeriod.name_period',
		'weight',
		 array('name'=>'debase',
                 'header'=>Yii::t('app','De base'),
                 'value'=>'$data->Debase',
                 ),
         array('name'=>'optional',
                 'header'=>Yii::t('app','Optional'),
                 'value'=>'$data->Optional',
                 ),   
		
           
		
	),
)); ?>

