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
/* @var $this ContactInfoController */
/* @var $model ContactInfo */

$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',));
    
$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

  $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
 $template ='';    
      
   if($current_acad==null)
						          $condition = '';
						     else{
						     	   if($acad!=$current_acad->id)
							         $condition = '';
							      else
							         $condition = 'person0.active IN(1, 2) AND ';
						        }








Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#contact-info-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>



		
<div id="dash">
		<div class="span3"><h2>
		    <?php echo Yii::t('app','Manage contact info'); ?>
		    
		 </h2> </div>
     
		   <div class="span3">
        <?php 
               if(!isAchiveMode($acad_sess))
                 {     $template ='{view}{update}{mail}';    
        ?>
              <div class="span4">
              <?php  $from='';
                         if(isset($_GET['from']))
					      { if($_GET['from']=='stud')
								  $from ='stud';      
						     elseif($_GET['from']=='teach')
								    $from ='teach';           
								 elseif($_GET['from']=='emp')
								     $from ='emp';
					      }
			

                 $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';
                           // build the link in Yii standard
                 echo CHtml::link($images,array('contactInfo/create?from='.$from)); 
               ?>
             </div>
       <?php
                 }
      
      ?>       
            
             <div class="span4">
                  <?php

                 $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                           // build the link in Yii standard
                    if(isset($_GET['pers'])&&($_GET['pers']!=""))
                       {   
                       	    if(isset($_GET['from']))
				           { if($_GET['from']=='stud')
				                   echo CHtml::link($images,array('/academic/persons/viewForReport?id='.$_GET['pers'].'&pg=lr&isstud=1&from=stud'));
				             elseif($_GET['from']=='teach')
				                 echo CHtml::link($images,array('/academic/persons/viewForReport?id='.$_GET['pers'].'&pg=lr&isstud=0&from=teach'));
				                 elseif($_GET['from']=='emp')
				                     echo CHtml::link($images,array('/academic/persons/viewForReport?id='.$_GET['pers'].'&pg=lr&from=emp')); 
				                     
				           }   

                       	     
                       
                       }
                     else
                       {  
                       	   if(isset($_GET['from']))
				           { if($_GET['from']=='stud')
				                   echo CHtml::link($images,array('/academic/persons/listforreport?isstud=1&from=stud'));
				             elseif($_GET['from']=='teach')
				                 echo CHtml::link($images,array('/academic/persons/listforreport?&isstud=0&from=teach'));
				                 elseif($_GET['from']=='emp')
				                     echo CHtml::link($images,array('/academic/persons/listforreport?from=emp')); 
				                     
				           }   


                       	      
                       	  
                        }
               ?>
             </div>  
      </div>

</div>

<div style="clear:both"></div>

<div  class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>

<?php 
          $from='';
        if(isset($_GET['from']))
	      { if($_GET['from']=='stud')
				{  $dataProvider =$model->searchforStudent($condition,$acad_sess); 
				    $header=Yii::t('app','Student Name');
				    $from='stud';
				    $link_person='"/academic/persons/viewForReport",array("id"=>$data->person0->id,"isstud"=>1,"pg"=>"ci","from"=>"'.$from.'"';
				    
                                     $el = 'stud';
				}     
		     elseif($_GET['from']=='teach')
				 {   $dataProvider = $model->searchforTeacher($condition,$acad_sess);           
				     $header=Yii::t('app','Teacher Name');
				     $from='teach';
				     $link_person='"/academic/persons/viewForReport",array("id"=>$data->person0->id,"isstud"=>0,"pg"=>"ci","from"=>"'.$from.'"';
				     
                                      $el = 'teach';
				}     
		     elseif($_GET['from']=='emp')
				   {  $dataProvider= $model->searchforEmployee($condition,$acad_sess);
				   $header=Yii::t('app','Employee Name');
				    $from='emp';
				   $link_person='"/academic/persons/viewForReport",array("id"=>$data->person0->id,"pg"=>"ci","from"=>"'.$from.'"';
				      
                                       $el = 'emp';
				}     
		     
	      }
				                 
				                 
				                 


 $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
       $gridWidget  = $this->widget('groupgridview.GroupGridView', array(
	'id'=>'contact-info-grid',
	'dataProvider'=>$dataProvider,
	'mergeColumns'=>array('person0.FullName','contact_name'),
	'columns'=>array(
		
         
            		 array(
                                    'name' => 'contact_name',
                                    'value'=>'$data->contact_name',
                                    'htmlOptions'=>array('width'=>'250px'),
                                ),
		
    
		 array(
                                    'name' => 'person0.FullName','header'=>$header,
                                    'type' => 'raw',
                                    'value'=>'CHtml::link($data->person0->FullName,Yii::app()->createUrl('.$link_person.')))',
                                    'htmlOptions'=>array('width'=>'250px'),
                                ),
            'contactRelationship.relation_name',
                
		
		'phone',
		
		
		'email',
		
		
		array(
			'class'=>'CButtonColumn',
			
			'template'=>$template,
			   'buttons'=>array (
        
         'view'=>array(
            'label'=>'<i class="fa fa-eye"></i>',
            'imageUrl'=>false,
            
            'url'=>'Yii::app()->createUrl("/academic/contactInfo/view?id=$data->id&from='.$from.'")',
            'options'=>array( 'title'=>Yii::t('app','View') ),
              ),
        'update'=>array(
            'label'=>'<i class="fa fa-pencil-square-o"></i>',
            'imageUrl'=>false,
            
            'url'=>'Yii::app()->createUrl("academic/contactInfo/update?id=$data->id&from='.$from.'")',
            'options'=>array( 'title'=>Yii::t('app','Update') ),
              ),
                               
        'mail'=> array(
            'label'=>'<span class="fa fa-envelope"></span>',
             'imageUrl'=>false,
            
            'url'=>'Yii::app()->createUrl("academic/mails/create?stud=$data->id&from='.$from.'&el='.$el.'&mn=std&&de=ci")',
            'options'=>array('title'=>Yii::t('app','Send email' )),
        ),                       

              ),
            
            'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                        'onchange'=>"$.fn.yiiGridView.update('contact-info-grid',{ data:{pageSize: $(this).val() }})",
            )),

		),
	),
)); 

// Export to CSV 
  $content=$dataProvider->getData();
 if((isset($content))&&($content!=null))
$this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app',' CSV'),array('class'=>'btn-info btn'));
?>
