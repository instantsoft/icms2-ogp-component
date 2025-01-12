<?php

class actionOpengraphImgPresetsAdd extends cmsAction {

    use icms\traits\controllers\actions\formItem;

    public function __construct($controller, $params = []) {

        parent::__construct($controller, $params);

        $list_url = $this->cms_template->href_to('img_presets');

        $this->table_name  = 'og_img_presets';
        $this->form_name   = 'preset';
        $this->success_url = $list_url;
        $this->title       = ['add' => LANG_OPENGRAPH_PRESETS_ADD, 'edit' => '{title}'];

        $this->update_callback = function($data) {
            $this->controller_opengraph->deleteFilesByMaskRecursive(cmsConfig::get('upload_path') . 'opengraph/', $data['id'] . '_*');
        };

        $this->breadcrumbs = [
            [LANG_OPENGRAPH_PRESETS, $list_url]
        ];

        $this->use_default_tool_buttons = true;
    }

}
