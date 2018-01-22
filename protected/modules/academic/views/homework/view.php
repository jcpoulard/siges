
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

?>

<?php
/* @var $this HomeworkController */
/* @var $model Homework */



$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',));
    
$acad=Yii::app()->session['currentId_academic_year']; 

?>

		
<div id="dash">
		<div class="span3"><h2>
		     <?php 
		     
		       echo Yii::t('app','Homework Title').': '.$model->title ?>
		    
		</h2> </div>
		
		
     
		   <div class="span3">
              
             <div class="span4">
                  <?php

                 $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                           // build the link in Yii standard
                    
				    echo CHtml::link($images,array('/academic/homework/index/isstud/1/from/stud'));
				                                  
               ?>
             </div>  
      </div>

</div>

<div style="clear:both"></div>



<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		
		array(
                                    'header'=>Yii::t('app','Course'),
                                    'name' => 'course',
                                    'type' => 'raw',
                                    'value'=>$model->course0->subject0->subject_name,
                 ),
		
		'description',
		
		array('name'=>'limit_date_submission','value'=>$model->LimitDateSubmission),
		
		array('name'=>'given_date','value'=>$model->givenDate),
		
	),
)); 




				
				
$path=$this->getPath_teacher($model->course0->room);
$ext='';
//check if extension is supported by our viewer
 $explode_fileName= explode(".",substr($model->attachment_ref, 0));  
 // Verifie qu'il y a un fichier avec une extension 
 if(isset($explode_fileName[1])){
 
        $ext=$explode_fileName[1];
 
 
 if (in_array($ext, $this->ext_allowed_by_viewer)) 
   {
    echo '<div style="clear:both"><iframe src="'.Yii::app()->baseUrl.'/ViewerJS/#../documents/homework/'.$path.'/'.$model->attachment_ref.'" width=\'90%\' height=\'650\' allowfullscreen webkitallowfullscreen ></iframe></div> '; //height=\'350\' allowfullscreen webkitallowfullscreen ></iframe></div> ';
 
   }
 else
   {   //allow downloading file.
   	    echo '<p>'.Yii::t('app','File extension is not allowed by the " viewer ".').'<a href="'.Yii::app()->baseUrl.'/documents/homework/'.$path.'/'.$model->attachment_ref.'" >'.Yii::t('app',' Click here to download.').'</a>'; echo '</p>';
   	    
   	}
        
  }else{ // Si on ne trouve pas de fichier 
       echo '<p>'.Yii::t('app','No file attached to this homework.').'</p>';
  }      





?>
