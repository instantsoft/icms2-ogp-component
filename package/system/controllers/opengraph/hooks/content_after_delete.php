<?php

class onOpengraphContentAfterDelete extends cmsAction {

    public function run($data){

        $ctype = $data['ctype'];
        $item  = $data['item'];

        $this->deleteFilesByMaskRecursive(cmsConfig::get('upload_path') . 'opengraph/', '[0-9]+_content_'.$ctype['name'].'_'.$item['id'].'_*');

        return $data;
    }

}
