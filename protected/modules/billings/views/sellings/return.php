<?php 
/*
 * © 2010 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
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

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$acad_sess=acad_sess();  

$currency_symbol = Yii::app()->session['currencySymbol'];
$currency_name = Yii::app()->session['currencyName'];


?>
<div id="dash">
    <div class="span3">
<h2><?php echo Yii::t('app','Make Return') ?> </h2>
    </div>

</div>

<?php
$template = '';

     if(!isAchiveMode($acad_sess))
          $template = '{stock}';  
         
    echo $this->renderPartial('//layouts/navBaseInventory',NULL,true);	
?>


<div class="search-form">
    <form method="GET">
    <input id="src_trans" name="src_trans" type="text" placeholder="<?php echo Yii::t('app','Transaction ID'); ?>"></input>
    <input  type="submit" name="btn_search" onclick="changeDivHeighth();" value="<?php echo Yii::t('app','Show'); ?>" ></input>
    </form>
</div>


<div id="content_src" class="row-fluid" style="max-height: 250px; overflow: scroll;" >
    <div id="content_cat" class="span8" > 
<?php 
if(isset($_GET['src_trans'])){
        $id_trans = $_GET['src_trans'];
        
    $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);    
    $gridWidget = $this->widget('groupgridview.GroupGridView', array(
	'id'=>'return-grid',
        'showTableOnEmpty'=>false,
	'dataProvider'=>$model->searchByTransaction($id_trans),
	'mergeColumns'=>array('saleDate','transaction_id'),
	'columns'=>array(
		
		'transaction_id',
		'idProducts.product_name',
		'quantity',
                array('header'=>Yii::t('app','Unit selling price'),'value'=>'$data->UnitSellingPrice'),
		'saleDate',
                'sell_by',
                
            array(
                    'class'=>'CButtonColumn',
                    'template'=>$template,
                    'buttons'=>array('stock'=>array('label'=>'<span class="fa fa-repeat"></span>',
                            'imageUrl'=>false,     
                           'url'=>'Yii::app()->createUrl("/billings/sellings/returnitem?id=$data->id&idProducts=$data->id_products&qty=$data->quantity&pu=$data->unit_selling_price&idt=$data->transaction_id")',
                            'options'=>array('title'=>Yii::t('app','Return'),'onclick'=>'return confirm("'.Yii::t('app','Are you sure you want to return this product?').'");'),
                             
                            ),
                           
                            ),
                    
		),
            ),
        
        
));
    
  
    
}
    ?>
    </div>
    <div class="span4">
        <?php
        if(isset($_GET['src_trans'])){
        $id_trans = $_GET['src_trans'];
        $dataProvider = Sellings::model()->searchByTransaction($id_trans); 
        $data_sale = $dataProvider->getData();
        
        $condition = "id_transaction = $id_trans";
        $returnProvider = ReturnHistory::model()->searchReturnHistory($condition);
        $returnData = $returnProvider->getData();
        $count = count($returnData);
        $total = 0.00;
        foreach($data_sale as $ds){
            $total += $ds->amount_selling;
            
        }
        $this->amount_selling = $total;
        $this->id_transaction = $id_trans;
        ?>
        
        <div class="box box-primary">
            <div class="  with-border " style='background-color: #53A753'>
                <h3 class="box-title" style='color: #D5F5DE'>
                    <?php 
                        if($count==0) echo '<i class="fa fa-shopping-cart fa-2x"></i><span class="pull-right" style="padding: 0 10px"> '.Yii::t('app','Return Cart').'</span>';
                        else echo "<i class='fa fa-shopping-cart fa-2x'></i><span class='badge' style='background: #D5F5DE; color: #EE6539; font-weight: bold;'> $count</span><span class='pull-right' style='padding: 0 10px'> ".Yii::t('app','Return Cart')." </span>";
                    ?>
                </h3>
            </div>
            <div class="box-body" style='height: 120px; overflow: scroll'>
                <div class="info"><?php echo Yii::t('app','Transaction # {name}',array('{name}'=>$this->id_transaction)); ?></div>
                <table class="table-condensed table-responsive info" style='line-height: 50%; color: #000C53'>
                    <?php
                        
                        foreach($returnData as $ds){
                              
                             
                                echo '<tr>';
                                echo '<td><font size="1">'.$ds->product_name.'</font></td>';
                                echo '<td><font size="1">'.$ds->return_quantity.' X '.$ds->selling_price.'</font></td>';
                                 
                                echo '<td><font size="1">'.$ds->return_quantity*$ds->selling_price.'</font></td>';
                                ?>
                    
                                
                    <?php       
                                echo '</tr>';
                               
                            
                        }
                        
                    ?>
                    
                </table>
                <?php if($count!=0) {?>
                <div style="text-align: center;">
                    <button class='btn btn-success' onclick="printDiv('print_receipt')">
                    <?php echo Yii::t('app','Print'); ?>
                </button>
                </div>
                
                    <?php } ?>
            </div>
            <div class="box-footer with-border">
                <div class="alert alert-success" style="text-align: center;">
                    <strong><?php  echo Yii::t('app','Total amount return : {name}',array('{name}'=>$currency_symbol.' '.numberAccountingFormat(ReturnHistory::model()->getTotalAmountReturn($this->id_transaction)))); ?></strong><br>
                    <strong><?php  echo Yii::t('app','Total sale : {name}',array('{name}'=>$currency_symbol.' '.numberAccountingFormat($total))); ?></strong>
                    
                </div>
            </div>
        </div>
        
        
        
        <div id="print_receipt" style="display: none">
            <?php
                $criteria = new CDbCriteria;
                $criteria->condition='item_name=:item_name';
                $criteria->params=array(':item_name'=>'school_name',);
                $school_name = GeneralConfig::model()->find($criteria)->item_value;
                $criteria->params=array(':item_name'=>'school_address',);
                $school_address = GeneralConfig::model()->find($criteria)->item_value;
                
            ?>
            <div class="span3">
                
            </div>
            <div class="span6">
                <div class="row-fluid" style="text-align: center">
                    <?php echo $school_name.'<br/>';
                          echo $school_address;   
                    ?>

                </div>
                <div class="row-fluid" style="text-align: center">
                    <?php echo Yii::t('app','Receipt of return');?>
                </div>
                <div class="row-fluid" style="align-content: center; text-align: center">
                    <div class="box">
                        <div class="">
                            <?php 
                              echo Yii::t('app','Transaction # {name}',array('{name}'=>$this->id_transaction)); 
                              echo '</br>';
                              echo date('Y-m-d H:m:s');
                            ?>
                        
                        </div>
                        <div class="box-body" style="min-height: 300px">
                            <table class="table-condensed table-responsive">
                                <?php
                                foreach($returnData as $rd){
                                    echo '<tr>';
                                        echo '<td>';
                                            echo $rd->product_name; 
                                        echo '</td>';
                                        echo '<td>';
                                            echo $rd->return_quantity.'X'.$rd->selling_price; 
                                        echo '</td>';
                                        echo '<td>';
                                            echo $rd->return_quantity*$rd->selling_price; 
                                        echo '</td>';
                                        
                                    echo '</tr>';
                                }
                                ?>
                            </table>
                        </div>
                        <div class="box-footer">
                            <?php echo Yii::t('app','Total amount return : {name}',array('{name}'=>$currency_symbol.' '.numberAccountingFormat(ReturnHistory::model()->getTotalAmountReturn($this->id_transaction)))); ?>
                            <hr/>
                            <?php echo Yii::t('app','Return by: {name}',array('{name}'=>Yii::app()->user->name)); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="span3">
                
            </div>
        </div>
        
        <?php } ?>
        
    </div>
</div>
<div class="row-fluid">
<div class="alert alert-info">
   <?php echo Yii::t('app','Return history');?>
</div>

<div class="search-form">
    <form method="GET">
    <input id="src_return" name="src_return" type="text" placeholder="<?php echo Yii::t('app','Transaction ID'); ?>"></input>
    <input  type="submit" name="btn_search_return" value="<?php echo Yii::t('app','Search'); ?>" ></input>
    </form>
</div>
    
    <?php 
    
    if(isset($_GET['src_return'])){
        $id_trans = $_GET['src_return'];
        $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);    
    $gridWidget = $this->widget('groupgridview.GroupGridView', array(
	'id'=>'return-grid',
	'dataProvider'=>$model->searchReturnByTransaction($id_trans),
	'mergeColumns'=>array('saleDate','transaction_id'),
	'columns'=>array(
		
		'transaction_id',
		'idProducts.product_name',
		'quantity',
                'sale',
                
		'saleDate',
		'sell_by',
               
		
	),
));
        
    }else{
        $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);    
    $gridWidget = $this->widget('groupgridview.GroupGridView', array(
	'id'=>'return-grid',
	'dataProvider'=>$model->searchReturn(),
	'mergeColumns'=>array('saleDate','transaction_id'),
	'columns'=>array(
		
		'transaction_id',
		'idProducts.product_name',
		'quantity',
                array('header'=>Yii::t('app','Total sale'),'value'=>'$data->sale'),
               // 'UnitSellingPrice',
		'saleDate',
		'sell_by',
                
		
	),
));
    }
    
    ?>
    
    
</div>
<script type="text/javascript">
    
function printDiv(divName) {
     document.getElementById(divName).style.display = "block";
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;
     
     
     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
     document.getElementById(divName).style.display = "none";
} 


</script>