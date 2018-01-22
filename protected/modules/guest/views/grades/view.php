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
			




		
<div id="dash">
		<div class="span3"><h2>
<?php  $_from=-1;      if(isset($_GET['room']))
							      $this->room_id=$_GET['room'];
							if(isset($_GET['course']))
							      $this->course_id=$_GET['course'];
							if(isset($_GET['eval']))
							      $this->evaluation_id=$_GET['eval'];
							if(isset($_GET['from']))
							      $_from=$_GET['from'];
          
		   echo Yii::t('app','{name} \'s Grade for ',array('{name}'=>$model->course0->subject0->subject_name)). $model->student0->first_name.' '.$model->student0->last_name; 
 ?> 
</h2> </div>
      <div class="span3">
             <div class="span4">
                  <?php



                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';


                               // build the link in Yii standard
                    
                        echo CHtml::link($images,array('/guest/grades/index')); 
					                        
                   ?>

            </div> 

       </div>
</div>
 
<div style="clear:both"></div>	


<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		
		
		'course0.courseName',
                'evaluation0.examName',
		'evaluation0.evaluation_date',
		'grade_value',
                'course0.weight',
            ),
)); ?>