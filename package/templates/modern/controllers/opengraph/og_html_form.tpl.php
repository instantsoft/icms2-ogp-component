<?php
$field_id = 'list-'.uniqid();
$this->addControllerJS('og_field');
?>
<div class="dynamic_list_wrap" id="<?php echo $field_id; ?>" data-error_text="<?php echo LANG_OPENGRAPH_FIELD_NEED_VALUE; ?>">

    <div class="other_field_list"></div>

    <a class="btn btn-outline-primary add_link" href="#">
        <?php echo html_svg_icon('solid', 'plus-circle'); ?> <?php echo LANG_OPENGRAPH_ADD_FIELD; ?>
    </a>

    <div class="add_other_field" style="display: none">
        <div class="d-flex align-items-center">
            <div>
                <label><?php echo LANG_OPENGRAPH_FIELD_NAME; ?></label>
                <?php echo html_input(); ?>
            </div>
            <div class="px-2 px-lg-3 flex-grow-1">
                <label><?php echo LANG_OPENGRAPH_FIELD_CONTENT; ?></label>
                <?php echo html_input('text', '', ''); ?>
            </div>
            <div>
                <label class="d-block" style="visibility: hidden">empty</label>
                <a class="btn btn-success add_value mr-sm-2" href="#" title="<?php echo LANG_ADD; ?>">
                    <?php echo html_svg_icon('solid', 'check-square'); ?>
                </a>
                <a class="btn btn-danger cancel" href="#" title="<?php echo LANG_CANCEL; ?>">
                    <?php echo html_svg_icon('solid', 'minus-square'); ?>
                </a>
            </div>
        </div>
        <div class="alert alert-secondary mt-2 mt-lg-3 mb-0"><?php echo LANG_OPENGRAPH_FIELD_NAME_HINT; ?></div>
    </div>

    <div class="other_template" style="display:none">
        <div class="d-flex align-items-center mb-2">
            <span class="text-danger font-weight-bold mr-1">&lt;meta</span>
            <span class="text-primary">property=&quot;</span>
            <span class="title">
                <input type="hidden" name="" value="" /><input type="hidden" name="" value="" />
                <span></span>
            </span>
            <span class="text-primary">&quot; content=&quot;</span>
            <span class="other_field_wrap"></span>
            <span class="text-primary">&quot;</span>
            <span class="text-danger font-weight-bold ml-1">/&gt;</span>
            <a class="btn btn-sm unset_value ml-2 ml-lg-3 text-danger" title="<?php echo LANG_CANCEL; ?>" href="#">
                <?php echo html_svg_icon('solid', 'minus-circle'); ?>
            </a>
        </div>
    </div>
</div>
<?php ob_start(); ?>
<script>
    $(function(){
        new icms.ogList('<?php echo $field_id; ?>', <?php echo json_encode($og_markups); ?>);
    });
</script>
<?php $this->addBottom(ob_get_clean()); ?>