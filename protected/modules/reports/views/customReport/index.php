<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
            $attributes_name = Persons::model()->attributeNames();
            $attributes_label = $model->personAttributesLabels();
            
            $attributes_grades = RecordInfraction::model()->attributeNames();
            print_r($attributes_label);
            
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'custom-report-index',
	'enableAjaxValidation'=>true,
        )); 

            
?>

<div class="row span12">
    <div id="dash">
        <div class="span3"><h1><?php echo Yii::t('app','SIGES custom report builder');  ?></h1></div>
     </div>
    <div class="span12">
        <div class="form-group span2">
            <label for="dimension"><?php echo Yii::t('app','Domaine'); ?></label>
            <select name="dimension" class="form-control">
                <option value="1"><?php echo Yii::t('app','Persons'); ?></option>
                <option value="2"><?php echo Yii::t('app','Grades'); ?></option>
                <option value="3"><?php echo Yii::t('app','Discipline'); ?></option>
                <option value="4"><?php echo Yii::t('app','Billings'); ?></option>
            </select>
        </div>
        <div class="form-group span2">
            
            <label for="available_fields"><?php echo Yii::t('app','Select fields');?></label>
            <select name="available_fields[]" multiple class="form-control">
                <?php 
                
                   for($i=0; $i<count($attributes_name);$i++){
                      
                       echo "<option value=$attributes_name[$i]>".$attributes_label[$attributes_name[$i]]."</option>";
                      
                      }
                     
                ?>
            </select>
        </div>
        
        <div class="form-group span2">
            
            <label for="filter_by"><?php echo Yii::t('app','Filter by');?></label>
            <select name="filter_by" class="form-control">
                <?php 
                
                   for($i=0; $i<count($attributes_name);$i++){
                      
                       echo "<option value=$attributes_name[$i]>".$attributes_label[$attributes_name[$i]]."</option>";
                      
                      }
                     
                ?>
            </select>
        </div>
        
        <div class="form-group span2">
             <label for="operateur"><?php echo Yii::t('app','Choose an operator');?></label>
             <select name="operateur">
              <?php  
                 $operateurs = $model->getOperateurs();
                 for($i=0;$i<count($operateurs);$i++){
                     echo "<option value=$operateurs[$i]>$operateurs[$i]</option>";
                 }
                     
               ?>
             </select>
        </div>
        
        <div class="form-group span2">
            <label for="parameter"><?php echo Yii::t('app','Parameter');?></label>
            <input name="parameter"  type="text"/>
            
        </div>
           
        
        
    </div>
    <div class="row-fluid">
    <div class="form-group span3">
            <button type="submit" name="btnPreview" class="btn btn-secondary"><?php echo Yii::t('app','Preview report'); ?></button>
    </div> 
    
    <div class="form-group span3">
            <button type="submit" name="btnPreview" class="btn btn-secondary"><?php echo Yii::t('app','Save report'); ?></button>
    </div>
    
    <div class="form-group span3">
            <button type="submit" name="btnPreview" class="btn btn-secondary"><?php echo Yii::t('app','Add more criteria'); ?></button>
    </div>
    </div>
</div>
    

<?php
echo 'SQL STRING :  ';
    
    $string = "SELECT last_name, first_name,birthday, gender FROM persons";
    
   // $columns_value = array('last_name','first_name','birthday', 'genders1');
    $columns_value = $attributes_name;
   // $columns_label = array(Yii::t('app','Last name'),Yii::t('app','First name'),Yii::t('app','Birthday'),Yii::t('app','Gender'));
   $columns_label = $attributes_label ; 
   if($this->string_sql != null){
    $data_ = $model->getAllElement($this->string_sql);
   }else{
       $data_ = null;
   }
    
    ?>
<?php 
    if($this->string_sql != null){
     print_r($this->string_sql);
     echo $this->query_yii;
    }
?>


<!--  DO IT WITH A YII GRID -->

<?php 

if($this->string_sql != null){

        $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
        
        $gridWidget = $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'record-infraction-grid',
	'dataProvider'=>$model->report($this->query_yii),
         'columns'=>$this->attributes_name,   
	/*
	'columns'=>array(
		array(
                    'name' => 'student',
                    'type' => 'raw',
                    'value'=>'CHtml::link($data->student0->fullName." (".$data->student0->id_number.")",Yii::app()->createUrl("discipline/recordInfraction/view",array("id"=>$data->id)))',
                    'htmlOptions'=>array('width'=>'200px'),
                     ),
		
		
                array(
                    'name' => 'infraction_type',
                    'type' => 'raw',
                    'value'=>'$data->infractionType->name',
                    'htmlOptions'=>array('width'=>'200px'),
                     ),
		'record_by',
                'value_deduction',
                array('name'=>'incident_date','value'=>'$data->incidentDate'),
		
		     	array(
			'class'=>'CButtonColumn',
                        'template'=>'{update}{delete}',
                        'buttons'=>array('update'=>array('label'=>'<span class="fa fa-pencil-square-o"></span>',
                            'imageUrl'=>false,
                            'options'=>array('title'=>Yii::t('app','Update')),
                             
                            ),
                            'delete'=>array('label'=>'<span class="fa fa-trash-o"></span>',
                            'imageUrl'=>false,
                            'options'=>array('title'=>Yii::t('app','Delete')),
                             
                            ),
                            
                            ),
                        'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                        'onchange'=>"$.fn.yiiGridView.update('record-infraction-grid',{ data:{pageSize: $(this).val() }})",
            )),

		),
	),*/
)); 


   // Export to CSV 
 // $content=$model->search_($month_,$acad)->getData();
// if((isset($content))&&($content!=null))
//   $this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app',' CSV'),array('class'=>'btn-info btn'));


}

?>

<!-- END OF YII GRID -->

<!--
<div class="grid-view">
<table class="items table-responsive table-condensed">
    <tr>
<?php

if($this->string_sql!=null){
   for($i = 0; $i<count($this->attributes_name);$i++) {
       echo "<th>".$columns_label[$this->attributes_name[$i]]."</th>";
       
    }

    }
    
?>
 </tr>
 
<?php 

if($data_ != null){
    
    foreach($data_ as $d){
        echo "<tr>";
        
        for($i=0; $i < count($this->attributes_name);$i++){
            
            echo "<td>".$d[$columns_value[$i]]."</td>";
            
            
        }
       echo "</tr>";      
    }
}else{
    
}
 
    
    ?>
 
</table>
</div>

-->
<?php $this->endWidget(); ?>