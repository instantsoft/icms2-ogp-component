<?php
/******************************************************************************/
//                                                                            //
//                             InstantMedia 2015                              //
//	 		  http://www.instantvideo.ru/, support@instantvideo.ru            //
//                               written by Fuze                              //
//                                                                            //
/******************************************************************************/
define('LANG_OPENGRAPH_CONTROLLER', 'Open Graph microformat');
define('LANG_OPENGRAPH_TYPE', 'Open Graph markup type');
define('LANG_OPENGRAPH_TYPE_OTHER', 'Other');
define('LANG_OPENGRAPH_TYPE_ARTICLES', 'Article');
define('LANG_OPENGRAPH_TYPE_BOOK', 'Books');
define('LANG_OPENGRAPH_TYPE_BASE', 'Common type');
define('LANG_OPENGRAPH_TYPE_MUSIC', 'Music');
define('LANG_OPENGRAPH_TYPE_MUSICTRACK', 'Music track');
define('LANG_OPENGRAPH_TYPE_MUSIC_ALBUM', 'Music album');
define('LANG_OPENGRAPH_TYPE_MUSIC_PLAYLIST', 'Music playlist');
define('LANG_OPENGRAPH_TYPE_RADIO', 'Radio');
define('LANG_OPENGRAPH_TYPE_VIDEO', 'Video');
define('LANG_OPENGRAPH_TYPE_FILM', 'Film');
define('LANG_OPENGRAPH_TYPE_SERIAL', 'Episode');
define('LANG_OPENGRAPH_TYPE_SHOW', 'Episode of the TV show');
define('LANG_OPENGRAPH_TYPE_LIVE', 'Broadcast');
define('LANG_OPENGRAPH_TYPE_MUSIC_VIDEO', 'Music videos');
define('LANG_OPENGRAPH_ENABLED_CTYPES', 'Content types, which markup');
define('LANG_OPENGRAPH_ENABLED_CTYPES_HINT', 'When enabled content types will be formed markup. In the content type settings will have additional options');
define('LANG_OPENGRAPH_IS_HTTPS_AVAILABLE', 'Site is running on https protocol');
define('LANG_OPENGRAPH_IS_HTTPS_AVAILABLE_HINT', 'Turn on, if website works including via the https Protocol. Make sure also, if you images are stored on another host, it is also accessible via https Protocol');
define('LANG_OPENGRAPH_DEFAULT_IMAGE', 'Default Image');
define('LANG_OPENGRAPH_MAX_IMAGE_COUNT', 'Maximum image count displayed in the og:image');
define('LANG_OPENGRAPH_DEFAULT_IMAGE_HINT', 'Will be used if content type is not set to a different default image and the entry has no images');
define('LANG_OPENGRAPH_IMAGE_FIELDS', 'Fields for image Open Graph markup');
define('LANG_OPENGRAPH_IMAGE_FIELD', 'Image Field');
define('LANG_OPENGRAPH_ADD_FIELD', 'Add field');
define('LANG_OPENGRAPH_OTHER_FIELDS', 'Additional fields');
define('LANG_OPENGRAPH_FIELD_NAME', 'Field name');
define('LANG_OPENGRAPH_FIELD_CONTENT', 'specified value');
define('LANG_OPENGRAPH_FIELD_CONTENT_HINT', 'Not set - will be a choice field');
define('LANG_OPENGRAPH_FIELD_FUNC', 'Values processing function');
define('LANG_OPENGRAPH_FIELD_NEED_VALUE', 'You need to enter a value');
define('LANG_OPENGRAPH_FIELD_NAME_HINT', 'The title, according to the specification <a target="_blank" href="http://ogp.me/">OpenGraphProtocol</a>. You can specify the invariant fields or use designs {key}, where key is the name of a field in a table of records of the content type. You can also specify the expression {host} which will be replaced by current host site protocol prefix — for example, {host}video/embed/{id} will be replaced by https://site.ru/video/embed/123');