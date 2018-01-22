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

        $criteria2 = new CDbCriteria;
	$criteria2->condition='item_name=:item_name';
	$criteria2->params=array(':item_name'=>'school_address',);
	$school_address = GeneralConfig::model()->find($criteria2)->item_value;
        
        


?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    


   
   
    <title><?php echo infoGeneralConfig('school_name').' - Nous contacter'; ?></title>
  



  </head>
<!-- NAVBAR
================================================== -->
<body onload="validateHuman();">
    
 
    
    <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

    <div class="row-fluid">

    
<!-- style=" width: 100%; margin: 0 auto;" class="featurette-heading" -->
<div class="col-md-7">
    <h3 class="featurette-heading">
    <?php echo Yii::t('app','Nous contacter'); ?>
    </h3>
				
  <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'contact-form',
                'enableAjaxValidation' => false,
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                        'validateOnSubmit'=>true,
                ),
        )); ?>



                <div class="form-group col-md-12">
                    <label for="name">Nom *</label>
                        
                        <?php echo $form->textField($model,'name',array('class'=>'form-control')); ?>
                    <span class="alert-danger"><?php echo $form->error($model,'name'); ?></span>
                </div>

                 <div class="form-group col-md-12">
                     <label for="email">Email *</label>
                        
                        <?php echo $form->textField($model,'email',array('class'=>'form-control')); ?>
                       <span class="alert-danger"> <?php echo $form->error($model,'email'); ?></span>
                </div>

               <div class="form-group col-md-12">
                   <label for="subject">Sujet *</label>
                        
                        <?php echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>128,'class'=>'form-control')); ?>
                   <span class="alert-danger">   <?php echo $form->error($model,'subject'); ?></span>
                </div>

               <div class="form-group col-md-12">
                   <label for="body">Message * </label>
                       
                        <?php echo $form->textArea($model,'body',array('rows'=>4, 'cols'=>50,'class'=>'form-control')); ?>
                   <span class="alert-danger">  <?php echo $form->error($model,'body'); ?></span>
                </div>
                                            
                <div class="form-group col-md-12">
                    <label><?php echo Yii::t('app','Quel est le résultat de : '); ?><span id="human1"></span> + <span id="human2"></span> ?</label>
                    
                    <input type="hidden" id="result_hide" name="result_hide"/>
                    <input class="form-control" id="result" name="result" type="number" required="required"/>
                </div>                            
          

                <div class="col-md-12">
                        <?php echo CHtml::submitButton(Yii::t('app','Envoyer message'),array('class'=>'btn btn-success')); ?>
                </div>

        <?php $this->endWidget(); ?>
        
        
        
	</div>


    <div class="col-md-5" id="map_contact">
        
            <?php echo $school_address; ?>
        
        
        
        <br/>
        <?php 
        
        include_once 'map.php'; 
        
        ?>
        
        <h5>  Heure de cours </h5>
       <i>
            <?php 
            $data_ = Shifts::model()->findAll();
            
            foreach($data_ as $d){
                if($d->shift_name!="" || $d->shift_name!=null ){
                    echo $d->shift_name.' : '.$d->time_start.' - '.$d->time_end.'<br/>';
                }else{
                    
                }
            }
            
            ?>
            
        </i>
      
    </div>
				     
</div>			
				 

        
</body>
</html>






<script type="text/javascript">
   

function validateHuman(){
    var d_number = ["Zero","Un","Deux","Trois","Quatre","Cinq","Six","Sept","Huit","Neuf"];
    
    var rand1 = Math.round(Math.random()*10); 
    var rand2 = Math.round(Math.random()*10);
    var result_addition = 0;
    
    
    if((rand1>=0 && rand1<=9)&&(rand2>=0 && rand2<=9)){
        document.getElementById("human1").innerHTML = d_number[rand1];
        document.getElementById("human2").innerHTML = d_number[rand2];
        result_addition = rand1+rand2;
        document.getElementById("result_hide").value = result_addition;
        
    }
    else{
        document.getElementById("human1").innerHTML = 4;
        document.getElementById("human2").innerHTML = 7;
        result_addition = 11;
        document.getElementById("result_hide").value = result_addition;
    }
    
    
  }
  
</script>