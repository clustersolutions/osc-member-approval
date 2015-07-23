<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2015 osCommerce
  
  Author: Cluster Solutions

  Released under the GNU General Public License
*/

  define('MODULE_CONTENT_MEMBER_APPROVAL_TITLE', 'Member Approval Registration');
  define('MODULE_CONTENT_MEMBER_APPROVAL_DESCRIPTION', 'Member Approval Registration for login page.');

  define('MODULE_CONTENT_MEMBER_APPROVAL_HEADING_NEW_CUSTOMER', 'Create An Account');
  define('MODULE_CONTENT_MEMBER_APPROVAL_TEXT_NEW_CUSTOMER', '');

  define('MODULE_CONTENT_MEMBER_APPROVAL_HEADING_RETURNING_CUSTOMER', 'Return Customer Login');
  define('MODULE_CONTENT_MEMBER_APPROVAL_TEXT_RETURNING_CUSTOMER', '');
  define('MODULE_CONTENT_MEMBER_APPROVAL_TEXT_PASSWORD_FORGOTTEN', 'Forgot Password?');
  define('MODULE_CONTENT_MEMBER_APPROVAL_TEXT_REQUIRED', '*');

  define('MODULE_CONTENT_MEMBER_APPROVAL_TEXT_LOGIN_ERROR', 'Oops...no match on E-Mail/Password.');

  define('EMAIL_SUBJECT', 'Welcome to ' . STORE_NAME);
  define('EMAIL_GREET_MR', 'Dear Mr. %s,' . "\n\n");
  define('EMAIL_GREET_MS', 'Dear Ms. %s,' . "\n\n");
  define('EMAIL_GREET_NONE', 'Dear %s' . "\n\n");
  define('EMAIL_WELCOME', 'Thank you for your interest in <strong>' . STORE_NAME . '</strong>.' . "\n\n");
  define('EMAIL_TEXT', 'Please follow this link to submit the required documents within the next 3 days to complete your registration:' . "\n\n" . '<a href="%s">%s</a>' . "\n\n" . 'You will receive a confirmation email once the registration process is completed.' . "\n\n");
  define('EMAIL_CONTACT', 'For help with any of our online services, please email us: ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n\n");
  define('EMAIL_WARNING', '<strong>Note:</strong> This email address was given to us by one of our customers. If you did not signup to be a member, please send an email to ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n");

?>
