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



 $acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

 


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
     






    function evenOdd($num)
            {
                ($num % 2==0) ? $class = 'odd' : $class = 'even';
                return $class;
            }
            
   
    

?>
    <?php
        
            
            echo $form->errorSummary($model);
        
        ?>
        
    
    
        <?php 
        
        
        
        
        
        
        if(isAchiveMode($acad_sess))
         {
         	$this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'reportcard-observation-grid',
	'dataProvider'=>$model->search(),
	'showTableOnEmpty'=>false,
        
	'summaryText'=>'',
	'columns'=>array(
		array(
                'name'=>'section',
                'headerHtmlOptions' => array('style' => 'width: 200px'),
                'value' =>'data->section0->section_name'  
            ),
         array(
                'name'=>'start_range',
                'headerHtmlOptions' => array('style' => 'width: 200px'),
                'value' =>'data->start_range'  
            ),
            array(
                'name'=>'end_range',
                'headerHtmlOptions' => array('style' => 'width: 200px'),
                'value' =>'data->end_range'
            ),
            array(
                'name'=>'comment',
                'headerHtmlOptions' => array('style' => 'width: 200px'),
                'value' =>'data->comment' 
            ),
            
	),
            )); 
        }  
     else
       {
        $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'reportcard-observation-grid',
	'dataProvider'=>$model->search($acad_sess),
	'showTableOnEmpty'=>false,
        
	'summaryText'=>'',
	'columns'=>array(
		array(
                'name'=>'section0.section_name',
                'headerHtmlOptions' => array('style' => 'width: 200px'),
                //'value' =>'data->section0->section_name'  
            ),
            array(
                'class' => 'editable.EditableColumn',
                'name'=>'start_range',
                'headerHtmlOptions' => array('style' => 'width: 200px'),
                'editable' => array(    //editable section
                
                  'url'        => $this->createUrl('reportcardObservation/updateObservation'),
                  'placement'  => 'right',
              )  
            ),
            array(
                'class' => 'editable.EditableColumn',
                'name'=>'end_range',
                'headerHtmlOptions' => array('style' => 'width: 200px'),
                'editable' => array(    //editable section
                
                  'url'        => $this->createUrl('reportcardObservation/updateObservation'),
                  'placement'  => 'right',
              )  
            ),
            array(
                'class' => 'editable.EditableColumn',
                'name'=>'comment',
                'headerHtmlOptions' => array('style' => 'width: 200px'),
                'editable' => array(    //editable section
                
                  'url'        => $this->createUrl('reportcardObservation/updateObservation'),
                  'placement'  => 'right',
              )  
            ),
            
	),
            )); 
            
           }
           
        
        
        ?>
   
     		    
<div class="col-submit">                             
                                <?php 
                         
                            	           //back button   
                                              $url=Yii::app()->request->urlReferrer;//$_SERVER['REQUEST_URI'];
                                              $explode_url= explode("php",substr($url,0));
				             
                                              echo ' <a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';
                                          

                        
                                ?>
              
                           </div>
     
    </form>
</div><!-- form -->

