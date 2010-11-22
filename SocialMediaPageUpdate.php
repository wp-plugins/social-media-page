<?php

/**
 * This file contains the SocialMediaPageUpdate class.
 *
 * @category Wordpress Plugin
 * @package  SocialMediaPage
 * @author   Philip Norton
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.hashbangcode.com/
 *
 */

/**
 * The SocialMediaPageUpdate class is used to control the update functions for the
 * Social Media Page plugin.
 *
 * @category Wordpress Plugin
 * @package  SocialMediaPage
 * @author   Philip Norton
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.hashbangcode.com/
 *
 */
class SocialMediaPageUpdate
{
	private $baseDir             = 'http://www.hashbangcode.com/api/social-media-page-plugin/';
	private $profilesCsvLocation;
	private $updateFile          = 'getfile.php';
	private $updateDate          = 'filedate.php';
	
	/**
     * Constructor
     *
     */
    public function __construct()
	{
		$this->profilesCsvLocation = WP_CONTENT_DIR . '/plugins/' . plugin_basename(dirname(__FILE__)) . '/profiles.csv';
	}

    /**
     *
     * @return <type>
     */
	public function getProfilesCsvLocation()
	{
		return $this->profilesCsvLocation;
	}

    /**
     *
     * @return <type>
     */
	public function checkForUpdate()
	{
		$update = wp_remote_get($this->baseDir . $this->updateDate);

        if ($update instanceof WP_Error) {
            return false;
        }

		if ($update['response']['code'] != 200) {
			return false;
		}
		
		if (strlen($update['body']) == 0) {
			return false;
		}
		
		return $update['body'];
	}

    /**
     *
     * @return WP_Error
     */
	public function getProfileFileUpdate()
	{
        $passkey = time();
		$update = wp_remote_get($this->baseDir . $this->updateFile . '?passkey=' . $passkey);

        if ($update instanceof WP_Error) {
            return $update;
        }

        if ($update['response']['code'] != 200) {
			return new WP_Error('broke', __("Server didn't give a 200 response."));
		}
		
		if (strlen($update['body']) == 0) {
			return new WP_Error('broke', __("Server didn't return any data."));
		}

        // check that the file actually is a csv file
        if (strpos($update['body'], md5($passkey)) === false) {
            return new WP_Error('broke', __("Site validation failed."));
        }
        
        $update['body'] = str_replace( md5($passkey), '', $update['body']);

		if (!$handle = fopen($this->profilesCsvLocation, 'w')) {
			return new WP_Error('broke', __("Couldn't open local CSV file."));
		}
		
		if (fwrite($handle, $update['body']) == FALSE) {
			return new WP_Error('broke', __("Coulsn't write to local CSV file."));
		}
        
        // Close local file.
        fclose($handle);

        // Everything went well, so return true.
		return true;
	}

    /**
     *
     * @return <type>
     */
    public function getProfileImagesUpdate()
    {
        if (file_exists($this->profilesCsvLocation)) {
            $handle = fopen($this->profilesCsvLocation, "r");

            $siteArray = array();
            $currentSection = '';

            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                $num = count($data);
                if ($num > 1) {
                    $siteArray[] = $data;
                }
            }
            fclose($handle);
        }

        if (count($siteArray) > 0) {
            foreach($siteArray as $site) {
                if (is_array($site)) {
                    // check that the string is a iamge file
                    $this->copyImage($site[3]);
                }
            }
        }
        return true;
    }

    /**
     *
     * @param <type> $imagefile
     * @return WP_Error
     */
    private function copyImage($imagefile)
    {
        // Image path.
        $smpimagepath = WP_CONTENT_DIR . '/plugins/' . plugin_basename(dirname(__FILE__)) . '/images/' . $imagefile;

		$imageFileContents = wp_remote_get($this->baseDir . '/images/' . $imagefile);

        if ($imageFileContents instanceof WP_Error) {
            return $imageFileContents;
        }

        if ($imageFileContents['response']['code'] != 200) {
			return new WP_Error('broke', __("Server didn't give a 200 response."));
		}
		
		if (strlen($imageFileContents['body']) == 0) {
			return new WP_Error('broke', __("Server didn't return any data."));
		}

        if (!$handle = fopen($smpimagepath, 'w')) {
			return new WP_Error('broke', __("Couldn't open local image file."));
		}

		if (fwrite($handle, $imageFileContents['body']) == FALSE) {
			return new WP_Error('broke', __("Coulsn't write to local image file."));
		}

        // Close local file
        fclose($handle);

        // Everything worked, so return true.
        return true;
    }

    /**
     *
     * @param <type> $lastFileCheck
     * @return <type> 
     */
    public function timeForUpdate($lastFileCheck)
    {
        $days = floor(abs(time()-$lastFileCheck) / 86400);

        if ($days > 3) {
            return true;
        }

        return true;
    }
}