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
/* @var $this HomeworkSubmissionController */
/* @var $model HomeworkSubmission */



$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',));
    
$acad=Yii::app()->session['currentId_academic_year']; 

?>

		
<div id="dash">
		<div class="span3"><h2>
		     <?php 
		     
		          
		          $info_homework= explode('-',substr($model->homework->course0->courseName, 0));
		          
		           $info_homework2= explode('[',substr($model->homework->course0->courseName, 0));
               $course=$info_homework[0].'['.$info_homework2[1];
               
		        echo Yii::t('app','Submited Homework for ').': '.$course ?>
		    
		</h2> </div>
		
		<div id="dash" style="width:auto;margin-top:20px; margin-left:5px;">
		 <span class="fa fa-2y" style="font-size: 19px;"> 
		     
               <?php   
                  $time = strtotime($model->homework->given_date);
                        $month=date("m",$time);
                         $year=date("Y",$time);
                         $day=date("j",$time);
                         
            $date = $day.'/'.$month.'/'.$year;         
                     echo '('.$date.')';
				   ?>

          </span>  </div>
     
		   <div class="span3">
              
             <div class="span4">
                  <?php

                 $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                           // build the link in Yii standard
                    
				    echo CHtml::link($images,array('/guest/homeworkSubmission/index/isstud/1/from/stud'));
				                                  
               ?>
             </div>  
      </div>

</div>

<div style="clear:both"></div>



<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		
		array(
                                    'header'=>Yii::t('app','Homework'),
                                    'name' => 'homework_id',
                                    'type' => 'raw',
                                    'value'=>$model->homework->title,
                 ),

		
		array('name'=>'date_submission','value'=>$model->dateSubmission),
		'comment',
		
	),
)); 

 $person_id='';   
           	
           	 $pers=User::model()->getPersonByUserId(Yii::app()->user->userid);
				 $pers=$pers->getData();
				 foreach($pers as $p)
				      $person_id=$p->id;
				
				
$path=$this->getPath($person_id);


echo '<div style="clear:both"><iframe src="'.Yii::app()->baseUrl.'/ViewerJS/#../documents/homework_submission/'.$path.'/'.$model->attachment_ref.'" width=\'90%\' height=\'650\' allowfullscreen webkitallowfullscreen ></iframe></div> '; //height=\'350\' allowfullscreen webkitallowfullscreen ></iframe></div> ';
 


?>
