<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2015 osCommerce
  
  Author: Cluster Solutions

  Released under the GNU General Public License
*/

  class d_customers_member_approval {
    var $code = 'd_customers_member_approval';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function d_customers_member_approval() {
      $this->title = MODULE_ADMIN_DASHBOARD_CUSTOMERS_MEMBER_APPROAVL_TITLE;
      $this->description = MODULE_ADMIN_DASHBOARD_CUSTOMERS_MEMBER_APPROAVL_DESCRIPTION;

      if ( defined('MODULE_ADMIN_DASHBOARD_CUSTOMERS_MEMBER_APPROAVL_STATUS') ) {
        $this->sort_order = MODULE_ADMIN_DASHBOARD_CUSTOMERS_MEMBER_APPROAVL_SORT_ORDER;
        $this->enabled = (MODULE_ADMIN_DASHBOARD_CUSTOMERS_MEMBER_APPROAVL_STATUS == 'True');
      }
    }

    function getOutput() {
      $output = '<table border="0" width="100%" cellspacing="0" cellpadding="4">' .
                '  <tr class="dataTableHeadingRow">' .
                '    <td class="dataTableHeadingContent">' . MODULE_ADMIN_DASHBOARD_CUSTOMERS_MEMBER_APPROAVL_TITLE . '</td>' .
                '    <td class="dataTableHeadingContent" align="right">' . MODULE_ADMIN_DASHBOARD_CUSTOMERS_MEMBER_APPROAVL_DATE . '</td>' .
                '  </tr>';

      $customers_query = tep_db_query("select c.customers_id, c.customers_lastname, c.customers_firstname, ci.customers_info_date_account_created from customers c, customers_info ci, member_approval ma where c.customers_id = ci.customers_info_id and c.customers_id = ma.customers_id and ma.status = 0 order by ci.customers_info_date_account_created desc limit 6");

      while ($customers = tep_db_fetch_array($customers_query)) {
        $output .= '  <tr class="dataTableRow" onmouseover="rowOverEffect(this);" onmouseout="rowOutEffect(this);">' .
                   '    <td class="dataTableContent"><a href="' . tep_href_link('customers_member_approval.php', 'cID=' . (int)$customers['customers_id'] . '') . '">' . tep_output_string_protected($customers['customers_firstname'] . ' ' . $customers['customers_lastname']) . '</a></td>' .
                   '    <td class="dataTableContent" align="right">' . tep_date_short($customers['customers_info_date_account_created']) . '</td>' .
                   '  </tr>';
      }

      $output .= '</table>';

      return $output;
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_ADMIN_DASHBOARD_CUSTOMERS_MEMBER_APPROAVL_STATUS');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Customers For Approval Module', 'MODULE_ADMIN_DASHBOARD_CUSTOMERS_MEMBER_APPROAVL_STATUS', 'True', 'Do you want to show the newest customers awaiting for approval on the dashboard?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_ADMIN_DASHBOARD_CUSTOMERS_MEMBER_APPROAVL_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '400', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_ADMIN_DASHBOARD_CUSTOMERS_MEMBER_APPROAVL_STATUS', 'MODULE_ADMIN_DASHBOARD_CUSTOMERS_MEMBER_APPROAVL_SORT_ORDER');
    }
  }
?>
