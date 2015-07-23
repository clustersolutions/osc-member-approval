<div class="contentContainer <?php echo (MODULE_CONTENT_MEMBER_APPROVAL_CONTENT_WIDTH == 'Half') ? 'col-sm-6' : 'col-sm-12'; ?>">
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-info">
    <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" role="tab" id="headingOne">
      <h2 class="panel-title">
        <?php echo MODULE_CONTENT_MEMBER_APPROVAL_HEADING_RETURNING_CUSTOMER; ?>
      </h2>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body">
      <div class="contentText">
        <p><?php echo MODULE_CONTENT_MEMBER_APPROVAL_TEXT_RETURNING_CUSTOMER; ?></p>

        <?php echo tep_draw_form('login', tep_href_link(FILENAME_LOGIN, 'action=process_login', 'SSL'), 'post', '', true); ?>

          <div class="form-group">
            <?php echo tep_draw_input_field('email_address', NULL, 'autofocus="autofocus" required id="inputEmail" placeholder="' . ENTRY_EMAIL_ADDRESS . MODULE_CONTENT_MEMBER_APPROVAL_TEXT_REQUIRED . '"', 'email'); ?>
          </div>
          <div class="form-group">
          <?php echo tep_draw_password_field('password', NULL, 'required aria-required="true" id="inputPassword" placeholder="' . ENTRY_PASSWORD . MODULE_CONTENT_MEMBER_APPROVAL_TEXT_REQUIRED . '"'); ?>
          </div>
          <!-- anchor trigger modal -->
          <p><a href="#passwdReset" data-toggle="modal" data-target="#passwdReset"><?php echo MODULE_CONTENT_MEMBER_APPROVAL_TEXT_PASSWORD_FORGOTTEN; ?></a></p>
          <!-- Modal -->
          <div class="modal fade" id="passwdReset" tabindex="-1" role="dialog" aria-labelledby="passwdResetLabel">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-body">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <iframe src="password_forgotten.php" frameborder="0" height="100%" width="100%"></iframe>
                </div>
              </div>
            </div>
          </div>
          <p class="text-right"><?php echo tep_draw_button(IMAGE_BUTTON_LOGIN, 'glyphicon glyphicon-log-in', null, 'primary', NULL, 'btn-primary'); ?></p>
        </form>
      </div>
      </div>
    </div>
  </div>
  <div class="panel panel-success">
    <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" role="tab" id="headingTwo">
      <h2 class="panel-title">
          <?php echo MODULE_CONTENT_MEMBER_APPROVAL_HEADING_NEW_CUSTOMER; ?>
      </h2>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
      <div class="panel-body">
      <div class="contentText">
        <p><?php echo MODULE_CONTENT_MEMBER_APPROVAL_TEXT_NEW_CUSTOMER; ?></p>
        <?php echo tep_draw_form('create_account', tep_href_link(FILENAME_LOGIN, '', 'SSL'), 'post', 'class="form-horizontal"', true) . tep_draw_hidden_field('action', 'process_account'); ?>
  <h3><?php echo CATEGORY_PERSONAL; ?></h3>
  <div class="contentText">
<?php
  if (ACCOUNT_GENDER == 'true') {
?>
    <div class="form-group has-feedback">
      <label class="control-label col-sm-3"><?php echo ENTRY_GENDER; ?></label>
      <div class="col-sm-9">
        <label class="radio-inline">
          <?php echo tep_draw_radio_field('gender', 'm', NULL, 'required aria-required="true"') . ' ' . MALE; ?>
        </label>
        <label class="radio-inline">
          <?php echo tep_draw_radio_field('gender', 'f') . ' ' . FEMALE; ?>
        </label>
        <?php if (tep_not_null(ENTRY_GENDER_TEXT)) echo '<span class="help-block">' . ENTRY_GENDER_TEXT . '</span>'; ?>
      </div>
    </div>
<?php
  }
?>
        <div class="form-group has-feedback">
          <label for="inputFirstName" class="control-label col-sm-3"><?php echo ENTRY_FIRST_NAME; ?></label>
          <div class="col-sm-9">
            <?php
            echo tep_draw_input_field('firstname', NULL, 'required aria-required="true" id="inputFirstName" placeholder="' . ENTRY_FIRST_NAME . MODULE_CONTENT_MEMBER_APPROVAL_TEXT_REQUIRED . '"');
            if (tep_not_null(ENTRY_FIRST_NAME_TEXT)) echo '<span class="help-block">' . ENTRY_FIRST_NAME_TEXT . '</span>';
            ?>
          </div>
        </div>
        <div class="form-group has-feedback">
          <label for="inputLastName" class="control-label col-sm-3"><?php echo ENTRY_LAST_NAME; ?></label>
          <div class="col-sm-9">
            <?php
            echo tep_draw_input_field('lastname', NULL, 'required aria-required="true" id="inputLastName" placeholder="' . ENTRY_LAST_NAME . MODULE_CONTENT_MEMBER_APPROVAL_TEXT_REQUIRED . '"');
            if (tep_not_null(ENTRY_LAST_NAME_TEXT)) echo '<span class="help-block">' . ENTRY_LAST_NAME_TEXT . '</span>';
            ?>
          </div>
        </div>
<?php
  if (ACCOUNT_DOB == 'true') {
?>
    <div class="form-group has-feedback">
      <label for="dob" class="control-label col-sm-3"><?php echo ENTRY_DATE_OF_BIRTH; ?></label>
      <div class="col-sm-9">
        <?php
        echo tep_draw_input_field('dob', '', 'required aria-required="true" id="dob" placeholder="' . ENTRY_DATE_OF_BIRTH . MODULE_CONTENT_MEMBER_APPROVAL_TEXT_REQUIRED . '"');
        if (tep_not_null(ENTRY_DATE_OF_BIRTH_TEXT)) echo '<span class="help-block">' . ENTRY_DATE_OF_BIRTH_TEXT . '</span>';
        ?>
      </div>
    </div>
<?php
  }
?>
        <div class="form-group has-feedback">
          <label for="inputEmail" class="control-label col-sm-3"><?php echo ENTRY_EMAIL_ADDRESS; ?></label>
          <div class="col-sm-9">
            <?php
            echo tep_draw_input_field('email_address', NULL, 'required aria-required="true" id="inputEmail" placeholder="' . ENTRY_EMAIL_ADDRESS . MODULE_CONTENT_MEMBER_APPROVAL_TEXT_REQUIRED . '"');
            if (tep_not_null(ENTRY_EMAIL_ADDRESS_TEXT)) echo '<span class="help-block">' . ENTRY_EMAIL_ADDRESS_TEXT . '</span>';
            ?>
          </div>
        </div>
        <div class="form-group has-feedback">
          <label for="inputPassword" class="control-label col-sm-3"><?php echo ENTRY_PASSWORD; ?></label>
          <div class="col-sm-9">
            <?php
            echo tep_draw_password_field('password', NULL, 'required aria-required="true" id="inputPassword" placeholder="' . ENTRY_PASSWORD . MODULE_CONTENT_MEMBER_APPROVAL_TEXT_REQUIRED . '"');
            if (tep_not_null(ENTRY_PASSWORD_TEXT)) echo '<span class="help-block">' . ENTRY_PASSWORD_TEXT . '</span>';
            ?>
          </div>
        </div>
        <div class="form-group has-feedback">
          <label for="inputConfirmation" class="control-label col-sm-3"><?php echo ENTRY_PASSWORD_CONFIRMATION; ?></label>
          <div class="col-sm-9">
          <?php
            echo tep_draw_password_field('confirmation', NULL, 'required aria-required="true" id="inputConfirmation" placeholder="' . ENTRY_PASSWORD_CONFIRMATION . MODULE_CONTENT_MEMBER_APPROVAL_TEXT_REQUIRED . '"');
            if (tep_not_null(ENTRY_PASSWORD_CONFIRMATION_TEXT)) echo '<span class="help-block">' . ENTRY_PASSWORD_CONFIRMATION_TEXT . '</span>';
          ?>
          </div>
        </div>
        </div>
<!-- // BOF Anti Robot Registration v3.0-->
<?php
  if (ACCOUNT_VALIDATION == 'true' && strstr($PHP_SELF,'login') &&  ACCOUNT_CREATE_VALIDATION == 'true') {
?>
        <div class="form-group has-feedback">
          <div class="col-xs-9 col-md-6 pull-right">
            <?php include(DIR_WS_MODULES . FILENAME_DISPLAY_VALIDATION); ?>
          </div>
        </div>
<?php
  }
?>
<!-- // EOF Anti Robot Registration v3.0-->
<?php
  if (ACCOUNT_COMPANY == 'true') {
?>

  <h3><?php echo CATEGORY_CONTACT; ?></h3>

  <div class="contentText">
    <div class="form-group">
      <label for="inputCompany" class="control-label col-sm-3"><?php echo ENTRY_COMPANY; ?></label>
      <div class="col-sm-9">
        <?php
        echo tep_draw_input_field('company', NULL, 'id="inputCompany" placeholder="' . ENTRY_COMPANY . '"');
        if (tep_not_null(ENTRY_COMPANY_TEXT)) echo '<span class="help-block">' . ENTRY_COMPANY_TEXT . '</span>';
        ?>
      </div>
    </div>
  </div>

<?php
  }
?>
  <div class="contentText">
    <div class="form-group has-feedback">
      <label for="inputStreet" class="control-label col-sm-3"><?php echo ENTRY_STREET_ADDRESS; ?></label>
      <div class="col-sm-9">
        <?php
        echo tep_draw_input_field('street_address', NULL, 'required aria-required="true" id="inputStreet" placeholder="' . ENTRY_STREET_ADDRESS . MODULE_CONTENT_MEMBER_APPROVAL_TEXT_REQUIRED . '"');
        if (tep_not_null(ENTRY_STREET_ADDRESS_TEXT)) echo '<span class="help-block">' . ENTRY_STREET_ADDRESS_TEXT . '</span>';
        ?>
      </div>
    </div>

<?php
  if (ACCOUNT_SUBURB == 'true') {
?>
    <div class="form-group">
    <label for="inputSuburb" class="control-label col-sm-3"><?php echo ENTRY_SUBURB; ?></label>
      <div class="col-sm-9">
        <?php
        echo tep_draw_input_field('suburb', NULL, 'id="inputSuburb" placeholder="' . ENTRY_SUBURB . '"');
        if (tep_not_null(ENTRY_SUBURB_TEXT)) echo '<span class="help-block">' . ENTRY_SUBURB_TEXT . '</span>';
        ?>
      </div>
    </div>
<?php
  }
?>
    <div class="form-group has-feedback">
      <label for="inputCity" class="control-label col-sm-3"><?php echo ENTRY_CITY; ?></label>
      <div class="col-sm-9">
        <?php
        echo tep_draw_input_field('city', NULL, 'required aria-required="true" id="inputCity" placeholder="' . ENTRY_CITY. MODULE_CONTENT_MEMBER_APPROVAL_TEXT_REQUIRED . '"');
        if (tep_not_null(ENTRY_CITY_TEXT)) echo '<span class="help-block">' . ENTRY_CITY_TEXT . '</span>';
        ?>
      </div>
    </div>
<?php
  if (ACCOUNT_STATE == 'true') {
?>
    <div class="form-group has-feedback">
      <label for="inputState" class="control-label col-sm-3"><?php echo ENTRY_STATE; ?></label>
      <div class="col-sm-9">
        <?php
        if ($process == true) {
          if ($entry_state_has_zones == true) {
            $zones_array = array();
            $zones_query = tep_db_query("select zone_name from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country . "' order by zone_name");
            while ($zones_values = tep_db_fetch_array($zones_query)) {
              $zones_array[] = array('id' => $zones_values['zone_name'], 'text' => $zones_values['zone_name']);
            }
            echo tep_draw_pull_down_menu('state', $zones_array, 0, 'id="inputState"');
          } else {
            echo tep_draw_input_field('state', NULL, 'id="inputState" placeholder="' . ENTRY_STATE . '"');
          }
        } else {
          echo tep_draw_input_field('state', NULL, 'id="inputState" placeholder="' . ENTRY_STATE    . '"');
        }
        if (tep_not_null(ENTRY_STATE_TEXT)) echo '<span class="help-block">' . ENTRY_STATE_TEXT . '</span>';
        ?>
      </div>
    </div>
<?php
  }
?>
    <div class="form-group has-feedback">
      <label for="inputZip" class="control-label col-sm-3"><?php echo ENTRY_POST_CODE; ?></label>
      <div class="col-sm-9">
        <?php
        echo tep_draw_input_field('postcode', NULL, 'required aria-required="true" id="inputZip" placeholder="' . ENTRY_POST_CODE . MODULE_CONTENT_MEMBER_APPROVAL_TEXT_REQUIRED . '"');
        if (tep_not_null(ENTRY_POST_CODE_TEXT)) echo '<span class="help-block">' . ENTRY_POST_CODE_TEXT . '</span>';
        ?>
     </div>
    </div>
    <div class="form-group has-feedback">
      <label for="inputCountry" class="control-label col-sm-3"><?php echo ENTRY_COUNTRY; ?></label>
      <div class="col-sm-9">
        <?php
        echo tep_get_country_list('country', NULL, 'required aria-required="true" id="inputCountry"');
        if (tep_not_null(ENTRY_COUNTRY_TEXT)) echo '<span class="help-block">' . ENTRY_COUNTRY_TEXT . '</span>';
        ?>
      </div>
    </div>
    <div class="form-group has-feedback">
      <label for="inputTelephone" class="control-label col-sm-3"><?php echo ENTRY_TELEPHONE_NUMBER; ?></label>
      <div class="col-sm-9">
        <?php
        echo tep_draw_input_field('telephone', NULL, 'required aria-required="true" id="inputTelephone" placeholder="' . ENTRY_TELEPHONE_NUMBER . MODULE_CONTENT_MEMBER_APPROVAL_TEXT_REQUIRED . '"', 'tel');
        if (tep_not_null(ENTRY_TELEPHONE_NUMBER_TEXT)) echo '<span class="help-block">' . ENTRY_TELEPHONE_NUMBER_TEXT . '</span>';
        ?>
      </div>
    </div>
    <div class="form-group">
      <label for="inputFax" class="control-label col-sm-3"><?php echo ENTRY_FAX_NUMBER; ?></label>
      <div class="col-sm-9">
        <?php
        echo tep_draw_input_field('fax', '', 'id="inputFax" placeholder="' . ENTRY_FAX_NUMBER . '"', 'tel');
        if (tep_not_null(ENTRY_FAX_NUMBER_TEXT)) echo '<span class="help-block">' . ENTRY_FAX_NUMBER_TEXT . '</span>';
        ?>
      </div>
    </div>
    <div class="form-group">
      <label for="inputNewsletter" class="control-label col-sm-3"><?php echo ENTRY_NEWSLETTER; ?></label>
      <div class="col-sm-9">
        <div class="checkbox">
          <label>
            <?php echo tep_draw_checkbox_field('newsletter', '1', NULL, 'id="inputNewsletter"'); ?>
            <?php if (tep_not_null(ENTRY_NEWSLETTER_TEXT)) echo ENTRY_NEWSLETTER_TEXT; ?>
          </label>
        </div>
      </div>
    </div>
    </div>

        <p class="text-right"><?php echo tep_draw_button(IMAGE_BUTTON_CONTINUE, 'glyphicon glyphicon-user', null, 'primary'); ?></p>
        </form>
      </div>
      </div>
    </div>
  </div>
</div>
</div>
