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


$acad=Yii::app()->session['currentId_academic_year']; 
						
  
	
	
	if(isset(Yii::app()->user->userid))
       {
          $userid = Yii::app()->user->userid;
       }
     else 
       {
           $userid = null;
        }
           
      
      
      $groupid=Yii::app()->user->groupid;
		$group=Groups::model()->findByPk($groupid);
       $group_name=$group->group_name;
       
					                       
             
?>

 <div class="coontainer">
 
 <ul class="nav nav-tabs nav-justified">  
<?php
          
          
             
           
                  
         echo '<li class="';  if($this->part == 'emlis') echo "active"; else echo ""; 
         echo '"><a href="'.Yii::app()->baseUrl.'/index.php/academic/examenMenfp/index?part=emlis">';    
         echo Yii::t('app','MENFP exam list');
         echo'</a></li>';
         
         echo '<li class="';  if($this->part == 'parlis') echo "active"; else echo ""; 
         echo '"><a href="'.Yii::app()->baseUrl.'/index.php/academic/menfpGrades/index?part=parlis">';    
         echo Yii::t('app','Participant list');
         echo'</a></li>';
         
       
         
         

        
         

         
     
         
?>
</ul>
     
 </div>
 

<!-- </div> -->
