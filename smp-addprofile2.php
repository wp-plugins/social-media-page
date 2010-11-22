<h2>Add Profile.</h2>

<p>Enter your details</p>
<?php
$submittedSite = $_GET['site'];
$handle = fopen(WP_CONTENT_DIR . '/plugins/social-media-page/profiles.csv', "r");

while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
  if ( $data[0] == $submittedSite ) {
    $siteArray = $data;
  }
}
fclose($handle);
?>
<form method="post" action="<?php echo get_option('siteurl'); ?>/wp-admin/options-general.php?page=social-media-page/social-media-page.php" id="socialMediaPageProfile">
<?php
if (function_exists('wp_nonce_field')) {
	wp_nonce_field('social_media_page_plugin_add_site');
}
?>
<label for="profile">Enter your username for <?php echo $siteArray[0]; ?>.</label>
<input type="text" name="profile" value="" id="profile" />
<p>Use the format <em id="profileTemplate"><?php echo $siteArray[2]; ?></em></p>
<p><span id="profileOutput"></span></p>
<label for="users">User</label>
<?php
if (current_user_can('manage_options')) {
    wp_dropdown_users();
} else {
    global $user_ID;
    wp_dropdown_users("include=" . $user_ID);
}
?>
<p>This is the user that this profile will be used for.</p>
<label for="Keyword">Keyword (optional)</label>
<input type="text" name="keyword" id="keyword" />
<p>This keyword will override the global keyword.</p>
<input type="submit" name="smpSaveProfile" value="Save Profile" id="smpSaveProfile" />
<input type="hidden" name="site" value="<?php echo $siteArray[0]; ?>" />
<input type="hidden" name="url" value="<?php echo $siteArray[1]; ?>" />
<input type="hidden" name="logo" value="<?php echo $siteArray[3]; ?>" />
<input type="hidden" name="profileTemplate" value="<?php echo $siteArray[2]; ?>" />
</form>
    <script type="text/javascript">
		//<!--
      jQuery('#profile').keyup(
        function(event){
          var userprofile = jQuery('#profile').val();
          var profile = "<?php echo $siteArray[2]; ?>".replace('{username}', userprofile);
          jQuery('#profileOutput').text(profile);
        }
      );
	  // -->
    </script>
<p>Thumbnail = <img src="<?php echo $smpimagepath . $siteArray[3]; ?>" alt="Profile Image" />.</p>