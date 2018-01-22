
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

$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',));
 
$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

$siges_structure = infoGeneralConfig('siges_structure_session');

  $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
     if($current_acad==null)
						          $condition = '';
						     else{
						     	   if($acad!=$current_acad->id)
							         $condition = '';
							      else
							         $condition = 'p.active IN(1,2) AND ';
						        }

      




?>


<!-- <div class="principal">  -->
</br>

         <div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin">
                      
                      <tbody>
                        
                        <tr>
                          <td colspan="4" style="background-color:#EFF3F8;border: none;">
<div style="padding:0px;">			
					
			<!--level-->
			<div class="left" style="margin-left:10px;  margin-right:20px;">
	         <label for="Levels"> <?php 
					echo Yii::t('app','Level'); 
					 ?>
				</label> 
	
					 <?php 
					 
					$modelLevelPerson = new LevelHasPerson;
						
							if(isset($this->idLevel))
								    echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevel(), array('options' => array($this->idLevel=>array('selected'=>true)),'onchange'=> 'submit()', 'disabled'=>'')); 
								 else
									{ $this->idLevel=0;
									  echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevel(), array('onchange'=> 'submit()', 'disabled'=>'' ));
						             }
						             
					   
						echo $form->error($modelLevelPerson,'level'); 
						
					 
					  ?>
				</div>

			
</div>
				<?php             echo  '<div  style="float:left; border:0px solid blue;width:10%;text-align:center;">'.$form->label($model,'menfp');
				                    if($this->menfp==1)
				                          { echo $form->checkBox($model,'menfp',array('onchange'=> 'submit()','checked'=>'checked'));
				                              
				                           }
						                 elseif($this->menfp==0)
							               echo $form->checkBox($model,'menfp',array('onchange'=> 'submit()'));
				         
				                   echo '</div>';
				   ?>      
				                
	                   </td>
	       
					    </tr>
					    
					    <tr>
					       <td colspan="4" style="background-color:#EFF3F8;border: none;">

     
      	<?php 
         
			       
	      $le='';
	    	          	  
	                $this->idLevel=Yii::app()->session['LevelHasPerson_classSetup'];
					if($this->idLevel!=null)
					  $le=$this->idLevel;
				  
if($this->menfp==1)
{	             
$gridWidget = $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'end-year-decision-grid',
	'dataProvider'=>$model->searchStudentsForPdfCSL($condition,$le,$acad_sess),
	'showTableOnEmpty'=>true,
 
	'columns'=>array(
		
		
		array('name'=>'last_name',
			'header'=>Yii::t('app','Student last name'),
                        'type' => 'raw',
			'value'=>'CHtml::link($data->last_name,Yii::app()->createUrl("/academic/persons/viewForReport",array("id"=>$data->id,"pg"=>"lfc","pi"=>"no","isstud"=>1,"from"=>"stud")))',
			       
                    ),  
                     	
		array('name'=>'first_name',
			'header'=>Yii::t('app','Student first name'),
                        'type' => 'raw',
			'value'=>'CHtml::link($data->first_name,Yii::app()->createUrl("/academic/persons/viewForReport",array("id"=>$data->id,"pg"=>"lfc","pi"=>"no","isstud"=>1,"from"=>"stud")))',
			       
                    ),
                    
      'mother_first_name',
      
      'sexe',
         
         
         array(     'header'=>Yii::t('app','Birthday'),
		                    'name'=>Yii::t('app','Birthday'),
		                    'value'=>'$data->Birthday_',
		                ),
		                
       
		array('header'=>Yii::t('app','Birth place'),'name'=>'cities0.city_name'),
		
		'identifiant',
		
		'matricule',
		
		
	),
)); 

}
elseif($this->menfp==0)
{

    $gridWidget = $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'end-year-decision-grid',
	'dataProvider'=>$model->searchStudentsForPdfCSL($condition,$le,$acad_sess),
	'showTableOnEmpty'=>true,
 
	'columns'=>array(
		
		
		array('name'=>'last_name',
			'header'=>Yii::t('app','Student last name'),
                        'type' => 'raw',
			'value'=>'CHtml::link($data->last_name,Yii::app()->createUrl("/academic/persons/viewForReport",array("id"=>$data->id,"pg"=>"lfc","pi"=>"no","isstud"=>1,"from"=>"stud")))',
			       
                    ),  
                     	
		array('name'=>'first_name',
			'header'=>Yii::t('app','Student first name'),
                        'type' => 'raw',
			'value'=>'CHtml::link($data->first_name,Yii::app()->createUrl("/academic/persons/viewForReport",array("id"=>$data->id,"pg"=>"lfc","pi"=>"no","isstud"=>1,"from"=>"stud")))',
			       
                    ),
                    
         'sexe',
         
        
         array(     'header'=>Yii::t('app','Birthday'),
		                    'name'=>Yii::t('app','Birthday'),
		                    'value'=>'$data->Birthday_',
		                ),
		                
        
		array(     'header'=>Yii::t('app','Person liable phone'),
		                    'name'=>Yii::t('app','Person liable phone'),
		                    'value'=>'$data->person_liable_phone',
		                ),		
		'adresse',
		
		
	),
)); 


}

   
    // Export to CSV 
  $content=$model->searchStudentsForPdfCSL($condition,$le,$acad_sess)->getData();
 if((isset($content))&&($content!=null))
  {  $this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app',' CSV'),array('class'=>'btn btn-info'));
   
   echo CHtml::submitButton(Yii::t('app', 'Create PDF'),array('name'=>'createPdf','class'=>'btn btn-warning'));
   }
       $sess_name='';
                      
                      if($siges_structure==1)
                        {  if($this->noSession)
                             {  Yii::app()->session['currentName_academic_session']=null;
                                Yii::app()->session['currentId_academic_session']=null;
                             	$sess_name=' / ';
                             }
                           else
                             $sess_name=' / '.Yii::app()->session['currentName_academic_session'];
                        }
                        
       $acad_name=Yii::app()->session['currentName_academic_year'];
	   $acad_name_ = strtr( $acad_name.$sess_name, pa_daksan() );
	   
	   $level=$this->getLevel($this->idLevel);
	   $level_ = strtr( $level, pa_daksan() );

if($this->menfp==1)
{	   
	   $file_name = strtr("LFC_CSL_MENFP", pa_daksan() ).'_'.$acad_name_.'_'.$level_.'.pdf';
	   
 }
elseif($this->menfp==0)
{
       $file_name = strtr("LFC_CSL", pa_daksan() ).'_'.$acad_name_.'_'.$level_.'.pdf';

}

   
										 
  if(file_exists(Yii::app()->basePath.'/../documents/lfc_csl/'.$acad_name_.'/'.$file_name))
    {   $images = '<i class="btn btn-warning">&nbsp;'.Yii::t('app','View PDF').'</i>';	
    									   // build the link in Yii standard
	                           
	                               echo CHtml::link($images, Yii::app()->baseUrl.'/documents/lfc_csl/'.$acad_name_.'/'.$file_name,array( 'target'=>'_blank'));
						  
							  // echo '</div>';
							   
      }

			    
				
			     ?>
	
 
                                 </td>
                              </tr>
                             
                             
                       </tbody>
                    </table>
                  </div><!-- /.table-responsive -->
               
<!-- /.box-body -->
                
              </div>
