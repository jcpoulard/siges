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
/* @var $this MenfpGradesController */
/* @var $model MenfpGrades */
 	
	$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

 
 $acad_name=Yii::app()->session['currentName_academic_year'];


 $student_id = 0;
    $birthday = '0000-00-00';
     $image='';
 
   
       	  if(isset($_GET['id']))
      	    {  $student_id = $_GET['id'];
      	       
      	       $student=Persons::model()->findByPk($student_id);
      	   
      	       $birthday = $student->birthday;
      	       
      	       $image= $student->image;
      	       $full_name = $student->fullName;
      
      	   
      	    }
  

?>

<div id="dash">
          
          <div class="span3"><h2>
               <?php  
                     echo CHtml::link($full_name,Yii::app()->createUrl("/academic/persons/viewForReport",array("id"=>$student_id,"pg"=>"parlis","pi"=>"no","isstud"=>1,"from"=>"stud")));                     
                     
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
                     echo CHtml::link($images,array('/academic/menfpGrades/create/part/parlis/'));
                        	
                   ?>

              </div>
              
<?php

          
        }
      ?>       

  
              <div class="span4">

                  <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard
                       echo CHtml::link($images,array('/academic/menfpGrades/index/part/parlis/from/'));
                        

                   ?>

            </div> 

        </div>
  </div>



<div style="clear:both"></div>





<!-- La ligne superiure  -->


<div class="row-fluid">
<div id="dash">
		<h2><span class="fa fa-2y" style="font-size: 19px; margin-left:15px;"><?php echo Yii::t('app','MENFP examen detail'); ?></span></h2> </div>
    
<div class="span5 grid-view" style="margin-top:-14px;">	
<?php
        $this->widget('groupgridview.GroupGridView', array(
	'id'=>'menfp-grades-grid',
	'summaryText'=>'',
	//'mergeColumns'=>array('student0.fullName', 'academic_period','level'),
	'dataProvider'=>$model->searchByStudent($student_id,$acad_sess),
	
	'columns'=>array(
		
		array('name'=>'subject',
			'header'=>Yii::t('app','Subject'), 
			'type' => 'raw',
                    'value'=>'$data->menfpExam->subject0->subject_name',
                 ),   
        
        'grade',		
		
		
	),
)); 

?>
</div>

<div class="span3 grid-view">
<div class="">
<?php 
    $modelDecision= new MenfpDecision;
    $modelDecision = MenfpDecision::model()->findByAttributes(array('student'=>$student_id,'academic_year'=>$acad_sess));
    
    $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$modelDecision,
	'attributes'=>array(
		//'id',
		'total_grade',
		'average',
		'mention', 
	
	),
));
    
   

   ?>


</div>  
          
    
<div class="photo_view">
    <?php
    $modelStud = new Persons;
   

    if($modelStud->ageCalculator($birthday)!=null)
         	  echo '<strong>'.$modelStud->ageCalculator($birthday).Yii::t('app',' yr old').' / '.$modelStud->getRooms($student_id, $acad_sess).'</strong>';
         	else
         	  echo $modelStud->getRooms($student_id, $acad_sess).' ';
    if($image!=null)
                        //if(file_exists(Yii::app()->basePath .'/../photo-Uploads/1/'.$model->image)) // if pdf file exist, allowlink to print it 
                                     echo CHtml::image(Yii::app()->request->baseUrl.'/documents/photo-Uploads/1/'.$image);
                                else         
                                    echo CHtml::image(Yii::app()->request->baseUrl.'/css/images/no_pic.png');
    ?>


    
</div>

</div>
      
</div>



