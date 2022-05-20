<?php
/**
 * Base Notification
 *
 * @package   dorzki\SlackNotifications\Base
 * @author    Dor Zuberi <admin@dorzki.io>
 * @copyright 2022 dorzki
 * @version   1.0.0
 */

namespace dorzki\SlackNotifications\Base;

use JsonSerializable;

defined( 'ABSPATH' ) || exit;


/**
 * Class Notification
 *
 * @package dorzki\SlackNotifications\Base
 */
abstract class Notification implements JsonSerializable {
	/** @var string */
	protected $type;
	/** @var string[] */
	protected $hooks = [];
	/** @var int */
	protected $channel;
	/** @var Block[] */
	protected $message = [];
	/** @var bool */
	protected $active;


	/**
	 * Notification constructor.
	 *
	 * @param string   $type  Notification type.
	 * @param string[] $hooks Notification hooks.
	 *
	 * @return void
	 */
	public function __construct( string $type, array $hooks ) {
		$this->set_type( $type );
		$this->set_hooks( $hooks );
		$this->set_active( true );
	}


	/**
	 * Retrieve properties to be serialized.
	 *
	 * @return array
	 */
	public function jsonSerialize() : array {
		return [
			'type'    => $this->get_type(),
			'hooks'   => $this->get_hooks(),
			'channel' => $this->get_channel(),
			'message' => $this->get_message(),
			'active'  => $this->is_active(),
		];
	}


	/**
	 * @return string
	 */
	public function get_type() : string {
		return $this->type;
	}

	/**
	 * @param string $type
	 *
	 * @return void
	 */
	public function set_type( string $type ) : void {
		$this->type = $type;
	}

	/**
	 * @return string[]
	 */
	public function get_hooks() : array {
		return $this->hooks;
	}

	/**
	 * @param string[] $hooks
	 *
	 * @return void
	 */
	public function set_hooks( array $hooks ) : void {
		$this->hooks = $hooks;
	}

	/**
	 * @return int
	 */
	public function get_channel() : int {
		return $this->channel;
	}

	/**
	 * @param int $channel
	 *
	 * @return void
	 */
	public function set_channel( int $channel ) : void {
		$this->channel = $channel;
	}

	/**
	 * @return Block[]
	 */
	public function get_message() : array {
		return $this->message;
	}

	/**
	 * @param Block[] $message
	 *
	 * @return void
	 */
	public function set_message( array $message ) : void {
		$this->message = $message;
	}

	/**
	 * @return bool
	 */
	public function is_active() : bool {
		return $this->active;
	}

	/**
	 * @param bool $active
	 *
	 * @return void
	 */
	public function set_active( bool $active ) : void {
		$this->active = $active;
	}
}
