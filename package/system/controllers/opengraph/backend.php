<?php
/******************************************************************************/
//                                                                            //
//                               InstantMedia                                 //
//	 		      http://instantvideo.ru/, support@instantvideo.ru            //
//                               written by Fuze                              //
//                     https://instantvideo.ru/copyright.html                 //
//                                                                            //
/******************************************************************************/
class backendOpengraph extends cmsBackend{

    public $useDefaultOptionsAction = true;
    protected $useOptions = true;

    public function actionIndex(){
        $this->redirectToAction('options');
    }

}
