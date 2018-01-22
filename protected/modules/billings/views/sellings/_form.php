<?php 
/*
 * © 2016 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
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

?>
<?php

$acad_sess=acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
$acad_name=Yii::app()->session['currentName_academic_year'];

$currency_name = Yii::app()->session['currencyName'];
$currency_symbol = Yii::app()->session['currencySymbol']; 


/* @var $this SellingsController */
/* @var $model Sellings */
/* @var $form CActiveForm */
?>
<div class="form">
<?php 

        $form=$this->beginWidget('CActiveForm', array(
            'id'=>'sellings-form',
            'enableAjaxValidation'=>true,
        )); 
    
        $dataProvider = Sellings::model()->searchByTransaction($this->id_transaction); 
        $data_sale = $dataProvider->getData();
        $count = count($data_sale);
       
        $total = 0.00;
        foreach($data_sale as $ds){
            $total += $ds->amount_selling;
            
        }
        $this->amount_selling = $total;
?>
   
 
<div class="b_m">

<div class="row">
    <div class="span8">
        <form  id="resp_form">
        <div class="row-fluid">
        
            <div class="col-3"style="display:inline-block; vertical-align: middle; margin: 10px; width: 45%;">
            <label id="resp_form">
            <?php echo $form->labelEx($model,'id_products'); ?>
            <?php echo $form->dropDownList($model,'id_products',$this->loadProducts(),array('prompt'=>Yii::t('app','Choose a product'),'onchange'=>'submit()','options' => array($this->product_id=>array('selected'=>true))) ); ?>
            <?php echo $form->error($model,'id_products'); ?>
            </label>
           
        </div>
        <div class="col-3" style="display:inline-block; vertical-align: middle; margin: 10px; width: 45%;">
            <label id="resp_form">
            <?php echo $form->labelEx($model,'quantity'); ?>
            <?php 
            if($this->product_id!=null){
                ?>
                <select name="quantity">
                    <?php 
                    for($i=1; $i<=10; $i++){
                        echo "<option value=$i>$i</option>";
                    }
                    ?>
                </select>
              
                <?php 
             
            }else{
                
               
            ?>
                <select name="quantity">
                    <?php 
                    for($i=1; $i<=10; $i++){
                        echo "<option value=$i>$i</option>";
                    }
                    ?>
                </select>
               
                <?php 
                
            }
            ?>
            
            <?php
            
            if($this->runStockAlert()!=null){
                ?>
                <a href="#" onclick="alert('<?php echo $this->runStockAlert(); ?>')" class="fa fa-warning fa-2x" style="color:#F00; margin-left: 20px;"></a>
            <?php 
                
            } 
            ?>
                
             <?php echo $form->error($model,'quantity'); ?>
            </label>
            
                
               
        </div>
            
 <?php 
     
     if(!isAchiveMode($acad_sess))
        {      
        
   ?>
            
            <div class="col-submit" style="margin: 10px auto;">
                   <?php echo CHtml::submitButton(Yii::t('app', 'Add this article'),array('name'=>'add','class'=>'btn btn-warning btn-large')); ?>
            </div>
            
 <?php
        }
      
      ?>       
            
            
        </div>
            
            <hr/>
            
            <div class="row-fluid">
                <div class="col-2" style="display:inline-block; vertical-align: middle; width: 45%; margin: 10px 0;">
                    <label id="resp_form">
                        <?php echo '<label>'.Yii::t('app', 'Total amount').'</label>'; //echo $form->labelEx($model,'amount_selling'); ?>
                        <?php
                        if($this->quantity>0){
                            $this->amount_selling = $model->getAmountSellingByTransaction($this->id_transaction)+$this->unit_price*$this->quantity;
                        }else{
                            $this->amount_selling = $this->amount_selling;
                        }
                        
                        $amount_selling=$this->amount_selling;
                        echo '<input name="amount_selling" id="amount_selling" type="text" readonly=true value="'.$amount_selling.'" />';
                        
                        ?>
                        <?php echo $form->error($model,'amount_selling'); ?>
                    </label>
               </div>
                
                <div class="col-2" style="display:inline-block; vertical-align: middle; width: 45%; margin: 10px 0;">
                <label id="resp_form">
                <?php echo $form->labelEx($model,'discount'); ?>
                <?php echo $form->textField($model,'discount',array('placeholder'=>Yii::t('app','Discount %'),'name'=>'discount','id'=>'discount','value'=>$this->discount,'onchange'=>"rabais('$this->amount_selling');")); ?>
                <?php echo $form->error($model,'discount'); ?>
                </label>
              </div>
                
                <div class="col-2" style="display:inline-block; vertical-align: middle; width: 45%; margin: 10px 0;">
                    <label id="resp_form" >
                        <?php echo $form->labelEx($model,'amount_receive'); ?>
                        <?php echo $form->textField($model,'amount_receive',array('placeholder'=>Yii::t('app','Amount receive'),'name'=>'amount_receive', 'id'=>'amount_receive','value'=>$this->amount_receive, 'onchange'=>'difference()')); ?>
                        <?php echo $form->error($model,'amount_receive'); ?>
                    </label>
               </div>
                
                <div class="col-2" style="display:inline-block; vertical-align: middle; margin: 10px 0; width: 45%">
                    <label id="resp_form">
                        <?php echo $form->labelEx($model,'amount_balance'); ?>
                        <?php echo $form->textField($model,'amount_balance',array('placeholder'=>Yii::t('app','Balance'),'name'=>'balance','id'=>'balance','value'=>$this->amount_balance,'readonly'=>true)); ?>
                        <?php echo $form->error($model,'amount_balance'); ?>
                    </label>
               </div>
                <input type="hidden" id="message_credit" value="<?php echo Yii::t('app','Amount received is less than amount sold!') ?>"/>
                <input type="hidden" name="real_sale" id="real_sale" value="<?php echo $total; ?>"></input>
              

  <?php 
     
     if(!isAchiveMode($acad_sess))
        {     
        
   ?>
            
             
                <div class="col-submit" style="margin: 10px auto;">
                    
                    <button class="btn btn-success" type="submit"  id="close_sale" name="close_sale" disabled="disabled" oncontextmenu="printDiv('print_receipt')">
                        <?php echo Yii::t('app','Close sale'); ?>
                    </button>
                      
                    <button class="fa fa-print btn btn-success" disabled="disabled" id="print_sale" name="print_sale" onclick="printDiv('print_receipt');"> <?php echo Yii::t('app','Print'); ?></button>
                    
                </div>
      <?php
        }
      
      ?>       
           
                
            </div>
    </form>
    </div>
    <div id="transac" class="span4" style="background-color: #fff; min-height: 300px; padding: 5px;">
        
        
        <div class="box box-primary">
            <div class="  with-border " style='background-color: #53A753'>
                <h3 class="box-title" style='color: #D5F5DE'>
                    <?php 
                        if($count==0) echo '<i class="fa fa-shopping-cart fa-2x"></i><span class="pull-right" style="padding: 0 10px">'.Yii::t('app','Cart').'</span>';
                        else echo "<i class='fa fa-shopping-cart fa-2x'></i><span class='badge' style='background: #D5F5DE; color: #EE6539; font-weight: bold;'> $count</span><span class='pull-right' style='padding: 0 10px'> ".Yii::t('app','Cart')." </span>";
                    ?>
                </h3>
            </div>
            <div class="box-body" style='height: 250px; overflow: scroll'>
                <?php if($count==0){?>
                <div class="info"><?php echo Yii::t('app','Cart is empty'); ?></div>
                <?php }else{ ?>
                <div class="info"><?php echo Yii::t('app','Transaction # {name}',array('{name}'=>$this->id_transaction)); ?></div>
                <?php } ?>
                <table class="table-condensed table-responsive info" style='line-height: 50%; color: #000C53'>
                    <?php
                        
                        foreach($data_sale as $ds){
                                
                                echo '<tr>';
                                echo '<td><font size="1">'.$ds->idProducts->product_name.'</font></td>';
                                echo '<td><font size="1">'.$ds->quantity.' X '.numberAccountingFormat($ds->unit_selling_price).'</font></td>';
                                 
                                echo '<td><font size="1">'.numberAccountingFormat($ds->amount_selling).'</font></td>';
                                
                                echo '<td><a href="'.Yii::app()->baseURL.'/index.php/billings/sellings/delete?id='.$ds->id.'&idProducts='.$ds->id_products.'&qty='.$ds->quantity.'"><span class="fa fa-trash-o"></span></a></td>';
                               
                                echo '</tr>';
                               
                            
                        }
                        
                    ?>
                    
                </table>
                <?php if($count!=0) {?>
                <div class="" style="text-align:center;"> <a href="<?php echo Yii::app()->baseURL.'/index.php/billings/sellings/emptyCart?id='.$this->id_transaction; ?>" class="fa fa-trash-o btn btn-warning" onclick='return confirm("<?php echo Yii::t('app','Empty cart means delete all items in this cart.\nDo you want to continue?'); ?>")'> <?php echo Yii::t('app','Empty cart'); ?></a></div>
                <?php } ?>
            </div>
            <div class="box-footer with-border">
                <div class="alert alert-success" style="text-align: center;">
                    <strong><?php  echo Yii::t('app', 'Total amount').' : '.$currency_symbol.' '.numberAccountingFormat($total); // echo Yii::t('app','Total : {name}',array('{name}'=>$currency_symbol.' '.numberAccountingFormat($total))); ?></strong>
                    <div><?php echo Yii::t('app','Discount: ').$currency_symbol; ?> <span id="discount_string"></span></div>
                    <div><?php echo Yii::t('app','Total after discount: ').$currency_symbol; ?> <span id="total_after_discount"></span></div>
                    
                </div>
            </div>
        </div>
        
        
        
        
    </div>
    
    <div id="print_receipt" style="display: none">
        <?php
                $school_name = infoGeneralConfig('school_name');
                $school_address = infoGeneralConfig('school_address');
                $school_phone_number= infoGeneralConfig('school_phone_number');
                $school_email_address= infoGeneralConfig('school_email_address');
                
        ?>
        
             
               
               
         
           
           <div id="header" style="">
                 
                  <div class="info"><?php echo headerLogo().'<b>'.strtoupper(strtr($school_name, pa_daksan() )).'</b><br/>'.$school_address.' &nbsp; / &nbsp; '.Yii::t('app','Tel: ').$school_phone_number.' &nbsp; / &nbsp; '.Yii::t('app','Email: ').$school_email_address; ?><br/></div> 
                  
                  <br/> 
                  
                  <div class="info" style="text-align:center;  margin-top:-9px; margin-bottom:-15px; "> <b><?php echo strtoupper(strtr(Yii::t('app','Receipt of sale'), pa_daksan() )); ?></b></div>
                  <br/>
                  </div>
           
           
           
           
   <div class="span3"></div>
        <div class="span6" style="align-content: center; text-align: center" >
                  
           
            <div class="row-fluid" style="align-content: center; text-align: center">
                <div class="box">
                    <div>
                        <?php 
                              echo Yii::t('app','Transaction # {name}',array('{name}'=>$this->id_transaction)); 
                              echo '</br>';
                              echo date('Y-m-d H:m:s');
                            ?>
                    </div>
                    <div class="box-body" style="min-height: 300px">
                        <table class="table-condensed table-responsive">
                            <?php
                                foreach($data_sale as $ds){
                                
                                echo '<tr>';
                                echo '<td><font size="1">'.$ds->idProducts->product_name.'</font></td>';
                                echo '<td><font size="1">'.$ds->quantity.' X '.numberAccountingFormat($ds->unit_selling_price).'</font></td>';
                                 
                                echo '<td><font size="1">'.numberAccountingFormat($ds->amount_selling).'</font></td>';
                                
                                echo '</tr>';
                               
                            
                                 }
                            
                            ?>
                        </table>
                    </div>
                    <div class="box-footer">
                        <strong><?php   echo Yii::t('app', 'Total amount').' : '.$total; //echo Yii::t('app','Total : {name}',array('{name}'=>$total)); ?></strong>
                        <div><?php echo Yii::t('app','Discount: ').$currency_symbol; ?> <span id="discount_string1"></span></div>
                        <div><?php echo Yii::t('app','Total after discount: '); ?> <span id="total_after_discount1"></span></div>
                        <div><?php echo Yii::t('app','Receive: ').$currency_symbol; ?> <span id="total_receive1"></span></div>
                        <div><?php echo Yii::t('app','Change: ').$currency_symbol; ?> <span id="total_change1"></span></div>
                  </div>
                </div>
            </div>
        </div>
        
        <div class="span3"></div>
        
    </div>
    
</div>
</div>
</div>
<?php $this->endWidget(); ?>



<script type="text/javascript">
       

    
    $(document).ready(function (){
            
            validate1();
            
            $('#amount_selling, #amount_receive, #balance').change(validate1);
     });

        function validate1(){
            if (
                $('#amount_selling').val().length   >   0 &&
                $('#amount_receive').val().length   >   0 &&
                $('#balance').val().length   >   0 &&
                $('#balance').val() >= 0
                ) {
                $("button[name=close_sale]").prop("disabled", false);
                $("button[name=print_sale]").prop("disabled", false);
            }
           else {
               $("button[name=close_sale]").prop("disabled", true);
               $("button[name=print_sale]").prop("disabled", true);
            }
       
    }
    
    
    
    function difference(){
       
       var amountSelling = parseFloat(document.getElementById("amount_selling").value);
       
       var amountReceive = parseFloat( document.getElementById("amount_receive").value);
       
        var discount = parseFloat(document.getElementById("discount").value);
      
      
      
       var balance; 
       balance = amountReceive - amountSelling; 
       if(balance<0){
           var message = document.getElementById("message_credit").value;
           alert(message);
       } 
       document.getElementById("balance").value = balance.toFixed(2);
       
       document.getElementById('total_receive').innerHTML = amountReceive;
       document.getElementById('total_change').innerHTML = balance.toFixed(2);
       
       document.getElementById('discount_string').innerHTML = discount+"%";
       document.getElementById('total_after_discount').innerHTML = amountSelling.toFixed(2); 
       
    }
    
    function rabais(venteInitiale){
        
       
       var x = parseFloat(venteInitiale);
        var discount = parseFloat(document.getElementById("discount").value);
        var newAmountSelling;
        newAmountSelling = x - x*(discount/100); 
        var discountAbsolute = x*(discount/100);
        
        document.getElementById("amount_selling").value = newAmountSelling.toFixed(2);
        document.getElementById('discount_string').innerHTML = discountAbsolute.toFixed(2);
        document.getElementById('total_after_discount').innerHTML = newAmountSelling.toFixed(2);
        
        if(discount!==0){
            document.getElementById("amount_receive").value = "";
            document.getElementById("balance").value = "";
        }
        
        
    }
    
    function printDiv(divName) {
     document.getElementById(divName).style.display = "block"; 
     // Affichaj
     var amountSelling = parseFloat(document.getElementById("amount_selling").value);
       
     var amountReceive = parseFloat( document.getElementById("amount_receive").value);
       
     var discount = parseFloat(document.getElementById("discount").value);
     
     var realSale = parseFloat(document.getElementById("real_sale").value);
     var absoluteDiscount = realSale*(discount/100); 
      
       var balance; 
       balance = amountReceive - amountSelling; 
        
      
       
       document.getElementById('total_receive1').innerHTML = amountReceive;
       document.getElementById('total_change1').innerHTML = balance.toFixed(2);
       
       document.getElementById('discount_string1').innerHTML = absoluteDiscount.toFixed(2);
       document.getElementById('total_after_discount1').innerHTML = amountSelling.toFixed(2); 
       //Fin afichaj
     
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;
     
     
     
     
     document.body.innerHTML = printContents;
     
     window.print();
     
     document.body.innerHTML = originalContents;
     
     document.getElementById(divName).style.display = "none";
     
     
    }    
    
    
    
     </script>