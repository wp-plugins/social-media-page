<?php
if (!current_user_can('manage_options')) {
    wp_die( __('You do not have sufficient permissions to access this page.') );
}
?><h3>Social Media Page Update</h3><?php
if (isset($_GET['update']) && $_GET['update'] == 'updateprofiles') {
    // Act on actions.
    if (isset($_GET['update']) && $_GET['update'] == 'updateprofiles') {
        // check nonce referer
        check_admin_referer('social-media-page-plugin-update-profiles');
        $smpupdate = new SocialMediaPageUpdate();
        // Update profiles.csv file
        $fileUdate = $smpupdate->getProfileFileUpdate();
        if ($fileUdate === true) {
            echo '<div id="message" class="updated fade"><p><strong>CSV File Updated</strong></p></div>';
        } else {
            echo '<div id="error" class="updated fade"><p><strong>CSV File Update Failed!</strong></p>' . print_r($fileUdate, true) . '</div>';
        }
        // Update images
        $imageUpdate = $smpupdate->getProfileImagesUpdate();
        if ($imageUpdate === true) {
            echo '<div id="message" class="updated fade"><p><strong>Image Files Updated</strong></p></div>';
        } else {
            echo '<div id="error" class="updated fade"><p><strong>Image Files Update Failed!</strong></p>'.print_r($imageUpdate, true).'</div>';
        }
    }
}

$smp = new SocialMediaPage();

$smpupdate = new SocialMediaPageUpdate();

// run once every couple of days or so to check for updates to profiles
if ($smpupdate->timeForUpdate($smp->getSmpOption('smp_lastFileCheck'))) {
    $updatetime = $smpupdate->checkForUpdate();
    if ($updatetime !== false) {
        $options = array(
                'smp_updateFileStamp' => $updatetime,
                'smp_lastFileCheck' => time()
        );
        $smp->saveSmpOptions($options);
    }
}

if ($smp->getSmpOption('smp_updateFileStamp') > filemtime($file)) {
    echo '<p>Your current profiles file is out of date, you should run the
    update script to get the latest profile information.</p>';
}

// Get current profiles.csv file location
$file = $smpupdate->getProfilesCsvLocation();

echo '<p>The location of your profiles file: ' . $file . '</p>';

// If the file is ready to be updated print link to update aciton
$url = $_SERVER["REQUEST_URI"] . "&update=updateprofiles";
$action = "social_media_page_plugin_update_profiles";
$link = wp_nonce_url($url, $action);
echo "<p><a href='" . $link . "' title=\"Update profiles\">Force update of profiles CSV file and accociated image files.</a></p>";
