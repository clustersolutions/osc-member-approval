<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2015 osCommerce
  
  Author: Cluster Solutions

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  require(DIR_WS_LANGUAGES . $language . '/registration_upload.php');

  $error = true;

  if (isset($HTTP_GET_VARS['key']) && tep_not_null($HTTP_GET_VARS['key'])) {
    $validation_key = $HTTP_GET_VARS['key'];
    if (!tep_session_is_registered('validation_key')) tep_session_register('validation_key');
  }
  if (tep_session_is_registered('validation_key')) {
    $error = false;
  } else {
    $messageStack->add('registration_upload', TEXT_NO_KEY_LINK_FOUND);
  }

  if ($error == false) {

    if (strlen($validation_key) != 40) {
      $error = true;

      $messageStack->add('registration_upload', TEXT_NO_KEY_LINK_FOUND);
    } else {

      $check_customer_query = tep_db_query("select c.customers_id, c.customers_email_address, ma.validation_key, ma.validation_key_date from customers c, member_approval ma where ma.validation_key = '" . tep_db_input($validation_key) . "' and c.customers_id = ma.customers_id");

      $check_customer = tep_db_fetch_array($check_customer_query);

      if ( empty($check_customer['validation_key']) || (strtotime($check_customer['validation_key_date'] . ' + ' . MODULE_CONTENT_MEMBER_APPROVAL_LINK_DAY_EXPIRE . ' day') <= time()) ) {
        $error = true;

        $messageStack->add('registration_upload', TEXT_NO_KEY_LINK_FOUND);
      }
    }
  }

  $breadcrumb->add(NAVBAR_TITLE_1, tep_href_link(FILENAME_LOGIN, '', 'SSL'));
  $breadcrumb->add(NAVBAR_TITLE_2);

  require(DIR_WS_INCLUDES . 'template_top.php');
?>

<div class="page-header">
  <h1><?php echo HEADING_TITLE; ?></h1>
</div>

<?php
  if ($messageStack->size('registration_upload') > 0) {
    echo $messageStack->output('registration_upload');
  }
?>

  <div class="contentContainer">
<?php if (!$error) { ?>
    <blockquote>
        <?php echo TEXT_MAIN; ?>
    </blockquote>
    <!-- The file upload form used as target for the file upload widget -->
    <?php echo tep_draw_form('fileupload', tep_href_link('ext/member_approval', '', 'SSL'), 'post', 'id="fileupload" enctype="multipart/form-data"', false) . tep_draw_hidden_field('key', $validation_key); ?>
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class="row fileupload-buttonbar">
            <div class="col-lg-7">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Add files...</span>
                    <input type="file" name="files[]" multiple>
                </span>
                <!-- Button trigger modal -->
                <button id="modalBtn" type="button" class="btn btn-primary" data-toggle="" data-target="#myModal">
                  <i class="glyphicon glyphicon-upload"></i>
                  <span>Start upload</span>
                </button>

                <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Please verify your account email</h4>
                      </div>
                      <div class="modal-body">
                        <div class="form-group">
                          <?php echo tep_draw_input_field('email_address', NULL, 'id="inputEmail" placeholder="' . ENTRY_EMAIL_ADDRESS . '"', 'email'); ?>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-primary start">
                          <i class="glyphicon glyphicon-ok"></i>
                            <span>Continue</span>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <button type="reset" class="btn btn-warning cancel hidden">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel upload</span>
                </button>
                <!-- The global file processing state -->
                <span class="fileupload-process"></span>
            </div>
            <!-- The global progress state -->
            <div class="col-lg-5 fileupload-progress fade hide">
                <!-- The global progress bar -->
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                </div>
                <!-- The extended global progress state -->
                <div class="progress-extended">&nbsp;</div>
            </div>
        </div>
        <!-- The table listing the files available for upload/download -->
        <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
    </form>
    <!-- The blueimp Gallery widget -->
    <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
        <div class="slides"></div>
        <h3 class="title"></h3>
        <a class="prev">‹</a>
        <a class="next">›</a>
        <a class="close">×</a>
        <a class="play-pause"></a>
        <ol class="indicator"></ol>
    </div>
<?php } ?>
  </div> <!-- /container -->
<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
