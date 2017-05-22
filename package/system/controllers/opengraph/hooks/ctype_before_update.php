<?php
/******************************************************************************/
//                                                                            //
//                             InstantMedia 2015                              //
//	 		  http://www.instantvideo.ru/, support@instantvideo.ru            //
//                               written by Fuze                              //
//                                                                            //
/******************************************************************************/
class onOpengraphCtypeBeforeUpdate extends cmsAction {

    public function run($ctype){

        if(isset($_REQUEST['options']['image_fields'])){
            foreach ($_REQUEST['options']['image_fields'] as $key => $value) {
                if($this->validate_sysname($value) !== true){
                    unset($_REQUEST['options']['image_fields'][$key]);
                }
            }
            $ctype['options']['image_fields'] = $_REQUEST['options']['image_fields'];
        }
        if(isset($_REQUEST['options']['image_preset'])){
            foreach ($_REQUEST['options']['image_preset'] as $key => $value) {
                if($this->validate_sysname($value) !== true){
                    unset($_REQUEST['options']['image_preset'][$key]);
                }
            }
            $ctype['options']['image_preset'] = $_REQUEST['options']['image_preset'];
        }

        $other_fields = array(
            'other_field', 'const_field', 'other_field_name', 'other_field_func'
        );

        foreach ($other_fields as $other_field_name) {

            if(isset($_REQUEST['options'][$other_field_name])){
                foreach ($_REQUEST['options'][$other_field_name] as $key => $value) {
                    $_REQUEST['options'][$other_field_name][$key] = strip_tags(trim($value));
                }
                $ctype['options'][$other_field_name] = $_REQUEST['options'][$other_field_name];
            }

        }

        return $ctype;

    }

}
