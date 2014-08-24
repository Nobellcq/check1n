/**
 * Created with JetBrains PhpStorm.
 * User: huobingqian
 * Date: 14-4-3
 * Time: 下午2:18
 * To change this template use File | Settings | File Templates.
 */
/**
 * Created with JetBrains PhpStorm.
 * User: huobingqian
 * Date: 14-4-1
 * Time: 上午11:49
 * To change this template use File | Settings | File Templates.
 */
jQuery('#add-merge-form').yiiactiveform({'enableAjaxValidation':true,'validateOnSubmit': true, 'attributes': [
    {'id': 'MergeForm_query2', 'inputID': 'MergeForm_query2', 'errorID': 'MergeForm_query2_em_', 'model': 'MergeForm', 'name': 'MergeForm[query2]', 'enableAjaxValidation': false, 'inputContainer': 'div.control-group', 'clientValidation': function (value, messages, attribute) {

        if (jQuery.trim(value) == '') {
            messages.push("查询词不能为空.");
        }

    }},
    {'id': 'MergeForm_state', 'inputID': 'MergeForm_state', 'errorID': 'MergeForm_state_em_', 'model': 'MergeForm', 'name': 'MergeForm[state]', 'enableAjaxValidation': false, 'inputContainer': 'div.control-group', 'clientValidation': function (value, messages, attribute) {

        if (jQuery.trim(value) == '') {
            messages.push("State cannot be blank.");
        }

    }}
], 'errorCss': 'error'});

jQuery('#add-merge-form').submit(function(){
    return false;
})