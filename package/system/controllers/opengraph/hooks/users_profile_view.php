<?php

class onOpengraphUsersProfileView extends cmsAction {

    public function run($profile) {

        if (empty($profile['avatar'])) {

            $avatars = [
                'normal' => 'default/avatar.jpg'
            ];

        } else {

            $avatars = $profile['avatar'];

            if (!is_array($avatars)) {
                $avatars = cmsModel::yamlToArray($avatars);
            }
        }

        $this->setBasicOpenGraph(
            'profile',
            $profile['nickname'],
            $profile['status_text'] ?: '',
            href_to_profile($profile, false, true),
            [$avatars['normal']]
        );

        $names = explode(' ', $profile['nickname']);

        if (count($names) === 1) {

            $this->setMetaTag('profile:first_name', $profile['nickname']);

        } else {

            $this->setMetaTag('profile:first_name', $names[0]);

            unset($names[0]);

            $this->setMetaTag('profile:last_name', implode(' ', $names));
        }

        return $profile;
    }

}
