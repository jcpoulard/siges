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

?>
    





<!-- Menu of CRUD  -->

<div id="dash">
          
<div class="span3"><h2> <?php echo Yii::t('app','Create courses'); ?></h2> </div>
     
		   <div class="span3">
             <div class="span4">

                      <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                      if(isset($_GET['from']))
                        {  if($_GET['from']=='teach')
                             {
		                        if(isset($_GET['pg']))
							     {  
									if($_GET['pg']=='vr')
									 { echo CHtml::link($images,array('/academic/persons/viewForReport?id='.$_GET['emp'].'&isstud=0&from=teach'));
									   $this->back_url='/academic/persons/viewForReport?id='.$_GET['emp'].'&isstud=0&from=teach';
									  }
										    
								  }
                                else
		                          { echo CHtml::link($images,array('/schoolconfig/courses/index/isstud/0/from/teach')); 
		                            $this->back_url='/schoolconfig/courses/index/isstud/0/from/teach'; 
		                           }
                               }
                            elseif($_GET['from']=='emp')
                             {  
                              if(isset($_GET['pg']))
							   {  
								if($_GET['pg']=='vr')
								 { echo CHtml::link($images,array('/academic/persons/viewForReport?id='.$_GET['emp'].'&from=emp'));
								   $this->back_url='/academic/persons/viewForReport?id='.$_GET['emp'].'&from=emp';
								  }
									    
								}
                             	
                             	
                              }
                               
                         }
                      else
                       {  
                          echo CHtml::link($images,array('/schoolconfig/courses/index')); 
                          $this->back_url='/schoolconfig/courses/index';
                          
                       }
                        
													
													
													
													
													
													
                   ?>

            </div>   
     </div> 

</div>



<div style="clear:both"></div>


</br>
<div class="b_mail">
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'courses-form',
	
)); 
echo $this->renderPartial('_form', array(
	'model'=>$model,
	'form' =>$form
	)); ?>


<?php $this->endWidget(); ?>

</div>
</div>
