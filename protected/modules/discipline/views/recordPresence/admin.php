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
 
 $acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 



?>

<div id="dash">
   <div class="span3"><h2>
          <?php 
          $room_val;
          $room_v;
          if(isset($_GET['room']))
           {
              
              $room_v = $_GET['room'];
             if($room_v > 0)
              {
               
		          $room = Rooms::model()->getInfoRoom($room_v)->getData();
		        
		          foreach($room as $r){
		              if($r->room_name!=null)
		                $room_val = $r->room_name;
		              else $room_val = "N/A";
                    }
          
                 echo Yii::t('app','Attendance report for {room_name}',array('{room_name}'=>$room_val)); 
              }
             else
               echo Yii::t('app','Attendance report');
             
          }else{
              echo Yii::t('app','Attendance report for '); 
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
                           // build the link in Yii standard
                 echo CHtml::link($images,array('recordPresence/recordPresence'));
                 
                   ?>
  		</div> 
  
   <?php 
     
        }    
        
   ?>	
  		<div class="span4">
                  <?php

                 $images = '<i class="fa fa-eye">&nbsp;'.Yii::t('app','Search').'</i>';
                           // build the link in Yii standard
                 echo CHtml::link($images,array('recordPresence/index'));
                 
                   ?>
  		</div> 
 
 
          
               <div class="span4">
              <?php

                  $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                           // build the link in Yii standard
                 echo CHtml::link($images,array('/discipline/recordPresence/index')); 

               ?>
          </div>
   </div>

</div>


<div style="clear:both"></div>

<?php echo $this->renderPartial('_view', array(
	'model'=>$model,
	
	)); ?>
