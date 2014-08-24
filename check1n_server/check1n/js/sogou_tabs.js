/**
 * Created with JetBrains PhpStorm.
 * User: huobingqian
 * Date: 14-3-20
 * Time: 下午8:52
 * To change this template use File | Settings | File Templates.
 */
$(function () {
    /*
     * Global vars start here..
     */

    /**
     * <li>used to store the text of the tab as a key while the tab index as the value.<br>
     * eg. a tab with the text "mailbox" and the index 0, it turns out that tabArr["mailbox"]=0.
     *
     * <li>it will also save the flag whether a ajax tab should be loaded in the future.<br>
     * eg. a tab with the text "mailbox" and the index 0, loaded , it turns out that tabArr["mailbox_loaded"]=1.
     */



    var tabArr = new Array();

    var tabs = $("#tabs").tabs();

    var tabTemplate = "<li style='height: 25px;cursor:pointer' title='双击可隐藏/显示侧边栏'><i title='重新加载' class='icon-refresh' style='float: left;margin: 0.3em 0em 0px 0.5em;cursor: pointer; ' role='presentation'></i><a href='#{href}'style='padding:0.2em 0.5em;font-size:13px'>#{label}</a><span class='ui-icon ui-icon-close' role='presentation'>Remove Tab</span></li>";

    /*
     * Global vars end here.
     */

    /**
     * called before loading a ajax tab.deciding whether to load this time.
     */
    tabs.on("tabsbeforeload", function (event, ui) {
        var key = ui.tab.find("a").text();
        if (tabArr[key] != undefined) {
            if (tabArr[key + "_loaded"] != undefined) {
                //what? the tab has been loaded?! stop it!
                ui.jqXHR.abort();
            }
        }
    });

    /**
     * called after loading a ajax tab. tell tabArr the tab has been loaded and never do it again.
     */
    tabs.on("tabsload", function (event, ui) {
        var key = ui.tab.innerHTML;
        //well, the ajax tab is loaded. tell the tabArr.
        tabArr[key + "_loaded"] = 1;
    });

    /**
     * used to sort the tabs when dragging by the mouse.
     */
    tabs.find(".ui-tabs-nav").sortable({
        axis: "x",
        stop: function () {
            refresh();
        }
    });

    /**
     * remove the tab! click the "X".
     */
    tabs.delegate("span.ui-icon-close", "click", function () {
        var key = $(this).prev("a").text();
        tabArr[key] = undefined;
        tabArr[key + "_loaded"] = undefined;

        var panelId = $(this).closest("li").remove().attr("aria-controls");
        $("#" + panelId).remove();
        refresh();
    });

    tabs.delegate("i.icon-refresh", "click", function () {
        var key = $(this).next("a").text();
        tabArr[key + "_loaded"] = undefined;
        tabs.tabs('load', tabArr[key]);
    });

    /**
     * call addTab when clicked.
     */
    $(".list_item").click(addTab);

    //Method start here.
    /**
     * actual addTab function: adds new tab using the input from the form above
     */
    function addTab() {
        var index = $(".list_item").index(this);
        var key = this.innerHTML;

        if (tabArr[key] == undefined) {
            var targetUrl = $(this).attr("targeturl");

            var label = this.innerHTML;
            var li = $(tabTemplate.replace(/#\{href\}/g, targetUrl).replace(/#\{label\}/g, label));
            tabs.find(".ui-tabs-nav").append(li);

            li.dblclick(function () {
                runEffect();
            });

            refresh();
            //just activate the newly added one.
            tabs.tabs({ active: -1 });
        } else {
            //activate the one according to the text.
            tabs.tabs({ active: tabArr[key] });
        }
    }

    /**
     * call tabs("refresh") first and then rearrange tabArr.
     * A foreach will be called through the method.
     */
    function refresh() {
        tabs.tabs("refresh");

        //rearrange tabArr here.
        var i = 0;
        $("#tabs li").each(function () {
            tabArr[$(this).children("a").text()] = i++;
        });
    }

    var flag = false;
    $("#toggle_left").click(function () {
        runEffect();
    });

    function runEffect() {
        var dist;
        var clzToRm;
        var clzToAdd;
        var _dist;
        if (flag) {
            dist = '+=140px';
            _dist = '-140px';
            clzToAdd = 'icon-chevron-left';
            clzToRm = 'icon-chevron-right';

            $("#tabs_body").removeClass('span12');
            $("#tabs_body").addClass('span10');
            $("#nav_body").addClass('span2');
        } else {
            dist = '-140px';
            _dist = '+=140px';
            clzToAdd = 'icon-chevron-right';
            clzToRm = 'icon-chevron-left';

        }
        flag = !flag;
        var options = {};
        $("#left_nav").toggle("slide", options, 500, function () {
            if (flag) {
                $("#tabs_body").removeClass('span10');
                $("#tabs_body").addClass('span12');
                $("#nav_body").removeClass('span2');
            } else {

            }
        });
    }

    $("#iframe_back").click(function () {
        var index = tabs.tabs("option", "active");
        if (index!==false) {
            tabs.eq(index).find('#iframepage').contentWindow.history.back();
            //alert(tabs.eq(index));
        }else{
            alert(index)
        }

    });

    function iframeBack() {
        document.getElementById('iframepage').contentWindow.history.back();
    }

    function iframeForward() {
        document.getElementById('iframepage').contentWindow.history.forward();
    }

});

