<?php
/* @var $this UserController */
/* @var $data User */
?>

<tr class="view">
    <td><?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?></td>
    <td><?php echo CHtml::encode($data->username); ?></td>
    <td><?php echo CHtml::encode($data->email);  ?></td>
<!--	<b>--><?php //echo CHtml::encode($data->getAttributeLabel('id')); ?><!--:</b>-->
<!--	--><?php //echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
<!--	<br />-->
<!---->
<!--	<b>--><?php //echo CHtml::encode($data->getAttributeLabel('username')); ?><!--:</b>-->
<!--	--><?php //echo CHtml::encode($data->username); ?>
<!--	<br />-->

<!--	<b>--><?php //echo CHtml::encode($data->getAttributeLabel('password')); ?><!--:</b>-->
<!--	--><?php //echo CHtml::encode($data->password); ?>
<!--	<br />-->

<!--	<b>--><?php //echo CHtml::encode($data->getAttributeLabel('email')); ?><!--:</b>-->
<!--	--><?php //echo CHtml::encode($data->email); ?>
<!--	<br />-->


</tr>