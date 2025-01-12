DROP TABLE IF EXISTS `{#}og_img_presets`;
CREATE TABLE IF NOT EXISTS `{#}og_img_presets` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(155) DEFAULT NULL,
  `options` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `{#}og_img_presets` (`id`, `title`, `options`) VALUES
(1, 'По умолчанию', '---\nformat: jpg\nquality: 91\nlayout: icms\nfont: Inter\nbase_color: \'#f8f9fa\'\naccent_color: \'#ffffff\'\nbackground_color: \'#786fa6\'\ntitle_color: \"\"\nshow_desc: null\ndescription_color: \'#dee2e6\'\nshow_cat: 1\ncat_pos: bottom-left\ncat_color: \'#fcac84\'\nbackground_img: null\nbackground_img_type: cover\nbackground_img_opacity: 1\nborder_pos: bottom\nborder_width: 16\nborder_color: \'#a49ad6\'\nwatermark: null\nwatermark_pos: top-right\nshow_info_text: 1\ninfo_text: InstantCMS Community\ninfo_text_pos: top-left\ninfo_text_color: \'#a49ad6\'\n');
