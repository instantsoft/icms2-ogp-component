<?php
/******************************************************************************/
//                                                                            //
//                             InstantMedia 2015                              //
//	 		  http://www.instantvideo.ru/, support@instantvideo.ru            //
//                               written by Fuze                              //
//                                                                            //
/******************************************************************************/
class onOpengraphCtypeBasicForm extends cmsAction {

    public function run($form){

        $core = cmsCore::getInstance();

        // проверяем разрешенные типы контента
        if($core->uri_params[0] != 'edit'){
            return $form;
        }

        $content_model = cmsCore::getModel('content');
        $ctype = $content_model->getContentType($core->uri_params[1]);

        if(empty($this->options['enabled_ctypes'])){
            return $form;
        }

        if(!in_array($ctype['name'], $this->options['enabled_ctypes'])){
            return $form;
        }

        $form->addFieldset('Open Graph', 'og');

        $form->addFieldToBeginning('og', new fieldList('options:og_type', array(
            'title' => LANG_OPENGRAPH_TYPE,
            'default' => 'website',
            'items' => array(
                'other'=>array(
                    LANG_OPENGRAPH_TYPE_OTHER
                ),
                'article' => LANG_OPENGRAPH_TYPE_ARTICLES,
                'book'    => LANG_OPENGRAPH_TYPE_BOOK,
                'website' => LANG_OPENGRAPH_TYPE_BASE,
                'music'=>array(
                    LANG_OPENGRAPH_TYPE_MUSIC
                ),
                'music.song' => LANG_OPENGRAPH_TYPE_MUSICTRACK,
                'music.album' => LANG_OPENGRAPH_TYPE_MUSIC_ALBUM,
                'music.playlist' => LANG_OPENGRAPH_TYPE_MUSIC_PLAYLIST,
                'music.radio_station' => LANG_OPENGRAPH_TYPE_RADIO,
                'video'=>array(
                    LANG_OPENGRAPH_TYPE_VIDEO
                ),
                'video.other' => LANG_OPENGRAPH_TYPE_OTHER,
                'video.movie' => LANG_OPENGRAPH_TYPE_FILM,
                'video.episode' => LANG_OPENGRAPH_TYPE_SERIAL,
                'video.tv_show' => LANG_OPENGRAPH_TYPE_SHOW,
                'ya:ovs:broadcast' => LANG_OPENGRAPH_TYPE_LIVE,
                'ya:ovs:music' => LANG_OPENGRAPH_TYPE_MUSIC_VIDEO,
            )
        )));

        $fields = $content_model->getContentFields($ctype['name']);
        $presets = cmsCore::getModel('images')->getPresetsList();

        // подключаем таким образом инлайн скрипт, чтобы переопределить нужное
		$script_bottom = cmsTemplate::getInstance()->renderInternal($this, 'og_html_form', array(
            'fields'=>$fields, 'ctype'=>$ctype, 'presets'=>$presets
        ));

		$form->addHtmlBlock('og_image', $script_bottom);

        return $form;

    }

}
