<div id="f_options_og_other_fields" class="field ft_list">
    <label><?php echo LANG_OPENGRAPH_OTHER_FIELDS; ?></label>
    <div class="dynamic_list_wrap">

        <div id="other_field_list"></div>

        <div id="add_other_field" style="display:none">
            <?php echo LANG_OPENGRAPH_FIELD_NAME; ?>: <?php echo html_input(); ?> <?php echo LANG_OPENGRAPH_FIELD_CONTENT; ?>: <?php echo html_input('text', '', '', array('placeholder'=>LANG_OPENGRAPH_FIELD_CONTENT_HINT)); ?>
            <a class="ajaxlink add_link" href="javascript:submitOtherField()"><?php echo LANG_ADD; ?></a> |
            <a class="ajaxlink" href="javascript:cancelOther()"><?php echo LANG_CANCEL; ?></a>
            <div class="hint"><?php echo LANG_OPENGRAPH_FIELD_NAME_HINT; ?></div>
        </div>

        <a id="add_other_field_link" class="ajaxlink" href="javascript:addOtherField()"><?php echo LANG_OPENGRAPH_ADD_FIELD; ?></a>

        <div id="other_template" class="sorting" style="display:none">
            <span style="color:#800000; font-weight:bold; ">&lt;meta</span> <span style="color:#274796; ">property=&quot;</span><span class="title"><input type="hidden" name="" value="" /><input type="hidden" name="" value="" /></span><span style="color:#274796; ">&quot; content=&quot;</span><span class="other_field_wrap"><select name="" style="display:none"></select><?php echo html_input('text', '', '', array('placeholder'=>LANG_OPENGRAPH_FIELD_FUNC, 'style'=>'display:none')); ?></span>&quot; <span style="color:#800000; font-weight:bold; ">/&gt;</span>
            <span class="delete"><a class="ajaxlink" href="javascript:" onclick="deleteSorting(this)"><?php echo LANG_DELETE; ?></a></span>
        </div>

        <select id="fields_list" style="display:none">
            <?php unset($fields['user']); ?>
            <?php foreach($fields as $field){ ?>
                <option value="<?php echo $field['name']; ?>" data-type="<?php echo $field['handler']->filter_type; ?>"><?php echo htmlspecialchars($field['title']); ?></option>
            <?php } ?>
        </select>
    </div>
</div>

<style>
    #other_field_list .sorting {
        display:none; margin-bottom: 5px;
    }
    form .field .other_field_wrap .input, form .field #add_other_field input {
        width: 200px;
        margin: 0 0 0 5px;
    }
    #add_other_field {
        margin: 20px 0 0 0;
    }
    #other_field_list {
        margin: 10px 0 0 0;
    }
</style>
<script type="text/javascript">
    function addOtherField(){
        $('#add_other_field').show().find('input:first').focus();
        $('#add_other_field_link').hide();
    }
    function cancelOther(){
        $('#add_other_field').hide();
        $('#add_other_field_link').show();
        $('#add_other_field input').val('');
    }
    function deleteSorting(link_instance){
        $(link_instance).parent('span').parent('div').fadeToggle('fast', function(){ $(this).remove() });
    }
    function submitOtherField(data){

        if (typeof(data) == 'undefined') {
            data = {other_field: false, const_field: false, other_field_name: false, other_field_func: false};
        }

        if (data.other_field !== false){
            var field = data.other_field;
        } else {
            var field = $('#add_other_field input:first').val();
            if(!field){
                alert('<?php echo LANG_OPENGRAPH_FIELD_NEED_VALUE; ?>');
                return false;
            }
        }
        if (data.const_field !== false){
            var const_field = data.const_field;
        } else {
            var const_field = $('#add_other_field input:last').val();
        }

        var sorting_id = $('#other_field_list .sorting').length;
        var other_template = $('#other_template').clone();

        $(other_template).attr('id', 'other_template'+sorting_id);

        $('.title', other_template).append(field);
        if(const_field.length > 0){
            $('.other_field_wrap', other_template).append(const_field);
        } else {
            $('.other_field_wrap select', other_template).html( $('#fields_list').html() ).show();
            $('.other_field_wrap input', other_template).show();
        }

        $('.title input:first', other_template).attr('name', 'options[other_field]['+sorting_id+']').val(field);
        $('.title input:last', other_template).attr('name', 'options[const_field]['+sorting_id+']').val(const_field);
        $('.other_field_wrap select', other_template).attr('name', 'options[other_field_name]['+sorting_id+']');
        $('.other_field_wrap input', other_template).attr('name', 'options[other_field_func]['+sorting_id+']');

        $('#other_field_list').append(other_template);

        if (data.other_field_name) {
            $('.other_field_wrap select', other_template).val(data.other_field_name);
        }

        if (data.other_field_func) {
            $('.other_field_wrap input', other_template).val(data.other_field_func);
        }

        $('#other_field_list #other_template'+sorting_id).fadeToggle();

        cancelOther();

    }
    $('#f_options_og_other_fields').appendTo($('#fset_og'));
    <?php if (!empty($ctype['options']['other_field'])){ ?>
        <?php foreach($ctype['options']['other_field'] as $key=>$other_field) { ?>
                submitOtherField({other_field: '<?php echo $other_field; ?>', const_field: '<?php echo !empty($ctype['options']['const_field'][$key]) ? $ctype['options']['const_field'][$key] : ''; ?>', other_field_name: '<?php echo !empty($ctype['options']['other_field_name'][$key]) ? $ctype['options']['other_field_name'][$key] : ''; ?>', other_field_func: '<?php echo !empty($ctype['options']['other_field_func'][$key]) ? $ctype['options']['other_field_func'][$key] : ''; ?>'});
        <?php } ?>
    <?php } ?>
</script>