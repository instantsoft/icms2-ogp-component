<?php
/******************************************************************************/
//                                                                            //
//                             InstantMedia 2015                              //
//	 		  http://www.instantvideo.ru/, support@instantvideo.ru            //
//                               written by Fuze                              //
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
            'title'=>$profile['nickname'],
            'description'=>$profile['status_text'],
            'type'=>'profile',
            'url'=>href_to('users', $profile['id']),
            'image_urls'=>$avatars['normal']
        ));

        $names = explode(' ', $profile['nickname']);

        if(count($names)==1){
            $template->addHead('<meta property="profile:first_name" content="'.htmlspecialchars($profile['nickname']).'"/>');
        } else {
            $template->addHead('<meta property="profile:first_name" content="'.htmlspecialchars($names[0]).'"/>'); unset($names[0]);
            $template->addHead('<meta property="profile:last_name" content="'.htmlspecialchars(implode(' ', $names)).'"/>');
        }

        return $profile;

    }

}
