=== Slack Notifications by dorzki ===
Contributors: dorzki
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=UYSJG8CB8YN2A
Tags: notifications, slack, realtime, updates
Requires at least: 4.5
Tested up to: 5.3
Stable tag: 2.0.7
Requires PHP: 5.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Get WordPress notifications to your team's Slack channel.

== Description ==

Light and customisable WordPress plugin to integrate your site with Slack.

Choose what type of notification you would like to receive:
* WordPress Update Available
* Plugins Updates Available
* Administrator Login
* Failed Administrator Login
* New User Registration
* New Comments
* Nee WooCommerce Orders
* WooCommerce Product with Low Stock
* And much more!

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

1. `Settings Screen` Configure Slack Integration settings, like WebHook url, desired channel, bot name and icon.
2. `Notifications Screen` Choose which notifications to get anf configure to which channel it will be sent.
3. `Slack Notifications - Part 1` Get notifications to you Slack channel.
4. `Slack Notifications - Part 2` Get notifications to you Slack channel.

== Changelog ==

= 2.0.7 =
* [HOTFIX] Fixed WooCommerce order not showing products.
* [FEATURE] Added Contact Form 7 integration.

= 2.0.6 =
* [HOTFIX] Fixed CPT notification being fired for unwanted CPT.

= 2.0.5 =
* [FEATURE] On post type update the user who updated will be displayed on the notification.

= 2.0.4 =
* [FEATURE] Added failed administrator login notification.
* [HOTFIX] Skip notification if a comment was marked as spam.
* [HOTFIX] Fixed typo on new note notification. (Thanks to [Music47ell](https://wordpress.org/support/users/music47ell/))
* [HOTFIX] Fixed wrong IP address when the server is behind load balancer.

= 2.0.3 =
* [HOTFIX] two factor collision.
* [FEATURE] Added new support page.

= 2.0.2 =
* [HOTFIX] Fixed issue with const no accepting return value. (Thanks to [Sven Wagener](https://wordpress.org/support/users/mahype/))
* [HOTFIX] Fixed issue with PHP 5.4. (Thanks to [Sven Wagener](https://wordpress.org/support/users/mahype/))
* [HOTFIX] Fixed text domain.

= 2.0.1 =
* [FEATURE] Added RTL support.
* [HOTFIX] Fixed issue with plugin doesn't update database.

= 2.0.0 =
* New version with new UI and better notification customization.
* Added actions and filters.
* Added native WooCommerce support.

= 1.0.12 =
* Fixed an issue when a CPT is being updated a notification of publication was fired, thanks to [nunas](https://wordpress.org/support/users/nanus/) for reporting.

= 1.0.11 =
* Fixed wrong parameters order on custom post type notification.

= 1.0.10 =
* Removed languages directory.
* Added the ability to post to several channels.

= 1.0.9 =
* Fixed issue with old PHP versions.

= 1.0.8 =
* Fixed broken plugins notification.

= 1.0.7 =
* Added future, pending and updated post notifications.
* Added future, pending and updated page notifications.
* Several plugin fixes.

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