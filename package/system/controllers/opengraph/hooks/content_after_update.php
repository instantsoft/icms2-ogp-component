<?php

class onOpengraphContentAfterUpdate extends cmsAction {

    public function run($item) {

        $this->deleteFilesByMaskRecursive(cmsConfig::get('upload_path') . 'opengraph/', '[0-9]+_content_'.$item['ctype_data']['name'].'_'.$item['id'].'_*');

        return $item;
    }

}
