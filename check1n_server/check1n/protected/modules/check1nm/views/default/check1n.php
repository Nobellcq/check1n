<script type="text/javascript" src="js/jquery-ui-slide.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-timepicker-addon.js"></script>
<style type="text/css">
    p span{color:red }
</style>
<div class="demo">
    <h3>批量：我要签到</h3>
    <p>为了方便，大家可以批量签到，但不要<span><strong>滥用</strong></span>，不然记录太多了，麻烦。</p>
    <form id="check1n_form" action="index.php?r=check1nm/ajax/check1n" method="post">
        <input type="hidden" name="userid" value="<?php echo $id; ?>"/>
        <?php
        for($i = 0;$i < Yii::app()->params['check1n_count']; $i++ ){

            echo "<h4>第 $i 条记录</h4>";
            echo '<p><input class="date_picker" type="text" name="'.$i.'" id="check1n_'.$i.'" /></p>';
        }
        ?>
        <input type="submit" class="btn btn-primary" value="提交"/>
    </form>

</div>

<script type="text/javascript">
    $(function(){
        $(".date_picker").datetimepicker({
            showSecond: true,
            dateFormat:'yy/mm/dd',
            timeFormat: 'hh:mm:ss'
        });

        $("#check1n_form").submit(function(){
            $.post("index.php?r=check1nm/ajax/check1n",$("#check1n_form").serialize(),function(response){
                 if(response !=null){
                     var res = eval(response)
                     if(res.code == 0){
                         alert(res.data)
                     }else{
                         alert(res.error)
                     }

                 }
            })

            $(".date_picker").val("")
            return false;
        })
    })
</script>