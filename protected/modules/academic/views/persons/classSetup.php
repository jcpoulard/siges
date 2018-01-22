<?php 
/*
 * © 2010 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
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

?>
<?php

$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',));
 
$acad=Yii::app()->session['currentId_academic_year']; 


?>



<?php

		Yii::app()->clientScript->registerScript('search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('persons-grid', {
data: $(this).serialize()
});
				return false;
				});
			");
		?>
		
		
	<!-- Menu of CRUD  -->

<div id="dash">
          
          <div class="span3"><h2>
          
            <?php
			echo Yii::t('app','Class setup list'); 
			 ?>   
    </h2> </div>
    
      <div class="span3"> 
        
		<!-- 	 <div class="span4">

                      <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard

                       if(isset($_GET['pg']))
					     {  if($_GET['pg']=='lr')
							  { echo CHtml::link($images,array('/academic/persons/listForReport','isstud'=>1,'from'=>'stud'));
							    $this->back_url='/academic/persons/listForReport?isstud=1&from=stud';
							  }
							elseif($_GET['pg']=='lrl')
							      { echo CHtml::link($images,array('/academic/persons/list','isstud'=>1,'pg'=>'lr','from'=>'stud'));
							         $this->back_url='/academic/persons/list?isstud=>1&pg=lr&from=stud';
							      }
								 elseif($_GET['pg']=='l')
							      { echo CHtml::link($images,array('/academic/persons/list','isstud'=>1,'from'=>'stud'));
							         $this->back_url='/academic/persons/list?isstud=1&from=stud';
							      }
							    
						 }
					   else
						{ echo CHtml::link($images,array('/academic/persons/listForReport?isstud=1&from=stud'));
						  $this->back_url='/academic/persons/listForReport?isstud=1&from=stud';
						}
																 

                   ?>

                  </div>  
        -->

        </div>

 </div>



<div class="clear"></div>	
			
<div class="form">
				
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'class-setup-form',
	
)); 
   
echo $this->renderPartial('_classSetup', array(
	'model'=>$model,
	'form' =>$form
	)); ?>

<div class="row buttons">
	
</div>

<?php $this->endWidget(); ?>

	
</div>