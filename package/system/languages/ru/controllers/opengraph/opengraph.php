<?php
/******************************************************************************/
//                                                                            //
//                             InstantMedia 2015                              //
//	 		  http://www.instantvideo.ru/, support@instantvideo.ru            //
//                               written by Fuze                              //
//                                                                            //
/******************************************************************************/
define('LANG_OPENGRAPH_CONTROLLER', 'Микроформат Open Graph');
define('LANG_OPENGRAPH_TYPE', 'Тип разметки Open Graph');
define('LANG_OPENGRAPH_TYPE_OTHER', 'Прочие');
define('LANG_OPENGRAPH_TYPE_ARTICLES', 'Статьи');
define('LANG_OPENGRAPH_TYPE_BOOK', 'Книги');
define('LANG_OPENGRAPH_TYPE_BASE', 'Общий тип');
define('LANG_OPENGRAPH_TYPE_MUSIC', 'Музыка');
define('LANG_OPENGRAPH_TYPE_MUSICTRACK', 'Музыкальный трек');
define('LANG_OPENGRAPH_TYPE_MUSIC_ALBUM', 'Музыкальный альбом');
define('LANG_OPENGRAPH_TYPE_MUSIC_PLAYLIST', 'Музыкальный плейлист');
define('LANG_OPENGRAPH_TYPE_RADIO', 'Радиостанция');
define('LANG_OPENGRAPH_TYPE_VIDEO', 'Видео');
define('LANG_OPENGRAPH_TYPE_FILM', 'Фильм');
define('LANG_OPENGRAPH_TYPE_SERIAL', 'Серия сериала');
define('LANG_OPENGRAPH_TYPE_SHOW', 'Эпизод телешоу');
define('LANG_OPENGRAPH_TYPE_LIVE', 'Трансляция');
define('LANG_OPENGRAPH_TYPE_MUSIC_VIDEO', 'Музыкальное видео');
define('LANG_OPENGRAPH_ENABLED_CTYPES', 'Типы контента, в которых формировать разметку');
define('LANG_OPENGRAPH_ENABLED_CTYPES_HINT', 'Во включенных типах контента будет формироваться разметка. В настройках типа контента появятся дополнительные опции');
define('LANG_OPENGRAPH_IS_HTTPS_AVAILABLE', 'Сайт работает по https протоколу');
define('LANG_OPENGRAPH_IS_HTTPS_AVAILABLE_HINT', 'Включите, если сайт работает в том числе и по https протоколу. Убедитесь так же, если у вас изображения хранятся на другом хосте, он так же доступен по https протоколу.');
define('LANG_OPENGRAPH_DEFAULT_IMAGE', 'Изображению по умолчанию');
define('LANG_OPENGRAPH_MAX_IMAGE_COUNT', 'Максимальное количество изображений, выводимых в og:image');
define('LANG_OPENGRAPH_DEFAULT_IMAGE_HINT', 'Будет использоваться, если в типе контента не задано другое изображение по умолчанию и у записи нет изображений');
define('LANG_OPENGRAPH_IMAGE_FIELDS', 'Поля для изображений разметки Open Graph');
define('LANG_OPENGRAPH_IMAGE_FIELD', 'Поле изображения');
define('LANG_OPENGRAPH_ADD_FIELD', 'Добавить поле');
define('LANG_OPENGRAPH_OTHER_FIELDS', 'Дополнительные поля разметки');
define('LANG_OPENGRAPH_FIELD_NAME', 'Название поля');
define('LANG_OPENGRAPH_FIELD_CONTENT', 'заданное значение');
define('LANG_OPENGRAPH_FIELD_CONTENT_HINT', 'Не задано - будет выбор поля');
define('LANG_OPENGRAPH_FIELD_FUNC', 'Функция обработки значения');
define('LANG_OPENGRAPH_FIELD_NEED_VALUE', 'Нужно ввести значение');
define('LANG_OPENGRAPH_FIELD_NAME_HINT', 'Название, согласно спецификации <a target="_blank" href="http://ogp.me/">OpenGraphProtocol</a> или рекомендаций <a target="_blank" href="https://yandex.ru/support/webmaster/open-graph/intro-open-graph.xml">Яндекс</a>. Можно указать неизменяемое значение поля или же воспользоваться конструкциями {key}, где key - название поля в таблице записей типа контента. Так же можно указывать ключевое выражение {host}, которое будет заменено на текущий хост сайта с префиксом протокола, например {host}video/embed/{id} будет заменен на https://site.ru/video/embed/123');