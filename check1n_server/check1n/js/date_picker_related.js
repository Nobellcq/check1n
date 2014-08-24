/**
 * Created with JetBrains PhpStorm.
 * User: huobingqian
 * Date: 14-4-1
 * Time: 下午7:16
 * To change this template use File | Settings | File Templates.
 */
Date.prototype.format = function (format) {
    var o = {
        "M+": this.getMonth() + 1, //month
        "d+": this.getDate(), //day
        "h+": this.getHours(), //hour
        "m+": this.getMinutes(), //minute
        "s+": this.getSeconds(), //second
        "q+": Math.floor((this.getMonth() + 3) / 3), //quarter
        "S": this.getMilliseconds() //millisecond
    };
    if (/(y+)/.test(format))
        format = format.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o)
        if (new RegExp("(" + k + ")").test(format))
            format = format.replace(RegExp.$1, RegExp.$1.length == 1 ? o[k] : ("00" + o[k]).substr(("" + o[k]).length));
    return format;
}
$(function(){
    reloadDatePicker();
})


var date_picker_content = '<div class="control-group "><label class="control-label required" for="QueryForm_days">下线时间<span class="required">*</span></label><div class="controls"><input name="QueryForm[days]" id="QueryForm_days" type="text" "/><br><a href="javascript:void(0)" id="one_day">一天</a>&nbsp;<a href="javascript:void(0)" id="three_days">三天</a>&nbsp;<a href="javascript:void(0)" id="one_month">一月</a>&nbsp;<a href="javascript:void(0)" id="two_months">两月</a><span class="help-inline error" id="QueryForm_days_em_" style="display: none"></span></div></div>';
$(".check_radio").change(function () {
    var container = $("#date_picker_container");
    container.empty();
    if ($('input[name="QueryForm[state]"]:checked').val() == 1) {
        container.append(date_picker_content);
        reloadDatePicker();
    } else {

    }
});



function addDate(days) {
    var myDate = new Date();
    var dayOfMonth = myDate.getDate();
    myDate.setDate(dayOfMonth + days);
    return myDate.format('yyyy-MM-dd hh:mm:ss');
}

//var date = "";

function reloadDatePicker() {
    var input_days = $("#QueryForm_days");
//    if(date == ""){
     var  date = input_days.val()
//    }

    input_days.datepicker();

    input_days.datepicker("option", "dateFormat", "yy-mm-dd 00:00:00");

    if(date == ""){
        date = addDate(14)
        input_days.val(date);
    }else{
        input_days.val(date);
    }
    //input_days.val("2014-05-01 20:41:33");
    $("#one_day").click(function () {
        input_days.val(addDate(1));
    });

    $("#three_days").click(function () {
        input_days.val(addDate(3));
    });

    $("#one_month").click(function () {
        input_days.val(addDate(30));
    });

    $("#two_months").click(function () {
        input_days.val(addDate(60));
    });
}


