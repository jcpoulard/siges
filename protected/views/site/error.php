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
<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name .Yii::t('app',' - Error');

?>
<?php /* @var $this Controller */ 

  
$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',));
  

?>
<?php $this->beginContent('//layouts/main'); ?>
 <div class="row-fluid">
  <div class="wrapper">

   
         			
     
    <section>
      
    <!-- Include content pages -->
         <?php //echo $content; ?>
         
    <div class="moderror">


		<div id="dash">
		   <h2><span class="fa fa-2y" style="font-size: 25px;"><?php echo Yii::t('app','Not authorized Access'); ?> </span></h2>
		    
		    
		            
		   <div class="span4">
		                  <?php
		
		                 $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
		                           // build the link in Yii standard
		                           
		                         //$url=Yii::app()->request->urlReferrer;//$_SERVER['REQUEST_URI'];//  
		                          //echo ' <FORM><INPUT Type="button" VALUE="Back" onClick="history.go(-1);return true;"></FORM>';
		                   echo ' <a href="javascript:history.back(1)">'.$images.'</a> '; //echo CHtml::link($images,array($url));
		               ?>
		        </div>
		   </div>  
		
		
		
		
		<div style="clear:both"></div>
		
<div class="warning">


		<h2><?php echo Yii::t('app','Please contact the administration'); ?></h2>
		<div class="error">
		<?php 
                echo CHtml::encode($message); 
                ?>
		

	</div><!--/span-->
	        </div>
	                 <div class="warning1">   
			
		              
		               </div>
		               


</div>

	 </section>
	 
	 
    </div>

  </div><!--/row-->


<?php $this->endContent(); ?>
		




