
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


$acad=Yii::app()->session['currentId_academic_year'];


$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); 





?>


				

<div class="search-form" >


       
     <div>
          <?php 
                echo '<div class="" style=" padding-left:0px;margin-right:0px; margin-bottom:-15px; ';//-20px; ';
				      echo '">';
				      
				       echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
					   <tr>
					    <td style="text-align:center;">';
				     
				   
				    echo '<span style="color:red;" >'.Yii::t('app','First, launch research.').'</span>'.'<br/>';
				   
				     
			  	         echo'</td>
					       </tr>
						  </table>';
						  echo '</div>';
         
          if($this->f_name!='')
             $placeholder1 = $this->f_name; 
          else
             $placeholder1 = Yii::t('app','First Name');
             
          if($this->l_name!='')
             $placeholder2 = $this->l_name;  
          else
             $placeholder2 = Yii::t('app','Last Name');             
                         
                         echo $form->textField($model,'first_name',array('size'=>20,'maxlength'=>20, 'placeholder'=>$placeholder1)); ?>
						 <?php echo $form->textField($model,'last_name',array('size'=>20,'maxlength'=>20, 'placeholder'=>$placeholder2)); ?>
						 <?php 
						       echo CHtml::submitButton(Yii::t('app', 'Search'),array('name'=>'search','class'=>''));
						   ?>
				
        </div>


</div><!-- search-form -->

<div style="clear:both"></div>

<?php $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']); // set controller and model for that before
 
           
          $to_search='';
          $to_search1 ='';
          $to_search2 ='';
          $daprovider=$model->transcriptNotesSearch_fullname('null','null');

           if($this->f_name!='')
		  	    $to_search1 = $this->f_name;
		  	
		  	if($this->l_name!='')
		  	     $to_search2 = $this->l_name;
		  	
		  	if(($to_search1!='')&&($to_search2==''))
		  	   { $to_search =$to_search1;
		  	       $daprovider = $model->transcriptNotesSearch($to_search);
		  	     }
		  	elseif(($to_search1=='')&&($to_search2!=''))
		  	      {   $to_search =$to_search2;
		  	          $daprovider = $model->transcriptNotesSearch($to_search);
		  	      }
		  	    elseif(($to_search1!='')&&($to_search2!=''))
		  	      {   
		  	          $daprovider = $model->transcriptNotesSearch_fullname($to_search1,$to_search2);
		  	      }


      // if($daprovider->getData()!=null)
     //	 {
     	   
     	
     	
		$this->widget('zii.widgets.grid.CGridView', array(
					'id'=>'persons-grid',
					'dataProvider'=>$daprovider,
					'showTableOnEmpty'=>true,
					
					'columns'=>array(
						
						array(
						'name'=>'id_number',
						 'type' => 'raw',
		                 'value'=>'CHtml::link($data->id_number,Yii::app()->createUrl("/academic/persons/transcriptNotes",array("id"=>$data->id,"isstud"=>1,"from"=>"adm","pg"=>"adm","n"=>"'.$to_search2.'","pn"=>"'.$to_search1.'","vi"=>9)))',
		                                   
		                                    ),
				      array(
						'name'=>'last_name',
						 'type' => 'raw',
		                 'value'=>'CHtml::link($data->last_name,Yii::app()->createUrl("/academic/persons/transcriptNotes",array("id"=>$data->id,"isstud"=>1,"from"=>"adm","pg"=>"adm","n"=>"'.$to_search2.'","pn"=>"'.$to_search1.'","vi"=>9)))',
		                                   
		                                    ),
		       array(
						'name'=>'first_name',
						 'type' => 'raw',
		                 'value'=>'CHtml::link($data->first_name,Yii::app()->createUrl("/academic/persons/transcriptNotes",array("id"=>$data->id,"isstud"=>1,"from"=>"adm","pg"=>"adm","n"=>"'.$to_search2.'","pn"=>"'.$to_search1.'","vi"=>9)))',
		                                  
						    ),
		
		
						 array(
									'name'=>'gender',
									'value'=>'$data->getGenders1()',
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
		            
		            'url'=>'Yii::app()->createUrl("/academic/persons/viewForReport?id=$data->id&isstud=1&pg=ext&from1=rpt")',
		            'options'=>array( 'title'=>Yii::t('app','View') ),
		        ),
		        
		    ),
						),
					),
				   )); 
	

     	// }
    
    
     

?>

