<?php

class actionOpengraphClear extends cmsAction {

    public function run() {

        if (!cmsForm::validateCSRFToken($this->request->get('csrf_token', ''))) {
            return cmsCore::error404();
        }

        files_clear_directory(cmsConfig::get('upload_path') . 'opengraph/');

        cmsUser::addSessionMessage(sprintf(LANG_OPENGRAPH_CLEAR_SUCCESS, cmsConfig::get('upload_root') . 'opengraph/'), 'success');

        return $this->redirectToAction('img_presets');
    }

}
