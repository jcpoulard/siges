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
/* @var $this ScholarshipHolderController */
/* @var $model ScholarshipHolder */
/* @var $form CActiveForm */



    
	
	$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

$acad_name=Yii::app()->session['currentName_academic_year'];



$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); 



  

   
?>





	<?php
	
	//get level for this student
								$modelLevel = null;
								$level=0;
								if($model->student!='')
								 {
								   $modelLevel=$this->getLevelByStudentId($model->student,$acad_sess);
								   }
								
								if($modelLevel!=null)
								 {
								 	$level=$modelLevel->id;
								 	
								   }
							
 
	 
	 ?>

	
	
	
<div  id="resp_form_siges">

        <form  id="resp_form">
        
        <div class="col-3">
            <label id="resp_form"> 
                          <?php echo $form->labelEx($model,'student'); ?>
								<?php 
									
								$criteria = new CDbCriteria(array('alias'=>'p', 'order'=>'last_name ASC', 'condition'=>'p.active in(1,2) AND ( (p.id in (select student from balance b  where balance >0) ) OR  (p.id in (select students from level_has_person lhp inner join fees f on(f.level=lhp.level) where (checked=0 AND (f.fee not in(select fee from scholarship_holder sh where fee IS NOT NULL AND partner IS NULL AND academic_year='.$acad_sess.' AND percentage_pay=100 )  )  ) and academic_year='.$acad_sess.') )  )'));
								
							
							  
							  	if($this->student_id!='')
							  	 {
								  	
								  	 echo $form->dropDownList($model,'student',$this->loadStudentToExempt($criteria), array('onchange'=> 'submit()', 'options' => array($this->student_id=>array('selected'=>true)) ));
								  	 
								  	
							  	  }
							  	else
							  	  {
							  	  	
							  	  	  echo $form->dropDownList($model,'student',$this->loadStudentToExempt($criteria), array('onchange'=> 'submit()', 'prompt'=>Yii::t('app','-- Please select student --') ));
							  	  	
							  	  	
							  	  }
								
							  	
							  	
								 ?>
								<?php echo $form->error($model,'student'); ?>
                           </label>
        </div>
       
        
 <br/> <br/>          


<div class="grid-view" style="width:48%; margin-top:-20px; margin-left:10px;">
 <label id="resp_form"> 

  											
   <?php 				  //And you can get values like this:
        						 
        
		 $dataProvider=Fees::model()->searchFeesToExempt($this->student_id,$level,$acad_sess); 
	     
	    		
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'exempt',
	'dataProvider'=>$dataProvider,
	'summaryText'=> '', 
	'showTableOnEmpty'=>'true',
	'selectableRows' =>2,
	
    'columns'=>array(
	 'id',
	// 'level',
	array('name'=>Yii::t('app','Fees'),'type' => 'raw','value'=>'Yii::t(\'app\',$data->fee_label)." (".numberAccountingFormat($data->getFeeAmount('.$this->student_id.','.$acad_sess.',$data->amount)).")"','htmlOptions'=>array('width'=>'200px')),
	
	array('name'=>Yii::t('app','Deadline'),'type' => 'raw','value'=>'ChangeDateFormat($data->date_limit_payment)','htmlOptions'=>array('width'=>'100px')),
		
	array('name'=>Yii::t('app','Amount Pay'),'type' => 'raw','value'=>'$data->getAmountPayOnFee('.$this->student_id.',$data->id)','htmlOptions'=>array('width'=>'100px')),
	
	
       array(             'class'=>'CCheckBoxColumn',   
                           'id'=>'chk',
                           'htmlOptions'=>array('width'=>'10px')
                 ),           
		
    ),
));
				
				
		
		   
			 ?>

     </label>
 </div>       
       
     
   <br/>    
       
       
       
 <?php
 
   if( $dataProvider->getData()!=NULL)
      {
 ?>      
       
       
       
         <div class="col-2">
            <label id="resp_form">

					<?php echo $form->labelEx($model,'comment'); ?>                              
							<?php 
							        
                                echo  $form->textArea($model,'comment',array('rows'=>3, 'cols'=>160,'style'=>'height:60px; width:100%; display:inline;')); 
                                echo $form->error($model,'comment');
                          								
								?>
                           </label>
        </div>




                            <div class="col-submit">
 
                                
                                <?php 
                                                	 if(!isAchiveMode($acad_sess))
                                                	     echo CHtml::submitButton(Yii::t('app', 'Create '),array('name'=>'create','class'=>'btn btn-warning')); //'Create ' avec espace a la fin POUR AVOIR UNE TRADUCTION "ENREGISTRER"
                                         
                                         echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary')); //'Cancel ' avec espace a la fin POUR AVOIR UNE TRADUCTION "Annuler"/ sans espace=>'Retour'
                                         
                                         
                                         
                                           //back button   
                                              $url=Yii::app()->request->urlReferrer;//$_SERVER['REQUEST_URI'];
                                              $explode_url= explode("php",substr($url,0));
				             
                                              echo ' <a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';
                                          

                                ?>
     
                            
                  </div><!-- /.table-responsive -->
                  
     <?php
     
          }
     
     ?>        
                  
                </form>
              </div>



