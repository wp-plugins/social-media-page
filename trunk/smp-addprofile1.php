<h2>Select the social media profile to load.</h2>

<?php
$file = WP_CONTENT_DIR . '/plugins/social-media-page/profiles.csv';
if (file_exists($file)) {
	$handle = fopen($file, "r");

	$siteArray = array();
	$currentSection = '';

	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		$num = count($data);
		if ($num == 1) {
			$siteArray[$data[0]] = array();
			$currentSection      = $data[0];
		} else {
			$siteArray[$currentSection][] = $data;
		}
	}
	fclose($handle);

    $url = $_SERVER["REQUEST_URI"]. "&action=add2";
    $action = "social_media_page_plugin_add_profile2";
    $link = wp_nonce_url($url, $action);

	foreach ($siteArray as $category => $site) {
	  if (is_array($site)) {
		echo '<p>' . $category . '</p><ul>';
		foreach ($site as $data) {
		  echo '<li><a style="padding:0 0 0 25px;background:#ffffff url(' . $smpimagepath . $data[3] . ') no-repeat top left;" 
				class="addProfile" 
				href="' . $link . '&amp;site=' . $data[0] . '"
				title="Add ' . $data[0] . '">' . $data[0] . '</a></li>';
		}
		echo '</ul>';
	  }
	}
} else {
	echo '<p>The profiles file cannot be found. Try downloading it again.</p>';
}
?>
    <script type="text/javascript">
    // <!--
	initAddProfileWindow();
    // -->
	</script>