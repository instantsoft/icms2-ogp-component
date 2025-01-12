<?php

class actionOpengraphImgPresetsEdit extends cmsAction {

    public function run($id){

        return $this->runExternalAction('img_presets_add', $this->params);

    }

}
