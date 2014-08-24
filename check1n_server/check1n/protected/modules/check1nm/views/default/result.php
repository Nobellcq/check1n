<style>
    .text.warning{
        color: red;
    }
</style>

<h3>考勤统计确认</h3>
<p>点击提交输出<span class="text warning"><?php echo $starttime;?></span>到<span class="text warning"><?php echo $endtime;?></span>之间的统计结果。</p>
<button id="pre" class="btn">前一周</button>&nbsp;&nbsp;<button id="next" class="btn">后一周</button>&nbsp;&nbsp;<button id="submit" class="btn btn-primary">提交</button>
<div id="debug"></div>
<script>
    var delta = <?php echo $delta;?>;
    $(function(){
        $("#pre").click(function(){
            delta--;
            window.location.href = "index.php?r=check1nm/default/result&delta="+delta;
        });

        $("#next").click(function(){
            delta++;
            window.location.href = "index.php?r=check1nm/default/result&delta="+delta;
        });

        $("#submit").click(function(){
            $.post('index.php?r=check1nm/ajax/showresult',{starttime:"<?php echo $starttime;?>",endtime:"<?php echo $endtime;?>"},function(data){
                if(data != null){
                    var resp = eval(data);
                    if(resp.code == 0){
                        window.location.href = resp.data;
                    }

                }
            })
            alert("已经提交请求，请等待页面跳转……")
        });
    });
</script>
<?php
/**
 * Created by PhpStorm.
 * User: Enbandari
 * Date: 14-5-26
 * Time: 上午10:06
 */

