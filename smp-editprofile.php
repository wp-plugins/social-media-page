<h2>Edit Profile.</h2>
<p>Enter your details</p>
<?php
$submittedSite = $_GET['site'];

$sql = "SELECT * FROM " . $wpdb->prefix . "socialmediaprofiles WHERE id = ".$wpdb->escape($submittedSite).";";

$profile = $wpdb->get_results($sql, ARRAY_A);
$profile = $profile[0];

$handle = fopen(WP_CONTENT_DIR . '/plugins/social-media-page/profiles.csv', "r");

while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
  if ($data[0] == $profile['site']) {
    $siteArray = $data;
  }
}
fclose($handle);

$pattern = '#' . str_replace(array('{username}','{userid}'),
          '(.*)',
          str_replace('?',
          '\?',
          $siteArray[2])
          ) .
          '#i';

preg_match($pattern, $profile['profileUrl'], $username);
$username = $username[1];
?>
<form method="post" action="<?php echo get_option('siteurl'); ?>/wp-admin/options-general.php?page=social-media-page/social-media-page.php" id="socialMediaPageProfile">
<?php
if (function_exists('wp_nonce_field')) {
	wp_nonce_field('social_media_page_plugin_update_site');
}
?>
<label for="profile">Enter your username for <?php echo $siteArray[0]; ?>.</label>
<input type="text" name="profile" value="<?php echo $username; ?>" id="profile" />
<p>Use the format <em id="profileTemplate"><?php echo $siteArray[2]; ?></em></p>
<p><span id="profileOutput"></span></p>
<label for="users">User</label>
<?php
if (current_user_can('manage_options')) {
    wp_dropdown_users('selected=' . $profile['user_login']);
} else {
    global $user_ID;
    wp_dropdown_users('selected=' . $profile['user_login'] . '&include=' . $user_ID);
}
?>
<p>This is the user that this profile will be used for.</p>
<label for="Keyword">Keyword (optional)</label>
<input type="text" name="keyword" id="keyword" value="<?php echo $profile['keyword']; ?>" />
<p>This keyword will override the global keyword.</p>
<input type="submit" name="smpUpdateProfile" value="Update Profile" id="smpUpdateProfile" />
<input type="hidden" name="id" value="<?php echo $profile['id']; ?>" />
<input type="hidden" name="site" value="<?php echo $siteArray[0]; ?>" />
<input type="hidden" name="url" value="<?php echo $siteArray[1]; ?>" />
<input type="hidden" name="logo" value="<?php echo $siteArray[3]; ?>" />
<input type="hidden" name="profileTemplate" value="<?php echo $siteArray[2]; ?>" />
</form>
    <script type="text/javascript">
      // <!--
	  jQuery('#profile').keyup(
        function(event){
          var userprofile = jQuery('#profile').val();
          var profile = "<?php echo $siteArray[2]; ?>".replace('{username}', userprofile);
          jQuery('#profileOutput').text(profile);
        }
      );
      jQuery('#profile').trigger('keyup');
		// -->
	</script>
<p>Thumbnail = <img src="<?php echo $smpimagepath . $siteArray[3]; ?>" alt="Profile Image" />.</p>