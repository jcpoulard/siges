<?php
/*
 * © 2016 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
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
		<div class="span3"><h2>
      
       <?php      
            if(!isset($_GET['pg'])||($_GET['pg']!="vr"))
               {
            	$this->extern=true;
                  $idShift = Yii::app()->session['Shifts'];
				  $this->idShift=$idShift;
				  
			      $section = Yii::app()->session['Sections'];
				  $this->section_id=$section;
				  
				  $level = Yii::app()->session['LevelHasPerson'];
				  $this->idLevel=$level;
				  
				  $room = Yii::app()->session['Rooms'];
				  $this->room_id=$room;
               
                  $eval = Yii::app()->session['EvaluationByYear'];
				  $this->evaluation_id=$eval;
				  
               } 
				  
		
			$full_name=$this->getStudent($_GET['stud']);
	      echo Yii::t('app','View report card for {name}',array('{name}'=>$full_name)); 
		?>
                 
       </h2> </div>
            
            
      <div class="span3">
             <div class="span4">

                      <?php
                         
                           $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard

                     //if ($drop==1)
					  //  echo CHtml::link($images,array('site/index')); 
                     // else
					    if(isset($_GET['pg']))
                           { 
                           	if($_GET['pg']=="vr")
                                echo	CHtml::link($images,array('/academic/persons/viewForReport?id='.$_GET['stud'].'&pg=lr&isstud=1&from=stud'));
                               elseif($_GET['pg']=="lr")
                                    echo	CHtml::link($images,array('/reports/reportcard/create?roo='.$_GET['roo'].'&pg=lr&isstud=1&from=stud'));   
                                
                                
                           }
                         else
                           echo CHtml::link($images,array('reportcard/create?')); 
                   ?>

                  </div> 
           
          <!--        <div class="icon-dash">
                      </br>
                      <?php
                      $this->widget('application.extensions.print.printWidget',array(
                                          //'printedElement' => 'dataGrid'
                                            ));
                   ?>

                  </div> 		   
            -->
          </div>
 </div>

 
<div style="clear:both"></div>	

</br>
<div class="b_mail">
<div class="form">
<?php 
$form=$this->beginWidget('CActiveForm', array(
	
)); 

?>

<?php
echo $this->renderPartial('_list', array(
	'model'=>$model,
	'form' =>$form
	)); ?>
	


<div class="row buttons">
	
	
</div>

<?php $this->endWidget(); ?>


</div>
</div>

