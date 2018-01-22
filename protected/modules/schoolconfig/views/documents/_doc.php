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



  
$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',));
  
  
          
?>

<div>
  
  <ul class="nav nav-tabs nav-justified">
    <li class=<?php if($_GET['pos']=="home") echo $class="active"; else echo $class=""; ?> ><a href="<?php echo Yii::app()->baseUrl; ?>/index.php/schoolconfig/documents/index/pos/home"> <?php echo Yii::t('app','Transcript'); ?></a></li>
   <!-- <li class=<?php if($_GET['pos']=="homew") echo $class="active"; else echo $class=""; ?> ><a  href="<?php echo Yii::app()->baseUrl; ?>/index.php/schoolconfig/documents/index/pos/homew"><?php echo Yii::t('app','Homework'); ?></a></li> 
    <li class=<?php if($_GET['pos']=="photo") echo $class="active"; else echo $class=""; ?> ><a  href="<?php echo Yii::app()->baseUrl; ?>/index.php/schoolconfig/documents/index/pos/photo"><?php echo Yii::t('app','Photos'); ?></a></li>     -->
     
    
  </ul>




<div class="tab-content">
    <div id="home" class="tab-pane fade in active">
       <div style="clear:both"></div>
        
        <?php if($_GET['pos']=="home")
                include("_doc_reporcard.php");
              elseif($_GET['pos']=="photo")
                  include("_doc_photo.php"); 
                elseif($_GET['pos']=="homew")
                    include("_doc_homework.php"); 
                   
               
          ?>
        
    </div>
   
</div>
 
</div>
      
    
 


