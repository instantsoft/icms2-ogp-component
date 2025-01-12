<?php

class backendOpengraph extends cmsBackend {

    public $useDefaultOptionsAction = true;
    protected $useOptions = true;

    public function getBackendMenu() {
        return [
            [
                'title' => LANG_OPTIONS,
                'url'   => href_to($this->root_url)
            ],
            [
                'title' => LANG_OPENGRAPH_PRESETS,
                'url'   => href_to($this->root_url, 'img_presets')
            ]
        ];
    }

}
