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
          
          
             
           
                  
         echo '<li class="';  if($this->part == 'enrlis') echo "active"; else echo ""; 
         echo '"><a href="'.Yii::app()->baseUrl.'/index.php/academic/postulant/viewListAdmission?part=enrlis">';    
         echo Yii::t('app','Enrollment list');
         echo'</a></li>';
         
         echo '<li class="';  if($this->part == 'decisi') echo "active"; else echo ""; 
         echo '"><a href="'.Yii::app()->baseUrl.'/index.php/academic/postulant/decisionAdmission?part=decisi">';    
         echo Yii::t('app','Decision');
         echo'</a></li>';
         
         echo '<li class="';  if($this->part == 'applis') echo "active"; else echo ""; 
         echo '"><a href="'.Yii::app()->baseUrl.'/index.php/academic/postulant/viewApprovePostulant?part=applis">';    
         echo Yii::t('app','Approved postulant list');
         echo'</a></li>';
         
        if( ($group_name!='Discipline') && ($group_name!='Pedagogie') )
        {
         echo '<li class="';  if($this->part == 'bill') echo "active"; else echo ""; 
         echo '"><a href="'.Yii::app()->baseUrl.'/index.php/billings/enrollmentIncome/index?part=bill&from=b">';    
         echo Yii::t('app','Cash enrollment fee');
         echo'</a></li>';
         
         echo '<li class="';  if($this->part == 'reserv') echo "active"; else echo ""; 
         echo '"><a href="'.Yii::app()->baseUrl.'/index.php/billings/reservation/index?part=reserv&from=b">';    
         echo Yii::t('app','Cash reservation');
         echo'</a></li>';
        }
         
         
         

        
         

         
     
         
?>
</ul>
     
 </div>
 

<!-- </div> -->
