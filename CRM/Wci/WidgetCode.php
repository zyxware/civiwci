<?php
require_once '../wci-helper-functions.php';

class CRM_Wci_WidgetCode {

  static function get_widget_realtime_code($widgetId) {
    $data = CRM_Wci_BAO_Widget::getWidgetData($widgetId);
    $template = CRM_Core_Smarty::singleton();
    $template->assign('wciform', $data);
    $template->assign('cpageId', $data['button_link_to']);
//    $template->assign('preview', $preview);

    if ($data["override"] == '0') {
      $template->template_dir[] = getWciWidgetTemplatePath();
      $wcidata = $template->fetch('wciwidget.tpl');
    } else {
      $wcidata = $template->fetch('string:' . html_entity_decode($data['custom_template']));
    }
    $code = json_encode($wcidata);
    CRM_Wci_BAO_WidgetCache::setWidgetCache($widgetId, $code);
    return $code;
  }
  
  static function get_widget_code($embedId, $preview=0) {
    
    if($preview) {
      /**On preview time controller is called from create widget 
          form so id will be widget id */
      $code = CRM_Wci_WidgetCode::get_widget_realtime_code($embedId);
    } else {
      $widgetId = CRM_Wci_BAO_EmbedCode::getWidgetId($embedId);
      $code = CRM_Wci_BAO_WidgetCache::getWidgetCache($widgetId);

      $tsDiff = CRM_Wci_BAO_WidgetCache::getCurrentTsDiff($widgetId);
      $cacheTime = civicrm_api3('setting', 'getValue', 
          array('group' => 'Wci Preference', 'name' => 'widget_cache_timeout'));
      if(($tsDiff > $cacheTime)||(empty($code))) {
        $code = CRM_Wci_WidgetCode::get_widget_realtime_code($widgetId);
      }
    }
    return $code;
  }
}

