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
