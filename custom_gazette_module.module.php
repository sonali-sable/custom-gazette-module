<?php

/**
 * Implements hook_help().
 */
function custom_gazette_module_help($route_name, RouteMatchInterface $route_match) {
  switch ($route_name) {
    case 'help.page.custom_gazette_module':
      return '<p>' . t('A Drupal module to consume The Gazette REST API.') . '</p>';
  }
}
