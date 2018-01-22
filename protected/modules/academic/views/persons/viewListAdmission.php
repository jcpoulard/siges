
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



 $siges_structure = infoGeneralConfig('siges_structure_session');

	
	   if($siges_structure==1)
	    {
	         $sess=Yii::app()->session['currentId_academic_session'];  
             $sess_name=Yii::app()->session['currentName_academic_session'];	
	      }

  $acad=Yii::app()->session['currentId_academic_year'];
 
 if($siges_structure==1)
 {  if( $sess=='')
        $acad_sess = 0;
    else 
		$acad_sess = $sess;
 }
 elseif($siges_structure==0)
   $acad_sess = $acad;

 

  $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
 
 if($current_acad==null)
						          $condition = '';
						     else{
						     	   if($acad!=$current_acad->id)
							         $condition = '';
							      else
							         $condition = 'p.active IN(1,2) AND ';
						        }

      


$id_teacher='';   
           	
           	 $pers=User::model()->getPersonByUserId(Yii::app()->user->userid);
				 $pers=$pers->getData();
				 foreach($pers as $p)
				      $id_teacher=$p->id;
				

$template1 ='';
 $template='';
?>

	
<!-- Menu of CRUD  -->

<div id="dash">
          
          <div class="span3"><h2>      
       <?php  
          	 echo Yii::t('app','Admission list'); 
          	 		
     		?>
              </h2> </div>
              
      <div class="span3">
             
        <?php 
               if(!isAchiveMode($acad))
                 {     $template1 =$template;    
        ?>
 
             <div class="span4">

                  <?php

                     $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';

                               // build the link in Yii standard
                       
                           		 
         							 	echo CHtml::link($images,array('persons/admission'));
         							 	
         							   

                   ?>

             </div>
      <?php
                 }
      
      ?>       

             
         </div> 

 </div>



<div style="clear:both"></div>				
				
 
<?php

 Yii::app()->clientScript->registerScript('searchStudentsAdmission('.$condition.')', "
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



<div class="search-form" style="">
<?php  $content='';
 
	$content= $model->searchStudentsAdmission($condition)->getData();
	  
	  $this->renderPartial('_search',array(
'model'=>$model,
)); ?>
</div>


<?php $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']); // set controller and model for that before

	   	   

           $dataProvider=$model->searchStudentsAdmission($condition);
		   
            
                             $template='{update}{delete}'; //{view}
                             
		   	      $url_view='Yii::app()->createUrl("academic/persons/viewDetailAdmission/id/$data->id")';
		   	      $value_f='CHtml::link($data->first_name,Yii::app()->createUrl("academic/persons/viewDetailAdmission",array("id"=>$data->id,"from"=>"ind")))';
		   	      $value_l='CHtml::link($data->last_name,Yii::app()->createUrl("academic/persons/viewDetailAdmission",array("id"=>$data->id,"from"=>"ind")))';
		   	      
		   	      $value_cod='CHtml::link($data->id_number,Yii::app()->createUrl("academic/persons/viewDetailAdmission",array("id"=>$data->id,"from"=>"ind")))';
		   	   
		   	 
		   	 
		   $gridWidget=$this->widget('zii.widgets.grid.CGridView', array(
			'id'=>'persons-grid',
			'dataProvider'=>$dataProvider,
			'showTableOnEmpty'=>true,
			//'filter'=>$model,
			'columns'=>array(
				//'id',
              /*                  array(
                                        'name'=>Yii::t('app','Code student'),
                                        'type' => 'raw',
                                        'value'=>$value_cod,
                                        'htmlOptions'=>array('width'=>'100px'),
				    ),
                */                
                                array(
                                'name' => 'first_name',
                                'type' => 'raw',
                                'value'=>$value_f,
                                'htmlOptions'=>array('width'=>'150px'),
                                ),
                                
                                array(
                                'name' => 'last_name',
                                'type' => 'raw',
                                'value'=>$value_l,
                                'htmlOptions'=>array('width'=>'150px'),
                                ),
                                
                                
				array(
                                    'name'=>'gender',
                                    'value'=>'$data->getGenders1()',
                                    'htmlOptions'=>array('width'=>'50px'),
						),
				
				
             /*                       array(
                                        'header'=>Yii::t('app','Previous Level'),
                                        'name'=>'previous_level',
                                        'value'=>'$data->getPreviousLevel($data->id)',
                                        //'htmlOptions'=>array('width'=>'200px'),
						),				
				*/
				                 array(
                                        'header'=>Yii::t('app','Apply for level'),
                                        'name'=>Yii::t('app','Apply for level'),
                                        'value'=>'$data->getLevelApplyFor($data->id)',
                                        //'htmlOptions'=>array('width'=>'200px'),
						),	
				
				//'adresse',
				'phone',
				'email',
				array('name'=>'paid',
				       'header'=>Yii::t('app','Paid'),
				       'value'=>'$data->Paid',
				      ),
				//'cities0.city_name',
				/*array('header'=>Yii::t('app','Status'),
                                    'name'=>'status',
                                    'value'=>'$data->status',
                                    'htmlOptions'=>array('width'=>'50px'),
                                    ),
				     */
				array(
					
					'class'=>'CButtonColumn',
					
					'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                                  'onchange'=>"$.fn.yiiGridView.update('persons-grid',{ data:{pageSize: $(this).val() }})",
                    )),
					
					'template'=>$template1,
			   'buttons'=>array ('print'=>array('label'=>'<span class="fa fa-print"></span>',
                            'imageUrl'=>false,     
                            'url'=>'Yii::app()->createUrl("/billings/billings/paymentReceipt?id=$data->id&al=$data->apply_for_level&from=ad")',
                            'options'=>array('title'=>Yii::t('app','Print')),
                             
                            ),
        
         'update'=> array(
            'label'=>'<span class="fa fa-pencil-square-o"></span>',
             'imageUrl'=>false,
            //'imageUrl'=>Yii::app()->request->baseUrl.'/images/update.png',
            'url'=>'Yii::app()->createUrl("academic/persons/admission/id/$data->id")',
            'options'=>array('title'=>Yii::t('app','Update' )),
        ),
/*		'view'=>array(
            'label'=>'<i class="fa fa-eye"></i>',
            'imageUrl'=>false,
            'url'=>$url_view,
            'options'=>array( 'title'=>Yii::t('app','View') ),
        ),
  */
          'delete'=>array(
              'label'=>'<span class="fa fa-trash-o"></span>',
              'imageUrl'=>false,
              'options'=>array('title'=>Yii::t('app','Delete')),
          ),
         
                               
        
    ),
				),
			),
		   ));
		   
		 

		   $content=$model->searchStudentsAdmission($condition)->getData();
	        if((isset($content))&&($content!=null)) 
			   $this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app',' CSV'),array('class'=>'btn-info btn'));
            
		 


	
	  



?>

