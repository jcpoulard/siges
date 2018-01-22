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

$this->pageTitle = Yii::app()->name. ' - '.Yii::t('app','Update {name}',array('{name}'=>$model->article_title));
?>

<div id="dash">
		<div class="span3"><h2>
		     <?php echo Yii::t('app','Update {name}',array('{name}'=>$model->article_title)); ?>
		     
		</h2> </div>
    
    <div class="span3">
        <div class="span4">
             <?php
                    $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';
                     echo CHtml::link($images,array('cmsArticle/create')); 
                   ?>
        </div>
        
        <div class="span4">
            <?php
                
                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                    if(isset($_GET['from'])){
                        
                        if($_GET['from']=='view')
                        {
                            echo CHtml::link($images,array('/portal/cmsArticle/index'));
                            $this->back_url='/portal/Article/index';
                        }
                      }
                      else
                       { echo CHtml::link($images,array('/portal/cmsArticle/index')); 
                         $this->back_url='/portal/cmsArticle/index';
                       }

                   ?>
        </div>
    </div>
</div>

<div style="clear:both"></div>

<div style="clear:both"></div>

<br/>
<div class="b_mail">

<div class="form">

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
</div>