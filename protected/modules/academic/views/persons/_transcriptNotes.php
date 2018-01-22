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
/* @var $this BillingsController */
/* @var $model Billings */
/* @var $form CActiveForm */



    
//$acad=Yii::app()->session['currentId_academic_year']; 
//$acad_name=Yii::app()->session['currentName_academic_year'];

$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); 

$acad_sess = acad_sess();
if($this->transcriptAcadItems=='')
   $this->transcriptAcadItems = 0;
?>












	


        <form  id="resp_form" >
        
		<div class="row-fluid">
				<div class="span4 well">
				<label id="resp_form">
					<?php 
                         echo $form->labelEx($model,Yii::t('app','Select'));
                                        
                                        if(isset($this->transcriptItems)&&($this->transcriptItems!=''))
							       echo $form->dropDownList($model,'transcriptItems',$this->loadTranscriptItems(), array('onchange'=> 'submit()','options' => array($this->transcriptItems=>array('selected'=>true)))); 
							    else
								  { 
									echo $form->dropDownList($model,'transcriptItems',$this->loadTranscriptItems(), array('onchange'=> 'submit()')); 
								  }

                                    ?>
				</label>
				</div>
		<?php
               if($this->transcriptItems==0)
			    {
			 ?>		
				
				<div class="span4 well">
					<label id="resp_form">
                               <?php  echo $form->labelEx($model,Yii::t('app','Academic Year')); 

							   echo $form->dropDownList($model,'transcriptAcadList',$this->loadTranscriptAcadList(), array('onchange'=> 'submit()','options' => array($this->transcriptAcadItems=>array('selected'=>true)))); 
							    
							       ?>
					</label>
				</div>
				
				<div class="span4 well">
					<label id="resp_form">
                               <?php  echo $form->labelEx($model,Yii::t('app','Student')); 

							    if(isset($this->student_id)&&($this->student_id!=''))
									echo $form->dropDownList($model,'student',$this->loadAllStudentsInAcadItems($this->transcriptAcadItems), array('onchange'=> 'submit()','options' => array($this->student_id=>array('selected'=>true)))); 
							    else
									echo $form->dropDownList($model,'student',$this->loadAllStudentsInAcadItems($this->transcriptAcadItems), array('onchange'=> 'submit()' )); 

									
							       ?>
					</label>
				</div>
				
			<?php
				}
			 ?>	
				
		</div>
	
	<?php
          if($this->transcriptItems==0)
			{
				if($this->student_id!='')
				{
	?>	
			 
		<div class="row-fluid">
				<div class="span12 well">
					<?php 
		$period=Grades::model()->searchPeriodForTranscriptNotes($this->transcriptAcadItems);
				$last_period = array();
				
				$modelPastEval= new Evaluations();
				
				//One evaluation by Period
					
					 //on ajoute les colonnes suivant le nbre d'etape anterieur
						if((isset($period)&&($period!=null)))
						  {  $period=$period->getData();//return a list of  objects
								foreach($period as $r)
								  {
									 $last_period[$r->evaluation] = $r->name_period;
									  															
								   }
						   }
						   
				      //end of   One evaluation by Period  
				      
				      	//One evaluation by Period	
						if($last_period!=null)           //(Many evaluations in ONE Period)
						 {	   
		                                                               
			             ?>
							
					
						
						    <label id="resp_form">
						<label for="Past_evaluation_name"><?php //echo Yii::t('app','Include Past evalution period'); ?></label>
						
						<?php
				          //One evaluation by Period
				          echo CHtml::activecheckBoxList($modelPastEval, 'evaluation_name', $last_period, array('separator' => '','template'=>'<div class="rmodal" style="float:left; width:auto;"> <div class=""  style="margin-right:10px; float:left; width:auto;"> <div class="l" style="margin-right:-20px; width:auto;">{label}</div><div class="r" style="float:left;margin-right:0px; width:3%;">{input}</div></div></div>'));		
				          
				          
				          
				          ?>
						     </label>

				
		</div>
		
		<div class="row-fluid">
			<div class="span6 well">
				<label id="resp_form">
                <?php echo $form->labelEx($model,'header_text_date'); ?>
                <?php echo $form->textField($model,'header_text_date',array('placeholder'=>Yii::t('app','City, Date'), 'size'=>60)); ?>
                <?php echo $form->error($model,'header_text_date'); ?>
                </label>

			</div>
			<div class="span6 well">
				<label id="resp_form">
						     
                              <?php echo $form->labelEx($model,'transcript_note_text'); ?>
							  <?php echo $form->textArea($model,'transcript_note_text',array('rows'=>9, 'cols'=>250,'style'=>'height:60px; width:100%; display:inline;')); ?>
							  <?php echo $form->error($model,'transcript_note_text'); ?>
		
				</label>
				
				<label id="resp_form">
                <?php echo $form->labelEx($model,'transcript_signature'); ?>
                <?php echo $form->textField($model,'transcript_signature',array( 'size'=>60)); ?>
                <?php echo $form->error($model,'transcript_signature'); ?>
                
                <?php echo $form->textField($model,'administration_signature_text',array( 'size'=>60)); ?>
                
                </label>
                
			</div>
			
			

			
		</div>
		
	<?php
			 }
	?>		
		
		<div class="row-fluid">
			<div class="span12 well">
				<div class="col-submit" style="content-align: center">
 
                                
                                <?php 
                                         //if(!isAchiveMode($acad_sess))
                                             echo CHtml::submitButton(Yii::t('app', 'Done'),array('name'=>'create','class'=>'btn btn-warning')); //'Create ' avec espace a la fin POUR AVOIR UNE TRADUCTION "ENREGISTRER"
                                         
                                         
                                           //back button   
                                              $url=Yii::app()->request->urlReferrer;//$_SERVER['REQUEST_URI'];
                                              $explode_url= explode("php",substr($url,0));
				             
                                              echo ' <a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';
                                          

                                ?>
     
                            
                  </div>
			</div>
			<?php				
			}
		}	
			?>
		</div>
	       </form>
              





