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
/* @var $this SellingsController */
/* @var $model Sellings */

$acad=Yii::app()->session['currentId_academic_year']; 

$acad_name=Yii::app()->session['currentName_academic_year'];

$currency_name = Yii::app()->session['currencyName'];
	       $currency_symbol = Yii::app()->session['currencySymbol']; 



Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#sellings-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div id="dash">
    <div class="span3">
<h2><?php echo Yii::t('app','Sales reports'); ?></h2>
    </div>
</div>

<?php
    echo $this->renderPartial('//layouts/navBaseInventory',NULL,true);	
?>




<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
if(isset($_GET['src_date_1']) && isset($_GET['src_date_2'])){
        $date1 = $_GET['src_date_1'];
        $date2 = $_GET['src_date_2'];
        $header=Yii::t('app','Sale date');
        
        
        
    $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);    
    $gridWidget = $this->widget('groupgridview.GroupGridView', array(
	'id'=>'sellings-grid',
        'showTableOnEmpty'=>false,
	'dataProvider'=>$model->searchByDate($date1, $date2),
	
        'summaryText'=>'<div id="en-tete" class="span12 btn disabled" style="text-align:center; background: #EE6539 opacity: 0.6"><span style="margin: 0 10px;">'.Yii::t('app','Total sale from <i class="alert-warning">{date1}</i> to <i>{date2}</i> : <u style="color: #000">{name}</u> ',array('{name}'=>$currency_symbol.' '.numberAccountingFormat($model->getTotalSale($date1, $date2) ),'{date1}'=>$this->formatDate($date1), '{date2}'=>$this->formatDate($date2))).'</span>|<span style="margin: 0 10px;">'
        .Yii::t('app','Cash balance : <u style="color : #000">{name}</u>',array('{name}'=>$currency_symbol.' '.numberAccountingFormat(round(SaleTransaction::model()->getTotalCash($date1,$date2),2) ) )). '</span>|<span style="margin: 0 10px;">  '
        .Yii::t('app','Total discount :<u style="color : #000"> {name}</u>',array('{name}'=>$currency_symbol.' '.numberAccountingFormat(round(SaleTransaction::model()->model()->getTotalDiscount($date1, $date2),2) ) )). '</span></div>',
        'mergeColumns'=>array('saleDate','transaction_id'),
	'columns'=>array(
		
                'saleDate',
		'transaction_id',
		'idProducts.product_name',
		'quantity',
		
                array('header'=>Yii::t('app','Amount Selling'),'value'=>'$data->AmountSelling'),
                'sell_by',
                
		array(
                    'class'=>'CButtonColumn',
                    'template'=>'',
                    'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100,100000=>Yii::t('app','all')),array(
                             'onchange'=>"$.fn.yiiGridView.update('sellings-grid',{ data:{pageSize: $(this).val() }})",
                             )),
		),
	),
));
    
     
    
  // Export to CSV 
  $content=$model->searchByDate($date1,$date2)->getData();
 if((isset($content))&&($content!=null))
   $this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app',' CSV'),array('class'=>'btn-info btn'));

   
    
}else{
    $date1 = date('Y-m-d');
    $date2 = date('Y-m-d');
    $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);    
    $gridWidget = $this->widget('groupgridview.GroupGridView', array(
        'showTableOnEmpty'=>false,
	'id'=>'sellings-grid',
	'dataProvider'=>$model->searchByDate($date1, $date2),
	
        'summaryText'=>'<div id="en-tete" class="span18 btn disabled" style="text-align:center; background: #EE6539 opacity: 0.6"><span style="margin: 0 10px;">'.Yii::t('app','Total sale  <i class="alert-warning">Today</i> : <u style="color: #000">{name}</u> ',array('{name}'=>$currency_symbol.' '.numberAccountingFormat($model->getTotalSale($date1, $date2) ),'{date1}'=>$this->formatDate($date1), '{date2}'=>$this->formatDate($date2))).'</span>|<span style="margin: 0 10px;">'
        .Yii::t('app','Cash balance : <u style="color : #000">{name}</u>',array('{name}'=>$currency_symbol.' '.numberAccountingFormat(round(SaleTransaction::model()->getTotalCash($date1,$date2),2) ) )). '</span>|<span style="margin: 0 10px;">  '
        .Yii::t('app','Total discount :<u style="color : #000"> {name}</u>',array('{name}'=>$currency_symbol.' '.numberAccountingFormat(round(SaleTransaction::model()->model()->getTotalDiscount($date1, $date2),2) ) )). '</span></div>',
        'mergeColumns'=>array('saleDate','transaction_id'),
	'columns'=>array(
		
                'saleDate',
		'transaction_id',
		'idProducts.product_name',
		'quantity',
		
                array('header'=>Yii::t('app','Amount Selling'),'value'=>'$data->AmountSelling'),
                'sell_by',
                
		
		array(
                    'class'=>'CButtonColumn',
                    'template'=>'',
                    'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100,100000=>Yii::t('app','all')),array(
                             'onchange'=>"$.fn.yiiGridView.update('sellings-grid',{ data:{pageSize: $(this).val() }})",
                             )),
		),
	),
));
    
     
    
  // Export to CSV 
  $content=$model->searchByDate($date1,$date2)->getData();
 if((isset($content))&&($content!=null))
   $this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app',' CSV'),array('class'=>'btn-info btn'));

}
    ?>
