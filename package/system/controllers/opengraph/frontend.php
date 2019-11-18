<?php
/******************************************************************************/
//                                                                            //
//                               InstantMedia                                 //
//	 		      http://instantvideo.ru/, support@instantvideo.ru            //
//                               written by Fuze                              //
//                     https://instantvideo.ru/copyright.html                 //
//                                                                            //
/******************************************************************************/

class opengraph extends cmsFrontend {

    protected $useOptions = true;

    /**
     * Устанавливает обязательные теги opengraph
     * @param array $param Массив: title, description, type, url, image_urls
     * @return \cmsTemplate
     */
    public function setBasicOpenGraph($param) {

        $template = cmsTemplate::getInstance();

        $template->addHead('<meta property="og:title" content="'.html((!empty($template->title_item) ? string_replace_keys_values_extended($param['title'], $template->title_item) : $param['title']), false).'"/>');
        $template->addHead('<meta property="og:type" content="'.html($param['type'], false).'" />');
        $template->addHead('<meta property="og:url" content="'.$this->cms_config->host.$param['url'].'" />');
        $template->addHead('<meta property="og:site_name" content="'.html($this->cms_config->sitename, false).'"/>');
        if(!empty($param['description'])){

            $param['description'] = !empty($template->metadesc_item) ? string_replace_keys_values_extended($param['description'], $template->metadesc_item) : $param['description'];
            $param['description'] = preg_replace('!\s+!', ' ', $param['description']);

            $template->addHead('<meta property="og:description" content="'.html($param['description'], false).'"/>');

        }

        // если сюда картинка не дошла, ставим картинку по умолчанию
        if(empty($param['image_urls'])){
            if($this->options['default_image']){
                $param['image_urls'] = array($this->options['default_image']['original']);
            }
        } else {
            if(!is_array($param['image_urls'])){
                $param['image_urls'] = array($param['image_urls']);
            }
        }

        if(!empty($param['image_urls'])){

            if(!empty($this->options['max_image_count']) && count($param['image_urls']) > $this->options['max_image_count']){
                $param['image_urls'] = array_slice($param['image_urls'], 0, $this->options['max_image_count']);
            }

            foreach ($param['image_urls'] as $image_url) {

                // передали полный путь к картинке
                if(strpos($image_url, '://') !== false){
                    $template->addHead('<meta property="og:image" content="'.$image_url.'"/>');
                    continue;
                }

                $img_size = @getimagesize($this->cms_config->upload_path.$image_url);
				$is_https_image_host = strpos($this->cms_config->upload_host_abs, 'https') !== false;

                if($img_size !== false){

                    $template->addHead('<meta property="og:image" content="'.$this->cms_config->upload_host_abs.'/'.$image_url.'"/>');

                    if($this->options['is_https_available']){
                        $this->cms_template->addHead('<meta property="og:image:secure_url" content="' . ($is_https_image_host ? $this->cms_config->upload_host_abs : str_replace('http', 'https', $this->cms_config->upload_host_abs)) . '/' . $image_url . '"/>');
                    }

                    $template->addHead('<meta property="og:image:type" content="'.$img_size['mime'].'"/>', false);
                    $template->addHead('<meta property="og:image:height" content="'.$img_size[1].'"/>', false);
                    $template->addHead('<meta property="og:image:width" content="'.$img_size[0].'"/>', false);

                }

            }
        }


        return $template;

    }

}
