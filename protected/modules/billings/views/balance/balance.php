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
/* @var $this BillingsController */
/* @var $model Billings */

$acad_sess = acad_sess();  
$acad=Yii::app()->session['currentId_academic_year']; 
$currency_name = Yii::app()->session['currencyName'];
	        $currency_symbol = Yii::app()->session['currencySymbol']; 


             if($this->room_id=='')
		        {
		  	       $method = 'search';
			     }
		       elseif(($this->room_id!='')&&($this->room_id!=0))
			    {
			    	//if($this->fee_id=='')
						$method = 'searchByRoom('.$this->room_id.')';
					//elseif(($this->fee_id!='')&&($this->fee_id!=0))
					  //  $method = 'searchByRoomFee('.$this->room_id.','.$this->fee_id.')';
			      }

Yii::app()->clientScript->registerScript($method, "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
			});
			$('.search-form form').submit(function(){
				$('#balance-grid').yiiGridView('update', {
					data: $(this).serialize()
				});
				return false;
			});
			");

	
?>



<div id="dash">
          
          <div class="span3"><h2>
              <?php echo Yii::t('app','Balance to be paid'); ?>
              
          </h2> </div>
     
		   <div class="span3">
             <div class="span4">
                  <?php

                 $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                           // build the link in Yii standard
                 echo CHtml::link($images,array('billings/index')); 
               ?>
  </div>  
</div>

</div>

<div style="clear:both"></div>


<br/>


    <?php
    echo $this->renderPartial('//layouts/navBaseBillingReport',NULL,true);	
    ?>


<div class="b_m">


<div class="grid-view">



<div class="row-fluid" style=" border:0px solid pink;">

<div class="" style="margin-left:0px;" >                        
                              <?php  $modelRoom = new Rooms;
                                   
                                    $form=$this->beginWidget('CActiveForm', array(
										'id'=>'balance-form',
										'enableAjaxValidation'=>true,
									));
									?>
									
                        <div class="left" >
            
            
                                   <?php  $modelRoom = new Rooms;
                                   
                                 /*   $form=$this->beginWidget('CActiveForm', array(
										//'id'=>'balance-form',
										'enableAjaxValidation'=>true,
									));
			                       */      //echo $form->labelEx($modelRoom,Yii::t('app','Room')); 
			                 
					
					     	if(isset($this->room_id)&&($this->room_id!=''))
							   { 
						          echo $form->dropDownList($modelRoom,'room_name',$this->loadRoom($acad_sess), array('onchange'=> 'submit()','options' => array($this->room_id=>array('selected'=>true)) )); 
					             }
							   else
							      { echo $form->dropDownList($modelRoom,'room_name',$this->loadRoom($acad_sess), array('onchange'=> 'submit()')); 
							          //echo $this->room_id;
									 //$this->room_id=0;
							      }
		                        
		                   //echo $form->error($modelRoom,'room_name');
		                   
		                  // $this->endWidget(); 
						
										
					   ?>

		     </div>
			 
		<!-- -->	  <div class="left" >
            
            
                                   <?php  $modelFee = new Fees;
                                   
                        
					
					     	if(isset($this->fee_id)&&($this->fee_id!=''))
							   { 
						          echo $form->dropDownList($modelFee,'fee_name',$this->loadFee($this->room_id,$acad_sess), array('onchange'=> 'submit()','options' => array($this->fee_id=>array('selected'=>true)) )); 
					             }
							   else
							      { echo $form->dropDownList($modelFee,'fee_name',$this->loadFee($this->room_id,$acad_sess), array('onchange'=> 'submit()')); 
							          //echo $this->room_id;
									 //$this->room_id=0;
							      }
		                      
		                   
										
					   ?>

		     </div>   
			 
			        <?php    $this->endWidget();   ?>
        </div>   

<div  class="search-form">
<?php 
    if(($this->room_id=='')||($this->room_id==0))
      {     
			    $this->renderPartial('_search',array(
				'model'=>$model,
			)); 
       }
?>
</div><!-- search-form -->

</div> 

<?php 
       //reket pou delete tout liy balans yo a zewo
   
   $command = Yii::app()->db->createCommand();
								    $command->delete('balance', 'balance=:bal', array(':bal'=>0));
       
               if($this->room_id=='')
		        {
		  	       $dataProvider=$model->search();
			  	    $content=$model->search()->getData();
			  	    $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
                    			  	    $columns_items = array(
					//'code',
			       
					array('name'=>'student_fname',
						'header'=>Yii::t('app','Student first name'), 
			                        'type' => 'raw',
						
			                        'value'=>'CHtml::link($data->student0->first_name,Yii::app()->createUrl("/billings/balance/view?stud=$data->student&id=$data->id"))',
			                    ),
			                    
			                array('name'=>'student_lname',
						'header'=>Yii::t('app','Student last name'), 
			                        'type' => 'raw',
						
			                        'value'=>'CHtml::link($data->student0->last_name,Yii::app()->createUrl("/billings/balance/view?stud=$data->student&id=$data->id"))',
			                    ),
						
					   array('name'=>'id_number',
			'header'=>Yii::t('app','Code student'), 
                        'value'=>'$data->student0->id_number',
                    ),
                    
                    
                     array('name'=>'room_name',
			'header'=>Yii::t('app','Room name'), 
                        'value'=>'$data->getRooms($data->student)',
                    ),
                    
                    
                    array(
			'header'=>Yii::t('app','Balance'), 
                        'value'=>'$data->Balance',
                    ),
                    
                   array('name'=>'status',
			'header'=>Yii::t('app','Status'), 
                        'value'=>'$data->student0->status',
                    ), 
                    
					
					array(
						'class'=>'CButtonColumn',
						'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
			                                  'onchange'=>"$.fn.yiiGridView.update('balance-grid',{ data:{pageSize: $(this).val() }})",
			                    )),
							'template'=>'{update}',
						   'buttons'=>array (
			        
										'view'=>array(
										     'label'=>'View',
										   //'imageUrl'=>Yii::app()->request->baseUrl.'/images/view.png',
										     'url'=>'Yii::app()->createUrl("billings/balance/view?stud=$data->student&id=$data->id")',
										     'options'=>array( 'class'=>'icon-search' ),
			                                ),
			                                'update'=>array('label'=>'<span class="fa fa-pencil-square-o"></span>',
						                            'imageUrl'=>false,
						                            'url'=>'Yii::app()->createUrl("/billings/balance/update?id=$data->id")',
						                            'options'=>array('title'=>Yii::t('app','Update')),
						                             
						                            ),

			                                                        
					               ),
				),
				);
			  	    
			     }
		       elseif(($this->room_id!=''))
			    {   
			    	if($this->fee_id=='')
					 { 

         				 $dataProvider=$model->searchByRoomFee($this->room_id,NULL);
						$content=$model->searchByRoomFee($this->room_id,NULL)->getData();
						$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
						$columns_items = array(
						//'code',
					   
						array('name'=>'student_fname',
							'header'=>Yii::t('app','Student first name'), 
										'type' => 'raw',
							
										'value'=>'CHtml::link($data->student0->first_name,Yii::app()->createUrl("/billings/balance/view?stud=$data->student&id=$data->id"))',
									),
									
								array('name'=>'student_lname',
							'header'=>Yii::t('app','Student last name'), 
										'type' => 'raw',
							
										'value'=>'CHtml::link($data->student0->last_name,Yii::app()->createUrl("/billings/balance/view?stud=$data->student&id=$data->id"))',
									),
							
							
							 array('name'=>'id_number',
				'header'=>Yii::t('app','Code student'), 
							'value'=>'$data->student0->id_number',
						),
						

							array(
				'header'=>Yii::t('app','Balance'), 
							'value'=>'$data->Balance',
						),
						
						array(
							'class'=>'CButtonColumn',
							'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
												  'onchange'=>"$.fn.yiiGridView.update('balance-grid',{ data:{pageSize: $(this).val() }})",
									)),
								'template'=>'{update}',
							   'buttons'=>array (
						
											'view'=>array(
												 'label'=>'View',
											   //'imageUrl'=>Yii::app()->request->baseUrl.'/images/view.png',
												 'url'=>'Yii::app()->createUrl("billings/balance/view?stud=$data->student&id=$data->id")',
												 'options'=>array( 'class'=>'icon-search' ),
												),
												'update'=>array('label'=>'<span class="fa fa-pencil-square-o"></span>',
						                            'imageUrl'=>false,
						                            'url'=>'Yii::app()->createUrl("/billings/balance/update?id=$data->id")',
						                            'options'=>array('title'=>Yii::t('app','Update')),
						                             
						                            ),

																		
									   ),
					),
					);
					
				 }
				   elseif(($this->fee_id!=''))
				   {
					  

					  $dataProvider=$model->searchByRoomFee($this->room_id,$this->fee_id);
						$content=$model->searchByRoomFee($this->room_id,$this->fee_id)->getData();
						$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
						$columns_items = array(
						//'code',
					   
						array('name'=>'student_fname',
							'header'=>Yii::t('app','Student first name'), 
										'type' => 'raw',
							
										'value'=>'CHtml::link($data->student0->first_name,Yii::app()->createUrl("/billings/balance/view?stud=$data->student&id=$data->id"))',
									),
									
								array('name'=>'student_lname',
							'header'=>Yii::t('app','Student last name'), 
										'type' => 'raw',
							
										'value'=>'CHtml::link($data->student0->last_name,Yii::app()->createUrl("/billings/balance/view?stud=$data->student&id=$data->id"))',
									),
							
							
							 array('name'=>'id_number',
				'header'=>Yii::t('app','Code student'), 
							'value'=>'$data->student0->id_number',
						),
						

							array(
				'header'=>Yii::t('app','Balance'), 
							'value'=>'$data->Balance',
						),
						
						array(
							'class'=>'CButtonColumn',
							'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
												  'onchange'=>"$.fn.yiiGridView.update('balance-grid',{ data:{pageSize: $(this).val() }})",
									)),
								'template'=>'{update}',
							   'buttons'=>array (
						
											'view'=>array(
												 'label'=>'View',
											   //'imageUrl'=>Yii::app()->request->baseUrl.'/images/view.png',
												 'url'=>'Yii::app()->createUrl("billings/balance/view?stud=$data->student&id=$data->id")',
												 'options'=>array( 'class'=>'icon-search' ),
												),
												'update'=>array('label'=>'<span class="fa fa-pencil-square-o"></span>',
						                            'imageUrl'=>false,
						                            'url'=>'Yii::app()->createUrl("/billings/balance/update?id=$data->id")',
						                            'options'=>array('title'=>Yii::t('app','Update')),
						                             
						                            ),
																		
									   ),
					),
					);
					
					
					
				   }
			   
			   
			   }
			  
    
        $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']); // set controller and model for that before
$gridWidget = $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'balance-grid',
	'dataProvider'=>$dataProvider,
	'showTableOnEmpty'=>true,
	//'filter'=>$model,
	'columns'=>$columns_items,
)); 


    // Export to CSV 
 
 if((isset($content))&&($content!=null))
      $this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app',' CSV'),array('class'=>'btn-info btn'));





?>


</div>
