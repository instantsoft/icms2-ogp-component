<?php
/******************************************************************************/
//                                                                            //
//                             InstantMedia 2015                              //
//	 		  http://www.instantvideo.ru/, support@instantvideo.ru            //
//                               written by Fuze                              //
//                                                                            //
/******************************************************************************/
class onOpengraphContentBeforeItem extends cmsAction {

    public function run($data){

        list($ctype, $item, $fields) = $data;

        if(empty($this->options['enabled_ctypes'])){
            return $data;
        }

        if(!in_array($ctype['name'], $this->options['enabled_ctypes'])){
            return $data;
        }

        if(empty($ctype['options']['og_type'])){
            return $data;
        }

        // формируем изображения
        $image_urls = array();
        if(!empty($ctype['options']['image_fields'])){
            foreach ($ctype['options']['image_fields'] as $key=>$image_field) {
                if(empty($item[$image_field])){
                    continue;
                }
                $preset = isset($ctype['options']['image_preset'][$key]) ? $ctype['options']['image_preset'][$key] : 'small';
                $images = cmsModel::yamlToArray($item[$image_field]);
                // берем первое поле
                $image = reset($images);
                if(is_array($image)){
                    foreach ($images as $image) {
                        $image_urls[] = $image[$preset];
                    }
                } else {
                    $image_urls[] = $images[$preset];
                }
            }
        }

        // пробелы и переносы нам не нужны
        $item['seo_desc'] = preg_replace('!\s+!', ' ', $item['seo_desc']);

        $template = $this->setBasicOpenGraph(array(
            'title'=>$item['title'],
            'description'=>($item['seo_desc'] ? $item['seo_desc'] : $item['title']),
            'type'=>$ctype['options']['og_type'],
            'url'=>href_to($ctype['name'], $item['slug'].'.html'),
            'image_urls'=>$image_urls
        ));

        // дополнительные поля
        if(!empty($ctype['options']['other_field'])){

            foreach ($ctype['options']['other_field'] as $key=>$other_field) {

                if(!empty($ctype['options']['const_field'][$key])){
                    $fcontent = string_replace_keys_values($ctype['options']['const_field'][$key], $item);
                    if(strpos($fcontent, '{host}') !== false){
                        $fcontent = str_replace('{host}', $this->protocol.$_SERVER['HTTP_HOST'].cmsConfig::get('root'), $fcontent);
                    }
                } else {

                    $fcontent = $item[$ctype['options']['other_field_name'][$key]];
                    if(strpos($ctype['options']['other_field_name'][$key], 'date_') !== false){
                        $fcontent = date('c', strtotime($item['date_pub']));
                    }
                    if(!empty($ctype['options']['other_field_func'][$key]) && function_exists($ctype['options']['other_field_func'][$key])){
                        $fcontent = $ctype['options']['other_field_func'][$key]($fcontent);
                    }

                }

                $template->addHead('<meta property="'.htmlspecialchars($other_field).'" content="'.htmlspecialchars($fcontent).'"/>');

            }

        }

        if($ctype['options']['og_type'] == 'article'){
            $template->addHead('<meta property="article:published_time" content="'.date('c', strtotime($item['date_pub'])).'"/>');
            $template->addHead('<meta property="article:modified_time" content="'.date('c', strtotime($item['date_last_modified'])).'"/>');
            if(!empty($item['date_pub_end'])){
                $template->addHead('<meta property="article:expiration_time" content="'.date('c', strtotime($item['date_pub_end'])).'"/>');
            }
            if(!empty($item['category']['title'])){
                $template->addHead('<meta property="article:section" content="'.htmlspecialchars($item['category']['title']).'"/>');
            }
            if(!empty($item['tags'])){
                $template->addHead('<meta property="article:tag" content="'.htmlspecialchars(is_array($item['tags']) ? implode(', ', $item['tags']) : $item['tags']).'"/>');
            }
        }

        return array($ctype, $item, $fields);

    }

}
