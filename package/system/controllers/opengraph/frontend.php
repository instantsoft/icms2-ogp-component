<?php
/******************************************************************************/
//                                                                            //
//                             InstantMedia 2015                              //
//	 		  http://www.instantvideo.ru/, support@instantvideo.ru            //
//                               written by Fuze                              //
//                                                                            //
/******************************************************************************/
class opengraph extends cmsFrontend {

    protected $useOptions = true;

    public $protocol = 'http://';

    public function __construct($request) {

        parent::__construct($request);

        if(
                (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
                (!empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443) ||
                (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
            ){
            $this->protocol = 'https://';
        }

    }

    /**
     * Устанавливает обязательные теги opengraph
     * @param array $param Массив: title, description, type, url, image_urls
     * @return \cmsTemplate
     */
    public function setBasicOpenGraph($param) {

        $cfg      = cmsConfig::getInstance();
        $template = cmsTemplate::getInstance();

        $template->addHead('<meta property="og:title" content="'.htmlspecialchars($param['title']).'"/>');
        $template->addHead('<meta property="og:type" content="'.htmlspecialchars($param['type']).'" />');
        $template->addHead('<meta property="og:url" content="'.$this->protocol.$_SERVER['HTTP_HOST'].$param['url'].'" />');
        $template->addHead('<meta property="og:site_name" content="'.htmlspecialchars(cmsConfig::get('sitename')).'"/>');
        if(!empty($param['description'])){
            $template->addHead('<meta property="og:description" content="'.htmlspecialchars($param['description']).'"/>');
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

                $img_size = @getimagesize($cfg->upload_path.$image_url);
                $is_https_image_host = strpos($cfg->upload_host_abs, 'https') !== false;

                if($img_size){

                    $template->addHead('<meta property="og:image" content="'.($is_https_image_host ? str_replace('https', 'http', $cfg->upload_host_abs) : $cfg->upload_host_abs).'/'.$image_url.'"/>');
                    if($this->options['is_https_available']){
                        $template->addHead('<meta property="og:image:secure_url" content="'.($is_https_image_host ? $cfg->upload_host_abs : str_replace('http', 'https', $cfg->upload_host_abs)).'/'.$image_url.'"/>');
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