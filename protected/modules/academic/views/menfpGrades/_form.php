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
/* @var $this MenfpGradesController */
/* @var $model MenfpGrades */
/* @var $form CActiveForm */


	$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

	
	  $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
     //if($acad!=$current_acad->id)
     //    $condition = '';
     // else
         $condition = 'p.active IN(1, 2) AND ';
                      

	
	?>

<div class="b_m">

<div class="row" style="padding: 5px 10px; margin-top:-16px;"> 
     
      <div class="span9" >
			

         <!--student-->
			<div class="span2" >
			<label for="Student_name"><?php echo Yii::t('app','Student'); ?></label>
			           <?php 
					
					        
							    if(isset($this->student_id)&&($this->student_id!=''))
							       echo $form->dropDownList($model,'student',$this->loadStudentsForMENFPGrades($acad_sess), array('onchange'=> 'submit()','options' => array($this->student_id=>array('selected'=>true)))); 
							    else
								  { 
									echo $form->dropDownList($model,'student',$this->loadStudentsForMENFPGrades($acad_sess), array('onchange'=> 'submit()')); 
						           }					      
						  
						echo $form->error($model,'student'); 
						
															
					   ?>
				</div>
            


	<?php 
                  if(isset($this->student_id)&&($this->student_id!=""))
                       $this->idLevel= getLevelByStudentId($this->student_id, $acad_sess)->id;

		 
		  ?>	
						
</div>													   
   
<br/><br/><br/>

  <div >
											
     <?php 
            $this->gen_not=false;
     
     
        if($this->student_id!='')
           {       
	        $dataProvider=MenfpGrades::model()->searchGradesForStudent($this->student_id,$this->idLevel,$acad_sess);
	        
	        if(($dataProvider->getData()==null))
			   { 
			     	$this->gen_not=false;
			   	
			   	   $dataProvider=ExamenMenfp::model()->searchStudentsForGrades($this->idLevel,$acad_sess);
			      
			      $dataProvider_weight = $dataProvider->getData();
			      foreach($dataProvider_weight as $d_weight)
			         $this->total_weight = $this->total_weight + $d_weight->weight;
			      //id_exam,subject_name,weight  
					  
					  $item_array=array(
					 
					  array('name'=>'subject_name',
				                'header'=>Yii::t('app','Subject name'),
					        'value'=>'$data->subject_name'
							),
				     array('header' =>Yii::t('app','Grade Value'), 'id'=>'gradeValue', 'value' => '\'
				           <input class="td_input" name="grades[\'.$data->id_exam.\']" type=text placeholder="\'.Yii::t(\'app\',\'over \').$data->weight.\'" style=" width:97%;" />
				          
						   <input name="id_subj[\'.$data->id_exam.\']" type="hidden" value="\'.$data->id_exam.\'" />
						   <input name="id_weight[\'.$data->id_exam.\']" type="hidden" value="\'.$data->weight.\'" />
				           <!--<input type="image" src="'.Yii::app()->request->baseUrl.'/img.png" />  -->
				           \'','type'=>'raw' ),
				      
				     
				       
				       
				     //  array(             'class'=>'CCheckBoxColumn',   
				       //                    'id'=>'chk',
				       //          ),           
						
				    );
			  	

			   }
			else
			  {   $this->gen_not=true;
				  	//id_exam,id_grade, subject_name, weight, grade  
				  	$dataProvider_weight = $dataProvider->getData();
			      foreach($dataProvider_weight as $d_weight)
			         $this->total_weight = $this->total_weight + $d_weight->weight;
				  	$item_array= array(
		 
						
					 array('name'=>'subject_name',
				                'header'=>Yii::t('app','Subject name'),
					        'value'=>'$data->subject_name'
							),
				     array('header' =>Yii::t('app','Grade Value'), 'id'=>'gradeValue', 'value' => '\'
				           <input class="td_input" name="grades[\'.$data->id_exam.\']" type=text value="\'.$data->grade.\'" style="width:97%;"  />
				          
						   <input name="id_subj[\'.$data->id_exam.\']" type="hidden" value="\'.$data->id_exam.\'" />
						    <input name="id_weight[\'.$data->id_exam.\']" type="hidden" value="\'.$data->weight.\'" />
						   <input name="id_grad[\'.$data->id_exam.\']" type="hidden" value="\'.$data->id_grade.\'" />
				           <!--<input type="image" src="'.Yii::app()->request->baseUrl.'/img.png" />  -->
				           \'','type'=>'raw' ),
				      
				      
				       
				       
				     //  array(             'class'=>'CCheckBoxColumn',   
				         //                  'id'=>'chk',
				           //      ),           
						
				    );
					  
				}
			 
		    
			                        
                  
           //error message 
	        	/*					     	
				   
				   if($this->message_noGradeEntered)
				     echo '<span style="color:red;" >'.Yii::t('app','You did not insert any grades.').'</span>'.'<br/>';
				   
				  
					if($this->success)
				     echo '<span style="color:green;" >'.Yii::t('app','Operation terminated successfully.').'</span>'.'<br/>';
					  
				    
					if($this->message_GradeHigherWeight)
					  {	 if(!isset($_GET['stud'])||($_GET['stud']==""))
		                     echo '<span style="color:red;" >'.Yii::t('app','Grades GREATER than COURSE WEIGHT are not saved.').'</span>'.'<br/>';
						 else
						   echo '<span style="color:red;" >'.Yii::t('app','Grade VALUE can\'t be GREATER than COURSE WEIGHT!').'</span>'.'<br/>';
					  }
                   

					    echo '<span style="color:blue;" ><b>'.Yii::t('app','- COURSE WEIGHT : ').$weight.' - </b></span>';
					
					
	    	  	$dataProvider=Persons::model()->searchStudentsForShowingGrades($condition,$this->idShift,$this->section_id,$this->idLevel,$this->room_id,$acad_sess,$this->evaluation_id,$this->course_id);
	    	  	
     */
     	                          
	$this->widget('zii.widgets.grid.CGridView', array(
    
	'dataProvider'=>$dataProvider,
	'showTableOnEmpty'=>'true',
	'selectableRows' => 2,
	'summaryText'=>'',
	
    'columns'=>$item_array,
));
		
  
   		
	 ?>

 
 
 </div>

 
  

<div  id="resp_form_siges">

        <form  id="resp_form">  
        
        
         <div class="col-3">
            <label id="resp_form">    
                         
                     <?php 
                            
                               $modelDecision= new MenfpDecision;
                              
                             
                              if($this->gen_not==true)
                               {
                               	$mecision = MenfpDecision::model()->findByAttributes(array('student'=>$this->student_id,'academic_year'=>$acad_sess));
                               	   
                               	   
	                               	    $modelDecision->setAttribute('total_grade',$mecision->total_grade);
	                               	    $modelDecision->setAttribute('average',$mecision->average);
	                               	    $modelDecision->setAttribute('mention',$mecision->mention);
                               	     
                               	     
                               	}
                             
                         echo $form->labelEx($modelDecision,'total_grade'); ?>    
                          
                              <?php 
                                    echo $form->textField($modelDecision,'total_grade', array('size'=>60,'name'=>'total_grade','id'=>'total_grade','placeholder'=>Yii::t('app','Total Grade'))); 
                              
                              //Extract average base
				              $average_base = infoGeneralConfig('average_base');
				              if($average_base=='')
				                $average_base =10;
                              echo '<input name="average_base" id="average_base" type="hidden" value="'.$average_base.'" />';
                              echo '<input name="total_weight" id="total_weight" type="hidden" value="'.$this->total_weight.'" />';
                              
                              ?>
                              <?php echo $form->error($modelDecision,'total_grade'); ?>
            </label>
        </div>

 <div class="col-3">
            <label id="resp_form">    
                       
                       
                          
                     <?php echo $form->labelEx($modelDecision,'average'); ?>    
                          
                              <?php echo $form->textField($modelDecision,'average', array('size'=>60,'name'=>'average','id'=>'average','placeholder'=>Yii::t('app','Average'), 'readonly'=>true  )); ?>
                              <?php echo $form->error($modelDecision,'average'); ?>
            </label>
        </div>

 <div class="col-3">
            <label id="resp_form">    
                          
                     <?php echo $form->labelEx($modelDecision,'mention'); ?>    
                          
                              <?php echo $form->textField($modelDecision, 'mention',array('size'=>60,'placeholder'=>Yii::t('app','mention'))); ?>
                              <?php echo $form->error($modelDecision,'mention'); ?>
            </label>
        </div>

  
<div class="col-submit">
		<?php 
		   //  $content=$dataProvider->getData();
		    //  if((isset($content))&&($content!=null))
			//    { 
			  		           if(!isAchiveMode($acad_sess))
                                             echo CHtml::submitButton(Yii::t('app', 'Create '),array('name'=>'create','class'=>'btn btn-warning'));
                                         
                                         echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary'));
                                     
                                            //back button   
                                              $url=Yii::app()->request->urlReferrer;
                                              $explode_url= explode("php",substr($url,0));
				             
                                              echo '<a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';

					      
					      
					      
					      					     
			 //   }
		?>
		
		
	</div>

 </form>
</div  >

<?php
           }
?>       
  
                </div>
                
              </div>

</div>



<script>   

$('#total_grade').keyup(function () {

          var average_base = parseFloat(document.getElementById("average_base").value);
          
		var tot_grade = parseFloat(document.getElementById("total_grade").value);
       
       var tot_weight = parseFloat(document.getElementById("total_weight").value);
       
       
      
       var average_ = (tot_grade / tot_weight)*average_base; 


    
    $('#average').val(average_.toFixed(2));
    
});


$('.td_input').keyup(function () {

    var average_base = parseFloat(document.getElementById("average_base").value);
          
		var tot_weight = parseFloat(document.getElementById("total_weight").value);
       
       
      
        
       
        var total = 0,
        valid_labels = 0,
        average;

    $('.td_input').each(function () {
        var val = parseFloat($(this).val(), 10);
        if (!isNaN(val)) {
            valid_labels += 1;
            total += val;
        }
    });

   var average_ = (total / tot_weight)*average_base;
   
      

       $('#total_grade').val(total);
       
        $('#average').val(average_.toFixed(2));
});

</script >
