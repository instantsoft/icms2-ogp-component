<?php

class actionOpengraphImgPresetsDelete extends cmsAction {

    use icms\traits\controllers\actions\deleteItem;

    public function __construct($controller, $params = []) {

        parent::__construct($controller, $params);

        $this->table_name  = 'og_img_presets';
        $this->success_url = $this->cms_template->href_to('img_presets');

        $this->delete_callback = function($item, $model){
            return $item['id'] != 1;
        };

    }

}
