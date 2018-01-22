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
 *//* @var $this CmsArticleController */
/* @var $model CmsArticle */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cms-article-form',
	'enableAjaxValidation'=>false,
)); ?>
    
        <?php
            echo $form->errorSummary($model); 
        ?>
<div class="box box-info">
         <div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin">
                      
                      <tbody>
                        <tr>
                          <td><?php echo $form->labelEx($model,'article_title'); ?></td>
                          <td>
                              <?php echo $form->textField($model,'article_title',array('size'=>45,'maxlength'=>45)); ?>
                              <?php echo $form->error($model,'article_title'); ?>
                          </td>
                          
                          <td>
                              <label><?php echo Yii::t('app','Article menu'); ?></label>
                          </td>
                          <td>
                              <?php
                                $criteria = new CDbCriteria(array('condition'=>'is_publish=1', 'order'=>'menu_label',));
								
                                echo $form->dropDownList($model, 'article_menu',
                                CHtml::listData(CmsMenu::model()->findAll($criteria),'id','menu_label'),
                                array('prompt'=>Yii::t('app','Select a menu'))
                                );
                              ?>
                          </td>
                          <td><?php echo $form->labelEx($model,'set_position'); ?></td>
                          <td>
                              <?php 
                                
                                echo $form->dropDownList($model, 'set_position',$model->getPositionName(),
                                        array('onchange'=> 'submit()','prompt'=>Yii::t('app','-- Select --'),'disabled'=>false,'options' => array($this->position_id=>array('selected'=>true))));
                                
                                ?>
                                <?php echo $form->error($model,'set_position'); ?>
                           </td>
                          
                        </tr>
                        <?php if(isset($_GET['id'])) { ?>
                        <tr>
                            <td>
                                <?php  echo $form->labelEx($model,'is_publish');  ?>
                            </td>
                            <td>
                               <?php  echo $form->checkBox($model,'is_publish');  ?>
                              <?php  echo $form->error($model,'is_publish');  ?>
                            </td>
                            
                          <td></td>
                          <td>
                              
                          </td>
                          
                        </tr>
                        <?php } ?>
                        <tr>
                            <?php 
                            if(!isset($_GET['id'])){
                                if($this->position_id == "main" || $this->position_id == "admission" || $this->position_id == "about") { ?>
                            <td colspan="6">
                                <script src="<?php echo Yii::app()->baseUrl.'/js/ckeditor/ckeditor.js'; ?>"></script>
                                <?php echo $form->labelEx($model,'article_description'); ?>
                                <?php echo $form->textArea($model,'article_description',array('id'=>'editor1')); ?>
                                  <script type="text/javascript">
                                    CKEDITOR.replace( 'editor1', {
                                         filebrowserBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/browse.php?type=files',
                                         filebrowserImageBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/browse.php?type=images',
                                         filebrowserFlashBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/browse.php?type=flash',
                                         filebrowserUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/upload.php?type=files',
                                         filebrowserImageUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/upload.php?type=images',
                                         filebrowserFlashUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/upload.php?type=flash'
                                    });
                                </script>
                                    <?php echo $form->error($model,'article_description'); ?>
                                
                            </td>
                            <?php } else { ?>
                            <td colspan="6"><?php echo $form->labelEx($model,'article_description'); ?>
                            
                               <?php echo $form->textArea($model,'article_description',array('rows'=>6,'cols'=>36,'id'=>'text_description','maxlength'=>400,'onkeydown'=>'verifyText();')); ?> 
                                <div id="le_li_long"><span><?php echo Yii::t('app','Remaining character:'); ?> </span><span id="text_long">400</span></div> 
                                <?php echo $form->error($model,'article_description'); ?>
                            </td>
                            <?php } } elseif($model->set_position == "main" || $model->set_position == "admission" || $model->set_position == "about"){?>
                            
                            <td colspan="6">
                                <script src="<?php echo Yii::app()->baseUrl.'/js/ckeditor/ckeditor.js'; ?>"></script>
                                <?php echo $form->labelEx($model,'article_description'); ?>
                                <?php echo $form->textArea($model,'article_description',array('id'=>'editor1')); ?>
                                  <script type="text/javascript">
                                    CKEDITOR.replace( 'editor1', {
                                         filebrowserBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/browse.php?type=files',
                                         filebrowserImageBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/browse.php?type=images',
                                         filebrowserFlashBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/browse.php?type=flash',
                                         filebrowserUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/upload.php?type=files',
                                         filebrowserImageUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/upload.php?type=images',
                                         filebrowserFlashUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/upload.php?type=flash'
                                    });
                                </script>
                                    <?php echo $form->error($model,'article_description'); ?>
                            </td>
                            
                            
                            <?php }else{?>
                            <td colspan="6">
                                <?php echo $form->labelEx($model,'article_description'); ?>
                            
                               <?php echo $form->textArea($model,'article_description',array('rows'=>6,'cols'=>36,'id'=>'text_description','maxlength'=>400,'onkeydown'=>'verifyText();')); ?> 
                                <div id="le_li_long"><span><?php echo Yii::t('app','Remaining character:'); ?> </span><span id="text_long">400</span></div>
                                <?php echo $form->error($model,'article_description'); ?>
                            </td>
                            <?php }?>
                        </tr>
                       
                        
                        <tr>
                            <td colspan="6"> 
                                
                                <?php if(!isset($_GET['id'])){
                                         echo CHtml::submitButton(Yii::t('app', 'Create '),array('name'=>'create','class'=>'btn btn-warning')); //'Create ' avec espace a la fin POUR AVOIR UNE TRADUCTION "ENREGISTRER"
                                         echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary')); //'Cancel ' avec espace a la fin POUR AVOIR UNE TRADUCTION "Annuler"/ sans espace=>'Retour'
                                        }
                                         else
                                           {  echo CHtml::submitButton(Yii::t('app', 'Save'),array('name'=>'update','class'=>'btn btn-warning'));
                                            
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
                </div><!-- /.box-body -->
                
              </div>  

    
    
	
	

<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">

function verifyText(){
    var string = document.getElementById("text_description").value; 
    document.getElementById("text_long").innerHTML = 400 - string.length;
   
}

</script>