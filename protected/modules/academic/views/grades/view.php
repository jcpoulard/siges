
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

$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 


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
          
         
		   echo Yii::t('app','Grade for').': '. $model->student0->first_name.' '.$model->student0->last_name; 
 ?> 
    
    </h2> </div>
    
    
      <div class="span3">

 <?php 
     
     if(!isAchiveMode($acad_sess))
        {      
        
   ?>
             
           <div class="span4">

                  <?php



                     $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';

                               // build the link in Yii standard

                     echo CHtml::link($images,array('grades/create?from=stud')); 

                   ?>

              </div>

          <div class="span4">

                  <?php



                     $images = '<i class="fa fa-edit">&nbsp;'.Yii::t('app','Update').'</i>';

                               // build the link in Yii standard

                     echo CHtml::link($images,array('grades/update','id'=>$model->id,'from'=>'stud','from1'=>'view')); 

                   ?>

              </div>  
              
  <?php
        }
      
      ?>       

         
            <div class="span4">

                  <?php



                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard
                     if($_from==0)
                        echo CHtml::link($images,array('grades/index?from=stud')); 
					 elseif($_from==1)
                        echo CHtml::link($images,array('grades/listByRoom?room='.$this->room_id.'&course='.$this->course_id.'&eval='.$this->evaluation_id));
                       else
                       {
                       	  if((isset($_GET['from1']))&&($_GET['from1']=="stud"))
                       	     { 
                       	       if((isset($_GET['pg']))&&($_GET['pg']=="lr"))
                       	           echo CHtml::link($images,array('/academic/persons/listforreport?isstud=1&from=stud&pg=lr'));
                       
                       	       }
                       	}
                   ?>

            </div> 

        </div>

</div>


<div style="clear:both"></div>


<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		
		
		array(
                                    'header'=>Yii::t('app','Course name'),
                                    'name' => 'course_name',
                                    'type' => 'raw',
                                    'value'=>$model->course0->courseName,
                 ),
                 
         
         array(
                                    'header'=>Yii::t('app','Exam Name'),
                                    'name' => Yii::t('app','Exam Name'),
                                    'type' => 'raw',
                                    'value'=>$model->evaluation0->examName,
                 ),
                 
		'evaluation0.evaluation_date',
		'grade_value',
                'course0.weight',
                'comment',
            ),
)); ?>