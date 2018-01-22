		

	

	
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

