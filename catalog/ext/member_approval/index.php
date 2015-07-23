<?php
/*
 * jQuery File Upload Plugin PHP Example 5.14
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Added OSC customer_id support, Cluster Solutions 2015.
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

chdir('../../');
require('includes/application_top.php');
require('ext/member_approval/UploadHandler.php');

class OscUploadHandler extends UploadHandler {
    private $key;
    private $email_address;
    function __construct($options = null, $initialize = true, $error_messages = null) {
        global $HTTP_POST_VARS;
        $this->key = isset($HTTP_POST_VARS['key']) ? $HTTP_POST_VARS['key'] : null;
        $this->email_address = isset($HTTP_POST_VARS['email_address']) ? $HTTP_POST_VARS['email_address'] : null;
        parent::__construct($options, $initialize, $error_messages);
    }
    protected function upcount_name_callback($matches) {
        $index = isset($matches[1]) ? ((int)$matches[1]) + 1 : 1;
        $ext = isset($matches[2]) ? $matches[2] : '';
        return '('.$index.')'.$ext;
    }
    protected function get_user_id() {
        return $_SESSION['id'] = $_SESSION['validation_key'];
    }
    protected function validate($uploaded_file, $file, $error, $index) {
        if (!$this->osc_chk_user()) {
            $file->error = $this->get_error_message('osc_chk_user');
            return false;
        }
        return parent::validate($uploaded_file, $file, $error, $index);
    }
    protected function osc_chk_user() {
        $check_customer_query = tep_db_query("select c.customers_id from customers c, member_approval ma where ma.validation_key = '" . $this->key . "' and c.customers_email_address = '" . $this->email_address . "' and c.customers_id = ma.customers_id");
        return (tep_db_num_rows($check_customer_query)) ? true : false;
    }
}
$upload_handler = new OSCUploadHandler(array('user_dirs' => true), true, array('osc_chk_user' => 'Invalid login email'));
?>
