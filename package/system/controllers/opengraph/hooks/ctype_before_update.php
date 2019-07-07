<?php
/******************************************************************************/
//                                                                            //
//                               InstantMedia                                 //
//	 		      http://instantvideo.ru/, support@instantvideo.ru            //
//                               written by Fuze                              //
//                     https://instantvideo.ru/copyright.html                 //
//                                                                            //
/******************************************************************************/
class onOpengraphCtypeBeforeUpdate extends cmsAction {

    public function run($ctype){

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
