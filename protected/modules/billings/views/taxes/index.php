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
/* @var $this TaxesController */
/* @var $dataProvider CActiveDataProvider */


	
	$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 


$template = '';

?>



<div id="dash">
          
          <div class="span3"><h2>
              <?php echo Yii::t('app','Manage Taxes'); ?>
              
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
                 echo CHtml::link($images,array('/billings/taxes/create/part/pay/from/stud')); 
               ?>
   </div>
 
  <?php
        }
      
      ?>       

  
   <div class="span4">
                  <?php

                 $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                           // build the link in Yii standard
                 echo CHtml::link($images,array('/billings/billings/index/part/rec/from/stud')); 
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
	$('#taxes-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

		?>




<br/>


    <?php
    echo $this->renderPartial('//layouts/navBaseBilling',NULL,true);	
    ?>



<div class="b_m">


<div class="grid-view">


<?php
    		//error message 
        if(isset($_GET['msguv'])&&($_GET['msguv']=='y'))
           $this->message_default_taxe_u=true;
           
      	 
           
                				       
			if($this->message_default_taxe_u)		
			      { echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:-48px; ';//-20px; ';
				      echo '">';
				      	
				      	echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
					   <tr>
					    <td style="text-align:center;">';			      
			      
			       echo '<span style="color:red;" >'.Yii::t('app','-IRI- cannot be either updated nor deleted.').'</span>';
				        $this->message_default_taxe_u=false;
				        echo'</td>
					    </tr>
						</table>';
					
				           echo '</div>
				           <div style="clear:both;"></div>';
				     }
				     			     	
				  
			
			       
?>


<?php 
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
$gridWidget = $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'taxes-grid',
	'dataProvider'=>$model->search($acad),
	
	'columns'=>array(
		
		array('header'=>Yii::t('app','Taxe Description'),'name'=>'taxe_description',
                    'type' => 'raw','value'=>'$data->taxe_description',
                    
                    ),
		
		array('header'=>Yii::t('app','Employer/Employee'),'name'=>'employeur_employe',
                    'type' => 'raw','value'=>'$data->EmployeurEmploye',
                    ),
                    
		
		array('header'=>Yii::t('app','Taxe Value'),'name'=>'taxe_value',
                    'type' => 'raw','value'=>'$data->TaxeValue',
                    
                    ),
		
		array('header'=>Yii::t('app','Type'),'name'=>'particulier',
                    'type' => 'raw','value'=>'$data->Particulier',
                    
                    ),
        
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
                           'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100,100000=>Yii::t('app','all')),array(
                             'onchange'=>"$.fn.yiiGridView.update('taxes-grid',{ data:{pageSize: $(this).val() }})",
                             )),
                             

		),
	),
)); 

  
    // Export to CSV 
  $content=$model->search($acad)->getData();
 if((isset($content))&&($content!=null))
   $this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app',' CSV'),array('class'=>'btn-info btn'));



?>

</div>


