<?php

/**
 * Collection of upgrade steps
 */
class CRM_Wci_Upgrader extends CRM_Wci_Upgrader_Base {

  // By convention, functions that look like "function upgrade_NNNN()" are
  // upgrade tasks. They are executed in order (like Drupal's hook_update_N).

  /**
   * Example: Run an external SQL script when the module is installed
   */
  public function install() {
    $this->executeSqlFile('sql/install.sql');
  }

  /**
   * Example: Run an external SQL script when the module is uninstalled
   */
  public function uninstall() {
   $this->executeSqlFile('sql/uninstall.sql');
  }

  /**
   * Example: Run a simple query when a module is enabled
   *
  public function enable() {
    CRM_Core_DAO::executeQuery('UPDATE foo SET is_active = 1 WHERE bar = "whiz"');
  }

  /**
   * Example: Run a simple query when a module is disabled
   *
  public function disable() {
    CRM_Core_DAO::executeQuery('UPDATE foo SET is_active = 0 WHERE bar = "whiz"');
  } // */

  /**
   * Example: Run a couple simple queries
   *
   * @return TRUE on success
   * @throws Exception
   */
  public function upgrade_1000() {
    $this->ctx->log->info('Applying update 1000');
    CRM_Core_DAO::executeQuery('
      ALTER TABLE `civicrm_wci_widget`
      ADD `show_pb_perc` TINYINT(4) NOT NULL DEFAULT "1"
      COMMENT "show pb in percentage or amount"
      AFTER  `hide_pbcap`
    ');
    CRM_Core_DAO::executeQuery('
      ALTER TABLE `civicrm_wci_widget`
      ADD `color_progress_bar_bg` VARCHAR(10) COLLATE utf8_unicode_ci NOT NULL
      COMMENT "Progress bar background color."
      AFTER  `color_progress_bar`
    ');

    return TRUE;
  } 

  public function upgrade_1001() {
    $this->ctx->log->info('Applying update 1001');
    CRM_Core_DAO::executeQuery('
      CREATE TABLE IF NOT EXISTS `civicrm_wci_widget_cache` (
        `widget_id` int(10) unsigned NOT NULL COMMENT "widget id.",
        `widget_code` text DEFAULT NULL COMMENT "Widget code.",
        `expire` int(10) DEFAULT 0 COMMENT "A Unix timestamp indicating when the cache entry should expire.",
        `createdtime` int(10) DEFAULT 0 COMMENT "A Unix timestamp indicating create time.",
        PRIMARY KEY (`widget_id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
    ');
    return TRUE;
  }

}
