
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



$acad_sess=acad_sess();
         
$acad=Yii::app()->session['currentId_academic_year']; 
    
  
   ?>
   
   
<div style="clear:both;"></div>
<!-- <div class="liste_note">  -->
</br>

         <div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin">
                      
                      <tbody>
                        
                        <tr>
                          <td colspan="4" style="background-color:#EFF3F8;border: none;">


   <div  style="padding:0px;">			
			
			<!--room / title-->
			<div class="left" style="margin-left:10px;">
			     <label for="Titles"> <?php 
					
					 echo Yii::t('app','Select '); 
					
				
							  if(isset($this->list_id))
							   {
						          echo $form->dropDownList($model,'list_id', $this->loadInactiveTitle(), array('onchange'=> 'submit()','options' => array($this->list_id=>array('selected'=>true)) )); 
					             }
							   else
							      echo $form->dropDownList($model,'list_id',$this->loadInactiveTitle(), array('onchange'=> 'submit()')); 
						
						echo $form->error($model,'list_id'); 
						
					       									   
					   ?>
				</div>
			
     </div>
                              </td>
	       
					       
					    </tr>
					    
					    <tr>
					       <td colspan="4" style="background-color:#EFF3F8;border: none;">



			
<!-- <div class="principal"> -->
  <div class="list_secondaire">	
       
       <div style="">      
      <?php 
	  
     
		   	
		   	
		   	 $this->female_s =0;
		   $this->male_s =0;
		   $this->tot_stud_s =0;
		   
		   
				 //total by gender
			 
	 if($this->list_id == 1)  //Inactive people
		{	$total_title = Yii::t('app','Total');
			$dataProvider_s1= Persons::model()->searchTotalInactivePerson();		
		   }
		 elseif($this->list_id == 2) //Inactive Students
		   {   $total_title = Yii::t('app','Total Students');
		   	  $dataProvider_s1= Persons::model()->searchTotalExStudents_();
		   	
		     }
		   elseif($this->list_id == 3) //Inactive Teachers
		    {   $total_title = Yii::t('app','Total Teachers');
		    	$dataProvider_s1= Persons::model()->searchTotalExTeachers();
		      }
		    elseif($this->list_id == 4) //Inactive Employees
		      {   $total_title = Yii::t('app','Total Employees');
		      	  $dataProvider_s1= Persons::model()->searchTotalExEmployee();
		        }
			 
				  if(isset($dataProvider_s1)&&($dataProvider_s1!=null))														  
					{ $person_s1=$dataProvider_s1->getData();
																		
						foreach($person_s1 as $stud1)
						  {  
						  	
							if($stud1->gender==0)
							  { 
							  	
							  $this->male_s ++;
							  }
							elseif($stud1->gender==1)
							   $this->female_s ++;
					      }
					      
					      $this->tot_stud_s = $this->female_s + $this->male_s;
						  
					 }
					 
					 
echo '<div class="all_gender" style="margin-bottom:-40px;">
<div class="total_student">'. $total_title.'<div>'.$this->tot_stud_s.'</div></div>

<div class="gender">'.Yii::t('app','').'<div class="female">'.Yii::t('app','Female').'<br/>'.$this->female_s.'</div><div class="male">'.Yii::t('app','Male').'<br/>'.$this->male_s.'</div></div>

</div><div style="clear:both;"></div>';
  	
?>
											

			<?php 		
	    
	  
    if($this->list_id == 1)  //Inactive people
		{	
			     
			     $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']); // set controller and model for that before
			     $gridWidget=$this->widget('zii.widgets.grid.CGridView', array(
			            'id'=>'persons-archive-grid',
			           
			            'dataProvider'=>$model->searchInactivePerson(),
			            'columns'=>array(
			                   array(
							'name'=>'last_name',
							 'type' => 'raw',
			                 'value'=>'$data->last_name',
			                                    
			                                    ),
			       array(
							'name'=>'first_name',
							 'type' => 'raw',
			                 'value'=>'$data->first_name',
			                                  
							    ),
			
			                    array(
			                        'name'=>'gender',
			                        'value'=>'$data->genders1',
			                        ),
			
			                    array(
			                        'header'=>Yii::t('app','profil'),
			                        'name'=>'profil',
			                        'value'=>'$data->getProfil($data->id)',
			                        ),
			                        
			                    'status',
			
			                    array(
			                            'class'=>'CButtonColumn',
			
			                            'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
			              'onchange'=>"$.fn.yiiGridView.update('persons-archive-grid',{ data:{pageSize: $(this).val() }})", 
			)),
			                    'template'=>'',
			                       'buttons'=>array (
			
			                             'update'=> array(
			                                    'label'=>'<i class="fa fa-pencil-square-o"></i>',
			                                    'imageUrl'=>false,
			                                    
			                                    'url'=>'Yii::app()->createUrl("/academic/persons/update?id=$data->id&pg=la&from1=rpt")',
			                                    'options'=>array( 'title'=>Yii::t('app','Update') ),
			                            ),
			                            'view'=>array(
			                                    'label'=>'<i class="fa fa-eye"></i>',
			                                    'imageUrl'=>false,
			                                    
			                                    'url'=>'Yii::app()->createUrl("/academic/persons/viewForReport?id=$data->id&pg=la&from1=rpt")',
			                                    'options'=>array( 'title'=>Yii::t('app','View') ),
			                            ),
			
			                    ),
			
			                    ),
			            ),
			    ));
	
	 $content=$model->searchInactivePerson()->getData();
 if((isset($content))&&($content!=null)) 		    
			$this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app', ' CSV'), array('class' => 'btn-info btn'));    
								
		   }
		 elseif($this->list_id == 2) //Inactive Students
		   {
		   	   $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']); // set controller and model for that before
  
         $gridWidget= $this->widget('zii.widgets.grid.CGridView', array(
			'id'=>'persons-grid',
			'dataProvider'=>$model->searchExStudents_(),
			'showTableOnEmpty'=>true,
			
			'columns'=>array(
				
				array(
				'name'=>'last_name',
				 'type' => 'raw',
                 'value'=>'CHtml::link($data->last_name,Yii::app()->createUrl("/academic/persons/viewForReport",array("id"=>$data->id,"pg"=>"ext","isstud"=>1,"from"=>"rpt")))',
                                    
                                    ),
       array(
				'name'=>'first_name',
				 'type' => 'raw',
                 'value'=>'CHtml::link($data->first_name,Yii::app()->createUrl("/academic/persons/viewForReport",array("id"=>$data->id,"pg"=>"ext","isstud"=>1,"from"=>"rpt")))',
                                 
				    ),


				 array(
							'name'=>'gender',
							'value'=>'$data->getGenders1()',
						), 
				 
				
                'status',
                
				array(
					'class'=>'CButtonColumn',
					'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                                  'onchange'=>"$.fn.yiiGridView.update('persons-grid',{ data:{pageSize: $(this).val() }})",
                    )),
					'template'=>'',
			   'buttons'=>array (
        
         'view'=>array(
            'label'=>'<i class="fa fa-eye"></i>',
            'imageUrl'=>false,
            
            'url'=>'Yii::app()->createUrl("/academic/persons/viewForReport?id=$data->id&isstud=1&pg=ext&from1=rpt")',
            'options'=>array( 'title'=>Yii::t('app','View') ),
        ),
        
    ),
				),
			),
		   )); 
	
  	 $content=$model->searchExStudents_()->getData();
 if((isset($content))&&($content!=null))
		   	   $this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app', ' CSV'), array('class' => 'btn-info btn'));    
		     }
		   elseif($this->list_id == 3) //Inactive Teachers
		    {
		    	 $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']); // set controller and model for that before
 
                        $gridWidget=$this->widget('zii.widgets.grid.CGridView', array(
			'id'=>'persons-grid',
			'dataProvider'=>$model->searchExTeachers(),
			'showTableOnEmpty'=>true,
			
			'columns'=>array(
				
				array(
				'name'=>'last_name',
				 'type' => 'raw',
                 'value'=>'CHtml::link($data->last_name,Yii::app()->createUrl("/academic/persons/viewForReport",array("id"=>$data->id,"pg"=>"lr","isstud"=>0,"tea"=>"yea","pg"=>"ext","from"=>"rpt")))',
                           
                                    ),
       array(
				'name'=>'first_name',
				 'type' => 'raw',
                 'value'=>'CHtml::link($data->first_name,Yii::app()->createUrl("/academic/persons/viewForReport",array("id"=>$data->id,"pg"=>"lr","isstud"=>0,"tea"=>"yea","pg"=>"ext","from"=>"rpt")))',
                               
				    ),

				 array(
							'name'=>'gender',
							'value'=>'$data->getGenders1()',
						), 
				array(
							'name'=>Yii::t('app','Working department'),
							'value'=>$model->getWorkedDepartment($model->id),
						), 
				
 
				
				array(
					'class'=>'CButtonColumn',
					'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                                  'onchange'=>"$.fn.yiiGridView.update('persons-grid',{ data:{pageSize: $(this).val() }})",
                    )),
					'template'=>'',
			   'buttons'=>array (
        
         'view'=>array(
            'label'=>'<i class="fa fa-eye"></i>',
            'imageUrl'=>false,
            
            'url'=>'Yii::app()->createUrl("/academic/persons/viewForReport?id=$data->id&isstud=0&pg=ext&from1=rpt")',
            'options'=>array( 'title'=>Yii::t('app','View') ),
        ),
        
    ),
				),
			),
		   )); 
	
   	 $content=$model->searchExTeachers()->getData();
 if((isset($content))&&($content!=null))
		    	 $this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app', ' CSV'), array('class' => 'btn-info btn'));    
		      }
		    elseif($this->list_id == 4) //Inactive Employees
		      {
		      	  $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']); // set controller and model for that before
 
          $gridWidget=$this->widget('zii.widgets.grid.CGridView', array(
			'id'=>'persons-grid',
			'dataProvider'=>$model->searchExEmployee(),
			'showTableOnEmpty'=>true,
			
			'columns'=>array(
				
		array(
				'name'=>'last_name',
				 'type' => 'raw',
                 'value'=>'CHtml::link($data->last_name,Yii::app()->createUrl("/academic/persons/viewForReport",array("id"=>$data->id,"pg"=>"lr","pg"=>"ext","from"=>"rpt")))',
                      
                                    ),
       array(
				'name'=>'first_name',
				 'type' => 'raw',
                 'value'=>'CHtml::link($data->first_name,Yii::app()->createUrl("/academic/persons/viewForReport",array("id"=>$data->id,"pg"=>"lr","pg"=>"ext","from"=>"rpt")))',
                            
				    ),
				 array(
							'name'=>'gender',
							'value'=>'$data->getGenders1()',
						), 
				array(
							'name'=>Yii::t('app','Working department'),
							'value'=>$model->getWorkedDepartment($model->id),
						), 
				
        
				array(
					'class'=>'CButtonColumn',
					'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                                  'onchange'=>"$.fn.yiiGridView.update('persons-grid',{ data:{pageSize: $(this).val() }})",
                    )),
					'template'=>'',
			   'buttons'=>array (
        
         'view'=>array(
            'label'=>'<i class="fa fa-eye"></i>',
            'imageUrl'=>false,
            
            'url'=>'Yii::app()->createUrl("/academic/persons/viewForReport?id=$data->id&isstud=0&pg=ext&from1=rpt")',
            'options'=>array( 'title'=>Yii::t('app','View') ),
        ),
        
    ),
				),
			),
		   )); 
		
 $content=$model->searchExEmployee()->getData();
 if((isset($content))&&($content!=null))
		      	  $this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app', ' CSV'), array('class' => 'btn-info btn'));    
		        }

		
			 
					
			
			
			
			
			    
				
			     ?>

  
   </div>
<!-- </div>  -->


                                            </td>
                                      </tr>
                       </tbody>
                    </table>
                  </div><!-- /.table-responsive -->
                </div><!-- /.box-body -->
                
            


 <div style="clear:both;"></div>
 
