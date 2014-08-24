/**
 * Created with JetBrains PhpStorm.
 * User: huobingqian
 * Date: 14-4-1
 * Time: 上午11:49
 * To change this template use File | Settings | File Templates.
 */
jQuery('#add-node-form').yiiactiveform({'enableAjaxValidation':true,'validateOnSubmit': true, 'attributes': [
    {'id': 'NodeForm_query', 'inputID': 'NodeForm_query', 'errorID': 'NodeForm_query_em_', 'model': 'NodeForm', 'name': 'NodeForm[query]', 'enableAjaxValidation': false, 'inputContainer': 'div.control-group', 'clientValidation': function (value, messages, attribute) {

        if (jQuery.trim(value) == '') {
            messages.push("特征query不能为空.");
        }

    }},
    {'id': 'NodeForm_state', 'inputID': 'NodeForm_state', 'errorID': 'NodeForm_state_em_', 'model': 'NodeForm', 'name': 'NodeForm[state]', 'enableAjaxValidation': false, 'inputContainer': 'div.control-group', 'clientValidation': function (value, messages, attribute) {

        if (jQuery.trim(value) == '') {
            messages.push("State cannot be blank.");
        }

    }},
    {'id': 'NodeForm_url', 'inputID': 'NodeForm_url', 'errorID': 'NodeForm_url_em_', 'model': 'NodeForm', 'name': 'NodeForm[url]', 'enableAjaxValidation': false, 'inputContainer': 'div.control-group', 'clientValidation': function (value, messages, attribute) {

        if (jQuery.trim(value) == '') {
            messages.push("url不能为空.");
        }

    }},
    {'id': 'NodeForm_eid', 'inputID': 'NodeForm_eid', 'errorID': 'NodeForm_eid_em_', 'model': 'NodeForm', 'name': 'NodeForm[eid]', 'enableAjaxValidation': false, 'inputContainer': 'div.control-group', 'clientValidation': function (value, messages, attribute) {

        if (jQuery.trim(value) == '') {
            messages.push("id不能为空.");
        }

    }},
    {'id': 'NodeForm_title', 'inputID': 'NodeForm_title', 'errorID': 'NodeForm_title_em_', 'model': 'NodeForm', 'name': 'NodeForm[title]', 'enableAjaxValidation': false, 'inputContainer': 'div.control-group', 'clientValidation': function (value, messages, attribute) {

        if (jQuery.trim(value) == '') {
            messages.push("标题不能为空.");
        }

    }}
], 'errorCss': 'error'});

jQuery('#add-node-form').submit(function(){
    return false;
})