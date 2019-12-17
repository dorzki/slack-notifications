
# Slack Notifications by [dorzki](https://www.dorzki.co.il)
Light and customisable WordPress plugin to integrate your site with Slack.

Choose what type of notification you would like to receive:
* WordPress Update Available
* Plugins Updates Available
* Administrator Login
* New User Registration
* New Comments
* Nee WooCommerce Orders
* WooCommerce Product with Low Stock
* And much more!

Download the plugin from [WordPress's plugins directory](https://he.wordpress.org/plugins/dorzki-notifications-to-slack/).

## Table of Contents
1. [Plugin Hooks](#plugin-hooks)
1. [Examples](#examples)
1. [Changelog](#changelog)
1. [Contributions](#contributions)
1. [Contact](#contact)

## Plugin Hooks
Soon.

## Examples
Soon.

## Changelog

| Version | Changes |
| :------ | :------ |
| 2.0.7 | [HOTFIX] Fixed WooCommerce order not showing products.<br>[FEATURE] Added Contact Form 7 integration. |
| 2.0.6 | [HOTFIX] Fixed CPT notification being fired for unwanted CPT. |
| 2.0.5 | [FEATURE] On post type update the user who updated will be displayed on the notification. |
| 2.0.4 | [FEATURE] Added failed administrator login notification.<br>[HOTFIX] Skip notification if a comment was marked as spam.<br>[HOTFIX] Fixed typo on new note notification. (Thanks to [Music47ell](https://wordpress.org/support/users/music47ell/))<br>[HOTFIX] Fixed wrong IP address when the server is behind load balancer. |
| 2.0.3 | [HOTFIX] two factor collision.<br>[FEATURE] Added new support page. |
| 2.0.2 | [HOTFIX] Fixed issue with const no accepting return value. (Thanks to [Sven Wagener](https://wordpress.org/support/users/mahype/))<br>[HOTFIX] Fixed issue with PHP 5.4. (Thanks to [Sven Wagener](https://wordpress.org/support/users/mahype/))<br>[HOTFIX] Fixed text domain.|
| 2.0.1 | [FEATURE] Added RTL support.<br>[HOTFIX] Fixed issue with plugin doesn't update database. |
| 2.0.0 | New version with new UI and better notification customization.<br>Added actions and filters.<br>Added native WooCommerce support. |
| 1.0.12 | Fixed an issue when a CPT is being updated a notification of publication was fired, thanks to [nunas](https://wordpress.org/support/users/nanus/) for reporting. |
| 1.0.11 | Fixed wrong parameters order on custom post type notification. |
| 1.0.10 | Removed languages directory. Added the ability to post to several channels. |
| 1.0.9 | Fixed issue with old PHP versions. |
| 1.0.8 | Fixed broken plugins notification. |
| 1.0.7 | Added future, pending and updated post notifications.<br>Added future, pending and updated page notifications. Several plugin fixes. |
| 1.0.6 | Fixed issue with image embed on WYSIWYG editor. |
| 1.0.5 | Changed text domain slug to plugin slug.<br>Added error notice if there is a problem with API.<br>Fixed notifications not firing because of value type.<br>Added test integration button.<br>Updated Hebrew translation files. |
| 1.0.4 | Fixed plugin text domain function.<br>Added Hebrew translation.<br>Plugin directory cleanup. |
| 1.0.3 | Fixed translation strings.<br>Added `.pot` file. |
| 1.0.2 | Fixed notices errors ( thanks to [LocalGhost-IL](https://profiles.wordpress.org/localghost-il) ).<br>Fixed issue when sometimes the slack notifies on new theme without version ( thanks to [yehudah](https://profiles.wordpress.org/yehudah) ).<br>Added support for Travis CI & PHPUnit ( thanks to [barzik](https://profiles.wordpress.org/barzik) ). |
| 1.0.1 | Now when a notification is generated, the website name & url will be appended at the end.<br>Added the ability to choose if and for which custom post type to enable notifications. |
| 1.0.0 | Hooray! First version! |

### Contributions
Soon.

### Contact
If you have any questions feel free to contact me at `webmaster[AT]dorzki.co.il`.