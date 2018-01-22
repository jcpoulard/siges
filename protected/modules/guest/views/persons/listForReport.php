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
$this->breadcrumbs = array(
	Yii::t('app','Persons'),
	Yii::t('app', 'Index'),
);



$acad=Yii::app()->session['currentId_academic_year']; 



?>


	
			

	

	
<!-- Menu of CRUD  -->

<div id="dash">
      
       <?php  $drop=0;
      if(isset($_GET['isstud']))
        { if($_GET['isstud']==1){ $drop=1; echo '<h2><span class="fa fa-bookmark fa-2x"> '.Yii::t('app','Students').'</span> </h2>'; }
			elseif($_GET['isstud']==0) echo '<h2><span class="fa fa-male fa-2x"> '.Yii::t('app','Working Teachers').'</span> </h2>'; 
		}
      else		
	      echo '<h2><span class="fa fa-suitcase fa-2x"> '.Yii::t('app','Employees').'</span> </h2>'; 
		?>
                 
                  <div class="icon-dash">

                      <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard

                    
                     if(isset($_GET['from'])){
                        if($_GET['from']=='teach')
                         echo CHtml::link($images,array('../site/index'));
                        elseif($_GET['from']=='emp')
                                  echo CHtml::link($images,array('../site/index'));
                          else
                            echo CHtml::link($images,array('../site/index'));
                                                          
                     }
                     else
                        {   if(isset($_GET['from1']))
                                {
                            	    if($_GET['from1']=='rpt')
                                       echo CHtml::link($images,array('/reports/reportcard/generalreport'));
                                  }

                        	                         	 
                        }
                   ?>

                  </div> 
    
    
                  
              <?php if(isset($_GET['isstud']))
                    {
                        if($_GET['isstud']==1)
                        {
                    
                  ?>
    
               
			  <div class="icon-dash">

                  

              </div> 
			  
			  
			  
			  <div class="icon-dash">

                  

              </div> 
	
			 
			  
                    <?php }}?>
					
			<div class="icon-dash">

                  <?php

                     $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';

                               // build the link in Yii standard
                    if(isset($_GET['isstud'])) 
                     {  if($_GET['isstud']==1)
                           {  if(!isset($_GET['from1']))
                                {
                           	       echo CHtml::link($images,array('persons/create?isstud=1&pg=lr')); 
									
								 }
                           }
                           
					   }
				   else      
					  {   if(!isset($_GET['from1']))
                                {	    echo CHtml::link($images,array('persons/create?pg=lr')); 
                                
                                }
                                
					  }
					   

                   ?>

              </div> 

 </div>
 
<?php

 Yii::app()->clientScript->registerScript('searchStudents_('.$acad.')', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('persons-grid', {
data: $(this).serialize()
});
				return false;
				});
			");


			
?>


<div style="clear:both"></div>				
				

<div class="search-form" style="">
<?php  $content='';
if(isset($_GET['isstud']))
   { if($_GET['isstud']==1) 
		 $content= $model->searchStudents_($acad)->getData();
      elseif($_GET['isstud']==0)
		 $content=$model->searchTeacher($acad)->getData();
	}   
else
    $content=$model->searchEmployee()->getData();
	  
	 
  if((isset($content))&&($content!=null)) 
	  $this->renderPartial('_search',array(
'model'=>$model,
)); ?>
</div>

<?php 

?>

<?php $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']); // set controller and model for that before
 if(isset($_GET['isstud']))
   { if($_GET['isstud']==1) 
		   { 
		   	  
		   	  
		   	 if((isset($_GET['from']))&&($_GET['from']=='stud'))
		   	   { $template='{view}{update}{delete}'; 
		   	      $url_view='Yii::app()->createUrl("academic/persons/viewForReport?id=$data->id&pg=lr&isstud=1&from=stud")';
		   	   }
		   	 else
		   	   { $template='{view}';
		   	     $url_view='Yii::app()->createUrl("academic/persons/viewForReport?id=$data->id&pg=lr&isstud=1")';
		   	   }
		   	 
		   $this->widget('zii.widgets.grid.CGridView', array(
			'id'=>'persons-grid',
			'dataProvider'=>$model->searchStudents_($acad),
			
			'columns'=>array(
				
                array(
							'name'=>Yii::t('app','Code student'),
							'value'=>'$data->id_number',
                                                        'htmlOptions'=>array('width'=>'100px'),
						),
                                
                                array(
                                    'name' => 'first_name',
                                    'type' => 'raw',
                                    'value' =>'CHtml::link(CHtml::encode($data["first_name"]), "viewForReport?id=$data->id&pg=lr&isstud=1&from=stud")',
                                    'htmlOptions'=>array('width'=>'150px'),
                                ),
                                array(
                                    'name' => 'last_name',
                                    'type' => 'raw',
                                    'value' =>'CHtml::link(CHtml::encode($data["last_name"]), "viewForReport?id=$data->id&pg=lr&isstud=1&from=stud")',
                                    'htmlOptions'=>array('width'=>'150px'),
                                ),
				array(
                                    'name'=>'gender',
                                    'value'=>'$data->getGenders1()',
                                    'htmlOptions'=>array('width'=>'50px'),
						),
				
				
                                    array(
                                        'header'=>Yii::t('app','Room Name'),
                                        'name'=>'room_name',
                                        'value'=>'$data->getRooms($data->id,'.$acad.')',
                                        'htmlOptions'=>array('width'=>'200px'),
						),				
				
				
				
				array('header'=>Yii::t('app','Status'),
                                    'name'=>'status',
                                    'value'=>'$data->status',
                                    'htmlOptions'=>array('width'=>'50px'),
                                    ),
				
				
				
				array(
					'class'=>'CButtonColumn',
					'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                                  'onchange'=>"$.fn.yiiGridView.update('persons-grid',{ data:{pageSize: $(this).val() }})",
                    )),
					'template'=>$template,
			   'buttons'=>array (
        
         'update'=> array(
            'label'=>'Update',
            
            'url'=>'Yii::app()->createUrl("academic/persons/update?id=$data->id&pg=lr&isstud=1&from=stud")',
            'options'=>array( 'class'=>'icon-edit' ),
        ),
		'view'=>array(
            'label'=>'View',
            
            'url'=>$url_view,
            'options'=>array( 'class'=>'icon-search' ),
        ),
        
    ),
				),
			),
		   ));
		 }
        elseif($_GET['isstud']==0)
		 {    
           
		   	  
		   	 if(isset($_GET['from']))
		   	   { $template='{view}{update}';
		   	      $url_view='Yii::app()->createUrl("academic/persons/viewForReport?id=$data->id&isstud=0&from=teach")';
		   	   }
		   	 else
		   	   { $template='{view}';
		   	     $url_view='Yii::app()->createUrl("academic/persons/viewForReport?id=$data->id&isstud=0")';
		   	   }
		   	   
            $gridWidget = $this->widget('zii.widgets.grid.CGridView', array(
			'id'=>'persons-grid',
			'dataProvider'=>$model->searchTeacher($acad),
			
			'columns'=>array(
				
                                'first_name',
				'last_name',
				
				array(
							'name'=>'gender',
							'value'=>'$data->getGenders1()',
						), 
				array(
							'name'=>Yii::t('app','Working department'),
							'value'=>'$data->getWorkingDepartment($data->id,'.$acad.')',
						), 
				

				
						 
				array(
					'class'=>'CButtonColumn',
					'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                                  'onchange'=>"$.fn.yiiGridView.update('persons-grid',{ data:{pageSize: $(this).val() }})",
                    )),
					'template'=>$template,
			   'buttons'=>array (
        
         'update'=> array(
            'label'=>'Update',
            
            'url'=>'Yii::app()->createUrl("academic/persons/update?id=$data->id&isstud=0&from=teach")',
            'options'=>array( 'class'=>'icon-edit' ),
        ),
		'view'=>array(
            'label'=>'View',
            
            'url'=>$url_view,
            'options'=>array( 'class'=>'icon-search' ),
        ),
       
    ),
				),
			),
		   ));
            // Export to CSV 
            $content=$model->searchTeacher($acad)->getData();
	        if((isset($content))&&($content!=null)) 
			   $this->renderExportGridButton($gridWidget, Yii::t('app','Export to CSV'),array('class'=>'btn-info'));
            
	    }
	  }
	else
	  {  
	  	 
		   	  
		   	 if(isset($_GET['from']))
		   	   { $template='{view}{update}';
		   	      $url_view='Yii::app()->createUrl("academic/persons/viewForReport?id=$data->id&from=emp")';
		   	   }
		   	 else
		   	   { $template='{view}';
		   	     $url_view='Yii::app()->createUrl("academic/persons/viewForReport?id=$data->id")';
		   	   }
		   	   

	  	
	  	$this->widget('zii.widgets.grid.CGridView', array(
			'id'=>'persons-grid',
			'dataProvider'=>$model->searchEmployee(),
			
			'columns'=>array(
				
                                'first_name',
				'last_name',
				
				array(
							'name'=>'gender',
							'value'=>'$data->getGenders1()',
						),
				
				array(
							'name'=>Yii::t('app','Working department'),
							'value'=>'$data->getWorkingDepartment($data->id,'.$acad.')',
						), 
				

					 
				array(
					'class'=>'CButtonColumn',
					'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                                  'onchange'=>"$.fn.yiiGridView.update('persons-grid',{ data:{pageSize: $(this).val() }})",
                    )),
					'template'=>$template,
			   'buttons'=>array (
        
         'update'=> array(
            'label'=>'Update',
           
            'url'=>'Yii::app()->createUrl("academic/persons/update?id=$data->id&from=emp")',
            'options'=>array( 'class'=>'icon-edit' ),
        ),
		'view'=>array(
            'label'=>'View',
            
            'url'=>$url_view,
            'options'=>array( 'class'=>'icon-search' ),
        ),
        
    ),
				),
			),
		   ));


	  }



?>

