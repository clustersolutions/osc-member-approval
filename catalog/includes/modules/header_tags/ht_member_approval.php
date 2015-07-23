<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2015 osCommerce

  Author: Cluster Solutions

  Released under the GNU General Public License
*/

  class ht_member_approval {
    var $code = 'ht_member_approval';
    var $group;
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function ht_member_approval() {
      $this->title = MODULE_HEADER_TAGS_MEMBER_APPROVAL_TITLE;
      $this->description = MODULE_HEADER_TAGS_MEMBER_APPROVAL_DESCRIPTION;

      if ( defined('MODULE_HEADER_TAGS_MEMBER_APPROVAL_STATUS') ) {
        $this->sort_order = MODULE_HEADER_TAGS_MEMBER_APPROVAL_SORT_ORDER;
        $this->enabled = (MODULE_HEADER_TAGS_MEMBER_APPROVAL_STATUS == 'True');
      }
    }

    function execute() {
      global $PHP_SELF, $oscTemplate;
      //Clean up password_forgotten.php for modal/colorbox.
      if (basename($PHP_SELF) === 'password_forgotten.php') {
$output = <<<EOD
<script>$(window).load(function(){if(inIframe()){ $('nav').hide();$('.modular-header').hide();$('a#btn1').hide();$('#columnLeft').hide();$('#columnRight').hide();$('footer').hide(); }});function inIframe(){try{return window.self!==window.top;}catch(e){return true;}}</script>
EOD;
        $oscTemplate->addBlock($output, 'footer_scripts');
      //CSS & jQuery needed for upload widget.
      } elseif (basename($PHP_SELF) === 'registration_upload.php') {
$output = <<<EOD
<!-- blueimp Gallery styles -->
<link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="ext/member_approval/css/jquery.fileupload.css">
<link rel="stylesheet" href="ext/member_approval/css/jquery.fileupload-ui.css">
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript><link rel="stylesheet" href="ext/member_approval/css/jquery.fileupload-noscript.css"></noscript>
<noscript><link rel="stylesheet" href="ext/member_approval/css/jquery.fileupload-ui-noscript.css"></noscript>
EOD;
        $oscTemplate->addBlock($output, 'header_tags');
$output = <<<EOD
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td style="vertical-align: middle;">
            {% if (!i && !o.options.autoUpload) { %}
                <button class="btn btn-primary start hidden" disabled>
                    <i class="glyphicon glyphicon-upload"></i>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-warning btn-xs cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                </button>
            {% } %}
        </td>
        <td>
            <span class="preview"></span>
        </td>
        <td style="vertical-align: middle;">
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
        </td>
        <td style="vertical-align: middle;">
            <p class="size">Processing...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
        </td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td style="vertical-align: middle;">
            {% if (file.deleteUrl) { %}
                <button class="btn btn-danger btn-xs delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="glyphicon glyphicon-remove"></i>
                </button>
            {% } else { %}
                <button class="btn btn-warning btn-xs cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                </button>
            {% } %}
        </td>
        <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td style="vertical-align: middle;">
            <p class="name">
                {% if (file.url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                {% } else { %}
                    <span>{%=file.name%}</span>
                {% } %}
            </p>
            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td style="vertical-align: middle;">
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
    </tr>
{% } %}
</script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="ext/member_approval/js/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="ext/member_approval/js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="ext/member_approval/js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="ext/member_approval/js/canvas-to-blob.min.js"></script>
<!-- blueimp Gallery script -->
<script src="ext/member_approval/js/jquery.blueimp-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="ext/member_approval/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="ext/member_approval/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="ext/member_approval/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="ext/member_approval/js/jquery.fileupload-image.js"></script>
<!-- The File Upload validation plugin -->
<script src="ext/member_approval/js/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="ext/member_approval/js/jquery.fileupload-ui.js"></script>
<!-- The main application script -->
<script src="ext/member_approval/js/main.js"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="ext/member_approval/js/jquery.xdr-transport.js"></script>
<![endif]-->
EOD;
        $oscTemplate->addBlock($output, 'footer_scripts');
      }
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_HEADER_TAGS_MEMBER_APPROVAL_STATUS');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Member Approval CSS & jQuery Scripts Module', 'MODULE_HEADER_TAGS_MEMBER_APPROVAL_STATUS', 'True', 'Do you want to enable the Member Approval css & jQuery module?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_HEADER_TAGS_MEMBER_APPROVAL_SORT_ORDER', '2000', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_HEADER_TAGS_MEMBER_APPROVAL_STATUS', 'MODULE_HEADER_TAGS_MEMBER_APPROVAL_SORT_ORDER');
    }

  }
?>
