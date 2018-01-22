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

$acad_sess =acad_sess();
?>
    



<!-- Menu of CRUD  -->

<div id="dash">
          
          <div class="span3"><h2>
<?php echo Yii::t('app','Update course {name}',array('{name}'=>$model->courseName)); ?>
</h2> </div>
     
		   <div class="span3">
		   
		    <?php
		       if((isset($_GET['from']))&&($_GET['from']=='teach'))
		         { echo '';
		         
		         }
		       else
		         {
		     ?>
            
    <?php 
               if(!isAchiveMode($acad_sess))
                 {       
        ?>           
             <div class="span4">

                  <?php

                     $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';


                               // build the link in Yii standard
                    
                        echo CHtml::link($images,array('courses/create')); 

                   ?>

              </div>
   <?php
                 }
   ?>              
               <?php 
		          
		           }
                 
                 ?>
              
              <div class="span4">
                      <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard
                           if(isset($_GET['from']))
                            {  
                            	if($_GET['from']=='teach')
                            	  { 
                            	  	  if(isset($_GET['pg']))
									   {  
										 if($_GET['pg']=='tea')
                            	  	       {
                            	  	       	 echo CHtml::link($images,array('/schoolconfig/courses/index/isstud/0/from/teach'));
					                         $this->back_url='/schoolconfig/courses/index/isstud/0/from/teach';
					                         
                            	  	       }

									   }
									 else
									   {
                            	  	     echo CHtml::link($images,array('/persons/viewForReport?id='.$_GET['pers'].'&isstud=0&from=teach'));
					                     $this->back_url='/persons/viewForReport?id='.$_GET['pers'].'&isstud=0&from=teach';
					                   
									   }
					                
                            	  }
                            	  
					          }
                            elseif(isset($_GET['from1']) &&($_GET['from1']=='view'))	    
                              {  echo CHtml::link($images,array('/schoolconfig/courses/view','id'=>$model->id));
                                  $this->back_url='/schoolconfig/courses/view?id='.$model->id;
                               }
                            else 
                              {  echo CHtml::link($images,array('/schoolconfig/courses/index'));
                                  $this->back_url='/schoolconfig/courses/index';   
                               }

                   ?>

                  </div>
           </div>
 </div>          
           

<div style="clear:both"></div>


</br>
<div class="b_mail">
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'courses-form',
	
)); 
echo $this->renderPartial('_form', array(
	'model'=>$model,
	'form' =>$form
	)); ?>


<?php $this->endWidget(); ?>

</div>
</div>
<!-- form -->
