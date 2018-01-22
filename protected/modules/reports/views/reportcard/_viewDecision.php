



<div id="dash">
          
          <div class="span3"><h2>
              <?php echo Yii::t('app','End Year Decision List'); ?>
              
          </h2> </div>
     
		   <div class="span3">
                
   <div class="span4">
                  <?php

                 $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                           // build the link in Yii standard
                 echo CHtml::link($images,array('/reports/reportcard/endYearDecision/mn/std/from/stud')); 
               ?>
  </div>  


  </div>

</div>


<div style="clear:both"></div>
	
</br>
<div class="b_mail">
<?php 

 $acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

 


    $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
     if($acad!=$current_acad->id)
         $condition = '';
      else
         $condition = 'p.active IN(1,2) AND ';
      

			
	      $sh='';
	      $se='';
	      $le='';
	      
	          
	          $this->idShift=Yii::app()->session['ShiftsAdmit'];
					 if($this->idShift!=null)
					  $sh=$this->idShift;
					  
					$this->section_id=Yii::app()->session['SectionsAdmit'];
					if($this->section_id!=null)
					  $se=$this->section_id;
					  
	                $this->idLevel=Yii::app()->session['LevelHasPersonAdmit'];
					if($this->idLevel!=null)
					  $le=$this->idLevel;
				  
	             
$gridWidget = $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'end-year-decision-grid',
	'dataProvider'=>$model->searchStudentsForPdfEYD($condition,$sh,$se,$le,$acad_sess),//
	'showTableOnEmpty'=>true,
 
	'columns'=>array(
		
		
		array('name'=>'last_name',
			'header'=>Yii::t('app','Student last name'),
                        'type' => 'raw',
			'value'=>'$data->last_name',
			       
                    ),  
                     	
		array('name'=>'first_name',
			'header'=>Yii::t('app','Student first name'),
                        'type' => 'raw',
			'value'=>'$data->first_name',
			       
                    ),
                    
      'mother_first_name',
      
      'sexe',
         
         'birthday',
		                
        
		array('header'=>Yii::t('app','Birth place'),'name'=>'cities0.city_name'),
		
		'identifiant',
		
		'matricule',
		
		
		
		'general_average',
		
		'mention',
		
		'comments',
		
		
		array(     'header'=>Yii::t('app','Current Level'),
		                    'name'=>Yii::t('app','Current Level'),
		                    'value'=>'$data->getLevelById($data->current_level)',
		                ),
		                
	
	),
)); 

   
    // Export to CSV 
  $content=$model->searchStudentsForPdfEYD($condition,$sh,$se,$le,$acad_sess)->getData();//
 if((isset($content))&&($content!=null))
    $this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app',' CSV'),array('class'=>'btn btn-info'));
   
   echo CHtml::submitButton(Yii::t('app', 'Create PDF'),array('name'=>'createPdf','class'=>'btn btn-warning'));
   
       $acad_name=Yii::app()->session['currentName_academic_year'];
	   $acad_name_ = strtr( $acad_name, pa_daksan() );
	   
	   $level=$this->getLevel($this->idLevel);
	   $level_ = strtr( $level, pa_daksan() );
	   
	   
	   $file_name = strtr("LDFA_EYDL", pa_daksan() ).'_'.$acad_name_.'_'.$level_.'.pdf';
	   
   if(file_exists(Yii::app()->basePath.'/../decision_final/'.$file_name))
    {   $images = '<i class="btn btn-warning">&nbsp;'.Yii::t('app','View PDF').'</i>';	
    									   // build the link in Yii standard
	                           
	                               echo CHtml::link($images, Yii::app()->baseUrl.'/decision_final/'.$file_name,array( 'target'=>'_blank'));
						  
							 
							   
      }

?>
</div>