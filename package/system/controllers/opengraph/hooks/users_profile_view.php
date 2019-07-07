<?php
/******************************************************************************/
//                                                                            //
//                               InstantMedia                                 //
//	 		      http://instantvideo.ru/, support@instantvideo.ru            //
//                               written by Fuze                              //
//                     https://instantvideo.ru/copyright.html                 //
//                                                                            //
/******************************************************************************/
class onOpengraphUsersProfileView extends cmsAction {

    public function run($profile){

        if (empty($profile['avatar'])){
            $avatars = array(
                'normal' => 'default/avatar.jpg'
            );
        } else {
            $avatars = $profile['avatar'];
            if (!is_array($avatars)){
                $avatars = cmsModel::yamlToArray($avatars);
            }
        }

        $template = $this->setBasicOpenGraph(array(
            'title'       => $profile['nickname'],
            'description' => $profile['status_text'],
            'type'        => 'profile',
            'url'         => href_to('users', $profile['id']),
            'image_urls'  => $avatars['normal']
        ));

        $names = explode(' ', $profile['nickname']);

        if(count($names)==1){
            $template->addHead('<meta property="profile:first_name" content="'.html($profile['nickname'], false).'"/>');
        } else {
            $template->addHead('<meta property="profile:first_name" content="'.html($names[0], false).'"/>'); unset($names[0]);
            $template->addHead('<meta property="profile:last_name" content="'.html(implode(' ', $names), false).'"/>');
        }

        return $profile;

    }

}
