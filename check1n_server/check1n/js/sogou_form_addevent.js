/**
 * Created with JetBrains PhpStorm.
 * User: huobingqian
 * Date: 14-4-1
 * Time: 上午11:49
 * To change this template use File | Settings | File Templates.
 */
jQuery('#add-event-form').yiiactiveform({'enableAjaxValidation':true,'validateOnSubmit': true, 'attributes': [
    {'id': 'QueryForm_query', 'inputID': 'QueryForm_query', 'errorID': 'QueryForm_query_em_', 'model': 'QueryForm', 'name': 'QueryForm[query]', 'enableAjaxValidation': false, 'inputContainer': 'div.control-group', 'clientValidation': function (value, messages, attribute) {

        if (jQuery.trim(value) == '') {
            messages.push("特征query不能为空.");
        }

    }},
    {'id': 'QueryForm_state', 'inputID': 'QueryForm_state', 'errorID': 'QueryForm_state_em_', 'model': 'QueryForm', 'name': 'QueryForm[state]', 'enableAjaxValidation': false, 'inputContainer': 'div.control-group', 'clientValidation': function (value, messages, attribute) {

        if (jQuery.trim(value) == '') {
            messages.push("State cannot be blank.");
        }

    }},
//    {'id': 'QueryForm_abstract', 'inputID': 'QueryForm_abstract', 'errorID': 'QueryForm_abstract_em_', 'model': 'QueryForm', 'name': 'QueryForm[abstract]', 'enableAjaxValidation': false, 'inputContainer': 'div.control-group', 'clientValidation': function (value, messages, attribute) {
//
//        if (jQuery.trim(value) == '') {
//            messages.push("摘要不能为空.");
//        }
//
//    }},
    {'id': 'QueryForm_title', 'inputID': 'QueryForm_title', 'errorID': 'QueryForm_title_em_', 'model': 'QueryForm', 'name': 'QueryForm[title]', 'enableAjaxValidation': false, 'inputContainer': 'div.control-group', 'clientValidation': function (value, messages, attribute) {

        if (jQuery.trim(value) == '') {
            messages.push("标题不能为空.");
        }

    }},
    {'id': 'QueryForm_days', 'inputID': 'QueryForm_days', 'errorID': 'QueryForm_days_em_', 'model': 'QueryForm', 'name': 'QueryForm[days]', 'enableAjaxValidation': false, 'inputContainer': 'div.control-group', 'clientValidation': function (value, messages, attribute) {

        if (jQuery.trim(value) == '') {
            messages.push("请选择有效的日期.");
        }

    }}
], 'errorCss': 'error'});

