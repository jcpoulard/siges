
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
		       if((Yii::app()->user->profil!='Teacher'))
     			 {	 
		           if(isset($_GET['stud'])&&($_GET['stud']!=""))
                     {
                     	        $this->room_id= Yii::app()->session['Rooms'];
								   
								   $this->evaluation_id= Yii::app()->session['Evaluation'];
							
								   if($this->success)
								      {  
								      	$this->course_id= '';
								      }
								    else
								       $this->course_id= Yii::app()->session['Courses'];
								       
					            $this->use_update=false;
		                    if(($this->room_id!='')&&($this->course_id!='')&&($this->evaluation_id!=''))
						        {
				                     $check = $this->checkDdataByEvaluation($this->evaluation_id, $this->course_id);
							 
									 if($check)
									  { $this->use_update=true; }
										  	
						        }
						        
						        
						        
                     }					       
							
     			 }//fen  if((Yii::app()->user->profil!='Teacher'))
                else // Yii::app()->user->profil=='Teacher'
                  {
                  	   $this->room_id= Yii::app()->session['Rooms'];
								   
								   $this->evaluation_id= Yii::app()->session['Evaluation'];
							
								   if($this->success)
								      {  
								      	$this->course_id= '';
								      }
								    else
								       $this->course_id= Yii::app()->session['Courses'];
								   

					         $this->use_update=false;
		                    if(($this->room_id!="")&&($this->course_id!="")&&($this->evaluation_id!=""))
						        {
				                     $check = $this->checkDdataByEvaluation($this->evaluation_id, $this->course_id);
							 
									 if($check)
									  { $this->use_update=true; }
										  	
						        }
					  
								   
                    }// Yii::app()->user->profil=='Teacher'
                    

		
		
		?>	

<!-- Menu of CRUD  -->

		
<div id="dash">
		<div class="span3"><h2>
		     <?php echo Yii::t('app','Create Grades'); ?> 
		     
		</h2> </div>
		     
		     
      <div class="span3">
            
            

                  <?php



                     $images = '<i class="fa fa-edit">&nbsp;'.Yii::t('app','Update').'</i>';

                               // build the link in Yii standard

                      if($this->use_update)
				        {
				        	 echo '<div class="span4">';
				           echo CHtml::link($images,array('grades/update?all=1&from=stud&mn=std')); 
                            echo '</div>';
				        }
                   ?>

              

             <div class="span4">

                      <?php



                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard

                        if(isset($_GET['stud'])&&($_GET['stud']!=""))
                          {   echo CHtml::link($images,array('/academic/persons/viewForReport?id='.$_GET['stud'].'&pg=lr&isstud=1&from=stud')); 
                             $this->back_url='/academic/persons/viewForReport?id='.$_GET['stud'].'&pg=lr&isstud=1&from=stud';   
                          }
                        else
                          {  echo CHtml::link($images,array('/academic/grades/index?from=stud&mn=std')); 
                            $this->back_url='/academic/grades/index?from=stud&mn=std';   
                          }

                   ?>

                  </div> 
                    
         
           </div>
 </div>


<div style="clear:both"></div>




</br>


<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'grades-form',
	
)); 
echo $this->renderPartial('_create', array(
	'model'=>$model,
	'form' =>$form
	)); ?>
    <div class="clear"></div>


<?php $this->endWidget(); ?>

</div>

