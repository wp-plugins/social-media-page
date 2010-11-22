<?php
    if (!current_user_can('edit_posts'))  {
        wp_die( __('You do not have sufficient permissions to access this page.') );
    }
?><h3>Social Media Page Plugin</h3>
<h4>Creating A Social Media Page</h4>
<p>To add this to your site fill out some profile information using the form
below and put the following to a page or post:<br />
<pre>&lt;!-- social-media-page --&gt;</pre>
<p>Make sure you are in HTML mode as the visual editor will display that text on
your site and not the intended content.  If you find that the plugin is giving
invalid HTML then make sure that there is a single blank linke before and
after this tag.</p>

<h4>Social Media Widget</h4>
<p>You can also use the Social Media Page Plugin Widget to display this information in your sidebar. Just go to the Widgets section in the Appearance menu and add in the widget.</p>
<p>The default title of the widget is <strong>Social Media</strong>, but you can change this on the setup page of the plugin.</p>

<h4>Facebook</h4>
<p>The two bits of information that you need to create your Facebook link are your name and your User ID. Your User ID is nice an easy to find, just go to your profile page and pick out the id number in the URL. The bold bit in the example below.</p>

<pre>http://www.facebook.com/profile.php?id=<strong>123456789</strong>&ref=profile</pre>

<p>Your name is exactly as it sounds. Just take your name and replace every space with a &quot;-&quot;, so if your name is &quot;Joe Bloggs&quot; then you need to type in &quot;Joe-Bloggs&quot;</p>

<p>Hi5 works in much the same was as this.</p>

<h4>Sort Order</h4>
<p>There are 4 different ways in which you can change the output order of the sites. These are profile name, site url, site name, random and custom sort order, the default being the custom sort order.</p>

<p>NOTE: If you change the sort order mode you will lose any custom sorting you have done!</p>

<h4>Output style</h4>
<p>You can select between two different output styles. The first is the default list of profiles and the second is a simple group of images.</p>

<h4>Updating</h4>
<p>When updating to a new version of the plugin you can either use the Wordpress built in updater or upload the files manually. However, if you upload the files manually you <strong>MUST</strong> deactivate and reactive the plugin in order to properly update the plugin.</p>
                                                     
<h4>More Information</h4>
<p>For more informaiton about this plugin, or to report bugs and suggestions go
to <a href="http://www.norton42.org.uk/294-social-media-page-plugin-for-wordpress.html" title="Social media page plugin">social media page plugin</a> page at <a href="http://www.norton42.org.uk/" title="www.norton42.org.uk">www.norton42.org.uk</a>.</p>

<h4>Bugs, Commends and Suggestions</h4>
<p>If you find any bugs or have an idea on how to improve the plugin then please either leave a comment on the <a href="http://www.norton42.org.uk/294-social-media-page-plugin-for-wordpress.html" title="Social media page plugin">Social media page plugin</a> post or use the contact form at <a href="http://www.norton42.org.uk/contact-me" title="Contact Philip Norton">http://www.norton42.org.uk/contact-me</a>.</p>
<p>However, please note that I maintain this plugin during my spare time and umongst other projects that I am also involved in so I can't guarantee that I will look at any problems straight away.</p>

<h4>Donate!</h4>
<p>If you like this plugin then you can help with development through a donation.</p>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick"/>
<input type="hidden" name="hosted_button_id" value="1181252"/>
<input type="image" src="https://www.paypal.com/en_GB/i/btn/btn_donate_LG.gif" border="0" name="submit" alt=""/>
<img alt="" border="0" src="https://www.paypal.com/en_GB/i/scr/pixel.gif" width="1" height="1"/><br />
</form>
