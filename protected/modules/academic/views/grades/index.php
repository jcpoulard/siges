
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

<?php

$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

$template = '';

  $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
        if($current_acad==null)
						          $condition = '';
						     else{
						     	   if($acad!=$current_acad->id)
							         $condition = '';
							      else
							         $condition = 'student0.active IN(1, 2) AND ';
						        }
   



?>
		

<!-- Menu of CRUD  -->

<div id="dash">
		<div class="span3"><h2><?php if(Yii::app()->user->profil!='Teacher')
																	 echo Yii::t('app','Grades');
																   else
																     echo Yii::t('app','Grades by Student');   
																         ?> 
		</h2> </div>
			
      <div class="span3">
           
<?php 
     
     if(!isAchiveMode($acad_sess))
        {    $template = '{update}{delete}';  
        
   ?>
           
             <div class="span4">

                  <?php



                     $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';

                               // build the link in Yii standard

                     echo CHtml::link($images,array('grades/create?from=stud&mn=std')); 

                   ?>

              </div>
   
				  
			
			  
			  <div class="span4">

                  <?php



                     $images = '<i class="fa fa-edit">&nbsp;'.Yii::t('app','Update').'</i>';

                               // build the link in Yii standard

                     echo CHtml::link($images,array('grades/update?all=1&from=stud&mn=std')); 

                   ?>

              </div>
              
 <?php
        }
      
      ?>       

    
              <div class="span4">

                      <?php



                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard

                     echo CHtml::link($images,array('/academic/persons/listforreport?isstud=1&from=stud')); 

                   ?>

                  </div>  
			  
			  
      </div>          

 </div>




<div style="clear:both"></div>
<div class="search-form" >
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>


<div class="principal">
  <div class="list_secondaire">
											


<?php 
        $id_teacher='';   
           	
           	 $pers=User::model()->getPersonByUserId(Yii::app()->user->userid);
				 $pers=$pers->getData();
				 foreach($pers as $p)
				      $id_teacher=$p->id;
				

        
        
        
        if(isset($_GET['msguv'])&&($_GET['msguv']=='y'))
           $this->message_UpdateValidate=true;
	
			//error message
	    if(($this->message_UpdateValidate))		
			      { echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:-45px; ';//-20px; ';
				      echo '">';
				      
				      echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
					   <tr>
					    <td style="text-align:center;">';	
				      				      
			       }			      
				 				   
				  if($this->message_UpdateValidate)
				     { echo '<span style="color:red;" >'.Yii::t('app','Validated Grades can\'t be updated.<br/>').'</span>';
				     $this->message_UpdateValidate=false;
				     }
				     
				 
			 echo'</td>
					    </tr>
						</table>';
					
           echo '</div>
           <div style="clear:both;"></div>';

if((Yii::app()->user->profil!='Teacher'))
  {   $dataProvider=$model->search($condition,$acad_sess);
  
       $method = 'search('.$condition.','.$acad_sess.')';

   }
else // Yii::app()->user->profil=='Teacher'
   {
   	  $dataProvider=$model->searchForTeacherUser($condition,$id_teacher,$acad_sess);
   	  
   	  $method = 'searchForTeacherUser('.$condition.','.$id_teacher.','.$acad_sess.')';
   	  
   	 }

 Yii::app()->clientScript->registerScript($method, "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('grades-grid', {
data: $(this).serialize()
});
				return false;
				});
			");
			
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']); // set controller and model for that before
   $gridWidget = $this->widget('groupgridview.GroupGridView', array(
	'id'=>'grades-grid',
	'dataProvider'=>$dataProvider,
	'showTableOnEmpty'=>true,
       
       'mergeColumns'=>array('evaluation0.examName','student'),
	
	'columns'=>array(
	
               
               array('name'=>'first_name','value'=>'$data->student0->first_name'),
               array('name'=>'last_name','value'=>'$data->student0->last_name'),
                array('name'=>'evaluation0.examName','header'=>Yii::t('app','Exam name'),'htmlOptions'=>array('style'=>'vertical-align: top')),    
                    
		
                array('header'=>Yii::t('app','Course name'),'name'=>'course0.courseName',
                    'type' => 'raw','value'=>'CHtml::link($data->course0->courseName,Yii::app()->createUrl("/academic/grades/view",array("id"=>$data->id,"from"=>"stud")))',
                    
                    ),
                
		'grade_value',
                'course0.weight',
                      
        
          array('header'=>Yii::t('app','Com. '),'name'=>'comment',
                    'type' => 'raw','value'=>'CHtml::link(($data->comment == null) ? " " : "<span data-toggle=\"tooltip\" title=\"$data->comment\"><i class=\"fa fa-comment-o\"></i> </span>
",Yii::app()->createUrl("/academic/grades/view",array("id"=>$data->id,"from"=>"stud")))',
                ),
                      
            array('header' =>Yii::t('app','Validate'),
	         'name'=>'validate',
	        'value'=>'$data->validateGrade'
			),
			
	array('header' =>Yii::t('app','Publish'),
	         'name'=>'publish',
	        'value'=>'$data->publishGrade'
			),
                
		
		array(
			'class'=>'CButtonColumn',
			'template'=>$template,
			'buttons'=>array (
        'update'=> array(
            'label'=>'<i class="fa fa-pencil-square-o"></i>',
            'imageUrl'=>false,
            'url'=>'Yii::app()->createUrl("/academic/grades/update?id=$data->id&from=stud")',
            'options'=>array( 'title'=>Yii::t('app','Update') ),
        ),
        
        'delete'=>array('label'=>'<span class="fa fa-trash-o"></span>',
                            'imageUrl'=>false,
                            'options'=>array('title'=>Yii::t('app','Delete')),
                                
                            ),

         'view'=>array(
            'label'=>'View',
            
            'url'=>'Yii::app()->createUrl("/academic/grades/view?id=$data->id&from=stud")',
            'options'=>array( 'class'=>'icon-search' ),
        ),
        
    ),
			'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                                  'onchange'=>"$.fn.yiiGridView.update('grades-grid',{ data:{pageSize: $(this).val() }})",
                    )),
		),
	),
)); 
  
   // Export to CSV 
  $content=$dataProvider->getData();
 if((isset($content))&&($content!=null))
   $this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app',' CSV'),array('class'=>'btn btn-info'));
   ?>

 </div>  

 </div>
 
 