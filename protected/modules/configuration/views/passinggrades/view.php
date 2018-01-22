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

$acad_sess=acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 


?>


<div id="dash">
		<div class="span3"><h2>
		      <?php 
		       
		       if($model->level_or_course==0)
			      {	
			      	echo Yii::t('app', 'Passing grades {name1} / {name2} ',array('{name1}'=>$model->level0->level_name,'{name2}'=>$model->academicPeriod->name_period)); 
			       }
			     elseif($model->level_or_course==1)
			       {
			       	  echo Yii::t('app', 'Passing grades {name1} / {name2} ',array('{name1}'=>$model->course0->subject0->subject_name,'{name2}'=>$model->academicPeriod->name_period)); 
			       	}	
			      	
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
                echo CHtml::link($images,array('passinggrades/create')); 
               ?>
        </div>
        <div class="span4">
             <?php
                $images = '<i class="fa fa-edit">&nbsp;'.Yii::t('app','Update').'</i>';
                echo CHtml::link($images,array('passinggrades/update/','id'=>$model->id,'from'=>'view')); 
              ?>
        </div>
        
      <?php
                 }
      
      ?>       
    
        <div class="span4">
           <?php
                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                    echo CHtml::link($images,array('passinggrades/index')); 
             ?>
        </div>
    </div>
</div>

<div style="clear:both"></div>


<div class="search-form">
    <?php
    echo $this->renderPartial('//layouts/navBaseConfiguration',NULL,true);	
    ?>
</div>
	
	
<!--IMPORTANT-->
<!-- pa efase sa, sinon lyen peryod academic nan update lan pap mache-->
	<div class="span3"></div>
<div style="clear:both"></div>

		
<?php 
 
 if($model->level_or_course==0)
   {	
			      	
	  $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			//'id',
			'level0.level_name',
			'academicPeriod.name_period',
			'minimum_passing',
	        ),
	     )); 
     }
  elseif($model->level_or_course==1)
    {
    			      	
	  $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			
			'course0.subject0.subject_name',
			
			array(
                    'name' => Yii::t('app','Teacher Name'),
                    'header'=>Yii::t('app','Teacher Name'),
                    'value'=>$model->course0->teacher0->first_name." ".$model->course0->teacher0->last_name,
                      
                ),
           array('name'=>Yii::t('app','Room'),
			'header'=>Yii::t('app','Room'),
			'value'=>$model->course0->room0->room_name,
			),
			
			'academicPeriod.name_period',
			'minimum_passing',
	        ),
	     )); 

    
     }	
			      	

?>

