
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

		

<!-- Menu of CRUD  -->

		
<div id="dash">
		<div class="span3"><h2>
		
		<?php $_from=-1;      if(isset($_GET['room']))
							      $this->room_id=$_GET['room'];
							if(isset($_GET['course']))
							      $this->course_id=$_GET['course'];
							if(isset($_GET['eval']))
							      $this->evaluation_id=$_GET['eval'];
							if(isset($_GET['from']))
							      $_from=$_GET['from'];
		        
				if(!isset($_GET['all']))
                                echo Yii::t('app','Update "{subject_name}" Grade for {first_name} {last_name}',array('{subject_name}'=>$model->course0->subject0->subject_name,'{first_name}'=>$model->student0->first_name,'{last_name}'=>$model->student0->last_name)); //.$model->course0->subject0->subject_name.'\'s Grade for '). $model->student0->first_name.' '.$model->student0->last_name;
	            elseif($_GET['all']==1)
                    echo Yii::t('app','Update Grades');//.$model->course0->subject0->subject_name.'\'s Grades ');


	?>  
	</h2> </div>
	
      <div class="span3">
             <div class="span4">


                      <?php



                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard
                    if(isset($_GET['all']))
					 {  if($_GET['all']==1)
							{    $this->back_url='/academic/grades/index?from=stud&mn=std';
								echo CHtml::link($images,array('/academic/grades/index?from=stud&mn=std'));
							}
                      }
					else
					  {   if($_from==1)
                            {  echo CHtml::link($images,array('/academic/grades/listByRoom?room='.$this->room_id.'&course='.$this->course_id.'&eval='.$this->evaluation_id)); 
                              $this->back_url='/academic/grades/listByRoom?room='.$this->room_id.'&course='.$this->course_id.'&eval='.$this->evaluation_id;
                            }
					    elseif($_from==0)
					      { echo CHtml::link($images,array('/academic/grades/index?from=stud&mn=std'));
					          $this->back_url='/academic/grades/index?from=stud&mn=std';
					          }
                             else {               
                             	      if(isset($_GET['from1']) && ($_GET['from1']=='view') )
                             	        {  echo CHtml::link($images,array('/academic/grades/view?d='.$model->id.'&from=0&mn=std'));
                             	            $this->back_url='/academic/grades/view?id='.$model->id.'&from=0&mn=std';
                             	          }
                                        elseif(isset($_GET['from1']) && ($_GET['from1']=='stud') )
                                           {
                                           	   if(isset($_GET['pg']) && ($_GET['pg']=='lr') )
                                           	     {  echo CHtml::link($images,array('/academic/persons/listforreport?isstud=1&from=stud&pg=lr'));
                                           	        $this->back_url='/academic/persons/listforreport?isstud=1&from=stud&pg=lr';
                                           	     }
                                           }
                                  }
						  
					  }
                   ?>

                  </div>   
         
            </div> 
 </div>




<div class="clear"></div>

</br>
<div class="b_mail">
<div class="form">
    

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'grades-form',
	//'enableAjaxValidation'=>true,
)); 
       if(!isset($_GET['all']))
		  echo $this->renderPartial('_update', array(
									'model'=>$model,
									'form' =>$form
									)); 
	   elseif($_GET['all']==1)
	       echo $this->renderPartial('_updateByRoom', array(
									'model'=>$model,
									'form' =>$form
									));

 ?>
    
   
    <div class="clear"></div>

<div class="row buttons">
	<?php //echo CHtml::submitButton(Yii::t('app', 'Update'),array('name'=>'update')); ?>
</div>

<?php $this->endWidget(); ?>

</div>
</div>

<!-- form -->
