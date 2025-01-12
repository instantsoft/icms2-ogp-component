<?php

class onOpengraphProcessRenderContentCategoryView extends cmsAction {

    public function run($data) {

        list($template_path, $params, $request) = $data;

        // На главной не нужно
        if (!empty($params['is_frontpage'])) {
            return $data;
        }

        // урл только 2.17.0
        if (empty($params['page_url'])) {
            return $data;
        }

        $ctype    = $params['ctype'];
        $seo      = $params['category_seo'];
        $cat      = $params['category'];
        $page_url = $params['page_url'];

        if (empty($ctype['options']['is_og_enable'])) {
            return $data;
        }

        // формируем изображения
        $image_urls = [];

        if ($ctype['options']['og_display_image_type'] === 'item') {

            if (!empty($cat['cover'])) {

                $images = cmsModel::yamlToArray($cat['cover']);

                $image = reset($images);

                if (!empty($ctype['options']['og_list_preset']) && !empty($images[$ctype['options']['og_list_preset']])) {
                    $image = $images[$ctype['options']['og_list_preset']];
                }

                $image_urls[] = $image;

            } elseif(!empty($ctype['options']['og_default_image'])) {
                $image_urls[] = $ctype['options']['og_default_image'][$this->options['default_image_preset']];
            }

        } else {

            $this->setGenCategory($ctype['title']);

            $this->setGenPresetId($ctype['options']['og_gen_preset_id'] ?? 0);

            $this->setGenContext([
                'tc' => 'content',
                'ts' => $ctype['name'],
                'ti' => 0
            ]);
        }

        $this->setBasicOpenGraph(
            $ctype['options']['og_type_list'],
            !empty($ctype['options']['og_list_title_pattern']) ? $ctype['options']['og_list_title_pattern'] : ($seo['title_str'] ?? ''),
            !empty($ctype['options']['og_list_desc_pattern']) ? $ctype['options']['og_list_desc_pattern'] : ($seo['desc_str'] ?? ''),
            $this->cms_config->host . (is_array($page_url) ? $page_url['base'] : $page_url),
            $image_urls
        );

        return $data;
    }

}
