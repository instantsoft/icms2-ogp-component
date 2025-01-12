<?php

class onOpengraphCtypeAfterDelete extends cmsAction {

    public function run($ctype) {

        $this->deleteFilesByMaskRecursive(cmsConfig::get('upload_path') . 'opengraph/', '[0-9]+_content_'.$ctype['name'].'_*');

        return $ctype;
    }

}
