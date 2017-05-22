<?php
/******************************************************************************/
//                                                                            //
//                             InstantMedia 2015                              //
//	 		  http://www.instantvideo.ru/, support@instantvideo.ru            //
//                               written by Fuze                              //
//                                                                            //
/******************************************************************************/
class formOpengraphOptions extends cmsForm {

    public function init() {

        return array(

            array(
                'type' => 'fieldset',
                'childs' => array(

					new fieldList('enabled_ctypes', array(
						'title' => LANG_OPENGRAPH_ENABLED_CTYPES,
						'hint' => LANG_OPENGRAPH_ENABLED_CTYPES_HINT,
                        'is_multiple' => true,
						'generator' => function(){

							$model = new cmsModel();

							$ps = $model->get('content_types');

							if ($ps){
								foreach($ps as $p){
									$items[$p['name']] = $p['title'];
								}
							}

							return $items;

						}
					)),

                    new fieldCheckbox('is_https_available', array(
                        'title' => LANG_OPENGRAPH_IS_HTTPS_AVAILABLE,
						'hint' => LANG_OPENGRAPH_IS_HTTPS_AVAILABLE_HINT
                    )),

                    new fieldNumber('max_image_count', array(
                        'title' => LANG_OPENGRAPH_MAX_IMAGE_COUNT
                    )),

                    new fieldImage('default_image', array(
                        'title' => LANG_OPENGRAPH_DEFAULT_IMAGE,
						'hint' => LANG_OPENGRAPH_DEFAULT_IMAGE_HINT,
                        'options' => array(
                            'sizes' => array('small', 'original')
                        )
                    )),

                )
            )

        );

    }

}
