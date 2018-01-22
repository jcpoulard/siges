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



$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

 

    $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
     if($acad!=$current_acad->id)
         $condition = '';
      else
         $condition = 'teacher0.active IN(1,2) AND ';
      


?>






<!-- Menu of CRUD  -->

<div id="dash">
          
         <div class="span3"><h2>

<?php echo Yii::t('app','My Courses');?></h2> </div>
     
		   <div class="span3">
             <div class="span4">
                      <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';


                               // build the link in Yii standard

                     echo CHtml::link($images,array('/academic/persons/listForReport?isstud=0&from=teach')); 

                   ?>

                  </div>   

		
          </div>
 </div>



<div style="clear:both"></div>



<?php



		Yii::app()->clientScript->registerScript('search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('courses-grid', {
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
		)); 
?>
</div>

<?php 

if((Yii::app()->user->profil=='Teacher'))
 {  
	  $pers=User::model()->getPersonByUserId(Yii::app()->user->userid);
	 $pers=$pers->getData();
	 foreach($pers as $p)
                $pers_id=$p->id;
	
	        $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
	        $gridWidget = $this->widget('groupgridview.GroupGridView', array(
		'id'=>'courses-grid',
		'dataProvider'=>$model->searchForSpecificTeacher($condition,$pers_id,$acad_sess),
		
		 'mergeColumns'=>array('subject_name'),
		 
		
		'columns'=>array(
			
			array('header'=>Yii::t('app','Subject'),'name'=>'subject_name','value'=>'$data->subject0->subject_name'),
			array('header'=>Yii::t('app','Room'),'name'=>'room_name','value'=>'$data->room0->room_name'),
			array('header'=>Yii::t('app','Name Period'),'name'=>'name_period','value'=>'$data->academicPeriod->name_period'),
			'weight',
			
			array('header'=>Yii::t('app','Optional'),'name'=>'optional', 'value'=>'$data->Optional'), 
			
			array(
				'class'=>'CButtonColumn',
	                        'template'=>'',
	                        'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
	                          'onchange'=>"$.fn.yiiGridView.update('courses-grid',{ data:{pageSize: $(this).val() }})",
	            )),
			),
		),
	)); 
	
	$content=$model->searchForSpecificTeacher($condition,$pers_id,$acad_sess)->getData();
			      if((isset($content))&&($content!=null))
	                    $this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app',' CSV'),array('class'=>'btn-info btn'));
	                    
	                    
  }//fen if((Yii::app()->user->profil=='Teacher'))
else // Yii::app()->user->profil!='Teacher'
  {
  	$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
        $gridWidget = $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'courses-grid',
	'dataProvider'=>$model->search($acad_sess),
	
	'columns'=>array(
		
		array('header'=>Yii::t('app','Subject'),'name'=>'subject_name','value'=>'$data->subject0->subject_name'),
		array('name'=>'teacher','value'=>'$data->teacher0->first_name." ".$data->teacher0->last_name'),
		array('header'=>Yii::t('app','Room'),'name'=>'room_name','value'=>'$data->room0->room_name'),
		array('header'=>Yii::t('app','Name Period'),'name'=>'name_period','value'=>'$data->academicPeriod->name_period'),
		'weight',
		
		array(
			'class'=>'CButtonColumn',
                        'template'=>'',
                        'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                          'onchange'=>"$.fn.yiiGridView.update('courses-grid',{ data:{pageSize: $(this).val() }})",
            )),
		),
	),
)); 

$content=$model->search($acad_sess)->getData();
		      if((isset($content))&&($content!=null))
                    $this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app',' CSV'),array('class'=>'btn-info btn'));


  	
  	
  	}
 

?>


