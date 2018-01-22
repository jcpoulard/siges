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

?>
<?php 
    $this->pageTitle = Yii::app()->name. ' - '.Yii::t('app','Update passing grades {name1}  / {name2}',array('{name1}'=>$model->level0->level_name,'{name2}'=>$model->academicPeriod->name_period));
?>
<div class="search-form">
    <?php
    echo $this->renderPartial('//layouts/navBaseConfiguration',NULL,true);	
    ?>
</div>

<div class="row">
    <div class="span6">
        <span class="fa fa-crop fa-2x">
            <?php echo Yii::t('app','Update passing grades {name1} / {name2}',array('{name1}'=>$model->level0->level_name,'{name2}'=>$model->academicPeriod->name_period)); ?>

        </span>
    </div>
    <div class="span3">
        
    </div>
    <div class="span3">
        <div class="span4">
            
        </div>
        <div class="span4">
             <?php
                $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';

                echo CHtml::link($images,array('passinggrades/create')); 
               ?>
        </div>
        
        <div class="span4">
           <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard
                     if(isset($_GET['from']))
                     {
                         if($_GET['from']=='view'){
                             echo CHtml::link($images,array('passinggrades/view','id'=>$_GET['id']));
                         }
                     }
                     else
                     echo CHtml::link($images,array('passinggrades/index')); 
                   ?>
        </div>
    </div>
</div>



<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>