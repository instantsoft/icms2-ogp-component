var icms = icms || {};
icms.ogList = function(field_id, current_values){

    let element_key = 0;

    let wrap = $('#'+field_id);

    let error_empty = wrap.data('error_text');

    let addOtherField = function(){
        $('.add_other_field', wrap).show().find('input:first').focus();
        $('.add_link', wrap).hide();
        return false;
    };

    let cancelOther = function(){
        $('.add_other_field', wrap).hide();
        $('.add_link', wrap).show();
        $('.add_other_field input', wrap).val('');
        return false;
    };

    let unsetValue = function(link){
        $(link).closest('div').remove();
        return false;
    };

    let submitValue = function(data){

        element_key += 1;

        if (typeof(data) === 'undefined') {
            data = {other_field: false, const_field: false};
        }

        let field, const_field;

        if (data.other_field !== false){
            field = data.other_field;
        } else {
            field = $('.add_other_field', wrap).find('input:first').val();
            if(!field){
                alert(error_empty);
                return false;
            }
        }
        if (data.const_field !== false){
            const_field = data.const_field;
        } else {
            const_field = $('.add_other_field', wrap).find('input:last').val();
            if(!const_field){
                alert(error_empty);
                return false;
            }
        }

        let other_template = $('.other_template', wrap).clone(true).show().removeClass('other_template');

        $('.title > span', other_template).append(field);
        $('.other_field_wrap', other_template).prepend(const_field);

        $('.title input:first', other_template).attr('name', 'options[other_field]['+element_key+']').val(field);
        $('.title input:last', other_template).attr('name', 'options[const_field]['+element_key+']').val(const_field);

        $('.other_field_list', wrap).append(other_template);

        return cancelOther();
    };

    $('.add_link', wrap).on('click', function (){
        return addOtherField();
    });

    $('.cancel', wrap).on('click', function (){
        return cancelOther();
    });

    $('.add_value', wrap).on('click', function (){
        return submitValue();
    });

    $('.unset_value', wrap).on('click', function (){
        return unsetValue(this);
    });

    for(let field in current_values) {
        submitValue(current_values[field]);
    }
};