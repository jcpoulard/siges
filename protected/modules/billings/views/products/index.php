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
/* @var $this ProductsController */
/* @var $model Products */

$acad_sess=acad_sess();
$acad=Yii::app()->session['currentId_academic_year'];

$template = '';



$this->pageTitle = Yii::app()->name.' - '.Yii::t('app','Manage Stocks');

?>

<!-- Menu of CRUD  -->
<div id="dash">
   <div class="span3"><h2>
        <?php echo Yii::t('app','Manage Stocks');?> 
        
    </h2> </div>       
         
     <div class="span3">

 <?php 
     
     if(!isAchiveMode($acad_sess))
        {    $template = '{stock}{update}{delete}';  
        
   ?>

         <div class="span4">
                  <?php
                     $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';
                               // build the link in Yii standard
                     echo CHtml::link($images,array('products/create')); 
                   ?>
               </div>
<?php
        }
      
      ?>       
               
               <div class="span4">
                      <?php
                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                               // build the link in Yii standard
                     echo CHtml::link($images,array('/billings/products/index')); 
                   ?>
               </div>
    </div> 
 </div>


<div style="clear:both"></div>

<div >
<?php
    echo $this->renderPartial('//layouts/navBaseInventory',NULL,true);	
    ?>
</div>    

<div style="clear:both"></div>

<div class="search-form">
    <form method="GET">
    <input type="text" id="srcProd" name="srcProd" placeholder="<?php echo Yii::t('app','Product name'); ?>"></input>
    <input id="search" name="search" type="submit" value="<?php echo Yii::t('app','Search'); ?>"></input>
    </form>
</div><!-- search-form -->



<?php 
function evenOdd($num)
{
($num % 2==0) ? $class = 'odd' : $class = 'even';
return $class;
}
if(isset($_GET['srcProd']) && $_GET['srcProd']!=""){
    $productName = $_GET['srcProd'];
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
     $gridWidget = $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'products-grid',
	'dataProvider'=>$stock->searchProductName("p.product_name LIKE '%".$productName."%'"),
	'rowCssClassExpression'=>'($data->quantity<=$data->stock_alert)?"balance":evenOdd($row)',
	'columns'=>array(
		
		array('header'=>Yii::t('app','Product Name'),'value'=>'$data->product_name'),
		
		'quantity',
		'stock_alert',
                array('header'=>Yii::t('app','Buying Price'),'value'=>'$data->BuyingPrice'),
                array('header'=>Yii::t('app','Selling Price'),'value'=>'$data->SellingPrice'),
               
		array(
			'class'=>'CButtonColumn',
			    'template'=>$template,
                         'buttons'=>array('stock'=>array('label'=>'<span class="fa fa-plus"></span>',
                            'imageUrl'=>false,     
                           'url'=>'Yii::app()->createUrl("/billings/stocks/update?id=$data->id&part=stock&soti=upstock")',
                            'options'=>array('title'=>Yii::t('app','Add Stock')),
                             
                            ),
                           'update'=>array('label'=>'<span class="fa fa-pencil-square-o"></span>',
                            'imageUrl'=>false,
                           'url'=>'Yii::app()->createUrl("/billings/products/update?id=$data->id_product&idstock=$data->id&part=prod&from=stud")',
                            'options'=>array('title'=>Yii::t('app','Update')),
                             
                            ),
                            'delete'=>array('label'=>'<span class="fa fa-trash-o"></span>',
                            'imageUrl'=>false,
                            'options'=>array('title'=>Yii::t('app','Delete')),
                                
                            ),
                            ),
                           'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100,100000=>Yii::t('app','all')),array(
                             'onchange'=>"$.fn.yiiGridView.update('products-grid',{ data:{pageSize: $(this).val() }})",
                             )),
                             

		),          
	),
)); 

$content=$stock->searchProductName("p.product_name LIKE '%".$productName."%'")->getData();
        if((isset($content))&&($content!=null))
              $this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app',' CSV'),array('class'=>'btn-info btn'));


}else{
    
    $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
   $gridWidget = $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'products-grid',
	'dataProvider'=>$stock->search(),
	'rowCssClassExpression'=>'($data->quantity<=$data->idProduct->stock_alert)?"balance":evenOdd($row)',
	'columns'=>array(
		
		array('header'=>Yii::t('app','Product Name'),'value'=>'$data->idProduct->product_name'),
		
		'quantity',
		'idProduct.stock_alert',
                array('header'=>Yii::t('app','Buying Price'),'value'=>'$data->BuyingPrice'),
                array('header'=>Yii::t('app','Selling Price'),'value'=>'$data->SellingPrice'),
                
               
		array(
			'class'=>'CButtonColumn',
			    'template'=>$template,
                         'buttons'=>array('stock'=>array('label'=>'<span class="fa fa-plus"></span>',
                            'imageUrl'=>false,     
                           'url'=>'Yii::app()->createUrl("/billings/stocks/update?id=$data->id&part=stock&soti=upstock")',
                            'options'=>array('title'=>Yii::t('app','Add Stock')),
                             
                            ),
                           'update'=>array('label'=>'<span class="fa fa-pencil-square-o"></span>',
                            'imageUrl'=>false,
                           'url'=>'Yii::app()->createUrl("/billings/products/update?id=$data->id_product&idstock=$data->id&part=prod&from=stud")',
                            'options'=>array('title'=>Yii::t('app','Update')),
                             
                            ),
                            'delete'=>array('label'=>'<span class="fa fa-trash-o"></span>',
                            'imageUrl'=>false,
                            'options'=>array('title'=>Yii::t('app','Delete')),
                                
                            ),
                            ),
                           'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100,100000=>Yii::t('app','all')),array(
                             'onchange'=>"$.fn.yiiGridView.update('products-grid',{ data:{pageSize: $(this).val() }})",
                             )),
                             

		),          
	),
)); 

$content=$stock->search()->getData();
        if((isset($content))&&($content!=null))
              $this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app',' CSV'),array('class'=>'btn-info btn'));
              
}



?>
