=== Slack Notifications by dorzki ===
Contributors: dorzki
Tags: notifications, slack
Requires at least: 4.3
Tested up to: 4.4.2
Stable tag: 1.0.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Get WordPress notifications to your team's Slack channel.

== Description ==

A light and essential plugin that notifies you via Slack API to your Slack channel on the following:

* New WordPress Version.
* New Plugins Updates.
* Post Published.
* New User Registration.
* Admin Login Detected.
* And more!
 
The plugin will be bring new notifications options on every update.

You can contribute by simple [Forking me on GitHub](https://github.com/dorzki/Slack-Notifications).

== Installation ==

Install the plugin by:

1. Upload `dorzki-notifications-to-slack` directory to the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Go to `Settings -> Slack Notifications Integration` page and setup integration and select desired notifications.

== Frequently Asked Questions ==

= What is Slack? =

Slack is an awesome team collaboration tool which is free and has a lot of API integrations to popular services.

= Does the plugin disable email notification? =

Not at the moment, in future version there will be an option to disable them.

= What about more notification options? =

In future versions we will add integration to popular plugins.

= I need help / i want to suggest something =

Please feel free to contact me `webmaster[AT]dorzki.co.il`

== Screenshots ==

1. `Settings Screen - Part 1` Configure Slack Integration settings, like WebHook url, desired channel, bot name and icon.
2. `Settings Screen - Part 2` Choose which notifications to get.

== Changelog ==

= 1.0.6 =
* Fixed issue with image embed on WYSIWYG editor.

= 1.0.5 =
* Changed text domain slug to plugin slug.
* Added error notice if there is a problem with API.
* Fixed notifications not firing because of value type.
* Added test integration button.
* Updated Hebrew translation files.

= 1.0.4 =
* Fixed plugin text domain function.
* Added Hebrew translation.
* Plugin directory cleanup.

= 1.0.3 =
* Fixed translation strings.
* Added `.pot` file.

= 1.0.2 =
* Fixed notices errors ( thanks to [LocalGhost-IL](https://profiles.wordpress.org/localghost-il) ).
* Fixed issue when sometimes the slack notifies on new theme without version ( thanks to [yehudah](https://profiles.wordpress.org/yehudah) ).
* Added support for Travis CI & PHPUnit ( thanks to [barzik](https://profiles.wordpress.org/barzik) ).

= 1.0.1 =
* Now when a notification is generated, the website name & url will be appended at the end.
* Added the ability to choose if and for which custom post type to enable notifications.

= 1.0.0 =
* Hooray! First version!