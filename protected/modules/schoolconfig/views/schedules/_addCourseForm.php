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

?>

<div style="clear:both;"></div>
<?php echo $form->errorSummary($model); ?>


<i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php 
           $model_=new Schedules;
           $model_->attributes=NULL; 
			$model_->setAttribute('day_course',$_GET['day']);
			  
			$model__=new Rooms;
			$r=$model__->findByPk($_GET['room']);
        
			  
        echo $r->room_name.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$model_->getDay().'('.substr($_GET['t_start'],0,5).'-'.substr($_GET['t_end'],0,5).')';
	?>
</i>			

<label for="Courses"><?php echo Yii::t('app','Course'); ?></label>
  <?php 
         $modelCourse= new Courses();
	     
		 echo $form->dropDownList($modelCourse,'subject_name',$this->loadCourseByRoomId($_GET['room']));
									  			
         echo $form->error($modelCourse,'subject_name'); 
?>

	