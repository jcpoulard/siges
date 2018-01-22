<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$acad=Yii::app()->session['currentId_academic_year'];  


$form=$this->beginWidget('CActiveForm', array(
	'id'=>'data-migration-employees',
	'enableAjaxValidation'=>false,
        'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
      ),
));

?>

<div id="dash">
    <div class="span3">
        <h2><?php echo Yii::t('app','Employees data migration'); ?></h2> 
    </div>
    		   
</div>



<?php
    echo $this->renderPartial('//layouts/navBaseMigration',NULL,true);	
?>

<div>
    <div class="row-fluid">
     
        <?php 
               if(!isAchiveMode($acad))
                 {         
        ?>
     
        <div class="span6 well" style="height: 120px;">
            <label>
                <?php echo Yii::t('app','Please select a CVS file '); ?>
            </label>
            <input type="file" name="input_csv"/>
            <button class="btn btn-warning" type="submit" name="btnUpload"><?php echo Yii::t('app','Upload file'); ?></button>
        </div>

      <?php
                 }
      
      ?>       

        <div class="span6 well" style="height: 120px;">
            <p>
                <?php echo Yii::t('app','Welcome to SIGES data migration tool.<br/>Please upload a csv file using the following format in this specific order : Last name - First name - Gender - Birthday.<br/>Birthday need to be in the format of day-month-year (22-12-2014)'); ?>
            </p> 
        </div>
    </div>
</div>


    <?php  
    
   // Verrifie que le fichier existe et a ete uploade 
    if($this->file_name!==null && $this->temoin){
    ?>
    <div class="row-fluid">
    <form method="POST">
        
        <div class="grid-view">
        <table class="items">
            <th>
                #
            </th>
           
            <th>
                <?php echo Yii::t('app','Last name'); ?>
            </th>
            <th>
                <?php echo Yii::t('app','First name'); ?>
            </th>
            <th>
                <?php echo Yii::t('app','Gender'); ?>
            </th>
            <th>
                <?php echo Yii::t('app','Birthday'); ?>
            </th>
            
            
    <?php
   
        // accede au fichier 
        $filename = Yii::app()->basePath.'/../tmp_csv/'.$this->file_name;
        $row=1;
        $flag = true;
        // Tableau pour formatte les sexes de maniere intelligente 
        $female_array = array('Female','Feminin','Fi','Fanm','Féminin','Fille','F','f','1','female','feminin','féminin','fille','fi','fanm','Mujer','mujer','femme','Femme');
        $male_array = array('Male','','Masculin','Gason','Garcon','Garçon','M','m','0','male','masculin','gason','garçon','Hombre','hombre','homme','Homme');
       // Charge le fichier dans un handle 
        if (($handle = fopen($filename, "r")) !== FALSE) {
                            while (($this->data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                                // Evite la premiere ligne qui contient les entete 
                                if($flag){
                                    $flag = false; 
                                    continue; 
                                 }
                                    $num = count($this->data);
                                    // Contruit le tableau d'affichage du fichier CSV dans SIGES pour faciliter les corrections possibles 
                                    echo '<tr>';
                                    $row++;
                                    $ligne_reelle = $row-1;
                                    echo '<td>'.$ligne_reelle.'</td>';
                                    /*
                                    echo '<td>';
                                        $criteria = new CDbCriteria(array('order'=>'title_name',));
                                        echo $form->dropDownList($model, 'title',
                                        CHtml::listData(Titles::model()->findAll($criteria),'id','title_name'),
                                        array('prompt'=>Yii::t('app','-- Please select a title --'),'name'=>'title'.$row)
                                        );
                                    echo '</td>';
                                     * 
                                     */
                                    for ($c=0; $c < $num; $c++) {
                                        
                                        if($c==2){
                                            if(in_array($this->data[$c], $male_array)){
                                                $gender = 0;
                                                echo '<td><select name="gender'.$row.'"><option value="'.$gender.'">'.Yii::t('app','Male').'<option value="1">'.Yii::t('app','Female').'</option></select></td>';
                                            }elseif(in_array($this->data[$c], $female_array)){
                                                $gender = 1;
                                                echo '<td><select name="gender'.$row.'"><option value="'.$gender.'">'.Yii::t('app','Female').'<option value="0">'.Yii::t('app','Male').'</option></select></td>';
                                            }
                                            
                                        }elseif($c==0){
                                            echo '<td><input type="text" name="last_name'.$row.'" value="'.$this->data[$c].'"></td>';
                                        }elseif($c==1){
                                            echo '<td><input type="text" name="first_name'.$row.'" value="'.$this->data[$c].'"></td>';
                                        }elseif($c==3){
                                            echo '<td><input type="text" name="birthday'.$row.'" value="'.$this->data[$c].'"></td>';
                                        }
                                        
                                    }
                                    
                                    
                                 
                                    echo '</tr>';
                                    $this->nombre_ligne++;
                                }
                                 
                                fclose($handle);
                                
                            } 
    
    ?>
        </table>
        <input type="hidden" name="file_name" value="<?php echo $this->file_name; ?>" />
        <input type="hidden" name="nombre_ligne" value="<?php echo $this->nombre_ligne; ?>"/>
        <div class="col-submit"> 
        <button name="btnFinish" class="btn btn-warning" type="submit"><?php echo Yii::t('app','Migrate employees');  ?></button>
        <button name="btnCancel" class="btn btn-secondary" type="submit"><?php echo Yii::t('app','Cancel ');  ?></button>
    
        
        </div>
        </form>
    </div>
    <?php } ?>
    
</div>


<?php
   $this->endWidget();
?>