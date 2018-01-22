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

$acad_sess=acad_sess();
$acad=Yii::app()->session['currentId_academic_year'];

?>
<?php $this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); ?>

<div class="form">
<?php
	echo '<p class="note">'.Yii::t('app','Fields with <span class="required">*</span> are required.').'</p>';

	  echo $form->errorSummary($model); ?>

    <div  id="resp_form_siges">

        <form  id="resp_form">
     




      <div class="col-2">
            <label id="resp_form">              
                        
                                <?php  echo '<label>'.Yii::t('app', 'Shift').'</label>'; ?>
                           
                                <?php  
                                
                                $modelShift = new Shifts;
                                
					if(isset($_GET['id']))
					  {  $id_to_update= $_GET['id'];
					     if(isset($id_to_update))
						  { 
						    if($id_to_update!=0)//c 1 update
							  { $this->idShift=$this->getShiftByIdRoom($id_to_update);
								   
								  if(isset($this->idShift['id']))
									 echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('options' => array($this->idShift['id']=>array('selected'=>true)) )); 
							  }
							 else //c pa update
                                {
                                    $default_vacation=null;
						            $criteria = new CDbCriteria;
							   								$criteria->condition='item_name=:item_name';
							   								$criteria->params=array(':item_name'=>'default_vacation',);
							   		$default_vacation_name = GeneralConfig::model()->find($criteria)->item_value;
							   		
							   		$criteria2 = new CDbCriteria;
							   								$criteria2->condition='shift_name=:item_name';
							   								$criteria2->params=array(':item_name'=>$default_vacation_name,);
							   		$default_vacation = Shifts::model()->find($criteria2);
				   		

									if($default_vacation!=null)
								       { echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('options' => array(($default_vacation->id)=>array('selected'=>true)),  )); 
								              $this->idShift=$default_vacation->id;
								       }
								    else
								       echo $form->dropDownList($modelShift,'shift_name',$this->loadShift() ); 


                                     
                                                                    
                                     echo $form->error($modelShift,'shift_name'); 
                                     
                                 }
								
					      }
					      
					  }
						
					  ?>
            </label>
       </div>


       

   
        <div class="col-2">
            <label id="resp_form">
    
            <?php echo '<label>'.Yii::t('app', 'Level').'</label>'; ?>
                          
                             <?php 
				if(isset($_GET['id']))
					  {  $id_to_update= $_GET['id'];
					      if($id_to_update==0)//c pa update
					       {
								$from=$_GET['from'];
								if($from==1)//la creation vient de la page room
								  {  $modelLevel = new Levels;
                                                                  $criteria = new CDbCriteria(array('order'=>'level_name',));
		
                                                                    echo $form->dropDownList($model, 'level',
                                                                    CHtml::listData(Levels::model()->findAll($criteria),'id','level_name'),
                                                                    array('prompt'=>Yii::t('app','-- Select --'))
                                                                            );
										
									  echo $form->error($modelLevel,'level_name'); 
								  }
								 elseif($from==0) //la creation vient de la page level
								  {    
										 $model1=new Levels;
										 echo CHtml::encode($model1->findByPk($_GET['levelID'])->level_name);	
									
								  }
						
					       }					     
					      else//c 1 update
						    { $this->idLevel=$this->getLevelByIdRoom($id_to_update);
							   $modelLevel = new Levels;
								if(isset($this->idLevel['id']))
                                                                
								    echo $form->dropDownList($modelLevel,'level_name',$this->loadLevel(), array('options' => array($this->idLevel['id']=>array('selected'=>true)) )); 
									 
								    echo $form->error($modelLevel,'level_name');
							}
					  }
						?>
            </label>
        </div>



       
       
       <div class="col-2">
            <label id="resp_form">
                          
                          <?php echo $form->labelEx($model,'room_name'); ?>
                          
                              <?php echo $form->textField($model,'room_name',array('size'=>60,'maxlength'=>45,'placeholder'=>Yii::t('app','Room Name'))); ?>
                              <?php echo $form->error($model,'room_name'); ?>
            </label>
        </div>
                          
      
            
        
         <div class="col-2">
            <label id="resp_form">
                                                        
                        <?php echo $form->labelEx($model,Yii::t('app','short_room_name')); ?>
                          
                              <?php echo $form->textField($model,'short_room_name',array('size'=>60,'maxlength'=>45,'placeholder'=>Yii::t('app','Short Room Name'))); ?>
                              <?php echo $form->error($model,'short_room_name'); ?>
            </label>
         </div>



                        
                       <div class="col-submit">
                                
                                <?php if(!isset($_GET['id'])|| $_GET['id']==0){
                                        if(!isAchiveMode($acad_sess))
                                            echo CHtml::submitButton(Yii::t('app', 'Create '),array('name'=>'create','class'=>'btn btn-warning')); //'Create ' avec espace a la fin POUR AVOIR UNE TRADUCTION "ENREGISTRER"
                                         echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary')); //'Cancel ' avec espace a la fin POUR AVOIR UNE TRADUCTION "Annuler"/ sans espace=>'Retour'
                                        }
                                         else
                                           {  if(!isAchiveMode($acad_sess))
                                                 echo CHtml::submitButton(Yii::t('app', 'Save'),array('name'=>'update','class'=>'btn btn-warning'));
                                            
                                              echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary'));
                                              
                                             } 
                                
                                           if(!isAchiveMode($acad_sess))
                                               echo CHtml::submitButton(Yii::t('app', 'Add New Room'),array('name'=>'addNewRoom','class'=>'btn btn-warning'));
                                
                               
                                           //back button   
                                              $url=Yii::app()->request->urlReferrer;
                                              $explode_url= explode("php",substr($url,0));
				             
                                              echo ' <a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';
                                          

                                 ?>
                       </div>
                                
             </form>
</div>
                        
</div>