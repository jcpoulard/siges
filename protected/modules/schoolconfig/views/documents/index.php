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


// PHP File Tree Demo
// For documentation and updates, visit http://abeautifulsite.net/notebook.php?article=21

// Main function file


//<link href="styles/default/default.css" rel="stylesheet" type="text/css" media="screen" />
		
//		<!-- Makes the file tree(s) expand/collapsae dynamically -->
//		<script src="php_file_tree.js" type="text/javascript"></script>
?>
	
<!-- Menu of CRUD  -->
<div id="dash">
          
          <div class="span3"><h2>
<?php echo Yii::t('app', 'View documents');?> 
</h2> </div> 
     
		   <div class="span3">
             	      
	  
                  
                <div class="span4">
                      <?php
				
                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard
                     echo CHtml::link($images,array('/academic/postulant/viewListAdmission/part/enrlis/pg')); 
                   ?>
                  </div>   


        </div>          
                           
</div>



<div style="clear:both"></div>


</br>
<div class="b_m">
<div class="form">
<?php 
$form=$this->beginWidget('CActiveForm', array(
	
)); 

?>

<?php
echo $this->renderPartial('_doc', array(
	'model'=>$model,
	'form' =>$form
	)); ?>
	



<?php $this->endWidget(); ?>


</div>
</div>

