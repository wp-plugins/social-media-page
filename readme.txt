=== Social Media Page ===
Contributors: philipnorton42
Donate link: http://www.norton42.org.uk/
Tags: social media page,social media,social,media,page,profile,profiles
Requires at least: 2.6.3
Tested up to: 2.6.3
Stable tag: 1.1

The Social Media Page Wordpress plugin will add a list of links to your social media profiles on a page or post of your choice.

== Description ==

The Social Media Page Wordpress plugin will add a list of links to your social media profiles on a page or post of your choice through the use of a simple tag.

Rather than getting you to enter all of your social media profiles as URLs the plugin gets you to enter your username and works out the rest for you. Some exceptions (like Facebook) require some extra information, which has been accounted for.  There are over 100 different social media sites to select from so it should cover anything you happen to be a member of.

When the links are displayed on the page it will use a keyword of your choice as the text for the link.

With this plugin you can create a central base for any social media strategy.

== Installation ==

1. To install the plugin just drop the folder called social-media-page into your Wordpress plugins folder (located at wp-content/plugins/).
1. Log into Wordpress and go to your Plugins section and activate the social media page plugin.
1. Go to the admin page, located in Settings->Social Media Page, and enter your keyword.
1. Enter your username or userID for the profiles you want to display.
1. Click Update Profiles
1. Add the tag <!-- social-media-page --> to a page or post of your choice to display the list.

When the plugin is activated for the first time it checks to see if a table exists called wp_socialmediaprofiles. If it doesn't then it creates it and adds the social media sites that will be used by the plugin.

The plugin also creates a Wordpress option called smp_keyword.  This option is used to store the keyword that will be used to link to the profiles entered.

== Screenshots ==

1. The Social Media Page plugin administration section.
2. Example output of the Social Media Page Plugin.

== Frequently Asked Questions ==
= How to I delete a profile from the list? =

Go into the social media page administration section, remove the username from the appropriate box and click update.  Any profiles with no text in them will not be shown on the front of the site.
