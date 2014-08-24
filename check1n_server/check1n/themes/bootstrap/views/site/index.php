<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;
?>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css"/>
<?php Yii::app()->bootstrap->register(); ?>

<?php $this->beginWidget('bootstrap.widgets.TbHeroUnit', array(
    'heading' => '', //Welcome to ' . CHtml::encode(Yii::app()->name),
)); ?>
<h1>Hello WCSN!</h1>

<?php $this->endWidget(); ?>
