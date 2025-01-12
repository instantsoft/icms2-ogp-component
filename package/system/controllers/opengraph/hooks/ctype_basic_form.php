<?php

class onOpengraphCtypeBasicForm extends cmsAction {

    use icms\controllers\opengraph\ogtypes;

    public function run(cmsForm $form){

        list($action, $ctype) = $form->getParams();

        if($action !== 'edit'){
            return $form;
        }

        if(!$ctype){
            return $form;
        }

        $list_fields = [
            'title'             => LANG_TITLE,
            'description'       => LANG_DESCRIPTION,
            'ctype_title'       => LANG_CONTENT_TYPE . ': ' . LANG_TITLE,
            'ctype_description' => LANG_CONTENT_TYPE . ': ' . LANG_DESCRIPTION,
            'ctype_label1'      => LANG_CP_NUMERALS_1_LABEL,
            'ctype_label2'      => LANG_CP_NUMERALS_2_LABEL,
            'ctype_label10'     => LANG_CP_NUMERALS_10_LABEL,
            'filter_string'     => LANG_FILTERS,
            'page'              => LANG_PAGE
        ];

        $item_fields = [
            'category'   => LANG_CATEGORY,
            'hits_count' => LANG_HITS
        ];

        foreach (['comments', 'rating', 'tags'] as $fname) {
            if (cmsController::enabled($fname)) {
                $item_fields[$fname] = string_lang($fname);
            }
        }

        $fields = $this->model_content->getContentFields($ctype['name']);

        foreach ($fields as $field) {
            $item_fields[$field['name']] = $field['title'];
        }

        $og_types = $this->getOgTypes();

        $presets = $this->model_images->getPresetsList();

        $fs_id = $form->addFieldset('Open Graph', 'og', ['is_collapsed' => true]);

        $form->addField($fs_id, new fieldCheckbox('options:is_og_enable', [
            'title' => LANG_OPENGRAPH_ENABLE
        ]));

        $form->addField($fs_id, new fieldList('options:og_display_image_type', [
            'title' => LANG_OPENGRAPH_IMG_TYPE,
            'items' => [
                'gen' => LANG_OPENGRAPH_IMG_TYPE0,
                'item' => LANG_OPENGRAPH_IMG_TYPE1
            ],
            'default' => 'item',
            'visible_depend' => ['options:is_og_enable' => ['show' => ['1']]]
        ]));

        $form->addField($fs_id, new fieldList('options:og_gen_preset_id', [
            'title' => LANG_OPENGRAPH_IMG_DEF_PRESET,
            'generator' => function () {

                $items = [];

                $p = (new cmsModel())->get('og_img_presets') ?: [];

                foreach ($p as $i) {
                    $items[$i['id']] = $i['title'];
                }

                return $items;
            },
            'default' => 1,
            'visible_depend' => ['options:is_og_enable' => ['hide' => ['0']], 'options:og_display_image_type' => ['show' => ['gen']]]
        ]));

        $form->addField($fs_id, new fieldImage('options:og_default_image', [
            'title' => LANG_OPENGRAPH_DEFAULT_IMAGE,
            'visible_depend' => ['options:is_og_enable' => ['hide' => ['0']], 'options:og_display_image_type' => ['show' => ['item']]]
        ]));

        $form->addField($fs_id, new fieldList('options:og_list_preset', [
            'title' => LANG_OPENGRAPH_IMAGE_LIST_PRESET,
            'items' => $presets,
            'visible_depend' => ['options:is_og_enable' => ['hide' => ['0']], 'options:og_display_image_type' => ['show' => ['item']]]
        ]));

        $form->addField($fs_id, new fieldList('options:og_images', [
            'title'         => LANG_OPENGRAPH_IMAGE_FIELDS,
            'add_title'     => LANG_OPENGRAPH_ADD_FIELD,
            'is_multiple'   => true,
            'dynamic_list'  => true,
            'select_title'  => LANG_OPENGRAPH_IMAGE_FIELD,
            'multiple_keys' => [
                'field'  => 'field', 'preset' => 'field_select'
            ],
            'generator' => function () use ($fields) {

                $items = [];

                if ($fields) {
                    foreach ($fields as $field) {
                        $items[$field['name']] = $field['title'];
                    }
                }

                return $items;
            },
            'value_items' => $presets,
            'visible_depend' => ['options:is_og_enable' => ['hide' => ['0']], 'options:og_display_image_type' => ['show' => ['item']]]
        ]));

        $form->addField($fs_id, new fieldList('options:og_type_list', [
            'title'   => LANG_OPENGRAPH_TYPE_LIST,
            'default' => 'website',
            'items'   => $og_types,
            'visible_depend' => ['options:is_og_enable' => ['show' => ['1']]]
        ]));

        $form->addField($fs_id, new fieldString('options:og_list_title_pattern', [
            'title'   => LANG_OPENGRAPH_LIST_TITLE_PATTERN,
            'can_multilanguage' => true,
            'patterns_hint' => [
                'patterns' =>  $list_fields
            ],
            'visible_depend' => ['options:is_og_enable' => ['show' => ['1']]]
        ]));

        $form->addField($fs_id, new fieldString('options:og_list_desc_pattern', [
            'title'   => LANG_OPENGRAPH_LIST_DESC_PATTERN,
            'can_multilanguage' => true,
            'patterns_hint' => [
                'patterns' =>  $list_fields
            ],
            'visible_depend' => ['options:is_og_enable' => ['show' => ['1']]]
        ]));

        $form->addField($fs_id, new fieldList('options:og_type', [
            'title'   => LANG_OPENGRAPH_TYPE,
            'default' => 'website',
            'items'   => $og_types,
            'visible_depend' => ['options:is_og_enable' => ['show' => ['1']]]
        ]));

        $form->addField($fs_id, new fieldString('options:og_item_title_pattern', [
            'title'   => LANG_OPENGRAPH_ITEM_TITLE_PATTERN,
            'default' => '{title}',
            'can_multilanguage' => true,
            'patterns_hint' => [
                'patterns' =>  $item_fields
            ],
            'visible_depend' => ['options:is_og_enable' => ['show' => ['1']]]
        ]));

        $form->addField($fs_id, new fieldString('options:og_item_desc_pattern', [
            'title'   => LANG_OPENGRAPH_ITEM_DESC_PATTERN,
            'default' => '{content|string_get_meta_description}',
            'can_multilanguage' => true,
            'patterns_hint' => [
                'patterns' =>  $item_fields
            ],
            'visible_depend' => ['options:is_og_enable' => ['show' => ['1']]]
        ]));

        $og_markups = [];

        if (!empty($ctype['options']['other_field'])) {
            foreach ($ctype['options']['other_field'] as $key => $other_field) {
                $og_markups[] = [
                    'other_field' => $other_field,
                    'const_field' => $ctype['options']['const_field'][$key] ?? ''
                ];
            }
        }

        $form->addField($fs_id, new cmsFormField('options:og_markups', [
            'title' => LANG_OPENGRAPH_OTHER_FIELDS,
            'html' => $this->cms_template->renderInternal($this, 'og_html_form', [
                'ctype' => $ctype, 'og_markups' => $og_markups
            ]),
            'visible_depend' => ['options:is_og_enable' => ['show' => ['1']]]
        ]));

        return $form;
    }

}
