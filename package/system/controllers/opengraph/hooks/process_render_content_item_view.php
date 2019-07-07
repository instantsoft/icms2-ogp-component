<?php
/******************************************************************************/
//                                                                            //
//                               InstantMedia                                 //
//	 		      http://instantvideo.ru/, support@instantvideo.ru            //
//                               written by Fuze                              //
//                     https://instantvideo.ru/copyright.html                 //
//                                                                            //
/******************************************************************************/
class onOpengraphProcessRenderContentItemView extends cmsAction {

    public function run($data){

        list($template_path, $params, $request) = $data;

        $ctype = $params['ctype'];
        $item  = $params['item'];

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
        $image_urls = [];
        if(!empty($ctype['options']['og_images'])){
            foreach ($ctype['options']['og_images'] as $image_field) {

                if(empty($item[$image_field['field']])){
                    continue;
                }

                $images = cmsModel::yamlToArray($item[$image_field['field']]);

                // берем первое поле
                $image = reset($images);

                if(is_array($image)){
                    foreach ($images as $image) {
                        $image_urls[] = $image[$image_field['preset']];
                    }
                } else {
                    $image_urls[] = $images[$image_field['preset']];
                }

            }
        }

        $template = $this->setBasicOpenGraph(array(
            'title'       => $params['item_seo']['title_str'],
            'description' => $params['item_seo']['desc_str'],
            'type'        => $ctype['options']['og_type'],
            'url'         => href_to($ctype['name'], $item['slug'] . '.html'),
            'image_urls'  => $image_urls
        ));

        // дополнительные поля
        if(!empty($ctype['options']['other_field'])){

            foreach ($ctype['options']['other_field'] as $key => $other_field) {

                if(!empty($ctype['options']['const_field'][$key])){
                    $fcontent = string_replace_keys_values($ctype['options']['const_field'][$key], $item);
                    if(strpos($fcontent, '{host}') !== false){
                        $fcontent = str_replace('{host}', $this->cms_config->host.$this->cms_config->root, $fcontent);
                    }
                } else {

                    if(strpos($ctype['options']['other_field_name'][$key], 'date_') !== false){
                        $item[$ctype['options']['other_field_name'][$key]] = date('c', strtotime($item[$ctype['options']['other_field_name'][$key]]));
                    }

                    $fcontent = $item[$ctype['options']['other_field_name'][$key]];

                    if(!empty($ctype['options']['other_field_func'][$key]) && function_exists($ctype['options']['other_field_func'][$key])){
                        $fcontent = $ctype['options']['other_field_func'][$key]($fcontent);
                    }

                }

                $template->addHead('<meta property="'.html($other_field, false).'" content="'.html($fcontent, false).'"/>');

            }

        }

        if($ctype['options']['og_type'] == 'article'){
            $template->addHead('<meta property="article:published_time" content="'.date('c', strtotime($item['date_pub'])).'"/>');
            $template->addHead('<meta property="article:modified_time" content="'.date('c', strtotime($item['date_last_modified'])).'"/>');
            if(!empty($item['date_pub_end'])){
                $template->addHead('<meta property="article:expiration_time" content="'.date('c', strtotime($item['date_pub_end'])).'"/>');
            }
            if(!empty($item['category']['title'])){
                $template->addHead('<meta property="article:section" content="'.html($item['category']['title'], false).'"/>');
            }
            if(!empty($item['tags'])){
                $template->addHead('<meta property="article:tag" content="'.html((is_array($item['tags']) ? implode(', ', $item['tags']) : $item['tags']), false).'"/>');
            }
        }

        return $data;

    }

}
