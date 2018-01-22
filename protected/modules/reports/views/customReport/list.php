<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



?>


    <div id="dash">
            <div class="span3">
                <h2><?php echo Yii::t('app','List custom report');  ?></h2>
            </div>
        
     <div class="span3">       
         <div class="span4">
                  <?php

                 $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Create report').'</i>';
                           // build the link in Yii standard
                 echo CHtml::link($images,array('customReport/customReportStud?part=stud&from1=rpt'));
                 
                   ?>
        </div> 
           
        
     </div>
  
    </div>
<div style="clear:both"></div>

    
<div class="row-fluid">
<?php
    echo $this->renderPartial('//layouts/navCustomReport',NULL,true);	
 ?>
</div>
<div class="row-fluid">
        <div class="span12 well">
            <label for="AcademicPeriods"><?php echo Yii::t('app', 'Academic year'); ?></label>
            <?php 
            if($this->academic_year==null){
                $acad=Yii::app()->session['currentId_academic_year'];
            }else{
                $acad = $this->academic_year;
            }
            ?>
           <?php 
           $modelAP=new AcademicPeriods;
           $form=$this->beginWidget('CActiveForm', array(
                                'id'=>'academic-year-form',
                                'enableAjaxValidation'=>true,
                                        )); 

                $criteria = new CDbCriteria(array('condition'=>'is_year=1','order'=>'date_end DESC',));

                echo $form->dropDownList($modelAP, 'name_period',
                CHtml::listData(AcademicPeriods::model()->findAll($criteria),'id','name_period'),
                array('options' => array(($acad)=>array('selected'=>true)),'onchange'=> 'submit()',
                    'name'=>'academic_year')
                );


                                $this->endWidget();
              ?>  
            
        </div>
    </div>
<?php 
    $data_rpt = $model->findAllBySql("SELECT * FROM rpt_custom WHERE academic_year = $acad ORDER BY title ASC"); 
?>
<div class="row-fluid">
    
    <div class="span12">
        <table> 
            <thead>
                <tr>
                    <th><?php echo Yii::t('app','Report title'); ?></th>
                    <th><?php echo Yii::t('app','Description'); ?></th>
                    <th><?php echo Yii::t('app','Category'); ?></th>
                    <th><?php echo Yii::t('app','Create date'); ?></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
        <?php 
            foreach($data_rpt as $d){
                $arr_ = json_decode($d->data,true);
                $description = $arr_['report_description'];
                
                
                
        ?>
            <tr>    
                <td><a href="<?php echo Yii::app()->baseUrl.'/index.php/reports/customReport/listdetails?id='.$d->id.'&part=stud&from1=rpt'; ?>"> <?php echo $d->title; ?></a></td>
                <td><?php echo $description; ?></td>
                <td><?php echo Yii::t('app',"$d->categorie"); ?></td>
                <td><?php echo $d->create_date; ?></td>
                <td><a href="<?php echo Yii::app()->baseUrl.'/index.php/reports/customReport/listdetails?id='.$d->id.'&part=stud&from1=rpt'; ?>" title="<?php echo Yii::t('app','Run report'); ?>"><i class="fa fa-play"></i></a></td>
                <?php
                if(Yii::app()->user->profil=="Admin"){
                 ?> 
                <td><a Onclick="return ConfirmDelete()" href="<?php echo Yii::app()->baseUrl.'/index.php/reports/customReport/delete?id='.$d->id; ?>" title="<?php echo Yii::t('app','Delete report'); ?>"><i class="fa fa-trash-o"></i></a></td>
             <?php    
                }
                ?>
            </tr>
            <?php    
                 
             }
        ?>
        </table>    
      
    </div>
    
</div>

<script>
    function ConfirmDelete()
        {
          var x = confirm("<?php echo Yii::t('app','Are you sure you want to delete?'); ?>");
          if (x)
              return true;
          else
            return false;
        }
</script>