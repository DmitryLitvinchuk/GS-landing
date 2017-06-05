<?php

/**
 * Look for the server path to the file wp-load.php for user authentication
 */

$wp_include = "../wp-load.php";
$i = 0;
while (!file_exists($wp_include) && $i++ < 10) {
  $wp_include = "../$wp_include";
}
require($wp_include);

/* Check user premissions */
if (!is_user_logged_in() || !current_user_can('edit_posts')) 
	wp_die(__('You are not allowed to be here', SPECTRA_PLUGIN));
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Shortcodes Manager</title>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_option('blog_charset'); ?>" />
<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/jquery/jquery.js"></script>
<script language="javascript" type="text/javascript" src="<?php plugin_dir_url( __FILE__ ) ?>shortcodes_manager.js"></script>
<style type="text/css" media="screen">
table { font-size: 12px; }
.r-sm-help { font-size:10px; color:#aaa; }
td { color:#666; }
input, select, textarea {border: 1px solid #ccc;background: #fcfcfc;padding: 2px; border-radius:2px; color:#333; }
label { font-size: 12px; }
.tabs {
  height: 22px;
}
.tabs li {
  background-color: #444;
  border-color: #444;
  margin: 0 2px 0 0;
  padding: 0 0 0 10px;
  line-height: 22px;
  height: 21px;
  display: block;
}
.tabs a:link, .tabs a:visited, .tabs a:hover {
  color: white;
}
.tabs .current a:link, .tabs .current a:visited, .tabs .current a:hover {
  color: #444;
}
.tabs li.current {
  background-color: transparent;
  border-color: #aaa;
  border-bottom: 1px solid #fff;
}
</style>

<base target="_self" />
</head>
<body id="link" onLoad="tinyMCEPopup.executeOnLoad('init();');document.body.style.display=''">
<!-- <form onsubmit="insertLink();return false;" action="#"> -->
<form name="shortcodes" action="#">
  <div class="tabs">
    <ul>
      <li id="shortcodes_tab" class="current"><span><a href="javascript:mcTabs.displayTab('shortcodes_tab','shortcodes_panel');" onMouseDown="return false;">Shortcodes</a></span></li>
      <li id="audio_tab"><span><a href="javascript:mcTabs.displayTab('audio_tab','audio_panel');" onMouseDown="return false;">Audio Tracks</a></span></li>
  </div>
  <div class="panel_wrapper" style="height:auto;">

    <!-- shortcodes panel -->
    <div id="shortcodes_panel" class="panel current" style="height:300px;"> <br />
      <fieldset>
        <legend>Select the Style Shortcode you would like to insert into the post</legend>
        <table border="0" cellpadding="4" cellspacing="0">
          <tr>
            <td nowrap="nowrap"><label for="shortcode">Select a shortcode:</label></td>
            <td><select id="shortcode" name="shortcode" style="width: 200px" >
                <option value="0"></option>
                <optgroup label="Columns">
                  <option value="row">Row</option>
                  <option value="2_columns">2 Columns</option>
                  <option value="3_columns">3 Columns</option>
                  <option value="4_columns">4 Columns</option>
                  <option value="2_3_1_3_columns">2/3 Column + 1/3 Column</option>
                  <option value="1_3_2_3_columns">1/3 Column + 2/3 Column</option>
                  <option value="3_4_1_4_columns">3/4 Column + 1/4 Column</option>
                  <option value="1_4_3_4_columns">1/4 Column + 3/4 Column</option>
                </optgroup>
                <optgroup label="Intro">
                  <option value="intro_ticker">Intro Ticker</option>
                </optgroup>
                <optgroup label="Typography">
                  <option value="heading_xl">Heading XL</option>
                  <option value="heading_l">Heading L</option>
                  <option value="heading_m">Heading M</option>
                  <option value="subheading">Subheading</option>
                  <option value="subheading_top">Subheading Top</option>
                </optgroup>
                 <optgroup label="Divider">
                  <option value="divider">Divider</option>
                </optgroup>
              </select></td>
          </tr>
        </table>
      </fieldset>
    </div>
    <!-- /shortcodes panel -->

    <!-- audio panel -->
    <div id="audio_panel" class="panel" style="height:300px;"> <br />
      <fieldset>
        <legend>Audio Tracks</legend>
        <table border="0" cellpadding="4" cellspacing="0">
          <!-- ID -->
          <tr>
            <td nowrap="nowrap"><label for="tracks_id">Tracks:</label></td>
            <?php
                $args = array(
                  'post_type' => 'spectra_tracks',
                  'meta_key' => '_audio_tracks',
                  'showposts'=> '-1'
                );
                $tracks_query = new WP_Query();
                $tracks_query->query($args);
            ?>
            <td colspan="3">
            <?php if ($tracks_query->have_posts()) : ?>
              <select name="tracks_id" id="tracks_id">
              <?php while ($tracks_query->have_posts()) : $tracks_query->the_post(); ?>
                <option value="<?php the_ID(); ?>"><?php the_title(); ?></option>
              <?php endwhile; ?>
              </select>
            <?php else : ?>
              <span style="color:red;">There are no tracks available.</span>
            <?php endif; ?>
            </td>
          </tr>
          <!-- Type -->
          <tr>
            <td nowrap="nowrap" style="width:120px"><label for="player_type">Player type:</label></td>
            <td colspan="3">
              <select name="player_type" id="player_type" data-main-group="r-main-group-type" class="r-meta-group">
                <option value="single_player" selected="selected">Single player</option>
                <option value="tracklist">Tracklist</option>
              </select>
            </td>
          </tr>
          <tr>
            <td nowrap="nowrap" ></td>
            <td colspan="3"><span class="r-sm-help">Please note "Single player" display only one track, the first on the playlist.</span></td>
          </tr>
        </table>
      </fieldset>
    </div>
    <!-- /audio panel -->
    
  </div>
  <div class="mceActionPanel">
    <div style="float: left">
      <input type="button" id="cancel" name="cancel" value="<?php _e('Cancel', SPECTRA_PLUGIN); ?>" onClick="tinyMCEPopup.close();" />
    </div>
    <div style="float: right">
      <input type="submit" id="insert" name="insert" value="<?php _e('Insert', SPECTRA_PLUGIN); ?>" onClick="insert_shortcode();" />
    </div>
  </div>
</form>
</body>
</html>
