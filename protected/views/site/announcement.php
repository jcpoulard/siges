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
  $baseUrl = Yii::app()->baseUrl; 
  $cs = Yii::app()->getClientScript();
  $cs->registerScriptFile($baseUrl.'css/js/html5.js');
?> 



<?php $this->beginWidget(
    'bootstrap.widgets.TbModal',
    array('id' => 'myModal')
); ?>
 
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h4 id="myModalHeader">Modal header</h4>
    </div>
 
    <div class="modal-body" id="myModalBody">
        <p>One fine body...</p>
    </div>
 
    <div class="modal-footer">
        <?php $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'label' => Yii::t('app','Close'),
                'url' => '#',
                'htmlOptions' => array('data-dismiss' => 'modal'),
            )
        ); ?>
    </div>
 
<?php $this->endWidget(); ?>

    <?php
    
    $annonces_ = Announcements::model()->findAllBySql("SELECT * FROM announcements ORDER BY create_time DESC LIMIT 3");
    
    ?>



<!-- Annonces de l'ecole -->

 <div class="box2 box2-default" style="overflow:scroll; height: 100%; max-height:800px;">    
     


	         <div class="navbar-inner box-header">
	             <h2 class="box-title navbar-inner"><span class="fa fa-bell fa-1.5x"> &nbsp; <?php echo Yii::t('app','Announcements'); ?></span></h3>
	         </div>

	         <div class="box-content">
	            
	             <?php foreach($annonces_ as $a) { ?>
	           
		          <div class="nav nav-tabs">
		                 <h3><a class="fa fa-tags">&nbsp;<?php echo $a->title; ?></a></h3>
		                 <p class="news-item-preview"> <?php echo $a->description; ?></p>
				           <div style="text-align: right; display: block; clear: both;"><h9><?php echo Yii::t('app','Publish at: ').$a->publishDate; ?></h9></div>
	          	</div>
	            
	             <?php }?>
	           
    </div>
  
     
        
 </div> <!--end class span-->

