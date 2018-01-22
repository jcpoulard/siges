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


/* @var $this UserController */
/* @var $model User */

$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

 
$this->pageTitle=Yii::app()->name." - ".Yii::t('app','User {name}',array('{name}'=>$model->full_name));




?>

<div id="dash">
		<div class="span3"><h2> <?php echo Yii::t('app','User {name}',array('{name}'=>$model->full_name))?> </h2> </div>
    <div class="span3">
<?php   
    
     if((Yii::app()->user->profil!='Teacher'))	    
       {
       	
      ?>
           
          <?php 
               if(!isAchiveMode($acad_sess))
                 {       
        ?>
         
           
             <div class="span4">
                      <?php
                     $images = '<i class="fa fa-edit">&nbsp;'.Yii::t('app','Update').'</i>';
                               // build the link in Yii standard
                    
                        echo CHtml::link($images,array('user/update/','id'=>$model->id)); 
                   
                   
                     ?>
            </div>
         
        <?php
                 }
      
      ?>       
       
            
            <div class="span4">
                  <?php
                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                               // build the link in Yii standard
                         if(isset($_GET['from'])&&($_GET['from']=='dis'))
                           echo CHtml::link($images,array('user/disableusers'));
                         else
                           echo CHtml::link($images,array('user/index')); 
                   ?>
           </div>
        
        
<?php   
       }
       	
      ?>              
       </div>

</div>

<div style="clear:both"></div>

<div class="search-form">
    <?php
    echo $this->renderPartial('//layouts/navBaseUser',NULL,true);	
    ?>
</div>



<div style="clear:both"></div>
<div class="span8">

<?php





//error message
	    if(($this->message_default_user_v))
	  	  { echo '<div class="" style=" width:45%; margin-top:10px; margin-bottom:10px; background-color:#F8F8c9; ';		
			      if(($this->message_default_user_v))
				     echo 'color:red;">';
				 
				   	
				    	
				   if($this->message_default_user_v)
				     echo Yii::t('app','This user connot be disabled.').'<br/>';
				     
				   
					
           echo '</div>';
	        }
	     
?>



<?php 


if((Yii::app()->user->profil!='Teacher'))	    
  { 
	$this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			array(
	                    'name'=>'full_name',
	                    'label'=>Yii::t('app','Full name'),
	                    'value'=>$model->full_name,
	                ),
	                
			'username',
			'profilUser',
	                'activeUser',
	                'group0.group_name'
			
		),
	)); 


?>

 <?php 
               if(!isAchiveMode($acad))
                 {       
        ?>

 <div class="activation">
			
	        <?php   echo Yii::t('app','Enable or Disable {first} {last}',array('{first}'=>$model->full_name,'{last}'=>''));
	                $this->beginWidget('CActiveForm', array(
								'id'=>'user-form',
								'enableAjaxValidation'=>true,
								'htmlOptions' => array(
							        'enctype' => 'multipart/form-data',
							      ),
							)); 
					?>
				<div class="checkbox_view" style="margin-left:20px;margin-top:5px;">
				
				   <?php			
						   echo Yii::t('app','Active');
						   
					 if($model->active==0)
						  echo '&nbsp;&nbsp;&nbsp;<input type="checkbox" id="active" name="active" value="1" >';
				     else
				           echo '&nbsp;&nbsp;&nbsp;'.CHtml::checkBox('active',$model);//<input type="checkbox" id="active" name="active" checked="checked" >';
						   
						   echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.CHtml::submitButton(Yii::t('app','Apply'), array('name'=>'apply','class'=>'btn btn-warning' ));
						   
						?>
					</div>
				<?php
						   
				   $this->endWidget();
			 ?>
	        
	    </div>
	    
      <?php
                 }
      
      ?>       
	
	
	    
<?php    }
       else //Yii::app()->user->profil=='Teacher'
        {
       	      $this->widget('zii.widgets.CDetailView', array(
				'data'=>$model,
				'attributes'=>array(
					array(
			                    'name'=>'full_name',
			                    'label'=>Yii::t('app','Full name'),
			                    'value'=>$model->full_name,
			                ),
			                
					'username',
					'profilUser',
			                'activeUser',
			                					
				),
			)); 
			

       	  }  
?>	    
	    </div>
        </div>

