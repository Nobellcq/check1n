<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - About';
$this->breadcrumbs=array(
	'About',
);

$this->widget('bootstrap.widgets.TbTabs', array(
    'type'=>'tabs',
    'placement'=>'below', // 'above', 'right', 'below' or 'left'
    'tabs'=>array(
        array('label'=>'Section 1', 'content'=>'<p>I\'m in Section 1.</p>', 'active'=>true),
        array('label'=>'Section 2', 'content'=>'<p>Howdy, I\'m in Section 2.</p>'),
        array('label'=>'Section 3', 'content'=>'<p>What up girl, this is Section 3.</p>'),
    ),
));

?>
<h1>About</h1>

<p>This is a "static" page. You may change the content of this page
by updating the file <code><?php echo __FILE__; ?></code>.</p>


<!---->
<?php //$this->widget('bootstrap.widgets.TbTabs', array(
//    'type'=>'tabs',
//    'placement'=>'below', // 'above', 'right', 'below' or 'left'
//    'tabs'=>array(
//        array('label'=>'Section 1', 'content'=>'<p>I\'m in Section 1.</p>', 'active'=>true),
//        array('label'=>'Section 2', 'content'=>'<p>Howdy, I\'m in Section 2.</p>'),
//        array('label'=>'Section 3', 'content'=>'<p>What up girl, this is Section 3.</p>'),
//    ),
//)); ?>