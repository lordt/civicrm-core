<?php
/*
 +--------------------------------------------------------------------+
 | CiviCRM version 5                                                  |
 +--------------------------------------------------------------------+
 | Copyright CiviCRM LLC (c) 2004-2019                                |
 +--------------------------------------------------------------------+
 | This file is a part of CiviCRM.                                    |
 |                                                                    |
 | CiviCRM is free software; you can copy, modify, and distribute it  |
 | under the terms of the GNU Affero General Public License           |
 | Version 3, 19 November 2007 and the CiviCRM Licensing Exception.   |
 |                                                                    |
 | CiviCRM is distributed in the hope that it will be useful, but     |
 | WITHOUT ANY WARRANTY; without even the implied warranty of         |
 | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
 | See the GNU Affero General Public License for more details.        |
 |                                                                    |
 | You should have received a copy of the GNU Affero General Public   |
 | License and the CiviCRM Licensing Exception along                  |
 | with this program; if not, contact CiviCRM LLC                     |
 | at info[AT]civicrm[DOT]org. If you have questions about the        |
 | GNU Affero General Public License or the licensing of CiviCRM,     |
 | see the CiviCRM license FAQ at http://civicrm.org/licensing        |
 +--------------------------------------------------------------------+
 */

/**
 * @package CRM
 * @copyright CiviCRM LLC (c) 2004-2019
 * $Id$
 *
 */

/**
 * This loads a smarty help file via ajax and returns as html
 */
class CRM_Core_Page_Inline_Help {
  public function run() {
    $args = $_REQUEST;
    if (!empty($args['file']) && strpos($args['file'], '..') === FALSE) {
      $file = $args['file'] . '.hlp';
      $additionalTPLFile = $args['file'] . '.extra.hlp';
      $smarty = CRM_Core_Smarty::singleton();
      $smarty->assign('id', $args['id']);
      CRM_Utils_Array::remove($args, 'file', 'class_name', 'type', 'q', 'id');
      foreach ($args as &$arg) {
        $arg = strip_tags($arg);
      }
      $smarty->assign('params', $args);

      $output = $smarty->fetch($file);
      $extraoutput = '';
      if ($smarty->template_exists($additionalTPLFile)) {
        $extraoutput .= trim($smarty->fetch($additionalTPLFile));
        // Allow override param to replace default text e.g. {hlp id='foo' override=1}
        if ($smarty->get_template_vars('override_help_text')) {
          $output = '';
        }
      }
      exit($output . $extraoutput);
    }
  }

}
