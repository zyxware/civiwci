<?php

  function getContributionPageOptions() {
    $options = array(
      '' => ts('- select -'),
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
    $widget_controller_path = getExtensionRootPath() . '/extern/wciwidget.php';
    
    return $widget_controller_path;
  }
  
  function getWciWidgetTemplatePath() {
    $widget_tpl_path = getExtensionRootPath() . '/templates/CRM/Wci/Page';
    
    return $widget_tpl_path;
  }