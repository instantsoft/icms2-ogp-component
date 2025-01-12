<?php

class onOpengraphBeforeRenderPage extends cmsAction {

    public function run($data) {

        $full_uri = $this->cms_core->uri . ($this->cms_core->uri_query ? '?' . http_build_query($this->cms_core->uri_query) : '');

        $is_stop_match = string_matches_mask_list(explode("\n", $this->options['url_mask_not']), $full_uri);

        if ($is_stop_match) {
            return $data;
        }

        $title = $this->cms_template->getMetaHandled('title');

        if (!empty($this->options['cut_sitename_from_title'])) {
            $title = str_replace(' — ' . $this->cms_config->sitename, '', $title);
        }

        $this->setBasicOpenGraph(
            $this->options['og_type_default'],
            $title,
            $this->cms_template->getMetaHandled('metadesc'),
            rel_to_href($this->cms_core->uri_before_remap, true)
        );

        $this->setGenContext([
            'tc' => $this->cms_core->controller,
            'ts' => $this->cms_core->uri_action,
            'ti' => 0
        ]);

        return $data;
    }

}
