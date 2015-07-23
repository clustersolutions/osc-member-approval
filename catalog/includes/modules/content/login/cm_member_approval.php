<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2015 osCommerce

  Author: Cluster Solutions

  Released under the GNU General Public License
*/

  class cm_member_approval {
    var $code;
    var $group;
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    private $action = '';

    function cm_member_approval() {
      $this->code = get_class($this);
      $this->group = basename(dirname(__FILE__));

      $this->title = MODULE_CONTENT_MEMBER_APPROVAL_TITLE;
      $this->description = MODULE_CONTENT_MEMBER_APPROVAL_DESCRIPTION;

      if ( defined('MODULE_CONTENT_MEMBER_APPROVAL_STATUS') ) {
        $this->sort_order = MODULE_CONTENT_MEMBER_APPROVAL_SORT_ORDER;
        $this->enabled = (MODULE_CONTENT_MEMBER_APPROVAL_STATUS == 'True');
      }
    }

    function execute() {
      global $HTTP_GET_VARS, $HTTP_POST_VARS, $sessiontoken, $oscTemplate;

      $error = false;

      if (isset($HTTP_POST_VARS['action']) && ($HTTP_POST_VARS['action'] == 'process_account') && isset($HTTP_POST_VARS['formid']) && ($HTTP_POST_VARS['formid'] == $sessiontoken)) {
        $this->create_account();
      } elseif (isset($HTTP_GET_VARS['action']) && ($HTTP_GET_VARS['action'] == 'process_login') && isset($HTTP_POST_VARS['formid']) && ($HTTP_POST_VARS['formid'] == $sessiontoken)) {
        $this->login();
      }

      ob_start();
      include(DIR_WS_MODULES . 'content/' . $this->group . '/templates/member_approval.php');
      $template = ob_get_clean();

      $oscTemplate->addContent($template, $this->group);
      $oscTemplate->addBlock('<script>$(document).ready(function(){$(\'#passwdReset .modal-dialog,#passwdReset .modal-content\').css({"height":"430px"});$(\'#passwdReset .modal-body\').css({"height":"420px"});if($(window).width()<480)$(\'#passwdReset .modal-body\').css({"overflow-y":"scroll"});$(\'#accordion .panel-heading\').on(\'click\',function(){$(\'[id^=collapse]\').collapse(\'toggle\');});$(\'#accordion .panel-heading\').css({"cursor":"pointer"});});</script>', 'footer_scripts');
      if ($this->action === 'create_account') $oscTemplate->addBlock('<script>$("[id^=collapse]").collapse(\'hide\');$("#collapseTwo").collapse(\'toggle\');</script>', 'footer_scripts');
    }

    protected function login() {
      global $HTTP_GET_VARS, $HTTP_POST_VARS, $login_customer_id, $messageStack;

        $email_address = tep_db_prepare_input($HTTP_POST_VARS['email_address']);
        $password = tep_db_prepare_input($HTTP_POST_VARS['password']);

// Check if email exists
        $customer_query = tep_db_query("select a.customers_id, a.customers_password from customers a, member_approval b where a.customers_id = b.customers_id and a.customers_email_address = '" . tep_db_input($email_address) . "' and b.status = 1 limit 1");

        if (!tep_db_num_rows($customer_query)) {
          $error = true;
        } else {
          $customer = tep_db_fetch_array($customer_query);

// Check that password is good
          if (!tep_validate_password($password, $customer['customers_password'])) {
            $error = true;
          } else {
// set $login_customer_id globally and perform post login code in catalog/login.php
            $login_customer_id = (int)$customer['customers_id'];

// migrate old hashed password to new phpass password
            if (tep_password_type($customer['customers_password']) != 'phpass') {
              tep_db_query("update customers set customers_password = '" . tep_encrypt_password($password) . "' where customers_id = '" . (int)$login_customer_id . "'");
            }
          }
        }

      if ($error == true) {
        $messageStack->add('login', MODULE_CONTENT_MEMBER_APPROVAL_TEXT_LOGIN_ERROR);
      }
    }

    protected function create_account() {
      global $HTTP_POST_VARS, $login_customer_id, $messageStack, $language, $cart, $validation_key;

      if (ACCOUNT_GENDER == 'true') {
        if (isset($HTTP_POST_VARS['gender'])) {
          $gender = tep_db_prepare_input($HTTP_POST_VARS['gender']);
        } else {
          $gender = false;
        }
      }
      $firstname = tep_db_prepare_input($HTTP_POST_VARS['firstname']);
      $lastname = tep_db_prepare_input($HTTP_POST_VARS['lastname']);
      if (ACCOUNT_DOB == 'true') $dob = tep_db_prepare_input($HTTP_POST_VARS['dob']);
      $email_address = tep_db_prepare_input($HTTP_POST_VARS['email_address']);
      if (ACCOUNT_COMPANY == 'true') $company = tep_db_prepare_input($HTTP_POST_VARS['company']);
      $street_address = tep_db_prepare_input($HTTP_POST_VARS['street_address']);
      if (ACCOUNT_SUBURB == 'true') $suburb = tep_db_prepare_input($HTTP_POST_VARS['suburb']);
      $postcode = tep_db_prepare_input($HTTP_POST_VARS['postcode']);
      $city = tep_db_prepare_input($HTTP_POST_VARS['city']);
      if (ACCOUNT_STATE == 'true') {
        $state = tep_db_prepare_input($HTTP_POST_VARS['state']);
        if (isset($HTTP_POST_VARS['zone_id'])) {
          $zone_id = tep_db_prepare_input($HTTP_POST_VARS['zone_id']);
        } else {
          $zone_id = false;
        }
      }
      $country = tep_db_prepare_input($HTTP_POST_VARS['country']);
      $telephone = tep_db_prepare_input($HTTP_POST_VARS['telephone']);
      $fax = tep_db_prepare_input($HTTP_POST_VARS['fax']);
      if (isset($HTTP_POST_VARS['newsletter'])) {
        $newsletter = tep_db_prepare_input($HTTP_POST_VARS['newsletter']);
      } else {
        $newsletter = false;
      }
      $password = tep_db_prepare_input($HTTP_POST_VARS['password']);
      $confirmation = tep_db_prepare_input($HTTP_POST_VARS['confirmation']);

      $error = false;

      if (ACCOUNT_GENDER == 'true') {
        if ( ($gender != 'm') && ($gender != 'f') ) {
          $error = true;
  
          $messageStack->add('login', ENTRY_GENDER_ERROR);
        }
      }

      if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
        $error = true;

        $messageStack->add('login', ENTRY_FIRST_NAME_ERROR);
      }

      if (strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
        $error = true;

        $messageStack->add('login', ENTRY_LAST_NAME_ERROR);
      }

      if (ACCOUNT_DOB == 'true') {
        if ((strlen($dob) < ENTRY_DOB_MIN_LENGTH) || (!empty($dob) && (!is_numeric(tep_date_raw($dob)) || !@checkdate(substr(tep_date_raw($dob), 4, 2), substr(tep_date_raw($dob), 6, 2), substr(tep_date_raw($dob), 0, 4))))) {
          $error = true;

          $messageStack->add('login', ENTRY_DATE_OF_BIRTH_ERROR);
        }
      }

      if (strlen($email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
        $error = true;

        $messageStack->add('login', ENTRY_EMAIL_ADDRESS_ERROR);
      } elseif (tep_validate_email($email_address) == false) {
        $error = true;

        $messageStack->add('login', ENTRY_EMAIL_ADDRESS_CHECK_ERROR);
      } else {
        $check_email_query = tep_db_query("select count(*) as total from customers where customers_email_address = '" . tep_db_input($email_address) . "'");
        $check_email = tep_db_fetch_array($check_email_query);
        if ($check_email['total'] > 0) {
          $error = true;

          $messageStack->add('login', ENTRY_EMAIL_ADDRESS_ERROR_EXISTS);
        }
      }

      if (strlen($street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
        $error = true;

        $messageStack->add('login', ENTRY_STREET_ADDRESS_ERROR);
      }

      if (strlen($postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
        $error = true;

        $messageStack->add('login', ENTRY_POST_CODE_ERROR);
      }

      if (strlen($city) < ENTRY_CITY_MIN_LENGTH) {
        $error = true;

        $messageStack->add('login', ENTRY_CITY_ERROR);
      }

      if (is_numeric($country) == false) {
        $error = true;

        $messageStack->add('login', ENTRY_COUNTRY_ERROR);
      }
  
      if (ACCOUNT_STATE == 'true') {
        $zone_id = 0;
        $check_query = tep_db_query("select count(*) as total from zones where zone_country_id = '" . (int)$country . "'");
        $check = tep_db_fetch_array($check_query);
        $entry_state_has_zones = ($check['total'] > 0);
        if ($entry_state_has_zones == true) {
          $zone_query = tep_db_query("select distinct zone_id from zones where zone_country_id = '" . (int)$country . "' and (zone_name = '" . tep_db_input($state) . "' or zone_code = '" . tep_db_input($state) . "')");
          if (tep_db_num_rows($zone_query) == 1) {
            $zone = tep_db_fetch_array($zone_query);
            $zone_id = $zone['zone_id'];
          } else {
            $error = true;

            $messageStack->add('login', ENTRY_STATE_ERROR_SELECT);
          }
        } else {
          if (strlen($state) < ENTRY_STATE_MIN_LENGTH) {
            $error = true;

            $messageStack->add('login', ENTRY_STATE_ERROR);
          }
        }
      }

      if (strlen($telephone) < ENTRY_TELEPHONE_MIN_LENGTH) {
        $error = true;

        $messageStack->add('login', ENTRY_TELEPHONE_NUMBER_ERROR);
      }


      if (strlen($password) < ENTRY_PASSWORD_MIN_LENGTH) {
        $error = true;

        $messageStack->add('login', ENTRY_PASSWORD_ERROR);
      } elseif ($password != $confirmation) {
        $error = true;

        $messageStack->add('login', ENTRY_PASSWORD_ERROR_NOT_MATCHING);
      }

      if ($error == false) {
        $sql_data_array = array('customers_firstname' => $firstname,
                                'customers_lastname' => $lastname,
                                'customers_email_address' => $email_address,
                                'customers_telephone' => $telephone,
                                'customers_fax' => $fax,
                                'customers_newsletter' => $newsletter,
                                'customers_password' => tep_encrypt_password($password));

        if (ACCOUNT_GENDER == 'true') $sql_data_array['customers_gender'] = $gender;
        if (ACCOUNT_DOB == 'true') $sql_data_array['customers_dob'] = tep_date_raw($dob);

        tep_db_perform('customers', $sql_data_array);

        $customer_id = tep_db_insert_id();

        $sql_data_array = array('customers_id' => $customer_id,
                                'entry_firstname' => $firstname,
                                'entry_lastname' => $lastname,
                                'entry_street_address' => $street_address,
                                'entry_postcode' => $postcode,
                                'entry_city' => $city,
                                'entry_country_id' => $country);

        if (ACCOUNT_GENDER == 'true') $sql_data_array['entry_gender'] = $gender;
        if (ACCOUNT_COMPANY == 'true') $sql_data_array['entry_company'] = $company;
        if (ACCOUNT_SUBURB == 'true') $sql_data_array['entry_suburb'] = $suburb;
        if (ACCOUNT_STATE == 'true') {
          if ($zone_id > 0) {
            $sql_data_array['entry_zone_id'] = $zone_id;
            $sql_data_array['entry_state'] = '';
          } else {
            $sql_data_array['entry_zone_id'] = '0';
            $sql_data_array['entry_state'] = $state;
          }
        }

        tep_db_perform('address_book', $sql_data_array);

        $address_id = tep_db_insert_id();

        tep_db_query("update customers set customers_default_address_id = '" . (int)$address_id . "' where customers_id = '" . (int)$customer_id . "'");

        tep_db_query("insert into customers_info (customers_info_id, customers_info_number_of_logons, customers_info_date_account_created) values ('" . (int)$customer_id . "', '0', now())");

        $i = 1;

        do {

          $validation_key = tep_create_random_value(40);

          $validation_key_query = tep_db_query("select validation_key from member_approval where validation_key = '" . $validation_key . "'");
 
          $i = tep_db_num_rows($validation_key_query);

        } while ($i == 1);


        $sql_data_array = array('customers_id' => $customer_id,
                                'status' => false,
                                'validation_key' => $validation_key,
                                'validation_key_date' => 'now()');

        tep_db_perform('member_approval', $sql_data_array);

        if (SESSION_RECREATE == 'True') {
          tep_session_recreate();
        }
       
        if (!tep_session_is_registered('validation_key')) {
          tep_session_register('validation_key');
        }
   
        // reset session token
        $sessiontoken = md5(tep_rand() . tep_rand() . tep_rand() . tep_rand());

        // build the message content
        $name = $firstname . ' ' . $lastname;

        if (ACCOUNT_GENDER == 'true') {
           if ($gender == 'm') {
             $email_text = sprintf(EMAIL_GREET_MR, $lastname);
           } else {
             $email_text = sprintf(EMAIL_GREET_MS, $lastname);
           }
        } else {
          $email_text = sprintf(EMAIL_GREET_NONE, $firstname);
        }

        $key_link = tep_href_link('registration_upload.php', 'key=' . $validation_key, 'SSL');
        $email_text .= EMAIL_WELCOME . sprintf(EMAIL_TEXT, $key_link, $key_link) . EMAIL_CONTACT . EMAIL_WARNING;
        tep_mail($name, $email_address, EMAIL_SUBJECT, $email_text, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);

        tep_redirect(tep_href_link('registration_upload.php', '', 'SSL'));
      } else {
        $this->action = 'create_account';
      }
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_CONTENT_MEMBER_APPROVAL_STATUS');
    }

    function install() {
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Member Approval Module', 'MODULE_CONTENT_MEMBER_APPROVAL_STATUS', 'True', 'Do you want to enable the member approval module for login and registration? Please disable all other login modules. ', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Content Width', 'MODULE_CONTENT_MEMBER_APPROVAL_CONTENT_WIDTH', 'Full', 'Should the content be shown in a full or half width container?', '6', '1', 'tep_cfg_select_option(array(\'Full\', \'Half\'), ', now())");
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_CONTENT_MEMBER_APPROVAL_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Submission Link Expiration Day', 'MODULE_CONTENT_MEMBER_APPROVAL_LINK_DAY_EXPIRE', '3', 'Day to expire registration document submission link', '6', '0', now())");
      $query = "CREATE TABLE IF NOT EXISTS `member_approval` ( `customers_id` int(11) NOT NULL, `status` boolean default false, `updated` datetime DEFAULT NULL, `validation_key` char(40) NOT NULL, `validation_key_date` datetime NOT NULL, UNIQUE KEY `customers_id` (`customers_id`) );";
      tep_db_query( $query );
    }

    function remove() {
      tep_db_query("delete from configuration where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_CONTENT_MEMBER_APPROVAL_STATUS', 'MODULE_CONTENT_MEMBER_APPROVAL_CONTENT_WIDTH', 'MODULE_CONTENT_MEMBER_APPROVAL_SORT_ORDER', 'MODULE_CONTENT_MEMBER_APPROVAL_LINK_DAY_EXPIRE');
    }
  }
?>
