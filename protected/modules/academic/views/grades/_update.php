
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

$grades_comment = infoGeneralConfig('grades_comment');	

if($grades_comment==0)
  {  $item_array=array(
	  
		array('name'=>'evaluation_date','value'=>'$data->evaluation0->evaluation_date'),

     array('header' =>Yii::t('app','Grade Value'), 'id'=>'gradeValue', 'value' => '\'
           <input name="grades[\'.$data->id.\']" value="\'.$data->grade_value.\'" type=text style="width:100%%" />
          
		   <input name="id_stud[\'.$data->id.\']" type="hidden" value="\'.$data->id.\'" />
           <!--<input type="image" src="'.Yii::app()->request->baseUrl.'/img.png" />  -->
           \'','type'=>'raw' ),
           
        'course0.weight',
             
		
    );
  }
elseif($grades_comment==1)
{
	$item_array=array(
	  
		array('name'=>'evaluation_date','value'=>'$data->evaluation0->evaluation_date'),

     array('header' =>Yii::t('app','Grade Value'), 'id'=>'gradeValue', 'value' => '\'
           <input name="grades[\'.$data->id.\']" value="\'.$data->grade_value.\'" type=text style="width:100%%" />
          
		   <input name="id_stud[\'.$data->id.\']" type="hidden" value="\'.$data->id.\'" />
           <!--<input type="image" src="'.Yii::app()->request->baseUrl.'/img.png" />  -->
           \'','type'=>'raw' ),
           
        array('header' =>Yii::t('app','Comment'), 'id'=>'commentValue', 'value' => '\'
           <input name="comments[\'.$data->id.\']" value="\'.$data->comment.\'" type=text style="width:100%%" />
          
		   <input name="id_stud[\'.$data->id.\']" type="hidden" value="\'.$data->id.\'" />
           <!--<input type="image" src="'.Yii::app()->request->baseUrl.'/img.png" />  -->
           \'','type'=>'raw' ),
		   

        'course0.weight',
             
		
    );
}
		 
 
	

 
$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
 


?>



<!-- <div class="principal">  -->
                        
  <div >
											

			<?php 	
			
			 $weight = ' ';
    
			  
			  $_model=Grades::model()->findbyPk($_GET['id']); 
                    
                     $result = Courses::model()->getWeight($_model->course);
                    $result =$result->getData();
                    foreach($result as $r)
                      $weight = $r->weight;
                      
                      
			$dataProvider=$model->searchById($_GET['id']);
			
				//error message 
      		
			if(($this->message_GradeHigherWeight)&&($dataProvider->getData()!=null))		
			      { echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:-45px; ';//-20px; ';
				      echo '">';
				      	
				      				      
			       }			      
				 elseif($dataProvider->getData()!=null) 	
				   	{
				   		echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:-45px; ';//-20px; ';
				      echo '">';
				            
				   	  }
				   	else
				   	  { 
				   	  	 echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:-15px; ';//-20px; ';
				      echo '">';
				   	  	
				   	  	}
				  
				    echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
					   <tr>
					    <td style="text-align:center;">';
				  
				  
				   if($this->message_GradeHigherWeight)
					 {
						    echo '<span style="color:red;" >'.Yii::t('app','Grade VALUE can\'t be GREATER than COURSE WEIGHT!').'</span><br/>';
					        
						   	$this->message_GradeHigherWeight=false;					
		              }

                  
					
					   echo '<span style="color:blue;" ><b>'.Yii::t('app','- COURSE WEIGHT : ').$weight.' - </b></span>';
					   
					 echo'</td>
					    </tr>
						</table>';
					
           echo '</div>
           <div style="clear:both;"></div>';
       
			
			 
	$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'grades-grid',
	'dataProvider'=>$dataProvider,
	'showTableOnEmpty'=>'true',
	'selectableRows' => 1,
	
    'columns'=>$item_array,
	
));
				
				
				

			 ?>
      <?php echo $form->error($model,'grade_value'); ?>

  </div>
  

<div  id="resp_form_siges">

        <form  id="resp_form">  
 	

<div class="col-submit">
	    <?php 
	                   if(!isAchiveMode($acad_sess))
	                       echo CHtml::submitButton(Yii::t('app', 'Save'),array('name'=>'update','class'=>'btn btn-warning'));
                                            
                       echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary'));
                                              
                                           
                                           //back button   
                                              $url=Yii::app()->request->urlReferrer;
                                              $explode_url= explode("php",substr($url,0));
				             
                                              echo ' <a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';
			 
	    ?>
    </div>
  </form>
</div  >




