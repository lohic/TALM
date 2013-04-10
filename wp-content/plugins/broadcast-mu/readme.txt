=== Broadcast MU ===
Contributors: unknowndomain
Donate link: http://donate.cancerresearchuk.org/donate
Tags: post, broadcast, crosspost, cross post, multipost, multicast, wpms, ms, multisite, blogs
Requires at least: 3.4
Tested up to: 3.5
Stable tag: 2.0
License: GPLv3

Broadcast MU is a plugin for WordPress which allows you to broadcast a post to one or more other blogs on the same installation of WordPress.

== Description ==

Broadcast MU is a plugin for WordPress which allows you to broadcast a post to one or more other blogs on the same installation of WordPress by simply checking the box next to those you wish to send it to.

You can enable this plugin on individual blogs or site wide.

This plugin is for WordPress Multisite installations only because regular WordPress only supports having one blog anyway.

Image credit: [Steve Harris]

[Steve Harris]: http://www.flickr.com/photos/steveharris/1361908299/

== Installation ==

1. Upload `broadcast-mu.php` to the `/wp-content/plugins/` directory.

2. Activate the plugin through the Network `Plugins` menu in WordPress.

3. Create a new post from the `New Post` menu in WordPress and tick the blogs you want from the `Broadcast` box.

== Frequently Asked Questions ==

= Why can I only see some of the blogs on the site? =
This is because Broadcast MU only allows you to post to blogs which you have access to publish on.

= Can I choose on which blogs my post will display? =
Yes, simply click the blogs you want when posting in WordPress.

= Can I modify or delete a post from all blogs simultaneously? =
No, once broadcasted they cannot be modified or deleted simultaneously however you can still go and change them manually.

== Screenshots ==

1. New post screen with the Broadcast MU meta box.
2. Close up of the Broadcast MU meta box.

== Changelog ==

= 2.0 =
* Complete rewrite
* Looses Rebroadcast feature
* Now supports categories, tags and post formats.

= 1.1.1 =
* Fixes a known issue where some installations of PHP do not allow short tags such as <? and <?= these have been substituted with <?php and <?php echo respectively.

= 1.1 =
* Adds a Re-Broadcast feature, so if you want to broadcast something after the original post was made you can just edit the post, select the blogs you want to Re-Broadcast to and then press update and then as well as the original post having its content updated if it was changed the other blogs will also receive the post (with its up-to-date content).

= 1.0.3 =
* Fixes incompatibility with the Domain Mapping plugin (was not printing the name of the blog).

= 1.0.2 =
* Fixes duplicate posting problem again - it really works this time, honest!

= 1.0.1 =
* Fixes duplicate posting problem and also a php typo.

= 1.0 =
* Initial release.

== Donate ==

Please donate whatever you can afford to Cancer Research UK, their work has saved literally thousands of lives and together we can beat cancer.

Thanks to Cancer Research UK and the NHS because without their help my families story could be a whole lot different right now.

If you want to show thanks for the work I have done making this plugin then  please donate.

Thanks.

== Upgrade Notice ==

= 2.0 =
This version of Broadcast MU is a total rewrite, it now includes support for categories, tags and post formats, but removes support for rebroadcasting.