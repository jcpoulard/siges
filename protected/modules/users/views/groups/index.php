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



$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',));
$acad_sess=acad_sess();    
$acad=Yii::app()->session['currentId_academic_year'];

 $template ='{view}';  



		Yii::app()->clientScript->registerScript('search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('groups-grid', {
data: $(this).serialize()
});
				return false;
				});
			");
		?>
		
<div id="dash">
   <div class="span3"><h2> <?php echo Yii::t('app','Manage groups'); ?> </h2></div>
     <div class="span3">
         
        <?php 
               if(!isAchiveMode($acad_sess))
                 {     $template ='{view}{update}{delete}';    
        ?>
 
 <div class="span4">
              <?php

                 $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';
                           // build the link in Yii standard
                 echo CHtml::link($images,array('groups/create')); 
               ?>
   </div>
 
     <?php
                 }
      
      ?>       

   
   <div class="span4">
                  <?php

                 $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                           // build the link in Yii standard
                 echo CHtml::link($images,array('/users/user/index')); 
               ?>
        </div>
   </div>  

</div>


<div style="clear:both"></div>

<div class="search-form">
    <?php
    echo $this->renderPartial('//layouts/navBaseUser',NULL,true);	
    ?>
</div>

<div style="clear:both"></div>


<div class="search-form" >
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>

<div class="clear"></div>
<?php


//error message

    		//error message 
        if(isset($_GET['msguv'])&&($_GET['msguv']=='y'))
           $this->message_default_group_u=true;
           
      	 
           
                				       
			if(($this->message_default_group_u)||($this->message_studentparent_group_u))		
			      { echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:-48px; ';//-20px; ';
				      echo '">';
				      	
				      	echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
					   <tr>
					    <td style="text-align:center;">';			      
			       }			      
				 
				  if($this->message_default_group_u)
				     { echo '<span style="color:red;" >'.Yii::t('app','-Developer- and -Default Group- cannot be either updated nor deleted.').'</span>';
				        $this->message_default_group_u=false;
				        echo'</td>
					    </tr>
						</table>';
					
				           echo '</div>
				           <div style="clear:both;"></div>';
				     }
				     			     	
				  if($this->message_studentparent_group_u)
				     { echo '<span style="color:red;" >'.Yii::t('app','Only access right will be updated.').'</span>';
				       $this->message_studentparent_group_u=false;
				       echo'</td>
					    </tr>
						</table>';
					
			           echo '</div>
			           <div style="clear:both;"></div>';
				     }
			
			       
?>
<?php  

$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'groups-grid',
	'dataProvider'=>$model->search(),
	
	'columns'=>array(
		
		
		array('name'=>'group_name',
			'header'=>Yii::t('app','Group name'),
			'value'=>'$data->group_name'),
			
		
		array('name'=>'belongs_to_profil',
			'header'=>Yii::t('app','Belongs to ... profil'),
			'value'=>'$data->profil->profil_name'),
		
		array(
			'class'=>'CButtonColumn',
			'template'=> $template,
			   'buttons'=>array (
        
         'view'=>array(
            'label'=>'<i class="fa fa-eye"></i>',
            'imageUrl'=>false,
            
            'url'=>'Yii::app()->createUrl("users/groups/view?id=$data->id")',
            'options'=>array( 'title'=>Yii::t('app','View') ),
                 ),
        
           'update'=>array(
            'label'=>'<span class="fa fa-pencil-square-o"></span>',
            'imageUrl'=>false,
            'url'=>'Yii::app()->createUrl("users/groups/update?id=$data->id")',
            'options'=>array( 'title'=>Yii::t('app','Update' )),
		        ),
		        
		     'delete'=>array(
              'label'=>'<span class="fa fa-trash-o"></span>',
              'imageUrl'=>false,
              'options'=>array('title'=>Yii::t('app','Delete')),
                ),
             
		    ), 
		    
		       
			'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                                  'onchange'=>"$.fn.yiiGridView.update('groups-grid',{ data:{pageSize: $(this).val() }})",
                    )),
			
		),
	),
)); 


   



?>
