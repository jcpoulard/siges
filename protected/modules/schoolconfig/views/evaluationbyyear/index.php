<?php

/*
 * © 2015 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
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
    
  <?php
$this->breadcrumbs=array(
	Yii::t('app','Evaluation By Period')=>array('index'),
	Yii::t('app', 'Manage'),
);


$siges_structure = infoGeneralConfig('siges_structure_session');
	     
	   if($siges_structure==1)
	    {
	         $sess=Yii::app()->session['currentId_academic_session'];  
             $sess_name=Yii::app()->session['currentName_academic_session'];	
	      }
$acad_sess=acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
		
		if($siges_structure==1)
    $acad_sess = $sess;
elseif($siges_structure==0)
   $acad_sess = $acad;



$template1 ='';
$template ='';

?>






<!-- Menu of CRUD  -->

<div id="dash">
          
          <div class="span3"><h2> <?php echo Yii::t('app','Manage Evaluation by Period'); ?></h2> </div>
     
		   <div class="span3">
                   
        <?php 
               if(!isAchiveMode($acad_sess))
                 {     if(Yii::app()->user->profil!='Teacher')
					      $template='{update}{delete}';
					      
					      $template1 =$template;    
        ?>
        

                  <?php



                     $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';


                               // build the link in Yii standard
                        if((Yii::app()->user->profil=='Admin')) 
                           {
                                echo  '<div class="span4">';
                                  echo CHtml::link($images,array('evaluationbyyear/create')); 
                               echo ' </div>';
                           }

                   ?>

              
              
      <?php
                 }
      
      ?>       
              
              <div class="span4">

                      <?php



                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';


                               // build the link in Yii standard

                     echo CHtml::link($images,array('/academic/persons/listForReport/from/teach/isstud/0')); 

                   ?>

                  </div> 
                  
            </div>   
 </div>




<div style="clear:both"></div>
<?php
if(Yii::app()->user->profil!='Teacher')
  {

?>
<div class="search-form">
    <?php
    echo $this->renderPartial('//layouts/navBaseConfiguration',NULL,true);	
    ?>
</div>


<div style="clear:both"></div>
<?php

  }



		Yii::app()->clientScript->registerScript('search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('evaluation-by-year-grid', {
data: $(this).serialize()
});
				return false;
				});
			");
		?>


<div  class="search-form">
<?php 
      
	      $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>

<?php 
     
     
      
        $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
        $gridWidget = $this->widget('groupgridview.GroupGridView', array(
	'id'=>'evaluation-by-year-grid',
	'dataProvider'=>$model->search($acad_sess),
	'mergeColumns'=>array('academic_year','evaluation_name' ),
	
	'columns'=>array(
                array(
                    'name' => 'evaluation_name',
                    'header'=>Yii::t('app','Evaluation name'),
                    
                    'value'=>'$data->evaluation0->evaluation_name',
                    'htmlOptions'=>array('width'=>'250px'),
                ),
            
   		array(
   	          'name'=>'academic_year',
   	          'header'=>Yii::t('app','Academic period'),
   	          'value'=>'$data->academicYear->name_period',
   	          ),
   	          
		array('name'=>'evaluation_date', 'header'=>Yii::t('app','Evaluation Date'),'value'=>'$data->evaluationDate'),
		
		array('name'=>'last_evaluation', 'header'=>Yii::t('app','Last evaluation'),'value'=>'$data->LastEvaluation'),
		
		
		
		array(
			'class'=>'CButtonColumn',
                        'template'=>$template1,
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
                        'onchange'=>"$.fn.yiiGridView.update('evaluation-by-year-grid',{ data:{pageSize: $(this).val() }})",
            )),
		),
	),
)); 

 $content=$model->search($acad_sess)->getData();
    if((isset($content))&&($content!=null))
         $this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app',' CSV'),array('class'=>'btn-info btn'));
?>


