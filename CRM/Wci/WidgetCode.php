<?php
require_once '../wci-helper-functions.php';

class CRM_Wci_WidgetCode {

  static function generate_widget_code($widgetId, $preview = 0) {
    $code = '';
    $dynamic_content = FALSE;
    $data = CRM_Wci_BAO_Widget::getWidgetData($widgetId);
    $template = CRM_Core_Smarty::singleton();
    $template->assign('wciform', $data);
    $template->assign('cpageId', $data['button_link_to']);
    $template->assign('preview', $preview);

    if ($data["override"] == '0') {
      $template->template_dir[] = getWciWidgetTemplatePath();
      $wcidata = $template->fetch('wciwidget.tpl');
    } else {
      $wcidata = $template->fetch('string:' . html_entity_decode($data['custom_template']));
    }
    
    $code = json_encode($wcidata);
    
    if ($data['progress_bar_id'] != 0) {
      $dynamic_content = TRUE;
    }
    return array('dynamic' => $dynamic_content, 'code' => $code);
  }
  
  static function get_widget_code($embedId, $preview = 0) {
    $code = '';
    if ($preview) {
      $widget = CRM_Wci_WidgetCode::generate_widget_code($embedId, $preview);
      return $widget['code'];
    }
    else {
      $widgetId = CRM_Wci_BAO_EmbedCode::getWidgetId($embedId);
      $code = CRM_Wci_BAO_WidgetCache::getWidgetCache($widgetId);
    }
    if (!$code) {
      $widget = CRM_Wci_WidgetCode::generate_widget_code($widgetId);
      CRM_Wci_BAO_WidgetCache::setWidgetCache($widgetId, $widget);
      $code = $widget['code'];
    }

    return $code;
  }
}

