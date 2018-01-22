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
$this->pageTitle = Yii::app()->name.' - '.Yii::t('app','Academic period {name}',array('{name}'=>$model->name_period));
$acad_sess=acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 


?>

	




	
		
		
		
<div id="dash">
		<div class="span3"><h2>
		     <?php echo Yii::t('app','Academic period, {name}',array('{name}'=>$model->name_period)); ?> 
		
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
		
		                     echo CHtml::link($images,array('academicperiods/create')); 
		
		                   ?>
		
		              </div>
               
               <div class="span4">

		                      <?php
		
		
		
		                     $images = '<i class="fa fa-edit">&nbsp;'.Yii::t('app','Update').'</i>';
		
		                               // build the link in Yii standard
		
		                     echo CHtml::link($images,array('academicperiods/update/','id'=>$model->id,'from'=>'view')); 
		
		                     ?>
		
		                      
		
		              </div> 
      <?php
                 }
      
      ?>       

		       
		        <div class="span4">
		
		                  <?php
		
		
		
		                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
		
		                               // build the link in Yii standard
		
		                     echo CHtml::link($images,array('academicperiods/index')); 
		
		                   ?>
		      </div>
               

		              
		  </div>
		   
</div>

<div style="clear:both"></div>


<div class="search-form">
    <?php
    echo $this->renderPartial('//layouts/navBaseConfiguration',NULL,true);	
    ?>
</div>
	
	
<!--IMPORTANT-->
<!-- pa efase sa, sinon lyen peryod academic nan update lan pap mache-->

<div style="clear:both"></div>

		
    <?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				
				'name_period',
				'weight',
				array('name'=>Yii::t('app','Date Start'),'value'=>$model->dateStart),
				array('name'=>Yii::t('app','Date End'),'value'=>$model->dateEnd),
                                'isYear',
                                
				'year0.name_period',
				
			),
		)); ?>
