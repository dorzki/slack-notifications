<?php
/**
 * Notifications class
 *
 * @package   Slack Notifications
 * @since     1.0.0
 * @version   1.0.5
 * @author    Dor Zuberi <me@dorzki.co.il>
 * @link      https://www.dorzki.co.il
 */

if ( ! class_exists( 'WPNotifications' ) ) {

	/**
	 * Class WPNotifications
	 */
	class WPNotifications {

		/**
		 * Slack class handler.
		 *
		 * @var 	  SlackBot
		 * @since   1.0.0
		 */
		private $slack;



		/**
		 * Register the SlackBot for internal use.
		 *
		 * @since   1.0.0
		 */
		public function __construct() {

			$this->slack = new SlackBot();

		}



		/**
		 * Core update check & send notification.
		 *
		 * @since   1.0.0
		 */
		public function core_update_notif() {

			global $wp_version;

			// Force version check.
			do_action( 'wp_version_check' );

			$versionCheck = get_site_transient( 'update_core' );

			// Is there a new version of WordPress?
			if ( $versionCheck->updates[0]->response === 'upgrade' ) {

				$newVersion = $versionCheck->updates[0]->current;

				// Did we already notified the admin?
				if ( get_option( 'slack_notif_core_version' ) !== $newVersion ) {

					update_option( 'slack_notif_core_version', $newVersion );

					$this->slack->send_message( sprintf( __( ':information_source: There is a new WordPress version available - v%s (current version is v%s).', 'dorzki-notifications-to-slack' ), $newVersion, $wp_version ) );

				}
			}

		}



		/**
		 * Theme udpate check & send notification.
		 *
		 * @since   1.0.0
		 */
		public function theme_update_notif() {

			// Force version check.
			do_action( 'wp_update_themes' );

			$versionCheck   = get_site_transient( 'update_themes' );
			$currentVersion = wp_get_theme()->get( 'Version' );
			$currentTheme   = get_option( 'template' );

			if ( $versionCheck->response[ $currentTheme ]['new_version'] !== $currentVersion && ! is_null( $versionCheck->response[ $currentTheme ]['new_version'] ) ) {

				$newVersion = $versionCheck->response[ $currentTheme ]['new_version'];

				// Did we already notified the admin?
				if ( get_option( 'slack_notif_theme_version' ) !== $newVersion ) {

					update_option( 'slack_notif_theme_version', $newVersion );

					$this->slack->send_message( sprintf( __( ':information_source: There is a new version of the theme *%s* - v%s (current version is v%s).', 'dorzki-notifications-to-slack' ), $currentTheme, $newVersion, $currentVersion ) );

				}
			}

		}



		/**
		 * Plugins update check & send notification.
		 *
		 * @since   1.0.0
		 */
		public function plugin_update_notif() {

			// Force version check.
			do_action( 'wp_update_plugins' );

			$versionCheck  = get_site_transient( 'update_plugins' );
			$activePlugins = get_option( 'active_plugins' );

			$needsUpdate = array_intersect_key( $versionCheck->response, array_flip( $activePlugins ) );

			if ( count( $needsUpdate ) > 0 ) {

				$notifiedPlugins = get_option( 'slack_notif_plugins_version' );

				$theMessage = '';

				foreach ( $needsUpdate as $plugin => $updateData ) {

					$pluginMeta = get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin, true, false );

					// Did we already notified the admin?
					if ( ! array_key_exists( $plugin, $notifiedPlugins ) && $notifiedPlugins[ $plugin ] !== $updateData->new_version ) {

						$notifiedPlugins[ $plugin ] = $updateData->new_version;

						$theMessage .= sprintf( __( '• *%s* - v%s (current version is v%s)', 'dorzki-notifications-to-slack' ) . "\n", $pluginMeta['Name'], $updateData->new_version, $pluginMeta['Version'] );

					}
				}

				update_option( 'slack_notif_plugins_version', $notifiedPlugins );

				// Do we still need to notify?
				if ( '' !== $theMessage ) {

					$theMessage = __( ':information_source: The following plugins have a new version:', 'dorzki-notifications-to-slack' ) . "\n" . $theMessage;

					$this->slack->send_message( $theMessage );

				}
			}

		}



		/**
		 * Send notification on published post.
		 *
		 * @param   integer $postID  the post id number.
		 * @param   object  $post    post details object.
		 * @since   1.0.0
		 */
		public function post_publish_notif( $postID, $post ) {

			$title  = $post->post_title;
			$url    = get_permalink( $postID );
			$author = get_the_author_meta( 'display_name', $post->post_author );

			$template = sprintf( __( ':metal: The post *<%s|%s>* was published by *%s* right now!', 'dorzki-notifications-to-slack' ), $url, $title, $author );

			$this->slack->send_message( $template );

		}



		/**
		 * Send notification on published page.
		 *
		 * @param   integer $postID  the page id number.
		 * @param   object  $post    page details object.
		 * @since   1.0.0
		 */
		public function page_publish_notif( $postID, $post ) {

			$title  = $post->post_title;
			$url    = get_permalink( $postID );
			$author = get_the_author_meta( 'display_name', $post->post_author );

			$template = sprintf( __( ':metal: The page *<%s|%s>* was published by *%s* right now!', 'dorzki-notifications-to-slack' ), $url, $title, $author );

			$this->slack->send_message( $template );

		}



		/**
		 * Send notification when comment has been submitted.
		 *
		 * @param   integer $commentID    the comment id number.
		 * @param   integer $isApproved   has the comment approved?.
		 * @since   1.0.0
		 */
		public function comment_added_notif( $commentID, $isApproved ) {

			$commentData = get_comment( $commentID );

			$author  = $commentData->comment_author;
			$post    = get_the_title( $commentData->comment_post_ID );
			$url     = get_permalink( $commentData->comment_post_ID );
			$comment = $commentData->comment_content;

			$template = sprintf( __( ':metal: A new comment by *%s* on *<%s|%s>*:', 'dorzki-notifications-to-slack' ) . "\n>>>%s", $author, $url, $post, $comment );

			$this->slack->send_message( $template );

		}



		/**
		 * Send notification on user registration.
		 *
		 * @param   integer $userID  the registered user id number.
		 * @since   1.0.0
		 */
		public function user_registered_notif( $userID ) {

			$user = get_userdata( $userID );

			$template = sprintf( __( ':dancer: A new user just registered - *%s* (%s).', 'dorzki-notifications-to-slack' ), $user->user_login, $user->user_email );

			$this->slack->send_message( $template );

		}



		/**
		 * Send notification on administrator login.
		 *
		 * @param   string $username  the username.
		 * @param   object $user      the user details.
		 * @since   1.0.0
		 */
		public function admin_logged_in_notif( $username, $user ) {

			if ( in_array( 'administrator', $user->roles ) ) {

				$template = sprintf( __( ':bowtie: Administrator login: *%s*.', 'dorzki-notifications-to-slack' ), $username );

				$this->slack->send_message( $template );

			}

		}



		/**
		 * Send notification on published custom post type.
		 *
		 * @param   integer $postID  the post id number.
		 * @param   object  $post    page details object.
		 * @since   1.0.1
		 */
		public function cpt_publish_notif( $postID, $post ) {

			$title  = $post->post_title;
			$url    = get_permalink( $postID );
			$author = get_the_author_meta( 'display_name', $post->post_author );

			$template = sprintf( __( ':metal: The post *<%s|%s>* was published by *%s* right now!', 'dorzki-notifications-to-slack' ), $url, $title, $author );

			$this->slack->send_message( $template );

		}



		/**
		 * Send a test notification.
		 * 
		 * @return   boolean   is the test sent successfully?
		 * @since    1.0.5
		 */
		public function send_test_message() {

			$template = __( ':pizza: Mmmmmm..... Pizzzzzzzzzzzzzzzzzzza!!!', 'dorzki-notifications-to-slack' );

			return $this->slack->send_message( $template );

		}

	}

}
