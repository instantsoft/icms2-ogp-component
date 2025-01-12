<?php

class onOpengraphProcessRenderContentItemView extends cmsAction {

    public function run($data) {

        list($template_path, $params, $request) = $data;

        $ctype = $params['ctype'];
        $item  = $params['item'];

        if (empty($ctype['options']['is_og_enable'])) {
            return $data;
        }

        // формируем изображения
        $image_urls = [];

        if ($ctype['options']['og_display_image_type'] === 'item') {

            if (!empty($ctype['options']['og_images'])) {
                foreach ($ctype['options']['og_images'] as $image_field) {

                    if (empty($item[$image_field['field']])) {
                        continue;
                    }

                    $images = cmsModel::yamlToArray($item[$image_field['field']]);

                    // берем первое поле
                    $image = reset($images);

                    if (is_array($image)) {
                        foreach ($images as $image) {
                            $image_urls[] = $image[$image_field['preset']];
                        }
                    } else {
                        $image_urls[] = $images[$image_field['preset']];
                    }
                }
            } elseif(!empty($ctype['options']['og_default_image'])) {
                $image_urls[] = $ctype['options']['og_default_image'][$this->options['default_image_preset']];
            }

        } else {

            $this->setGenPresetId($ctype['options']['og_gen_preset_id'] ?? 0);

            $this->setGenCategory($item['category']['title'] ?? $ctype['title']);

            $this->setGenContext([
                'tc' => 'content',
                'ts' => $ctype['name'],
                'ti' => $item['id']
            ]);
        }

        $this->setBasicOpenGraph(
            $ctype['options']['og_type'],
            !empty($ctype['options']['og_item_title_pattern']) ? $ctype['options']['og_item_title_pattern'] : $params['item_seo']['title_str'],
            !empty($ctype['options']['og_item_desc_pattern']) ? $ctype['options']['og_item_desc_pattern'] : $params['item_seo']['desc_str'],
            href_to_abs($ctype['name'], $item['slug'] . '.html'),
            $image_urls
        );

        // дополнительные поля
        if (!empty($ctype['options']['other_field'])) {

            foreach ($ctype['options']['other_field'] as $key => $other_field) {

                $content = $ctype['options']['const_field'][$key] ?? '';

                if (strpos($content, '{host}') !== false) {
                    $content = str_replace('{host}', $this->cms_config->host . $this->cms_config->root, $content);
                }

                $matches = [];

                if (preg_match('/^{(date_[a-z_]+)}$/', $content, $matches)) {

                    if (empty($item[$matches[1]])) {
                        continue;
                    }

                    $content = date('c', strtotime($item[$matches[1]]));
                }

                $this->setMetaTag($other_field, $this->prepareMetaTagContent($content, 'title_item'));
            }
        }

        if ($ctype['options']['og_type'] === 'article') {

            $this->setMetaTag('article:published_time', date('c', strtotime($item['date_pub'])))->
                   setMetaTag('article:modified_time', date('c', strtotime($item['date_last_modified'])));

            if (!empty($item['date_pub_end'])) {
                $this->setMetaTag('article:expiration_time', date('c', strtotime($item['date_pub_end'])));
            }

            if (!empty($item['category']['title'])) {
                $this->setMetaTag('article:section', $item['category']['title']);
            }

            if (!empty($item['tags'])) {
                $this->setMetaTag('article:tag', (is_array($item['tags']) ? implode(', ', $item['tags']) : $item['tags']));
            }
        }

        return $data;
    }

}
