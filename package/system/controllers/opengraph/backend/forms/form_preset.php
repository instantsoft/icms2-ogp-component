<?php

class formOpengraphPreset extends cmsForm {

    const FONTS_DIR = 'system/controllers/opengraph/libs/og/Theme/Fonts';
    const LAYOUTS_DIR = 'system/controllers/opengraph/libs/og/Layout/Layouts';

    public function init($do) {

        return [
            'basic' => [
                'title'  => LANG_BASIC_OPTIONS,
                'type'   => 'fieldset',
                'childs' => [
                    new fieldString('title', [
                        'title' => LANG_OPENGRAPH_PRESETS_NAME,
                        'rules' => [
                            ['required'],
                            ['max_length', 155]
                        ]
                    ]),
                    new fieldList('options:format', [
                        'title' => LANG_OG_OPT_FORMAT,
                        'default' => 'webp',
                        'items' => [
                            'png'  => 'PNG',
                            'webp' => 'WEBP',
                            'jpg'  => 'JPG'
                        ]
                    ]),
                    new fieldNumber('options:quality', [
                        'title'   => LANG_OG_OPT_QUALITY,
                        'units'   => '%',
                        'default' => '87',
                        'rules'   => [
                            ['required'],
                            ['digits'],
                            ['min', 1],
                            ['max', 100]
                        ]
                    ]),
                    new fieldList('options:layout', [
                        'title' => LANG_OG_OPT_LAYOUT,
                        'hint'  => sprintf(LANG_OPENGRAPH_FILE_LIST_HINT, self::LAYOUTS_DIR),
                        'default' => 'icms',
                        'generator' => function ($item) {

                            $files = cmsCore::getFilesList(self::LAYOUTS_DIR, '*.php', true);

                            return array_combine($files, $files);
                        }
                    ])
                ]
            ],
            'options' => [
                'title'  => LANG_OPTIONS,
                'type'   => 'fieldset',
                'childs' => [
                    new fieldList('options:font', [
                        'title' => LANG_OG_OPT_FONT,
                        'hint'  => sprintf(LANG_OPENGRAPH_FILE_LIST_HINT, self::FONTS_DIR),
                        'default' => 'Inter',
                        'generator' => function ($item) {

                            $files = cmsCore::getFilesList(self::FONTS_DIR, '*.php', true);

                            return array_combine($files, $files);
                        }
                    ]),
                    new fieldColor('options:base_color', [
                        'title' => LANG_OG_OPT_BASE_COLOR,
                        'rules' => [
                            ['required']
                        ]
                    ]),
                    new fieldColor('options:accent_color', [
                        'title' => LANG_OG_OPT_ACCENT_COLOR,
                        'hint'  => LANG_OG_OPT_ACCENT_COLOR_HINT,
                        'rules' => [
                            ['required']
                        ]
                    ]),
                    new fieldColor('options:background_color', [
                        'title' => LANG_OG_OPT_BG_COLOR,
                        'rules' => [
                            ['required']
                        ]
                    ]),
                    new fieldColor('options:title_color', [
                        'title' => LANG_OG_OPT_TITLE_COLOR
                    ]),
                    new fieldCheckbox('options:show_desc', [
                        'title' => LANG_OG_OPT_SHOW_DESC,
                        'default' => true
                    ]),
                    new fieldColor('options:description_color', [
                        'title' => LANG_OG_OPT_DESCRIPTION_COLOR,
                        'visible_depend' => ['options:show_desc' => ['show' => ['1']]]
                    ]),
                    new fieldCheckbox('options:show_cat', [
                        'title' => LANG_OG_OPT_SHOW_CAT,
                        'default' => true
                    ]),
                    new fieldList('options:cat_pos', [
                        'title' => LANG_OG_OPT_CAT_POS,
                        'items' => [
                            'bottom-left'   => LANG_OG_OPT_BL,
                            'bottom-right'  => LANG_OG_OPT_BR,
                            'middle-bottom' => LANG_OG_OPT_MB,
                            'middle-left'   => LANG_OG_OPT_ML,
                            'middle-right'  => LANG_OG_OPT_MR,
                            'middle-top'    => LANG_OG_OPT_MT,
                            'top-left'      => LANG_OG_OPT_TL,
                            'top-right'     => LANG_OG_OPT_TR
                        ],
                        'visible_depend' => ['options:show_info_text' => ['show' => ['1']]]
                    ]),
                    new fieldColor('options:cat_color', [
                        'title' => LANG_OG_OPT_CAT_COLOR,
                        'visible_depend' => ['options:show_cat' => ['show' => ['1']]]
                    ]),
                    new fieldImage('options:background_img', [
                        'title' => LANG_OG_OPT_BG_IMG,
                        'options' => [
                            'sizes' => ['small', 'original']
                        ]
                    ]),
                    new fieldList('options:background_img_type', [
                        'title' => LANG_OG_OPT_BG_IMG_TYPE,
                        'items' => [
                            'repeat' => LANG_OG_OPT_BG_IMG_TYPE_R,
                            'cover' => LANG_OG_OPT_BG_IMG_TYPE_C
                        ]
                    ]),
                    new fieldNumber('options:background_img_opacity', [
                        'title' => LANG_OG_OPT_BG_IMG_OPACITY,
                        'default' => 0.5,
                        'options' => [
                            'is_abs' => true,
                            'decimal_int' => 1,
                            'decimal_s' => 1
                        ]
                    ]),
                    new fieldList('options:border_pos', [
                        'title' => LANG_OG_OPT_BORDER_POS,
                        'items' => [
                            'none'   => LANG_NO,
                            'all'    => LANG_OG_OPT_BORDER_POS_ALL,
                            'bottom' => LANG_OG_OPT_BORDER_POS_B,
                            'left'   => LANG_OG_OPT_BORDER_POS_L,
                            'right'  => LANG_OG_OPT_BORDER_POS_R,
                            'top'    => LANG_OG_OPT_BORDER_POS_T,
                            'x'      => 'X',
                            'y'      => 'Y'
                        ]
                    ]),
                    new fieldNumber('options:border_width', [
                        'title' => LANG_OG_OPT_BORDER_WIDTH,
                        'options' => [
                            'is_abs' => true,
                            'is_ceil' => true,
                            'units' => 'px'
                        ],
                        'visible_depend' => ['options:border_pos' => ['hide' => ['none']]]
                    ]),
                    new fieldColor('options:border_color', [
                        'title' => LANG_OG_OPT_BORDER_COLOR,
                        'visible_depend' => ['options:border_pos' => ['hide' => ['none']]]
                    ]),
                    new fieldImage('options:watermark', [
                        'title' => LANG_OG_OPT_WATERMARK,
                        'options' => [
                            'sizes' => ['small', 'original']
                        ]
                    ]),
                    new fieldList('options:watermark_pos', [
                        'title' => LANG_OG_OPT_WATERMARK_POS,
                        'items' => [
                            'bottom-left'   => LANG_OG_OPT_BL,
                            'bottom-right'  => LANG_OG_OPT_BR,
                            'center'        => LANG_OG_OPT_CENTER,
                            'middle-bottom' => LANG_OG_OPT_MB,
                            'middle-left'   => LANG_OG_OPT_ML,
                            'middle-right'  => LANG_OG_OPT_MR,
                            'middle-top'    => LANG_OG_OPT_MT,
                            'top-left'      => LANG_OG_OPT_TL,
                            'top-right'     => LANG_OG_OPT_TR
                        ]
                    ]),
                    new fieldCheckbox('options:show_info_text', [
                        'title' => LANG_OG_OPT_SHOW_INFO_TEXT
                    ]),
                    new fieldString('options:info_text', [
                        'title' => LANG_OG_OPT_INFO_TEXT,
                        'options' => [
                            ['max_length', 70]
                        ],
                        'visible_depend' => ['options:show_info_text' => ['show' => ['1']]]
                    ]),
                    new fieldList('options:info_text_pos', [
                        'title' => LANG_OG_OPT_INFO_TEXT_POS,
                        'items' => [
                            'bottom-left'   => LANG_OG_OPT_BL,
                            'bottom-right'  => LANG_OG_OPT_BR,
                            'middle-bottom' => LANG_OG_OPT_MB,
                            'middle-left'   => LANG_OG_OPT_ML,
                            'middle-right'  => LANG_OG_OPT_MR,
                            'middle-top'    => LANG_OG_OPT_MT,
                            'top-left'      => LANG_OG_OPT_TL,
                            'top-right'     => LANG_OG_OPT_TR
                        ],
                        'visible_depend' => ['options:show_info_text' => ['show' => ['1']]]
                    ]),
                    new fieldColor('options:info_text_color', [
                        'title' => LANG_OG_OPT_INFO_TEXT_COLOR,
                        'visible_depend' => ['options:show_info_text' => ['show' => ['1']]]
                    ])
                ]
            ]
        ];
    }
}
