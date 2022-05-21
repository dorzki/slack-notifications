<?php
/**
 * Enums -> Control Type
 *
 * @package    dorzki\SlackNotifications\Enum
 * @author     Dor Zuberi <admin@dorzki.io>
 * @copyright  2022 dorzki
 * @version    2.1.0
 */

namespace dorzki\SlackNotifications\Enum;

defined( 'ABSPATH' ) || exit;


/**
 * Class Control_Type
 *
 * @package dorzki\SlackNotifications\Enum
 */
class Control_Type {
	const SECTION = 'section';

	const TEXT     = 'text';
	const EMAIL    = 'email';
	const URL      = 'url';
	const NUMBER   = 'number';
	const PASSWORD = 'password';
	const HIDDEN   = 'hidden';

	const RADIO    = 'radio';
	const CHECKBOX = 'checkbox';
	const SELECT   = 'select';

	const MEDIA = 'media';
	const FILE  = 'file';

	const BUTTON = 'button';
	const SUBMIT = 'submit';


	/**
	 * Check if type is input type.
	 *
	 * @param string $type Field type.
	 *
	 * @return bool
	 *
	 * @since 2.1.0
	 */
	public static function is_input( string $type ) : bool {
		return in_array(
			$type,
			[
				self::TEXT,
				self::EMAIL,
				self::URL,
				self::NUMBER,
				self::PASSWORD,
				self::HIDDEN,
			],
			true
		);
	}

	/**
	 * Check if type is button type.
	 *
	 * @param string $type Field type.
	 *
	 * @return bool
	 *
	 * @since 2.1.0
	 */
	public static function is_button( string $type ) : bool {
		return in_array(
			$type,
			[
				self::BUTTON,
				self::SUBMIT,
			],
			true
		);
	}
}
