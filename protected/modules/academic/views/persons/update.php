<?php 
/*
 * © 2010 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
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
$this->breadcrumbs=array(
	Yii::t('app','Persons')=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('app', 'Update'),
);


?>


<!-- Menu of CRUD  -->
<?php 


$acad=Yii::app()->session['currentId_academic_year'];


$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); 

?>

<div id="dash">
          
          <div class="span3"><h2>
          
   <?php        if(isset($_GET['id'])) // c 1 update
                  {  if(isset($_GET['isstud'])) 
                     {  if($_GET['isstud']==1)
                           echo Yii::t('app','Update student :').'  '.$model->first_name." ".$model->last_name; 
					 
					    elseif($_GET['isstud']==0)
						       echo Yii::t('app','Update teacher :').'  '.$model->first_name." ".$model->last_name;
					   }
					 else      
						    echo Yii::t('app','Update employee :').'  '.$model->first_name." ".$model->last_name; 
					   			  
				  }
				 else // c 1 create 
                  { if(isset($_GET['isstud'])) 
                     {  if($_GET['isstud']==1)
                           echo Yii::t('app','Create Student'); 
					 
					    elseif($_GET['isstud']==0)
						       echo Yii::t('app','Create Teacher');
					   } 
					 else      
						    echo Yii::t('app','Create Employee'); 
					   
					}
		?>
            </h2> </div>
            
      <div class="span3">
             <div class="span4">
      
                      <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard
                        
                     
					                if(isset($_GET['isstud'])) 
                                        {  
                                             if(($_GET['isstud']==1))
											   {  //update
                                                if(isset($_GET['pg']))
												   {  if($_GET['pg']=='vr')
												       { echo CHtml::link($images,array('/academic/persons/viewForReport?id='.$model->id.'&isstud=1&from=stud'));
												         $this->back_url='/academic/persons/viewForReport?id='.$model->id.'&isstud=1&from=stud';
												       }
                                                      elseif($_GET['pg']=='vrlr')
												        {  echo CHtml::link($images,array('/academic/persons/viewForReport?id='.$model->id.'&pg=lr&isstud=1&from=stud'));
												            $this->back_url='/academic/persons/viewForReport?id='.$model->id.'&pg=lr&isstud=1&from=stud';
												          }
														  elseif($_GET['pg']=='vrl')
												             {  echo CHtml::link($images,array('/academic/persons/viewForReport?id='.$model->id.'&pg=l&isstud=1&from=stud'));
												                 $this->back_url='/academic/persons/viewForReport?id='.$model->id.'&pg=l&isstud=1&from=stud';
												              }
															 if($_GET['pg']=='lr')
															  { echo CHtml::link($images,array('/academic/persons/listForReport?id='.$model->id.'&isstud=1&from=stud'));
															     $this->back_url='/academic/persons/listForReport?id='.$model->id.'&isstud=1&from=stud';
															  }
															   elseif($_GET['pg']=='l')
																 {  echo CHtml::link($images,array('/academic/persons/list?isstud=1&from=stud'));
																   $this->back_url='/academic/persons/list?isstud=1&from=stud';
																 }
																 elseif($_GET['pg']=='ext')
																   {  if(isset($_GET['from1']))
																       {  if($_GET['from1']=='rpt')
								                                            {
										                                    	echo CHtml::link($images,array('/academic/persons/listArchive?from1=rpt'));
										                                        $this->back_url='/academic/persons/listArchive?from1=rpt';
										                                      }
																        }
																   }
													}
												else //$_GET['pg'] not set
												  {
												     if(isset($_GET['from1']))
												       {  if($_GET['from1']=='rpt')
				                                            {
						                                    	echo CHtml::link($images,array('/academic/persons/listArchive?from1=rpt'));
						                                        $this->back_url='/academic/persons/listArchive?from1=rpt';
						                                      }
												        }
												      else
												        {
		                                    	          echo CHtml::link($images,array('/academic/persons/viewForReport?id='.$model->id.'&pg=lr&isstud=1&from=stud'));
													      $this->back_url='/academic/persons/viewForReport?id='.$model->id.'&pg=lr&isstud=1&from=stud';
												         
												          }
												          
	
												  }
											   }
											 elseif($_GET['isstud']==0) 
											  {
		                                         echo CHtml::link($images,array('/academic/persons/listForReport?isstud=0&from=teach'));
		                                         $this->back_url='/academic/persons/listForReport?isstud=0&from=teach';
											   }
											  elseif($model->id == null) //create
                                                 { if($_GET['isstud']==1)
													 {  if(isset($_GET['pg']))
													     {  if($_GET['pg']=='lr')
															 { echo CHtml::link($images,array('/academic/persons/listForReport?isstud=1&from=stud'));
															    $this->back_url='/academic/persons/listForReport?isstud=1&from=stud'; 
															 }
														 }
													   else
														 { echo CHtml::link($images,array('/academic/persons/listForReport?isstud=1&from=stud'));
														    $this->back_url='/academic/persons/listForReport?isstud=1&from=stud';
														   }
													 }
													elseif($_GET['isstud']==0) 
													  {  if(isset($_GET['pg']))
													     {  if($_GET['pg']=='lr')
															  { echo CHtml::link($images,array('/academic/persons/listForReport?isstud=0&from=teach'));
															    $this->back_url='/academic/persons/listForReport?isstud=0&from=teach';
															  }
														 }
													   else
 													     {  echo CHtml::link($images,array('/academic/persons/listForReport?isstud=0&from=teach'));
 													        $this->back_url='/academic/persons/listForReport?isstud=0&from=teach';
 													     }
													   
													  }
												  }
											    elseif(isset($_GET['from1']))
												   {
                                                        if($_GET['from1']=='teach_view')
                                                          {   echo CHtml::link($images,array('/academic/persons/view?id='.$model->id.'&isstud=0&from=teach')); 
                                                              $this->back_url='/academic/persons/view?id='.$model->id.'&isstud=0&from=teach';
                                                            }
                                                   }
					 
												
											   
                                           
                              } 
                              elseif(isset($_GET['from1']))
                                  {  if($_GET['from1']=='view')
	                                  { echo CHtml::link($images,array('/academic/persons/viewForReport?id='.$model->id.'&from=emp'));
	                                    $this->back_url='/academic/persons/viewForReport?id='.$model->id.'&from=emp';
	                                   }
	                                  elseif($_GET['from1']=='rpt')
	                                    {
	                                    	echo CHtml::link($images,array('/academic/persons/listArchive?from1=rpt'));
	                                        $this->back_url='/academic/persons/listArchive?from1=rpt';
	                                      }
	                                    	
	                                    	
                                    }
                                  else
                                   { echo CHtml::link($images,array('/academic/persons/listForReport?from=emp')); 
                                     $this->back_url='/academic/persons/listForReport?from=emp';   
                                   }
                                                    
						    
                                                
					   
                   ?>

                  </div>  


			  
		</div>	  
  </div>
   
</div>

<div style="clear:both"></div>





</br>
<div class="b_mail">			
<div class="form">

<?php 

  
  $form=$this->beginWidget('CActiveForm', array(
	'id'=>'persons-form',
	
	'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
      ),
)); 
echo $this->renderPartial('_form', array(
	'model'=>$model,
	'form' =>$form
	)); ?>

<div class="row buttons">
	
</div>

<?php $this->endWidget(); ?>

</div>
</div>
<!-- form -->
