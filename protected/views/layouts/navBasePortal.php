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
                        
             
?>

 <div class="coontainer">
 
		 <ul class="nav nav-tabs nav-justified">  
		<?php
		          
		          
		             
		           
		                  
		         echo '<li class="';  if($this->part == 'pot') echo "active"; else echo ""; 
		         echo '"><a href="'.Yii::app()->baseUrl.'/index.php/portal/cmsArticle/index?part='.$this->part.'">';    
		         echo Yii::t('app','Manage article');
		         echo'</a></li>';
		         
		         echo '<li class="';  if($this->part == 'men') echo "active"; else echo ""; 
		         echo '"><a href="'.Yii::app()->baseUrl.'/index.php/portal/cmsMenu/admin?part='.$this->part.'">';    
		         echo Yii::t('app','Manage menu');
		         echo'</a></li>';
                         
                         echo '<li class="';  if($this->part == 'doc') echo "active"; else echo ""; 
		         echo '"><a href="'.Yii::app()->baseUrl.'/index.php/portal/cmsDoc/index?part='.$this->part.'">';    
		         echo Yii::t('app','Upload document');
		         echo'</a></li>';
		         
		         
		?>
		</ul>
     
 </div>
 

<!-- </div> -->
