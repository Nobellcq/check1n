<?php
/* @var $this UserController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Users',
);

$this->menu=array(
	array('label'=>'Create User', 'url'=>array('create')),
	array('label'=>'Manage User', 'url'=>array('admin')),
);
?>

<h1>Users</h1>
<div>
    <table class="table" >
        <thead>
        <tr>
            <th>序号</th>
            <th>用户名</th>
            <th>email</th>
        </tr>
        </thead>
        <tbody>
        <?php $this->widget('zii.widgets.CListView', array(
            'dataProvider'=>$dataProvider,
            'itemView'=>'_view',
        )); ?>

        </tbody>

    </table>

</div>
