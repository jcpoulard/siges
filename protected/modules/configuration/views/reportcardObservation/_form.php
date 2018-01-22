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



/* @var $this ReportcardObservationController */
/* @var $model ReportcardObservation */
/* @var $form CActiveForm */

$acad_sess=acad_sess();
 $acad = Yii::app()->session['currentId_academic_year'];

?>




<div  id="resp_form_siges">

        <form  id="resp_form">


             <div class="col-4">
            <label id="resp_form">

              
                    <?php echo $form->label($model,'all_sections'); 
		                              if($this->all_sections==1)
				                          { echo $form->checkBox($model,'all_sections',array('onchange'=> 'submit()','checked'=>'checked'));
				                              
				                           }
						                 else
							               echo $form->checkBox($model,'all_sections',array('onchange'=> 'submit()'));
		                    ?>
		     </label>
        </div>
        
<?php
      if($this->all_sections==0)
             {
?>

      <div class="col-4">
            <label id="resp_form">    
                          <?php echo '<label>'. Yii::t('app', 'Section').'</label>'; ?>
                            
                                <?php 
						
						  $modelSection = new Sections;
						  
						  $criteria = new CDbCriteria(array('order'=>'section_name',));
		
                          echo $form->dropDownList($model, 'section',
                                 CHtml::listData(Sections::model()->findAll($criteria),'id','section_name'),
                                 array('onchange'=> 'submit()','prompt'=>Yii::t('app','-- Select --')) );
                           
                           echo $form->error($modelSection,'section'); 
                                                          					
											
					   ?>
            </label>
         </div>



    <?php
             }
             
    echo $form->errorSummary($model);
 
   function evenOdd($num)
            {
                ($num % 2==0) ? $class = 'odd' : $class = 'even';
                return $class;
            }
  
        ?>
        
    <div class="grid-view" style='width:100%'>
        <table class="items table">
        <?php for($i=0;$i<=6; $i++){ ?>
            <tr class="<?php echo evenOdd($i); ?>">
		
      <!--  <div class="input-group" id="liy_<?php echo $i?>"> -->
            
               <td> 
                    <input name="<?php echo 'start_range'.$i; ?>" type="text" placeholder="<?php echo Yii::t('app','Start range'); ?>">
                </td>  
                <td>
                    <input name="<?php echo 'end_range'.$i; ?>" type="text" placeholder="<?php echo Yii::t('app','End range'); ?>">
                </td>
                <td>
                    <input name="<?php echo 'comment'.$i; ?>" type="text" placeholder="<?php echo Yii::t('app','Comment'); ?>"/>
                </td>
                <!--   </div> -->
        </tr>

        <?php } ?>
        </table>
    </div>
    
        <?php 
                     
        ?>
     
	
     		    
<div class="col-submit">                             
                                <?php 
                         
                            	     if(!isAchiveMode($acad_sess))
                            	    	    echo CHtml::submitButton(Yii::t('app', 'Save'),array('name'=>'btnSave','class'=>'btn btn-warning'));//'Create ' avec espace a la fin POUR AVOIR UNE TRADUCTION "ENREGISTRER"
	                                         
	                                         echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary')); //'Cancel ' avec espace a la fin POUR AVOIR UNE TRADUCTION "Annuler"/ sans espace=>'Retour'
                            	    	     
                            	    	   
                                           
                                           //back button   
                                              $url=Yii::app()->request->urlReferrer;//$_SERVER['REQUEST_URI'];
                                              $explode_url= explode("php",substr($url,0));
				             
                                              echo ' <a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';
                                          

                        
                                ?>
              
                           </div>
       <?php
                
      
      ?>       
  


    </form>
</div><!-- form -->

