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


$acad=Yii::app()->session['currentId_academic_year']; 
$acad_sess=acad_sess();
?>

<?php
	echo '<p class="note">'.Yii::t('app','Fields with <span class="required">*</span> are required.').'</p>';

	  echo $form->errorSummary($model); ?>

<?php


//error message
	   	        
	        
                				       
			if(($this->message_default_group_u)||($this->message_studentparent_group_u)||($this->warning_message_for_developer))		
			      { echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:-17px; ';//-20px; ';
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
				   
				   if($this->warning_message_for_developer)
				     { echo '<span style="color:red;" >'.Yii::t('app','Please do not update this group, until you really sure of what you do!').'</span>';
				       $this->warning_message_for_developer=false;
				        echo'</td>
					    </tr>
						</table>';
					
			           echo '</div>
			           <div style="clear:both;"></div>';
				     }

			
	     
?>



<div class="b_mail">
<div class="box box-info">
         <div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin">
                      
                      <tbody>
                        <tr>
                          <td><?php echo $form->labelEx($model,'group_name'); ?></td>
                          <td>
                              <?php echo $form->textField($model,'group_name',array('size'=>32,'maxlength'=>32)); ?>
                              <?php echo $form->error($model,'group_name'); ?>
                          </td> 
                          
                          <td><?php echo $form->labelEx($model,'belongs_to_profil'); ?></td>
                          <td>
                              <?php if(isset($this->belongs_to_profil))
							      echo $form->dropDownList($model,'belongs_to_profil',$this->loadBelongsProfil(), array('onchange'=> 'submit()','options' => array($this->belongs_to_profil=>array('selected'=>true)))); 
							  else  
								   echo $form->dropDownList($model,'belongs_to_profil',$this->loadBelongsProfil(),array('onchange'=> 'submit()'));
                               ?>
                              <?php echo $form->error($model,'belongs_to_profil'); ?>
                          </td>
                         
                        </tr>
                        
                        <tr>
                          <td colspan="3"> 
                               <?php
  
							    
							    $module_list = Modules::model()->searchByProfil($this->belongs_to_profil);
							    $t = $module_list->getData();
							    $tab_array=array(); 
							    $i=0;
							    foreach($t as $m)
							    {
							     $i++;
							        
							    
							    $criteria = new CDbCriteria(array('condition'=>'module_id=:module_s','params'=>array(':module_s'=>$m->id),'order'=>'action_name ASC',));
							      
							        $action = CHtml::listData(Actions::model()->findAll($criteria), 'id', 'action_name');
							        $selected_keys_a = array_keys(CHtml::listData($model->actions, 'id' , 'id'));
							        
							        
							        
							    if(Yii::app()->user->groupid!=1)
							      {  if($m->module_short_name!='users')//!='Developer'
							           {  $tab_array[$m->module_name] = CHtml::checkBoxList('Groups[Actions][]', $selected_keys_a, $action,array('template'=>'<div class="rmodal"> <div class="row"> <div class="l">{label}</div><div class="r">{input}</div></div></div>',"checkAll" => Yii::t('app','Select All')));
                                       }
							      }
							     else//group: Developer
							       { 
							       	  $tab_array[$m->module_name] = CHtml::checkBoxList('Groups[Actions][]', $selected_keys_a, $action,array('template'=>'<div class="rmodal"> <div class="row"> <div class="l">{label}</div><div class="r">{input}</div></div></div>',"checkAll" => Yii::t('app','Select All')));

							       	 }
							       	  
							        
							    }
							    
							      $this->widget('zii.widgets.jui.CJuiAccordion',array(
							      'panels'=>$tab_array,    
							   
							    // additional javascript options for the accordion plugin
							'options'=>array(
							
							        'collapsible'=> true,
							
							        'animated'=>'bounceslide',
							
							        'autoHeight'=>false,
							
							        
							
							    ),
							
							));
							    
							     
							    ?>
                          </td>
                          <td></td>
                        </tr>
                       
                        
                        <tr>
                            <td colspan="4"> 
                                
                                <?php if(!isset($_GET['id'])){
                                         if(!isAchiveMode($acad_sess))
                                            echo CHtml::submitButton(Yii::t('app', 'Create '),array('name'=>'create','class'=>'btn btn-warning'));
                                         
                                         echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary'));
                                        }
                                         else
                                           {  if(!isAchiveMode($acad_sess))
                                                 echo CHtml::submitButton(Yii::t('app', 'Save'),array('name'=>'update','class'=>'btn btn-warning'));
                                            
                                              echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary'));
                                              
                                             } 
                                           //back button   
                                              $url=Yii::app()->request->urlReferrer;
                                              $explode_url= explode("php",substr($url,0));
				             
                                              echo ' <a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';
                                      
                                          
                                         
                                ?>
                                
                            </td>
                            
                        </tr>
                       
                      
                      </tbody>
                    </table>
                  </div><!-- /.table-responsive -->
                </div>
				</div>
			
<!-- /.box-body -->
                
              </div> 
<!-- END OF TEST -->



