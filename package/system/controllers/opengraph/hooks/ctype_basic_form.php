<?php
/******************************************************************************/
//                                                                            //
//                               InstantMedia                                 //
//	 		      http://instantvideo.ru/, support@instantvideo.ru            //
//                               written by Fuze                              //
//                     https://instantvideo.ru/copyright.html                 //
//                                                                            //
/******************************************************************************/

class onOpengraphCtypeBasicForm extends cmsAction {

    public function run($form){

        if(empty($this->options['enabled_ctypes'])){
            return $form;
        }

        list($action, $ctype) = $form->getParams();

        if($action !== 'edit'){
            return $form;
        }

        if(!$ctype){
            return $form;
        }

        if(!in_array($ctype['name'], $this->options['enabled_ctypes'])){
            return $form;
        }

        $fs_id = $form->addFieldset('Open Graph', 'og', ['is_collapsed' => true]);

        $form->addField($fs_id, new fieldList('options:og_type', array(
            'title' => LANG_OPENGRAPH_TYPE,
            'default' => 'website',
            'items' => array(
                'other' => array(
                    LANG_OPENGRAPH_TYPE_OTHER
                ),
                'article' => LANG_OPENGRAPH_TYPE_ARTICLES,
                'book'    => LANG_OPENGRAPH_TYPE_BOOK,
                'website' => LANG_OPENGRAPH_TYPE_BASE,
                'music'   => array(
                    LANG_OPENGRAPH_TYPE_MUSIC
                ),
                'music.song'          => LANG_OPENGRAPH_TYPE_MUSICTRACK,
                'music.album'         => LANG_OPENGRAPH_TYPE_MUSIC_ALBUM,
                'music.playlist'      => LANG_OPENGRAPH_TYPE_MUSIC_PLAYLIST,
                'music.radio_station' => LANG_OPENGRAPH_TYPE_RADIO,
                'video' => array(
                    LANG_OPENGRAPH_TYPE_VIDEO
                ),
                'video.other'      => LANG_OPENGRAPH_TYPE_OTHER,
                'video.movie'      => LANG_OPENGRAPH_TYPE_FILM,
                'video.episode'    => LANG_OPENGRAPH_TYPE_SERIAL,
                'video.tv_show'    => LANG_OPENGRAPH_TYPE_SHOW,
                'ya:ovs:broadcast' => LANG_OPENGRAPH_TYPE_LIVE,
                'ya:ovs:music'     => LANG_OPENGRAPH_TYPE_MUSIC_VIDEO
            )
        )));

        $fields = $this->model_content->getContentFields($ctype['name']);
        $presets = cmsCore::getModel('images')->getPresetsList();

        $form->addField($fs_id, new fieldList('options:og_images', array(
            'title'        => LANG_OPENGRAPH_IMAGE_FIELDS,
            'add_title'    => LANG_OPENGRAPH_ADD_FIELD,
            'is_multiple'  => true,
            'dynamic_list' => true,
            'select_title' => LANG_OPENGRAPH_IMAGE_FIELD,
            'multiple_keys' => array(
                'field' => 'field', 'preset' => 'field_select'
            ),
            'generator' => function() use($fields){

                $items = [];

                if($fields){
                    foreach($fields as $field){
                        $items[$field['name']] = $field['title'];
                    }
                }

                return $items;
            },
            'value_items' => $presets
        )));


        // подключаем таким образом инлайн скрипт, чтобы переопределить нужное
		$script_bottom = $this->cms_template->renderInternal($this, 'og_html_form', array(
            'fields' => $fields, 'ctype' => $ctype
        ));

		$form->addHtmlBlock('og_image', $script_bottom);

        return $form;

    }

}
