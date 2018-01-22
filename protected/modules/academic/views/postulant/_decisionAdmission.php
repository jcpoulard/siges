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

$acad_sess= acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

 
$day_for_currentYear_postulant = infoGeneralConfig('day_for_currentYear_postulant'); 
 if($day_for_currentYear_postulant=='')
	$day_for_currentYear_postulant=30;

$template = '';


$acad_name=Yii::app()->session['currentName_academic_year'];

 $siges_structure = infoGeneralConfig('siges_structure_session');
	
			

$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); 



?>												   
   




    <?php
    echo $this->renderPartial('//layouts/navBaseEnrollment',NULL,true);	
    ?>


<div class="b_m">
<?php 
     $acad_or_sess=Yii::t('app','academic year');
        if($siges_structure==1)
           $acad_or_sess=Yii::t('app','session');
           
         echo '<div ><label>'.Yii::t('app','Decision take in the first {name} day(s) of the current {name1} start from the his "start date" can have impact on this {name1}.',array('{name}'=>$day_for_currentYear_postulant,'{name1}'=>$acad_or_sess)).'</label></div>'; ?>
<div class="row" style="padding: 5px 10px;"> 
     
      <div class="span9" >
			

         <!--klas dadmisyon-->
			<div class="span2" >
			<label for="Admission-level"><?php echo Yii::t('app','Apply for level'); ?></label>
			           <?php 
					 if($this->idLevel!='')
							    echo $form->dropDownList($model,'apply_for_level',loadAllLevelToSort(), array('onchange'=> 'submit()','options' => array($this->idLevel=>array('selected'=>true)) )); 
							 else
								 echo $form->dropDownList($model,'apply_for_level',loadAllLevelToSort(), array('onchange'=> 'submit()' )); 
					
					        															
					   ?>
				</div>
				
				
             <!--klas estati-->
			<div class="span2" >
			<label for="Status"><?php echo Yii::t('app','Status'); ?></label>
			          
                        <?php 
                             
                           echo $form->dropDownList($model,'status',$model->getStatusValue(), array('onchange'=> 'submit()' )  );
                           
                           ?>
                       								 
				</div>
            

			
     </div>	
 
</div>

<div style="clear:both"></div>


    
     
<?php 
            
            
            
                $null=Yii::t('app','None');
                $approv=Yii::t('app','Approve');
                $hold=Yii::t('app','Put on hold');
                $reject=Yii::t('app','Reject');
                
                //level ak stati kapab null
$dataProvider=Postulant::model()->searchForDecision($this->idLevel,$model->status, $acad_sess);

$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
        $gridWidget = $this->widget('zii.widgets.grid.CGridView', array(
   
               
   
	'dataProvider'=>$dataProvider,
	'showTableOnEmpty'=>'true',
	'selectableRows' => 2,
        
	'columns'=>array(
		'id',
		
	array('name'=>'student_name',
                'header'=>Yii::t('app','Student name'),
	        'value'=>'$data->first_name." ".$data->last_name'
			),
			
	array('name'=>'apply_for_level',
                'header'=>Yii::t('app','Apply for level'),
	        'value'=>'$data->getLevel($data->apply_for_level)'
			),
	
	array('name'=>'paid',
			'header'=>Yii::t('app','Paid'), 
			'value'=>'$data->Paid'),
					
     array('header' =>Yii::t('app','Status'), 'id'=>'status', 'value' => '$data->status == 0 ? \'
           <select name="postulant[\'.$data->id.\']" > 
           
  <option value=0 selected  >'.$null.'</option>
  <option value=1  >'.$approv.'</option>
  <option value=2 >'.$hold.'</option>
  <option value=3  >'.$reject.'</option></select>
          
		   <input name="id_pos[\'.$data->id.\']" type="hidden" value="\'.$data->id.\'" />
           <!--<input type="image" src="'.Yii::app()->request->baseUrl.'/img.png" />  -->
           \' : ($data->status == 1 ? \'
           <select name="postulant[\'.$data->id.\']" > 
           
  <option value=0   >'.$null.'</option>
  <option value=1 selected >'.$approv.'</option>
  <option value=2 >'.$hold.'</option>
  <option value=3  >'.$reject.'</option></select>
          
		   <input name="id_pos[\'.$data->id.\']" type="hidden" value="\'.$data->id.\'" />
           <!--<input type="image" src="'.Yii::app()->request->baseUrl.'/img.png" />  -->
           \' : ($data->status == 2 ? \'
           <select name="postulant[\'.$data->id.\']" > 
           
  <option value=0   >'.$null.'</option>
  <option value=1  >'.$approv.'</option>
  <option value=2 selected>'.$hold.'</option>
  <option value=3  >'.$reject.'</option></select>
          
		   <input name="id_pos[\'.$data->id.\']" type="hidden" value="\'.$data->id.\'" />
           <!--<input type="image" src="'.Yii::app()->request->baseUrl.'/img.png" />  -->
           \' : ($data->status == 3 ? \'
           <select name="postulant[\'.$data->id.\']" > 
           
  <option value=0   >'.$null.'</option>
  <option value=1  >'.$approv.'</option>
  <option value=2 >'.$hold.'</option>
  <option value=3 selected >'.$reject.'</option></select>
          
		   <input name="id_pos[\'.$data->id.\']" type="hidden" value="\'.$data->id.\'" />
           <!--<input type="image" src="'.Yii::app()->request->baseUrl.'/img.png" />  -->
           \' : " "      )      )      )      
     
         ','type'=>'raw' ),
      
     
			array(
			'class'=>'CButtonColumn',
                        'template'=>'', //$template,
                        'buttons'=>array('update'=>array('label'=>'<span class="fa fa-pencil-square-o"></span>',
                            'imageUrl'=>false,
                            'options'=>array('title'=>Yii::t('app','Update')),
                             
                            ),
                            'delete'=>array('label'=>'<span class="fa fa-trash-o"></span>',
                            'imageUrl'=>false,
                            'options'=>array('title'=>Yii::t('app','Delete')),
                                
                            ),
                            ),
                        'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                         'onchange'=>"$.fn.yiiGridView.update('postulant-grid',{ data:{pageSize: $(this).val() }})",
            )),
		),
	),
)); 


?>

 
 </div>

 
  

<div  id="resp_form_siges">

        <form  id="resp_form">  
  
<div class="col-submit">
		<?php 
		     $content=$dataProvider->getData();
		      if((isset($content))&&($content!=null))
			    { 
			  		          // if((!$this->use_update)&&(!$this->message_UpdateValidate))
					          //       {
                                         if(!isAchiveMode($acad_sess))
                                             echo CHtml::submitButton(Yii::t('app', 'Create '),array('name'=>'create','class'=>'btn btn-warning'));
                                         
                                         echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary'));
                               //         }
                                            //back button   
                                              $url=Yii::app()->request->urlReferrer;
                                              $explode_url= explode("php",substr($url,0));
				             
                                              echo '<a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';

					      
					      
					      
					      					     
			    }
		?>
		
		
	</div>

 </form>
</div  >

       
  
                </div>
                
              </div>

</div>

	
	  
