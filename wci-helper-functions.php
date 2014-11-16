<?php

  function getContributionPageOptions() {
    $options = array(
      0 => ts('- select -'),
    );
    
    $result = civicrm_api3('contribution_page', 'get');
    foreach ($result['values'] as $contribution_page) {
      $options[$contribution_page['id']] = $contribution_page['title'];
    }
    
    return $options;
  }
  
  function getExtensionRootPath() {
    return 'http://' . $_SERVER['SERVER_NAME'] . str_replace($_SERVER['DOCUMENT_ROOT'], '', __DIR__);
  }
  
  function getWciWidgetControllerPath() {
    $widget_controller_path = getExtensionRootPath() . '/extern/embed.php';
    
    return $widget_controller_path;
  }
  
  function getWciWidgetTemplatePath() {
    $widget_tpl_path = __DIR__ . '/templates/CRM/Wci/Page';
    
    return $widget_tpl_path;
  }
