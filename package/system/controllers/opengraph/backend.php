<?php
/******************************************************************************/
//                                                                            //
//                             InstantMedia 2015                              //
//	 		  http://www.instantvideo.ru/, support@instantvideo.ru            //
//                               written by Fuze                              //
//                                                                            //
/******************************************************************************/
class backendOpengraph extends cmsBackend{

    public $useDefaultOptionsAction = true;

    public function actionIndex(){
        $this->redirectToAction('options');
    }

}
