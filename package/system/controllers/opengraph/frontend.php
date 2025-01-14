<?php

class opengraph extends cmsFrontend {

    private static $is_set_base_tags = false;

    protected $useOptions = true;

    protected $gen_preset_id = 0;
    protected $gen_cat_name = '';

    protected $gen_context = [
        'tc' => '',
        'ts' => '',
        'ti' => ''
    ];

    public function __construct(cmsRequest $request) {

        parent::__construct($request);

        $this->gen_preset_id = $this->options['default_gen_preset_id'] ?? 0;
    }

    /**
     * Устанавливает массив контекста генерации изображения
     *
     * @param array $gen_context
     * @return $this
     */
    public function setGenContext(array $gen_context) {

        $this->gen_context = $gen_context;

        return $this;
    }

    /**
     * Устанавливает id пресета генерации изображения
     *
     * @param int $gen_preset_id
     * @return $this
     */
    public function setGenPresetId($gen_preset_id) {

        $this->gen_preset_id = $gen_preset_id;

        return $this;
    }

    /**
     * Устанавливает название раздела (категории) записи
     *
     * @param string $cat_name
     * @return $this
     */
    public function setGenCategory(string $cat_name) {

        $this->gen_cat_name = $cat_name;

        return $this;
    }

    /**
     * Устанавливает атрибуты для <html> тега страницы
     */
    public function setHtmlAttr() {

        if (!empty($this->options['html_attr_value'])) {
            $this->cms_template->addLayoutParams(['attr' => ['prefix' => $this->options['html_attr_value']]]);
        }

    }

    /**
     * Подготавливает контент для метатега
     *
     * @param string $content
     * @param array|string $meta_item
     */
    public function prepareMetaTagContent(string $content, $meta_item) {

        if (is_string($meta_item)) {
            $meta_item = $this->cms_template->{$meta_item} ?? [];
        }

        return preg_replace('!\s+!', ' ', string_replace_keys_values_extended($content, $meta_item));
    }

    /**
     * Устанавливает метатег
     *
     * @param string $property
     * @param string $content
     * @param null|array|string $meta_item
     * @return $this
     */
    public function setMetaTag(string $property, string $content) {

        $this->cms_template->addHead('<meta property="'.html($property, false).'" content="'.html($content, false).'"/>');

        return $this;
    }

    /**
     * Устанавливает обязательные теги opengraph
     *
     * @param string $type        Тип
     * @param string $title       Заголовок
     * @param string $description Описание
     * @param string $url         Абсолютный URL страницы
     * @param array $image_urls   Массив изображений
     * @return void
     */
    public function setBasicOpenGraph(string $type, string $title, string $description, string $url, array $image_urls = []) {

        if (self::$is_set_base_tags) {
            return;
        }

        self::$is_set_base_tags = true;

        $title = $this->prepareMetaTagContent($title, 'title_item');

        $this->setMetaTag('og:title', $title)->
               setMetaTag('og:type', $type)->
               setMetaTag('og:site_name', $this->cms_config->sitename)->
               setMetaTag('og:url', $url);

        if ($description) {

            $description = $this->prepareMetaTagContent($description, 'metadesc_item');

            $this->setMetaTag('og:description', $description);
        }

        // если сюда картинка не дошла, ставим картинку по умолчанию
        if (!$image_urls) {

            switch ($this->options['display_image_type']) {
                case 'item':

                    if ($this->options['default_image'] && !empty($this->options['default_image'][$this->options['default_image_preset']])) {
                        $image_urls = [$this->options['default_image'][$this->options['default_image_preset']]];
                    }

                    break;
                case 'gen':

                    if ($this->gen_preset_id) {

                        $preset = $this->getPreset($this->gen_preset_id);

                        $image_urls[] = (new icms\controllers\opengraph\imageGenerator($preset, $this->gen_context))->
                                renderImage($title, $description, $this->gen_cat_name);
                    }

                    break;
                default:
                    break;
            }

        } elseif (!is_array($image_urls)) {
            $image_urls = [$image_urls];
        }

        if (!empty($this->options['max_image_count']) && count($image_urls) > $this->options['max_image_count']) {
            $image_urls = array_slice($image_urls, 0, $this->options['max_image_count']);
        }

        foreach ($image_urls as $image_url) {

            if (!$image_url) {
                continue;
            }

            // передали полный путь к картинке
            if (strpos($image_url, '://') !== false) {

                $this->setMetaTag('og:image', $image_url);

                continue;
            }

            $this->setMetaTag('og:image', $this->cms_config->upload_host_abs . '/' . $image_url);

            if (empty($this->options['print_img_params'])) {
                continue;
            }

            $img_path = $this->cms_config->upload_path . $image_url;

            if (file_exists($img_path)) {

                $img_size = getimagesize($img_path);

                if ($img_size !== false) {

                    $this->setMetaTag('og:image:type', $img_size['mime'])->
                           setMetaTag('og:image:height', $img_size[1])->
                           setMetaTag('og:image:width', $img_size[0]);
                }
            }
        }

        return $this->setHtmlAttr();
    }

    private function getPreset($id) {

        return $this->model->getItemById('og_img_presets', $id, function($item, $model) {
            $options = cmsModel::yamlToArray($item['options']);
            $options['id'] = $item['id'];
            return $options;
        }) ?: [];
    }

    public function deleteFilesByMaskRecursive($directory, $mask) {

        if (!is_dir($directory)) {
            return false;
        }

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        $regex = '/^' . str_replace(['*', '?'], ['.*', '.'], $mask) . '$/';

        foreach ($iterator as $file) {
            if ($file->isFile() && preg_match($regex, $file->getFilename())) {
                @unlink($file->getPathname());
            }
        }

        return true;
    }

}
