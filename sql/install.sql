-- WCI progress bar.
CREATE TABLE IF NOT EXISTS civicrm_wci_progress_bar (
  id int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Custom Progress bar Id.',
  name varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Name of progress bar.',
  starting_amount float unsigned NULL COMMENT 'Arbitrary starting amount for progress bar.',
  goal_amount float unsigned NULL COMMENT 'Goal amount for progress bar.',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_wci_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- WCI progress bar formula
CREATE TABLE IF NOT EXISTS civicrm_wci_progress_bar_formula (
  id int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Formula entry Id.',
  contribution_page_id int(10) unsigned NOT NULL COMMENT 'Reference contribution page id.',
  progress_bar_id int(10) unsigned DEFAULT NULL COMMENT 'Custom Progress bar reference id.',
  percentage float unsigned NULL COMMENT 'Percentage amount.',
  PRIMARY KEY (`id`),
  CONSTRAINT FK_civicrm_wci_progress_bar_formula_progress_bar_id FOREIGN KEY (`progress_bar_id`) REFERENCES `civicrm_wci_progress_bar`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- WCI widget
CREATE TABLE IF NOT EXISTS civicrm_wci_widget (
  id int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Widget Id.',
  title varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Widget title.',
  logo_image varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Image url of widget logo image.',
  image varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Url of widget image.',
  button_title varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Contribute/Donate button title.',
  button_link_to int(10) unsigned DEFAULT NULL COMMENT 'Contribution/Donation page reference.',
  progress_bar_id int(10) unsigned DEFAULT NULL COMMENT 'Custom Progress bar reference.',
  description text DEFAULT NULL COMMENT 'Widget description.',
  email_signup_group_id int(10) unsigned DEFAULT NULL COMMENT 'Group reference for email newsletter signup.',
  size_variant varchar(25) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Widget size variant.',
  color_title varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Widget title color.',
  color_title_bg varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Widget title background color.',
  color_progress_bar varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Progress bar color.',
  color_progress_bar_bg varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Progress bar background color.',
  color_widget_bg varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Widget background color.',
  color_description varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Widget description color.',
  color_border varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Widget border color.',
  color_button varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Widget button text color.',
  color_button_bg varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Widget button background color.',
  style_rules text DEFAULT NULL COMMENT 'Additional style rules.',
  override tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Override default template, if 1.',
  custom_template text DEFAULT NULL COMMENT 'Widget custom template.',
  hide_title tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Hide title, if 1.',
  hide_border tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Hide widget border, if 1.',
  hide_pbcap tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Hide pb caption, if 1.',
  show_pb_perc tinyint(4) NOT NULL DEFAULT '1' COMMENT 'show pb in %(1) or amt(0)',
  color_btn_newsletter varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Newsletter Button text color',
  color_btn_newsletter_bg varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Newsletter Button color',
  newsletter_text varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Newsletter text',
  color_newsletter_text varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Newsletter text color',
  
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_wci_title` (`title`),
  CONSTRAINT FK_civicrm_wci_widget_progress_bar_id FOREIGN KEY (`progress_bar_id`) REFERENCES `civicrm_wci_progress_bar`(`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- WCI embed code.
CREATE TABLE IF NOT EXISTS civicrm_wci_embed_code (
  id int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Custom Progress bar Id.',
  name varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Embed code.',
  widget_id int(10) unsigned DEFAULT NULL COMMENT 'widget id.',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_wci_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- WCI widget cache.
CREATE TABLE IF NOT EXISTS civicrm_wci_widget_cache (
  widget_id int(10) unsigned NOT NULL COMMENT 'widget id.',
  widget_code text DEFAULT NULL COMMENT 'Widget code.',
  expire int(10) DEFAULT 0 COMMENT 'A Unix timestamp indicating when the cache entry should expire.',
  createdtime int(10) DEFAULT 0 COMMENT 'A Unix timestamp indicating create time.',
  PRIMARY KEY (`widget_id`)

) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
