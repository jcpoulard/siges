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
$this->pageTitle = Yii::app()->name.' - '.Yii::t('app','Manage academic periods');

$acad_sess=acad_sess();
$acad=Yii::app()->session['currentId_academic_year'];

$siges_structure = infoGeneralConfig('siges_structure_session');

   $template = '';


?>

<!-- Menu of CRUD  -->
<div id="dash">
   <div class="span3"><h2>
        <?php echo Yii::t('app','Manage academic periods');?> 
        
    </h2> </div>       
         
     <div class="span3">
        
        <?php $pass=false;
               //si c yon ane akademik ki vin apre ane sa, pa kreye l (mesaj-> tann ou boukle ane sa)
				    	$lastAcadDate=$model->denyeAneAkademikNanSistemLan();
				    	
				    	if($lastAcadDate['id']==$acad)
				    	    $pass=true;
				    	
				    	
               if(!isAchiveMode($acad_sess)||( isAchiveMode($acad_sess)&&($pass==true) ))
                 {    
                 	if(!isAchiveMode($acad_sess))
                 	   $template = '{update}{delete}';  
        ?>
        
         <div class="span4">
                  <?php
                     $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';
                               // build the link in Yii standard
                     echo CHtml::link($images,array('academicperiods/create')); 
                   ?>
               </div>
               
      <?php
                 }
      
      ?>       
               <div class="span4">
                      <?php
                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                               // build the link in Yii standard
                     echo CHtml::link($images,array('../site/index')); 
                   ?>
               </div>
               
    </div> 
 </div>


<div style="clear:both"></div>

<div class="search-form">
    <?php
    echo $this->renderPartial('//layouts/navBaseConfiguration',NULL,true);	
    ?>
</div>
	
<?php
           
            

		Yii::app()->clientScript->registerScript('search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('academic-periods-grid', {
data: $(this).serialize()
});
				return false;
				});
			");
		?>

<!--IMPORTANT-->
<!-- pa efase sa, sinon lyen peryod academic nan update lan pap mache-->
<!--	<div class="span3"></div> -->
<div class="clear"></div>

<div  class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>
                
		<?php 
		$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
		
		      if($siges_structure==0)
		        {  $array_= array(
                                'year0.name_period',
                                array(
                                'name' => 'name_period',
                                
                                'value'=>'$data->name_period',
                                'htmlOptions'=>array('width'=>'150px'),
                                ),
                            
                           array('name'=>'date_start','value'=>'$data->dateStart'),
				array('name'=>'date_end','value'=>'$data->dateEnd'),
                                
				array('header'=>Yii::t('app','Is year?'),'value'=>'$data->isYear'),
				
		           
		                
				array(
					'class'=>'CButtonColumn',
					'template'=>$template,
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
                          'onchange'=>"$.fn.yiiGridView.update('academic-periods-grid',{ data:{pageSize: $(this).val() }})",
                                )),
				),
                            
			);
                            
                            }
		      if($siges_structure==1)
		          {  $array_= array(
                                'year0.name_period',
                                array(
                                'name' => 'name_period',
                                
                                'value'=>'$data->name_period',
                                'htmlOptions'=>array('width'=>'150px'),
                                ),
                            
                            
				            array('name'=>'date_start','value'=>'$data->dateStart'),
				array('name'=>'date_end','value'=>'$data->dateEnd'),
                                
				array('header'=>Yii::t('app','Is year?'),'value'=>'$data->isYear'),
				
		           
		                
				array(
					'class'=>'CButtonColumn',
					'template'=>$template,
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
                          'onchange'=>"$.fn.yiiGridView.update('academic-periods-grid',{ data:{pageSize: $(this).val() }})",
                                )),
				),
                            
			);
                            }

		  	      
                
                $gridWidget = $this->widget('groupgridview.GroupGridView', array(
			'id'=>'academic-periods-grid',
			'dataProvider'=>$model->search_($acad),
                        'showTableOnEmpty'=>true,
                        'emptyText'=>Yii::t('app','No academic period found'),
			'summaryText'=>Yii::t('app','View academic period from {start} to {end} (total of {count})'),
                        'mergeColumns'=>'year0.name_period',
			'columns'=>$array_,
		)); 
		
		      $date_start ='';
		      $acad_result=AcademicPeriods::model()->getAcademicPeriodNameById($acad);
		     
		      $date_start = $acad_result->date_start;
		      
		      if($siges_structure==0)
		        { $array_1 = array(
                       
				
             array(
                      'name' => 'past_acad_years',
                      'type' => 'raw',
                      'value'=>'$data->namePeriod',
                      'htmlOptions'=>array('width'=>'160px'),
                    
                    ),     
                                
                                
                               
                                array(
                                'name' => 'name_period',
                               
                                'value'=>'$data->name_period',
                                'htmlOptions'=>array('width'=>'150px'),
                                ),
				
				array('name'=>'weight','value'=>'$data->weight'),
				array('name'=>'date_start','value'=>'$data->dateStart'),
				array('name'=>'date_end','value'=>'$data->dateEnd'),
                                
				array('header'=>Yii::t('app','Is year?'),'value'=>'$data->isYear'),
				
				array(
					'class'=>'CButtonColumn',
					'template'=>'',
                                        'buttons'=>array('update'=>array('label'=>'<span class="fa fa-pencil-square-o"></span>',
                                        'imageUrl'=>false,
                                        'options'=>array('title'=>Yii::t('app','Update')),

                                        ),
                                        'delete'=>array('label'=>'<span class="fa fa-trash-o"></span>',
                                        'imageUrl'=>false,
                                        'options'=>array('title'=>Yii::t('app','Delete')),


                                        ),
                                        ),
                                    
                     'header'=>CHtml::dropDownList('pageSize',$pageSize,array(1000000=> Yii::t('app','All')  )),
				),

		           
             
			);
		        }
		      elseif($siges_structure==1)
		        {
		        	$array_1 = array(
                       
				
             array(
                      'name' => 'past_acad_years',
                      'type' => 'raw',
                      'value'=>'$data->namePeriod',
                      'htmlOptions'=>array('width'=>'160px'),
                    
                    ),     
                                
                                
                               
                                array(
                                'name' => 'name_period',
                               
                                'value'=>'$data->name_period',
                                'htmlOptions'=>array('width'=>'150px'),
                                ),
				
				
				array('name'=>'date_start','value'=>'$data->dateStart'),
				array('name'=>'date_end','value'=>'$data->dateEnd'),
                                
				array('header'=>Yii::t('app','Is year?'),'value'=>'$data->isYear'),
				
				array(
					'class'=>'CButtonColumn',
					'template'=>'',
                                        'buttons'=>array('update'=>array('label'=>'<span class="fa fa-pencil-square-o"></span>',
                                        'imageUrl'=>false,
                                        'options'=>array('title'=>Yii::t('app','Update')),

                                        ),
                                        'delete'=>array('label'=>'<span class="fa fa-trash-o"></span>',
                                        'imageUrl'=>false,
                                        'options'=>array('title'=>Yii::t('app','Delete')),


                                        ),
                                        ),
                                    
                     'header'=>CHtml::dropDownList('pageSize',$pageSize,array(1000000=> Yii::t('app','All')  )),
				),

		           
             
			);
		          }
			
		$gridWidget1 = $this->widget('groupgridview.GroupGridView', array(
			
			'dataProvider'=>$model->searchPast($acad, $date_start),
                        'showTableOnEmpty'=>false,
                        'emptyText'=>'',
			'summaryText'=>'',
                        'mergeColumns'=>array('past_acad_years'),
			'columns'=>$array_1,
		)); 

		
		$this->renderExportGridButton($gridWidget, '<span class="fa fa-arrow-right">'.Yii::t('app',' CSV').'</span>',array('class'=>'btn-info btn'));
?>
