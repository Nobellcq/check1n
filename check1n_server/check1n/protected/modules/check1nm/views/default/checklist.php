<style type="text/css">
    .invisible {
        display: none;
    }

    .align-right {
        float: right;
    }

    input[type="text"] {
        margin: 0
    }

   .checkitem form{margin:0}
</style>

<form id="search_form" class="align-right">
    <input id="search_text" type="text" class="input-medium search-query">
    <a href="#" id="search" class="btn">搜索id</a>
</form>

<button id="back" class="btn invisible">返回</button>&nbsp;&nbsp;
<button id="go_check1n" class="btn btn-primary invisible">我要签到</button>

<h3 id="title">人员名单</h3>


<div class="tab-content row" style="margin:0px">
    <table id="event_table" class="table">
        <thead>
        <tr id="table_title">

        </tr>
        </thead>
        <tbody id="table_body">
        </tbody>
    </table>

    <div class="pagination text-center span6 offset3">
        <ul id="page_container">

        </ul>
        <div id="total_count" class="pull-right">共0条</div>
    </div>

</div>


<script type="text/javascript">
    $(function () {
        var list_type = 0;
        var userid = "";
        var username = "";
        var cur_page = 1;
        var pages = 0;
        var q = '<?php echo $id?>';
        var page_size = 20;
        var total_count = 0;
        var item_state = -1;
//        $state = -1, $limit = 20, $page = 0
        var page_prev = '<li><a id="page_prev" href="javascript:void(0)">Prev</a></li>';
        var page_item = '<li><a id="page_#{i}" class="page_item" href="javascript:void(0)">#{i}</a></li>';
        var page_next = '<li><a id="page_next" href="javascript:void(0)">Next</a></li>';
        var page_prev_3 = '<li><a id="page_prev_3" class="page_item_spec" href="javascript:void(0)">#{i}</a></li>'
        var page_next_3 = '<li><a id="page_next_3" class="page_item_spec" href="javascript:void(0)">#{i}</a></li>'

        var userlist_title = '<th>姓名</th><th>用户id</th><th>指纹编号</th><th>快速签到</th>';
        var userlist_item = '<tr class="useritem"><td>#{name}</td><td>#{id}</td><td>#{nid}</td><td><button class="check1n_now btn btn-success">我签</button></td>';

        var checklist_title = '<th>用户id</th><th>签到时间</th>';
        var checklist_item = '<tr class="checkitem"><td>#{id}</td><td>#{checktime}</td></tr>';
        var checklist_item_edit = '<td>#{id}</td><td><form id="update_check"><input type="text" id="newtime" name="newtime"/>&nbsp;&nbsp;<input id="submit_update" type="submit" class="btn btn-primary" value="提交更新"/>&nbsp;&nbsp;<input id="cancel" type="button" class="btn" value="取消">&nbsp;&nbsp;<input id="delete" type="button" class="btn btn-danger" value="删除"></form></td>';
        var checklist_item_content = '<td>#{id}</td><td>#{checktime}</td>';

        $("#search").click(function () {
            search();
        });

        $("#search_form").submit(function () {
            search();
            return false;
        });

        function search() {
            q = $("#search_text").val();
            loadList();
        }

        loadList();

        function loadList() {
            var url;
            var params;
            if (list_type == 0) {
                //
                url = "index.php?r=check1nm/ajax/userlist"; // user list
                params = {page: cur_page, limit: page_size, q: q};

                $("#title").text("人员名单")
                $("#back").addClass("invisible")
                $("#go_check1n").addClass("invisible")
                $("#search_form").removeClass("invisible")
            } else {
                url = "index.php?r=check1nm/ajax/checklist"; // check list
                params = {page: cur_page, limit: page_size, userid: userid};

                $("#title").text(username + "的签到记录")
                $("#back").removeClass("invisible")
                $("#go_check1n").removeClass("invisible")
                $("#search_form").addClass("invisible")

                $("#go_check1n").click(function(){
                    window.location.href = "index.php?r=check1nm/default/check1n&userid="+userid;
                });
            }

            $.get(url, params, function (data, textStatus) {
                var json = eval(data);
                if (json.code == 0) { // success
                    var table_body = $("#table_body");
                    var table_title = $("#table_title");
                    var pages_container = $("#page_container");
                    table_body.empty();
                    table_title.empty();
                    pages_container.empty();

                    var list = json.data;
                    total_count = json.data_count;

                    if (list_type == 0) {
                        table_title.append($(userlist_title));
                    } else {
                        table_title.append($(checklist_title));
                    }
                    for (var item in list) {
                        if (list_type == 0) {
                            var li = $(userlist_item.replace(/#\{id\}/g, list[item].id).replace(/#\{nid\}/g, list[item].nid).replace(/#\{name\}/g, list[item].name))//.replace(/#\{time\}/g, list[item].time));
                        } else {
                            var li = $(checklist_item.replace(/#\{id\}/g, list[item].id).replace(/#\{checktime\}/g, list[item].checktime));
                        }

                        table_body.append(li);
                    }


                    pages = Math.ceil(total_count / page_size);
                    var start_page = 1;
                    var end_page = pages;
                    if (cur_page > 1) {
                        pages_container.append(page_prev);
                    }
                    if (cur_page > 2) {
                        var li = $(page_prev_3.replace(/#\{i\}/g, "..."));
                        pages_container.append(li);
                        start_page = cur_page - 2;

                    }

                    if (pages - cur_page > 2) {
                        end_page = cur_page + 2;
                    }
                    for (var i = start_page; i <= end_page; ++i) {
                        var li = $(page_item.replace(/#\{i\}/g, i));
                        pages_container.append(li);
                    }

                    if (pages - cur_page > 2) {
                        var li = $(page_next_3.replace(/#\{i\}/g, "..."));
                        pages_container.append(li);
                    }

                    if (pages - cur_page > 0) {
                        pages_container.append(page_next);
                    }
                    $("#page_" + cur_page).removeClass("page_item").parent().addClass("active");

                    $("#total_count").text("共" + total_count + "条");

                    $(".page_item").click(function () {
                        cur_page = parseInt($(this).text());
                        loadList();
                    });

                    $("#page_prev").click(function () {
                        --cur_page;
                        loadList();
                    });

                    $("#page_next").click(function () {
                        ++cur_page;
                        loadList();
                    });

                    $("#page_prev_3").click(function () {
                        cur_page -= 2;
                        loadList();
                    });

                    $("#page_next_3").click(function () {
                        cur_page += 2;
                        loadList();
                    });


                    $(".check1n_now").click(function(e){
                        var tds = $(this).parents("tr").find("td");
                        var checktime = new Date().format("yyyy/MM/dd hh:mm:ss");
                        $.post("index.php?r=check1nm/ajax/check1n",{userid: tds.eq(1).text(),0:checktime},function(response){
                            if(response !=null){
                                var res = eval(response);
                                if(res.code == 0){
                                    alert("签到成功："+checktime)
                                }else{
                                    alert(res.error)
                                }
                            }
                        })

                        if (e && e.stopPropagation)
                            e.stopPropagation()
                        else
                            window.event.cancelBubble=true
                    })

                    $(".useritem").click(function () {
                        cur_page = 1;
                        list_type = 1;
                        userid = $(this).find("td").eq(1).text();
                        username = $(this).find("td").eq(0).text();
                        loadList();
                    })

                    var isEditting = false;
                    $(".checkitem").dblclick(function () {
                        if (!isEditting) {
                            isEditting = true;

                            var oldtime = $(this).find("td").eq(1).text();
                            var userid = $(this).find("td").eq(0).text();

                            var that = $(this)
                            that.empty();
                            that.append($(checklist_item_edit.replace(/#{id}/g, userid)));

                            var newTimeNode = $("#newtime");
                            newTimeNode.datetimepicker({
                                showSecond: true,
                                dateFormat: 'yy-mm-dd',
                                timeFormat: 'hh:mm:ss'
                            });
                            newTimeNode.val(oldtime);

                            $("#update_check").submit(function () {
                                var newtime = newTimeNode.val();
                                $.post("index.php?r=check1nm/ajax/updatecheck1n", {userid: userid, oldtime: oldtime, newtime: newtime}, function (response) {
                                    if (response != null) {
                                        var res = eval(response)
                                        that.empty();
                                        if (res.code == 0) {
                                            alert(res.data);
                                            that.append($(checklist_item_content.replace(/#{id}/g, userid).replace(/#{checktime}/g, newtime)));
                                            loadList()
                                        } else {
                                            alert(res.error)
                                            that.append($(checklist_item_content.replace(/#{id}/g, userid).replace(/#{checktime}/g, oldtime)));
                                        }
                                    } else {
                                        alert("网络错误")
                                        that.append($(checklist_item_content.replace(/#{id}/g, userid).replace(/#{checktime}/g, oldtime)));
                                    }
                                    isEditting = false;
                                })
                                return false;
                            })

                            $("#cancel").click(function(){
                                that.empty();
                                that.append($(checklist_item_content.replace(/#{id}/g, userid).replace(/#{checktime}/g, oldtime)));
                                isEditting = false;
                            })

                            $("#delete").click(function(){
                                $.post("index.php?r=check1nm/ajax/deletecheck1n", {userid: userid, oldtime: oldtime}, function (response) {
                                    if (response != null) {
                                        var res = eval(response)
                                        that.empty();
                                        if (res.code == 0) {
                                            alert(res.data);
                                            loadList()
                                        } else {
                                            alert(res.error)
                                            that.append($(checklist_item_content.replace(/#{id}/g, userid).replace(/#{checktime}/g, oldtime)));
                                        }
                                    } else {
                                        alert("网络错误")
                                        that.append($(checklist_item_content.replace(/#{id}/g, userid).replace(/#{checktime}/g, oldtime)));
                                    }
                                    isEditting = false;
                                })
                            })
                        }

                    })
                }
            });
        }

        $("#back").click(function () {
            list_type = 0;
            cur_page = 1;
            loadList();
        })
    });

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

</script>

<script type="text/javascript" src="js/jquery-ui-slide.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-timepicker-addon.js"></script>