<?php

class onOpengraphCtypeBeforeUpdate extends cmsAction {

    public function run($ctype) {

        $other_fields = [
            'other_field', 'const_field'
        ];

        foreach ($other_fields as $other_field_name) {

            $field_value = $this->cms_core->request->get('options:' . $other_field_name, []);

            $ctype['options'][$other_field_name] = [];

            foreach ($field_value as $key => $value) {

                if (!is_numeric($key) || is_array($value)) {
                    continue;
                }

                $ctype['options'][$other_field_name][$key] = strip_tags(trim($value));
            }
        }

        return $ctype;
    }

}
