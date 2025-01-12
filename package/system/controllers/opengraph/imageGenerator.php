<?php

namespace icms\controllers\opengraph;

use cmsAutoloader, cmsConfig;

use SimonHamp\TheOg\Image;
use SimonHamp\TheOg\Theme\Background;
use SimonHamp\TheOg\BorderPosition;
use SimonHamp\TheOg\Theme\BackgroundPlacement;
use SimonHamp\TheOg\Layout\Position;
use SimonHamp\TheOg\Theme\Theme;
use Intervention\Image\Colors\Rgb\Color;
use Intervention\Image\Encoders\FileExtensionEncoder;

class imageGenerator {

    private $preset = [];
    private $gen_context = [];

    public function __construct(array $preset, array $gen_context) {

        cmsAutoloader::registerList([
            ['Intervention\Image', 'system/controllers/opengraph/libs/intervention/'],
            ['SimonHamp\TheOg', 'system/controllers/opengraph/libs/og/'],
        ]);

        $this->preset = $preset;
        $this->gen_context = $gen_context;
    }

    public function renderImage(string $title, string $description = '', string $cat_name = '') {

        list($rel_path, $abs_path) = $this->getGenImagePath($title);

        if (file_exists($abs_path)) {
            return $rel_path;
        }

        try {

            $layout = '\SimonHamp\TheOg\Layout\Layouts\\'.$this->preset['layout'];
            $font   = '\SimonHamp\TheOg\Theme\Fonts\\'.$this->preset['font'];

            $theme = new Theme(
                accentColor: $this->preset['accent_color'],
                backgroundColor: $this->preset['background_color'],
                baseColor: $this->preset['base_color'],
                urlColor: $this->preset['info_text_color'] ?: null,
                titleColor: $this->preset['title_color'] ?: null,
                descriptionColor: $this->preset['description_color'] ?: null,
                callToActionColor: $this->preset['cat_color'] ?: null,
                baseFont: $font::bold(),
                descriptionFont: $font::light(),
                titleFont: $font::black(),
            );

            $img = new Image(new $layout, $theme);

            // Границы
            $img->border(
                BorderPosition::from($this->preset['border_pos']),
                $this->preset['border_color'] ? Color::create($this->preset['border_color']) : null,
                (int)$this->preset['border_width']
            );

            // Бэкграунд
            if (!empty($this->preset['background_img']['original'])) {

                $background = new Background(cmsConfig::get('upload_path') . $this->preset['background_img']['original']);

                $img->background(
                    $background,
                    $this->preset['background_img_opacity'] ? (float) $this->preset['background_img_opacity'] : null,
                    BackgroundPlacement::from($this->preset['background_img_type'])
                );
            }

            // Ватермарк
            if (!empty($this->preset['watermark']['original'])) {

                $img->watermark(
                    cmsConfig::get('upload_path') . $this->preset['watermark']['original'],
                    Position::from($this->preset['watermark_pos'])
                );
            }

            // Имя домена
            if (!empty($this->preset['show_info_text']) && $this->preset['info_text']) {

                $img->url(
                    $this->preset['info_text'],
                    Position::from($this->preset['info_text_pos'])
                );
            }

            // Категория
            if (!empty($this->preset['show_cat']) && $cat_name) {
                $img->callToAction(
                    $cat_name,
                    Position::from($this->preset['cat_pos'])
                );
            }

            if (!empty($this->preset['show_desc']) && $description) {
                $img->description($description);
            }

            $img->title($title);

            $img->save($abs_path, new FileExtensionEncoder($this->preset['format'], $this->preset['quality']));

        } catch (Exception $e) {

            error_log($e->getMessage());

            $rel_path = '';
        }

        return $rel_path;
    }

    public function getGenImagePath($title) {

        $file_name = md5($title) . '.' . $this->preset['format'];

        $first_dir   = substr($file_name, 0, 1);
        $second_dir  = substr($file_name, 1, 1);

        $rel_path = 'opengraph/' . $first_dir . '/' . $second_dir . '/';

        $abs_path = cmsConfig::get('upload_path') . $rel_path;

        if (!is_dir($abs_path)) {

            @mkdir($abs_path, 0777, true);
            @chmod($abs_path, 0777);
            @chmod(pathinfo($abs_path, PATHINFO_DIRNAME), 0777);
        }

        $prefix = [$this->preset['id']];

        if (!empty($this->gen_context['tc'])) {
            $prefix[] = $this->gen_context['tc'];
        }

        if (!empty($this->gen_context['ts'])) {
            $prefix[] = $this->gen_context['ts'];
        }

        if (!empty($this->gen_context['ti'])) {
            $prefix[] = $this->gen_context['ti'];
        }

        $file_name = implode('_', $prefix) . '_' . $file_name;

        return [$rel_path . $file_name, $abs_path . $file_name];
    }

}
