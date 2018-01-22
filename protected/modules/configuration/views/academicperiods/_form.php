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
   
  $siges_structure = infoGeneralConfig('siges_structure_session');
 $acad_sess=acad_sess(); 
    $acad=Yii::app()->session['currentId_academic_year'];
 
    $this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); 
    
    if((isset($_GET['from']))&&($_GET['from']=='gol'))
           $this->message=true;
    else
           $this->message=false;
		   
   
   ?>
<div class="form">

</br>
<div class="b_mail">	


<p class="note">
    <?php   
     if($this->message==true)
		echo '<span class="required">'.Yii::t('app','Please create the new academic year.').'</span><br/>';
		
     echo Yii::t('app','Fields with <span class="required">*</span> are required.'); 
     ?>
</p>

<?php echo $form->errorSummary($model); ?>



<div  id="resp_form_siges">

<form  id="resp_form">
        
        <div class="col-3">
            <label id="resp_form">
                
                <?php echo $form->labelEx($model,'name_period'); ?>
                <?php echo $form->textField($model,'name_period',array('size'=>60,'maxlength'=>45,'placeholder'=>Yii::t('app','Name Period'))); ?>
                <?php echo $form->error($model,'name_period'); ?>
            </label>
        </div>
    
     <div class="col-3">
            <label id="resp_form">
                          <?php echo $form->labelEx($model,'date_start'); ?>
                             <?php $this->widget('zii.widgets.jui.CJuiDatePicker',
						 array(
								 'model'=>'$model',
								 'name'=>'AcademicPeriods[date_start]',
                                                                 'language' => 'fr',   
								 
								 'value'=>$model->date_start,
								 'htmlOptions'=>array('size'=>60, 'style'=>'width:100% !important','placeholder'=>Yii::t('app','Date Start')),
									 'options'=>array(
									 'showButtonPanel'=>true,
									 'changeYear'=>true,
                                                                         'yearRange'=>'1950:2100',    
									 'dateFormat'=>'yy-mm-dd',
                                                                         
									 ),
								 )
							 );
					; ?>
<?php echo $form->error($model,'date_start'); ?>
            </label>
     </div>
     <div class="col-3">
            <label id="resp_form">                      
                               <?php echo $form->labelEx($model,'date_end'); ?> 
                            
                               <?php $this->widget('zii.widgets.jui.CJuiDatePicker',
						 array(
								 'model'=>'$model',
								 'name'=>'AcademicPeriods[date_end]',
								  'language' => 'fr',  
								 'value'=>$model->date_end,
								 'htmlOptions'=>array('size'=>60, 'style'=>'width:100% !important','placeholder'=>Yii::t('app','Date End')),
									 'options'=>array(
									 'showButtonPanel'=>true,
                                                                         'yearRange'=>'1950:2100',    
									 'changeYear'=>true,                                      
									 'changeYear'=>true,
                                                                        'dateFormat'=>'yy-mm-dd', 
                                                                             
									 ),
								 )
							 );
					; ?>
<?php echo $form->error($model,'date_end'); ?> 
            </label>
     </div>
    
     <div class="col-3">
            <label id="resp_form">
                <div>
                                <?php if(isset($_GET['from'])&&($_GET['from']=='gol'))
		                                 {  echo '';
		                                     $this->is_year=1;
		                                  }
		                                else
		                                 {
		                                 	 echo $form->labelEx($model,'is_year'); 
		                                 	 
		                                 }
		                                 	 
		                            ?>
                            
                                <?php 
 
                                if(isset($_GET['from'])&&($_GET['from']=='gol'))
                                 {  echo '';
                                     $this->is_year=1;
                                  }
                                else
                                 {
                                     if($this->is_year==1)
				                          { 
                                                            echo $form->checkBox($model,'is_year',array('onchange'=> 'submit()','checked'=>'checked'));
				                              
				                           }
						                 else
							               echo $form->checkBox($model,'is_year',array('onchange'=> 'submit()'));
							               
							             
							           
							          echo $form->error($model,'is_year'); 
                                 
                                  }
                                 
                                 ?>
                    </div>
            </label>
     
    </div>
    
    <?php
         if(($this->is_year==0))
		  {
		  	
    ?>
    
        <div class="col-3">
            <label id="resp_form">
               <?php
	              
	            if($siges_structure==0)
		  	      { 
	                echo $form->labelEx($model,'weight'); 
	                echo $form->textField($model,'weight',array('size'=>60,'maxlength'=>45,'placeholder'=>Yii::t('app','Weight'))); 
	                echo $form->error($model,'weight'); 
		  	       }
		        elseif($siges_structure==1)
			       {
			       	  echo '<label>'.Yii::t('app','Previous period').'</label>';
			       	$criteria = '';
			       	
			       	    if( (isset($_GET['id']))&&($_GET['id']!='') )
			       	      {
			       	      	  $criteria = new CDbCriteria(array('order'=>'name_period','condition'=>'id<>'.$_GET['id'].' AND date_end < \''.$model->date_end.'\' AND is_year=0 AND year='.$acad));
			       	      	}
			       	    else
			       	       {
			       	       	    $criteria = new CDbCriteria(array('order'=>'name_period','condition'=>'is_year=0 AND year='.$acad));
			       	       	}
			       	     
			       	 echo $form->dropDownList($model, 'previous_academic_year',
						CHtml::listData(AcademicPeriods::model()->findAll($criteria),'id','name_period'),
						array('prompt'=>Yii::t('app','-- Please select --'),'disabled'=>false)
						);

			       	
			       	}
		  	     
                
                ?>
            </label>
        </div>
        
   <?php     	
		  }
    ?>   
    
     <div class="col-3">
            <label id="resp_form">
                            
                               <?php if(($this->is_year==0))
				                          { echo '<label>'.Yii::t('app','Academic year').'</label>'; 
				                          }
				                       elseif(($this->is_year==1))
				                          {   echo '<label>'.Yii::t('app','Previous Academic Year').'</label>';
				                          	}
				                          
				                          ?>  
                           
                                <?php 
			                          if($this->is_year==0)
				                          {
											$criteria = new CDbCriteria(array('order'=>'name_period','condition'=>'is_year=1 AND year='.$acad));
											
											echo $form->dropDownList($model, 'year',
											CHtml::listData(AcademicPeriods::model()->findAll($criteria),'id','name_period'),
									array('options' => array(($acad)=>array('selected'=>true)), 'disabled'=>false)
											
											);
											
				                          }
				                        elseif($this->is_year==1)
				                          {     
				                          	
				                             //get the most recent academic year
									       //get  date_end of the last academic year
									       //depi pa gen decision_finale ki pran pou ane a sa vle di ane a pa boukle, li pap nan lis la   
						                            $lastAcadDate=$model->denyeAneAkademikNanSistemLan();
													
													$greater_date=$lastAcadDate['date_end'];
													$greater_date_id=$lastAcadDate['id'];	
																                          	
				                          	        											
											      if(isset($_GET['from'])&&($_GET['from']=='gol'))
					                                 {  
					                                 	  if($greater_date_id!='')
					                                 	    $criteria = new CDbCriteria(array('limit'=>1,'offset'=>0, 'order'=>'name_period DESC', 'condition'=>'is_year=1 AND id ='.$greater_date_id));
					                                 	  else
					                                 	     $criteria = '';
					                                 	   
					                                 	  echo $form->dropDownList($model, 'previous_academic_year',
																CHtml::listData(AcademicPeriods::model()->findAll($criteria),'id','name_period'),
																array('options' => array(($greater_date_id)=>array('selected'=>true)),'disabled'=>false)
																);
					                                     
					                                  }
					                                else
					                                 {
					                                 		
							          
							          if($greater_date!='')
							           {    
									      if(substr($greater_date,0,4)==substr($model->date_start,0,4))  //new year follow old one
								            {
								            	$criteria = new CDbCriteria(array('limit'=>1,'offset'=>0, 'order'=>'name_period DESC','condition'=>'is_year=1 AND id <='.$greater_date_id));
								             }
								          else
								            {
								            	$firstAcadDate=$model->premyeAneAkademikNanSistemLan();
												 
												 $firstAcad_startDate=$firstAcadDate['date_start'];
												 
												 
												 if(substr($firstAcad_startDate,0,4)==substr($model->date_end,0,4))  //new year before the first one in the system
										            {
										            	$criteria = new CDbCriteria(array('limit'=>1,'offset'=>0, 'order'=>'name_period DESC','condition'=>'is_year=1 AND date_start <'.$firstAcad_startDate));
										             }
										          else
												     $criteria = ''; 
								             }
								          
							            }
					                   else
					                      $criteria = '';              	
					                                 	
					                                 	
					                                 	
					                                 	
					                                 	echo $form->dropDownList($model, 'previous_academic_year',
																CHtml::listData(AcademicPeriods::model()->findAll($criteria),'id','name_period'),
																array('prompt'=>Yii::t('app','-- Please select --'),'disabled'=>false)
																);
																
					                                 }
											
				                          }
    ?> 
            </label>
     </div>
                        
                        <div class="col-submit">
                                
                                 <?php if(!isset($_GET['id'])){
                                   
                                    //si c yon ane akademik ki vin apre ane sa, pa kreye l (mesaj-> tann ou boukle ane sa)
				    	$lastAcadDate=$model->denyeAneAkademikNanSistemLan();
				    	
				    	if($lastAcadDate['id']==$acad)
				    	    $pass=true;
				    	
				    	
               
                                      if(!isAchiveMode($acad_sess)||( isAchiveMode($acad_sess)&&($pass==true) ))
                                            echo CHtml::submitButton(Yii::t('app', 'Create '),array('name'=>'create','class'=>'btn btn-warning'));
                                         
                                         echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary'));
                                        }
                                         else
                                           {   if(!isAchiveMode($acad_sess)||( isAchiveMode($acad_sess)&&($pass==true) ))
                                                 echo CHtml::submitButton(Yii::t('app', 'Save'),array('name'=>'update','class'=>'btn btn-warning'));
                                            
                                              echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary'));
                                              
                                             } 
                                           //back button   
                                              $url=Yii::app()->request->urlReferrer;
                                              $explode_url= explode("php",substr($url,0));
				             
                                             if(!isset($_GET['from']))
                                                echo '<a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';

                                ?>
                                
                        </div>                     

</form>
</div>
</div>

</div>

			