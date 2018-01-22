yiiselect2
==========

[select2](http://ivaynberg.github.com/select2/) extension for [YII](http://www.yiiframework.com/).

Usage:

Check out this repository under `extensions` in your project.

In the view you want to use yiiselect2
```php
<?php $this->widget('ext.yiiselect2.YiiSelect2', $options ?>

```

Where options can be:

* `target` - jQuery elements to be matched. Defaults to `.yii-select2`.
* `debug` - Boolean. Whether to include minified JS file or regular. Defaults to `false`.
* `options` - Hash. Native options to pass through to select2. Defaults to an empty associative
  array.
* `scriptPosition` - This can be one of the `CClientScript::POS_*` constants. Defaults to
  `CClientScript::POS_END`.

