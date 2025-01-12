<?php

class formOpengraphOptions extends cmsForm {

    use icms\controllers\opengraph\ogtypes;

    public function init() {

        $presets = cmsCore::getModel('images')->getPresetsList();

        return [
            [
                'type'   => 'fieldset',
                'childs' => [
                    new fieldString('html_attr_value', [
                        'title' => LANG_OPENGRAPH_HTML_ATTR_VALUE,
                        'default' => 'og: http://ogp.me/ns# video: http://ogp.me/ns/video# ya: http://webmaster.yandex.ru/vocabularies/ article: http://ogp.me/ns/article#  profile: http://ogp.me/ns/profile#'
                    ]),
                    new fieldList('og_type_default', [
                        'title'   => LANG_OPENGRAPH_TYPE_DEFAULT,
                        'default' => 'website',
                        'items'   => $this->getOgTypes()
                    ]),
                    new fieldCheckbox('print_img_params', [
                        'title' => LANG_OPENGRAPH_PRINT_IMG_PARAMS
                    ]),
                    new fieldList('display_image_type', [
                        'title' => LANG_OPENGRAPH_IMG_TYPE,
                        'items' => [
                            'gen' => LANG_OPENGRAPH_IMG_TYPE0,
                            'item' => LANG_OPENGRAPH_IMG_TYPE1
                        ],
                        'default' => 'item'
                    ]),
                    new fieldList('default_gen_preset_id', [
                        'title' => LANG_OPENGRAPH_IMG_DEF_PRESET,
                        'default' => 1,
                        'generator' => function () {

                            $items = [];

                            $p = (new cmsModel())->get('og_img_presets') ?: [];

                            foreach ($p as $i) {
                                $items[$i['id']] = $i['title'];
                            }

                            return $items;
                        },
                        'default' => 1,
                        'visible_depend' => ['display_image_type' => ['show' => ['gen']]]
                    ]),
                    new fieldNumber('max_image_count', [
                        'title' => LANG_OPENGRAPH_MAX_IMAGE_COUNT,
                        'default' => 0,
                        'visible_depend' => ['display_image_type' => ['show' => ['item']]]
                    ]),
                    new fieldImage('default_image', [
                        'title' => LANG_OPENGRAPH_DEFAULT_IMAGE,
                        'hint'  => LANG_OPENGRAPH_DEFAULT_IMAGE_HINT,
                        'visible_depend' => ['display_image_type' => ['show' => ['item']]]
                    ]),
                    new fieldList('default_image_preset', [
                        'title' => LANG_OPENGRAPH_DEFAULT_IMAGE_PRESET,
                        'items' => $presets,
                        'default' => 'big',
                        'visible_depend' => ['display_image_type' => ['show' => ['item']]]
                    ]),
                    new fieldText('url_mask_not', [
                        'title' => LANG_OPENGRAPH_URL_MASK_NOT,
                        'hint' => LANG_OPENGRAPH_URL_MASK_NOT_HINT,
                        'default' => "admin*\npages/add\npages/edit/*\nusers/{slug}/edit"
                    ]),
                    new fieldCheckbox('cut_sitename_from_title', [
                        'title' => LANG_OPENGRAPH_CUT_STITLE
                    ])
                ]
            ]
        ];
    }

}
