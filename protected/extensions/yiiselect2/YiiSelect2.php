<?php
/**
 * select2 extension for YII
 *
 * @author Juan C. Muller <jcmuller@gmail.com>
 * @copyright Copyright &copy; 2013 Juan C. Muller
 * @license Licensed under MIT license.
 * @version 0.0.1
 */

/**
 * Select2 is a jQuery based replacement for select boxes. It supports
 * searching, remote data sets, and infinite scrolling of results. Look and
 * feel of Select2 is based on the excellent Chosen library.
 *
 * @author Juan C. Muller <jcmuller@gmail.com>
 */
class YiiSelect2 extends CWidget
{
  /**
   * @var string apply select plugin to these elements.
   */
  public $target = '.yii-select2';

  /**
   * @var boolean include un-minified plugin then debuging.
   */
  public $debug = false;

  /**
   * @var array native select plugin options.
   */
  public $options = array();

  /**
   * @var int script registration position.
   */
  public $scriptPosition = CClientScript::POS_END;

  /**
   * Apply select plugin to select boxes.
   */
  public function run()
  {
    // Publish extension assets
    $assets = Yii::app()->getAssetManager()->
      publish(Yii::getPathOfAlias('ext.yiiselect2') . '/assets');

    // Register extension assets
    $cs = Yii::app()->getClientScript();
    $cs->registerCssFile($assets . '/select2.css');

    // Get extension for JavaScript file
    $ext = '.min.js';
    if ($this->debug)
      $ext = '.js';

    $options = CJavaScript::encode($this->options);
    $cs->registerScriptFile("{$assets}/select2{$ext}", $this->scriptPosition);
    $cs->registerScript('select2', "$('{$this->target}').select2({$options});",
      CClientScript::POS_READY);
  }
}
