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

 <div class="coontainer">
 <ul class="nav nav-tabs" role="tablist">
    <li role="presentation">
        <?php    
        $images = '<span class="fa fa-plus-square"></span> '.Yii::t('app','Academic Periods');
         echo CHtml::link($images,array('/configuration/academicperiods/index')); 

         ?>
    </li>
   <li role="presentation">
        <?php    
        $images = '<span class="fa fa-plus-square"></span> '.Yii::t('app','Shifts');
         echo CHtml::link($images,array('/configuration/shifts/index')); 

         ?>
    </li>
    <li role="presentation">
        <?php    
        $images = '<span class="fa fa-plus-square"></span> '.Yii::t('app','Sections');
         echo CHtml::link($images,array('/configuration/sections/index')); 

         ?>
    </li>
    
    <li role="presentation">
        <?php    
        $images = '<span class="fa fa-plus-square"></span> '.Yii::t('app','Cycles');
         echo CHtml::link($images,array('/configuration/cycles/index')); 

         ?>
    </li>
    
   <li role="presentation">
        <?php    
        $images = '<span class="fa fa-plus-square"></span> '.Yii::t('app','Levels');
         echo CHtml::link($images,array('/configuration/levels/index')); 

         ?>
    </li>
    
   <li role="presentation">
         <?php    
        $images = '<span class="fa fa-plus-square"></span> '.Yii::t('app','Rooms');
         echo CHtml::link($images,array('/configuration/rooms/index')); 

         ?>
    </li>
    
   <li role="presentation">
         <?php    
        $images = '<span class="fa fa-plus-square"></span> '.Yii::t('app','Passing Grades');
         echo CHtml::link($images,array('/configuration/passinggrades/index')); 

         ?>
    </li>
    
    <li role="presentation">
         <?php    
        $images = '<span class="fa fa-plus-square"></span> '.Yii::t('app','Evaluations');
        echo CHtml::link($images,array('/configuration/evaluations/index')); 
        ?>
    </li>
    
    <li role="presentation">
         <?php    
        $images = '<span class="fa fa-plus-square"></span> '.Yii::t('app','Evaluation by period');
        echo CHtml::link($images,array('/schoolconfig/evaluationbyyear/index')); 
        ?>
    </li>
    
   
    
    <li role="presentation">
	         <?php    
	        $images = '<span class="fa fa-plus-square"></span> '.Yii::t('app','Observation reportcard');
	         echo CHtml::link($images,array('/configuration/reportcardObservation/index')); 

	     ?>
	    </li>
    
  </ul>     
 </div>
<!-- </div> -->
