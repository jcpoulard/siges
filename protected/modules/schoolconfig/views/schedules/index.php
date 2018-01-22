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

?>
<?php

$acad_sess=acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; //current academic year

$chosen_acad=Yii::app()->session['AcademicP_sch']; //the chosen academic year


?>








<!-- Menu of CRUD  -->

<div id="dash">
          
          <div class="span3"><h2> <?php echo Yii::t('app','Manage schedule'); ?>

</h2> </div>
     
		   <div class="span3">
             
           <?php    
           if(isAchiveMode($acad_sess))
             {  
                  //display if PDF file exit 
             if($this->allowLink)
			  {
			?>	
				<div class="span4">

                  <?php  //display if PDF file exit 
                        
						 $images = '<i class="fa fa-file">&nbsp;'.Yii::t('app','View PDF').'</i>';

								   // build the link in Yii standard
                         echo CHtml::link($images, Yii::app()->baseUrl.$this->pathLink,array( 'target'=>'_blank'));
					  
						
                       
                   ?>

            	</div>
			<?php  	
                       }
                    
                 }
              else
                {
                
               if($acad==$chosen_acad)  {		   
                  	
               //display if PDF file exit 
             if($this->allowLink)
			  {
			?>	
				<div class="span4">

                  <?php  //display if PDF file exit 
                        
						 $images = '<i class="fa fa-file">&nbsp;'.Yii::t('app','View PDF').'</i>';

								   // build the link in Yii standard
                         echo CHtml::link($images, Yii::app()->baseUrl.$this->pathLink,array( 'target'=>'_blank'));
					  
						
                       
                   ?>

            	</div>
			<?php  	
                       }
                   ?>
		
		<div class="span4">

                  <?php

                     $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';

                               // build the link in Yii standard

                     echo CHtml::link($images,array('schedules/create')); 

                   ?>

            	</div>
			 <?php
                      if($this->temoin_data)//&&($this->room_id<>NULL))
						{
				?>	
				<div class="span4">

                  <?php
                       $images = '<i class="fa fa-edit">&nbsp;'.Yii::t('app','Update').'</i>';
								   // build the link in Yii standard

						 echo CHtml::link($images,array('schedules/viewForUpdate?room='.$this->room_id)); 
                       
                   ?>

            	</div>
           <?php    }
                   ?>

            	 <div class="span4">

                      <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard

                     echo CHtml::link($images,array('/academic/persons/viewListAdmission/isstud/1/pg/lr/mn/std')); 

                   ?>

                  </div> 
				
		 <?php	   } //end if $acad==$chosen_acad 
		 
                }
		    ?>	
			
				
				  
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
				$.fn.yiiGridView.update('schedules-grid', {
data: $(this).serialize()
});
				return false;
				});
			");
		?>



<div class="form">
<?php 
$form=$this->beginWidget('CActiveForm', array(
	
)); 
echo $this->renderPartial('_schedulesView', array(
	'model'=>$model,
	'form' =>$form
	)); ?>
	


<div class="row buttons">
	<?php     
            	
                 if($acad==$chosen_acad)  
				    {		   
                      if($this->temoin_data)
						{  echo CHtml::submitButton(Yii::t('app', 'Create PDF'),array('name'=>'createPdf','class'=>'btn btn-warning'));
             
						
                       }
					}
					
                   ?>
</div>

<?php $this->endWidget(); ?>


</div>
