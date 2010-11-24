=== Social Media Page ===
Contributors: philipnorton42
Donate link: http://www.hashbangcode.com/
Tags: social media page,social media,social,media,page,profile,profiles
Requires at least: 2.6.3
Tested up to: 3.0
Stable tag: 2.2

The Social Media Page Wordpress plugin will add a list of links to your social media profiles on a page or post of your choice.

== Description ==

The Social Media Page Wordpress plugin will add a list of links to your social media profiles on a page or post of your choice through the use of a simple tag.  A widget is also added so that you can display this list of links in the side menu of the site.

Rather than getting you to enter all of your social media profiles as URLs the plugin gets you to enter your username and works out the rest for you. Some exceptions (like Facebook) require some extra information, which has been accounted for.  There are over 100 different social media sites to select from so it should cover anything you happen to be a member of.

When the links are displayed on the page it will use a keyword of your choice as the text for the link.

With this plugin you can create a central base for any social media strategy.

= New in version 2.2 =
1. Bug fixes.

= New in version 2.1 =
1. Bug fixes.

= New in version 2.0 =
1. Sites are no longer linked to the plugin, they are stored and downloaded separately so that new versions don't have to be release in order to add sites.
2. Profiles can be added for different users.
3. Any user with the privilege to do so can edit their own profiles. Administrators can edit all profiles belonging to all users.
4. Added the ability to open the links in a new window.
5. Each profile can now be given it's own keyword. This will override the global keyword.
6. Plugin archetechture overhall.

= Changes in version 1.7 =
1. Fixed Blip.tv account details.
2. Added 12seconds to profile list.
3. Added personal Facebook Profile page URL to profile list.
4. Added LibraryThing to profile list.
5. Added Hyves to profile list.
6. Added Behance to profile list.
7. Added ClaimID to profile list.
8. Updated Identica logo.

= Changes in version 1.6 =
1. Fixed bug that overrides the title of other pages within Wordpress.
2. Fixed bug that causes JavaScript to break in the admin section.
3. Added LinkedIn Company profile page to profile list.
4. Added imeem to profile list.

= Changes in version 1.5 =
1. Added Blip.fm to profile list.
2. Added Blip.tv to profile list.
3. Added Microsoft Live to profile list.
4. Added WAYN to profile list.
5. Added Facebook Group link to profile list.
6. Added Facebook Page link to profile list.

= Changes in version 1.4 =

1. Removed the now closed Pownce from profile list.
2. Added custom header for Widget.
3. Fixed bug in a regular expression in site admin.
4. Fixed bug that caused the ordering of sites not to be saved.
5. Added profile name, site url, site name, random and custom sort order as sorting options.
6. Added Hi5 to profile list.
7. Added ohloh to profile list.
8. Added deviantArt to profile list.
9. Split help out into a separate page and expanded.

= Changes in version 1.3 =

1. Added a fix for a typo in the Friendfeed profile.
2. Added an option to add rel="nofollow" to the links created by this plugin.
3. Tidied up widget code to incorporate widget options from theme.

= Changes in version 1.2 =

1. This plugin can now be used as a widget.
2. Plugin output tweaked to have normal output for pages and smaller output when printing widget.
3. Added option to allow blog admin to decide if credit should be given to plugin author.
4. Noticed bug when updating plugin due to file permissions. Added a function that sets file permissions properly at install.

== Installation ==

1. To install the plugin just drop the folder called social-media-page into your Wordpress plugins folder (located at wp-content/plugins/).
2. Log into Wordpress and go to your Plugins section and activate the social media page plugin.
3. Go to the admin page, located in the Social Media menu item, and enter your keyword.
4. Enter your username or userID for the profiles you want to display.
5. Click Update Profiles
6. Add the tag <!-- social-media-page --> to a page or post of your choice to display the list. You can also use <!-- social-media-page1 --> to print out all profiles for the user with the ID of 1.

When the plugin is activated for the first time it checks to see if a table exists called wp_socialmediaprofiles. If it doesn't then it creates it and adds the social media sites that will be used by the plugin.

The plugin also creates a Wordpress option called smp_keyword.  This option is used to store the keyword that will be used to link to the profiles entered.

== Screenshots ==

1. The Social Media Page plugin administration section.
2. Example output of the Social Media Page Plugin.

== Frequently Asked Questions ==
= How do I delete a profile from the list? =

Click delete on the profile you want to delete from the admin section.

= How do I get a site added to the list? =
Go to #! code (www.hashbangcode.com) and either leave a message in the forum or use the contact form.

= How can I use the list in my template? =
Use the smp_print_list() function to print out the profile list or smp_print_list($user_id) to print out the list for a given user.
