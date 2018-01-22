
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
/* @var $form CActiveForm */

$acad_sess=acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

$this->pageTitle = Yii::app()->name. ' - '.Yii::t('app','Create User');
?>

	<?php
	echo 'ppp<p class="note">'.Yii::t('app','Fields with <span class="required">*</span> are required.').'</p>';

	  echo $form->errorSummary($user); ?>
    <?php echo $form->errorSummary($person); ?>
        

                
        
	<div class="box box-info">
         <div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin">
                      
                      <tbody>
                        
                       <tr>
			            <td><?php echo $form->labelEx($person,'first_name'); ?></td>
			           <td> <?php echo $form->textField($person, 'first_name', array('size'=>20,'maxlength'=>20)); ?>
			            <?php echo $form->error($person,'first_name'); ?></td>
			            			        
			            <td><?php echo $form->labelEx($person,'last_name'); ?></td>
			            <td><?php echo $form->textField($person, 'last_name', array('size'=>20,'maxlength'=>20)); ?>
			            <?php echo $form->error($person,'last_name'); ?></td>
            
                     </tr>

					<tr>
						<td><?php echo $form->labelEx($user,'username'); ?></td>
						<td><?php echo $form->textField($user,'username',array('size'=>20,'maxlength'=>20)); ?>
						<?php echo $form->error($user,'username'); ?></td>
					
					     <td></td>
						 <td></td>
						 
					</tr>
	
	                 <tr>
			            <td><?php echo $form->labelEx($user,'group_id'); ?></td>
			            <td><?php  if(isset($this->group_id))
										      echo $form->dropDownList($user,'group_id',$this->loadGroups(), array('onchange'=> 'submit()','options' => array($this->group_id=>array('selected'=>true)))); 
								 else
			                      {  if(Yii::app()->user->userid==2)
			                            $criteria='';
			                         else
			                            $criteria='group_name NOT LIKE("Developer")';
			                      	echo $form->dropDownList($user, 'group_id',
					 CHtml::listData(Groups::model()->findAll( $criteria),'id','group_name'),
				  array('onchange'=> 'submit()','prompt'=>Yii::t('app','-- Select --'))
				    );
			                        }
			            ?>
			            <?php echo $form->error($user,'group_id'); ?></td>
			       			        
			            <td><?php echo $form->labelEx($user,'profil'); ?></td>
			            <td><?php echo $form->dropDownList($user,'profil', $this->searchProfilByGroupID($this->group_id));  ?>
			            <?php echo $form->error($user,'profil'); ?></td>
			            
			        </tr>


                     <tr>
                        <td><?php echo $form->labelEx($user,'password'); ?></td>
						<td><?php echo $form->passwordField($user,'new_password',array('size'=>20,'maxlength'=>64)); ?>
						<?php echo $form->error($user,'password'); ?></td>
						
						<td><?php echo $form->labelEx($user,'password_repeat'); ?></td>
			            <td><?php echo $form->passwordField($user, 'password_repeat',array('size'=>20,'maxlength'=>64)); ?>
			            <?php echo $form->error($user,'password_repeat'); ?></td>
			            
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
				             
                                              echo '<a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';
                                                                      ?>
                                
                            </td>
                            
                        </tr>
                       
                      
                      </tbody>
                    </table>
                  </div><!-- /.table-responsive -->
                </div><!-- /.box-body -->
                
              </div>
<!-- END OF TEST -->