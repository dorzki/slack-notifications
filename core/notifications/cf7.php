<?php
/**
 * Contact form 7 notifications.
 *
 * @package     SlackNotifications\Notifications
 * @subpackage  Cf7
 * @author      Itai Arbel <itai@arbelis.com>
 * @link        https://www.arbelis.com
 * @since       2.0.0
 * @version     2.0.4
 */

namespace SlackNotifications\Notifications;
use WPCF7_Submission;
use WPCF7_FormTagsManager;

// Block direct access to the file via url.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class User
 *
 * @package SlackNotifications\Notifications
 */
class Cf7 extends Notification_Type {

	/**
	 * User constructor.
	 */
	public function __construct() {	    

		$this->object_type    = 'cf7';
		$this->object_label   = esc_html__( 'Contact Form 7', 'dorzki-notifications-to-slack' );
		$this->object_options = [
			
		    'cf7_submitted'  => [
				'label'    => esc_html__( 'Form Submitted', 'dorzki-notifications-to-slack' ),
				'hooks'    => [
					'wpcf7_before_send_mail' => 'cf7_submitted',
				],
				'priority' => 10,
				'params'   => 1,
			],
		    
		    'cf7_created'    => [
		        'label'    => esc_html__( 'New Form Created', 'dorzki-notifications-to-slack' ),
		        'hooks'    => [
		            'wpcf7_after_create' => 'cf7_created',
		        ],
		        'priority' => 10,
		        'params'   => 1,
		    ],
		    
		    'cf7_updated'  => [
		        'label'    => esc_html__( 'Form Updated', 'dorzki-notifications-to-slack' ),
		        'hooks'    => [
		            'wpcf7_after_update' => 'cf7_updated',
		        ],
		        'priority' => 10,
		        'params'   => 1,
		    ],
		    		    
		];

		parent::__construct();

	}

	
	
	/**
	 * Post notification when a  cf7 form has been updated.
	 *
	 * @param $contact_data
	 *
	 * @return bool
	 */
	public function cf7_updated( $contact_data ) {
	    
	    // Build notification
	    $message = __( ':mailbox_with_mail: A CF7 form has been updated on <%s|%s>.', 'dorzki-notifications-to-slack' );
	    $message = sprintf( $message, get_bloginfo( 'url' ), get_bloginfo( 'name' ) );
	    
	    $attachments = [
	        [
	            'title' => esc_html__( 'Form Id', 'dorzki-notifications-to-slack' ),
	            'value' => $contact_data->id(),
	            'short' => true,
	        ],
	        [
	            'title' => esc_html__( 'Form Title', 'dorzki-notifications-to-slack' ),
	            'value' => $contact_data->title(),
	            'short' => true,
	        ],
	    ];
	    
	    $channel = $this->get_notification_channel( __FUNCTION__ );
	    
	    return $this->slack_bot->send_message( $message, $attachments, [
	        'color'   => '#42f4bc',
	        'channel' => $channel,
	    ] );
	    	    
	}
	
	
	/**
	 * Post notification when a  cf7 form has been created.
	 *
	 * @param $contact_data
	 *
	 * @return bool
	 */
	public function cf7_created( $contact_data ) {
	    
	    // Build notification
	    $message = __( ':mailbox_with_mail: A new CF7 form has been created on <%s|%s>.', 'dorzki-notifications-to-slack' );
	    $message = sprintf( $message, get_bloginfo( 'url' ), get_bloginfo( 'name' ) );
	    
	    $attachments = [
	        [
	            'title' => esc_html__( 'Form Id', 'dorzki-notifications-to-slack' ),
	            'value' => $contact_data->id(),
	            'short' => true,
	        ],
	        [
	            'title' => esc_html__( 'Form Title', 'dorzki-notifications-to-slack' ),
	            'value' => $contact_data->title(),
	            'short' => true,
	        ],
	    ];
	    
	    $channel = $this->get_notification_channel( __FUNCTION__ );
	    
	    return $this->slack_bot->send_message( $message, $attachments, [
	        'color'   => '#7bce29',
	        'channel' => $channel,
	    ] );
	    
	}
	

	/**
	 * Post notification when a new cf7 form is submitted.
	 *
	 * @param $contact_data
	 *
	 * @return bool
	 */
	public function cf7_submitted( $contact_data ) {
	    	
	        $submission = WPCF7_Submission::get_instance();
	        
	        if ($submission) {
	            $posted_data = $submission->get_posted_data();
	        }
	  
	        //remove unnessesery data
	        unset($posted_data['_wpcf7']);
	        unset($posted_data['_wpcf7_version']);
	        unset($posted_data['_wpcf7_locale']);
	        unset($posted_data['_wpcf7_unit_tag']);
	        unset($posted_data['_wpcf7_container_post']);
	   
		
		// Build notification
		$message = __( ':mailbox_with_mail: A CF7 form has been submitted on <%s|%s>.', 'dorzki-notifications-to-slack' );
		$message = sprintf( $message, get_bloginfo( 'url' ), get_bloginfo( 'name' ) );

		
		$scanned_form_tags = WPCF7_FormTagsManager::get_instance()->get_scanned_tags();
		if ( count( $scanned_form_tags ) ) {
		    foreach ( $scanned_form_tags as $fe ) {
		        if ( empty( $fe['name'] ) ) {
		            continue;
		        }
		        $tags_type[$fe['name']]=$fe['basetype'];		       
		    }
		}
		
		
		$attachments = [];
		
		//form title
		$attachments[]= [
		    'title' => 'cf7 form',
		    'value' => '[#'.$contact_data->id().'] '.$contact_data->title(),
		    'short' => false,
		];		    
		
		//poseted data
		foreach ($posted_data as $key => $value) {
		    
		    $short=true; $icon='';
		    
		   //set field length & icon
		    switch($tags_type[$key]){
		        case 'text': $short=true; $icon=':memo:';break;
		        case 'email': $short=true; $icon=':email:'; break;
		        case 'tel': $short=true; $icon=':phone:'; break;
		        case 'textarea': $short=false; $icon=':scroll:'; break;		        
		        default: $short=true; $icon='';		  
		    }
		    
		    $attachments[]= [
		        'title' => $icon.$key,
		        'value' => $value,
		        'short' => $short,
		    ];		    
		    
		    
		}
		
		
		$channel = $this->get_notification_channel( __FUNCTION__ );

		return $this->slack_bot->send_message( $message, $attachments, [
			'color'   => '#2ecc71',
			'channel' => $channel,
		] );

	
	
	}



}
