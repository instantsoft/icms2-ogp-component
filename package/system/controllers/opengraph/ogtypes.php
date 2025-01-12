<?php

namespace icms\controllers\opengraph;

trait ogtypes {

    public function getOgTypes(){

        return [
            'other' => [
                LANG_OPENGRAPH_TYPE_OTHER
            ],
            'article'             => LANG_OPENGRAPH_TYPE_ARTICLES,
            'book'                => LANG_OPENGRAPH_TYPE_BOOK,
            'website'             => LANG_OPENGRAPH_TYPE_BASE,
            'music' => [
                LANG_OPENGRAPH_TYPE_MUSIC
            ],
            'music.song'          => LANG_OPENGRAPH_TYPE_MUSICTRACK,
            'music.album'         => LANG_OPENGRAPH_TYPE_MUSIC_ALBUM,
            'music.playlist'      => LANG_OPENGRAPH_TYPE_MUSIC_PLAYLIST,
            'music.radio_station' => LANG_OPENGRAPH_TYPE_RADIO,
            'video' => [
                LANG_OPENGRAPH_TYPE_VIDEO
            ],
            'video.other'         => LANG_OPENGRAPH_TYPE_OTHER,
            'video.movie'         => LANG_OPENGRAPH_TYPE_FILM,
            'video.episode'       => LANG_OPENGRAPH_TYPE_SERIAL,
            'video.tv_show'       => LANG_OPENGRAPH_TYPE_SHOW,
            'ya:ovs:broadcast'    => LANG_OPENGRAPH_TYPE_LIVE,
            'ya:ovs:music'        => LANG_OPENGRAPH_TYPE_MUSIC_VIDEO
        ];
    }

}
