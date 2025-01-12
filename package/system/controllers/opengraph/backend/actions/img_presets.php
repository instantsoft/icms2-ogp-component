<?php

class actionOpengraphImgPresets extends cmsAction {

    use icms\traits\controllers\actions\listgrid;

    public function __construct($controller, $params = []) {

        parent::__construct($controller, $params);

        $this->table_name = 'og_img_presets';
        $this->grid_name  = 'presets';
        $this->title      = LANG_OPENGRAPH_PRESETS;

        $this->tool_buttons = [
            [
                'class' => 'add',
                'title' => LANG_ADD,
                'href'  => $this->cms_template->href_to('img_presets_add')
            ],
            [
                'class'   => 'refresh',
                'title'   => LANG_OPENGRAPH_CLEAR,
                'confirm' => LANG_OPENGRAPH_CLEAR_CONFIRM,
                'href'    => $this->cms_template->href_to('clear').'?csrf_token='.cmsForm::getCSRFToken()
            ]
        ];
    }

}
