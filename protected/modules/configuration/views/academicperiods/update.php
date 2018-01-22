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


$acad_sess=acad_sess();

$this->pageTitle = Yii::app()->name. ' - '.Yii::t('app','Update {name}',array('{name}'=>$model->name_period));

?>

	
		
		
<div id="dash">
		<div class="span3"><h2>
		      <?php echo Yii::t('app','Update {name}',array('{name}'=>$model->name_period)); ?> 
		  
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
  <?php
        }
  ?>             
                      
		        <div class="span4">
		
		                  <?php
		$images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                      if(isset($_GET['from'])){
                        
                        if($_GET['from']=='view')
                        {
                            echo CHtml::link($images,array('/configuration/academicperiods/view','id'=>$_GET['id']));
                            $this->back_url='/configuration/academicperiods/view?id='.$_GET['id'];
                        }
                      }
                      else
                        {  echo CHtml::link($images,array('/configuration/academicperiods/index'));
                           $this->back_url='/configuration/academicperiods/index';
                        }

                      // build the link in Yii standard

		
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
<!--	<div class="span3"></div> -->
<div style="clear:both"></div>



<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'academic-periods-form',
	'enableAjaxValidation'=>true,
)); 
echo $this->renderPartial('_form', array(
	'model'=>$model,
	'form' =>$form
	)); ?>



<?php $this->endWidget(); ?>

</div>

<!-- form -->


