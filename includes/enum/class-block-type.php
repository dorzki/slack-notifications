<?php
/**
 * Block Type Enum
 *
 * @package   dorzki\SlackNotifications\Enum
 * @author    Dor Zuberi <admin@dorzki.io>
 * @copyright 2022 dorzki
 * @version   1.0.0
 */

namespace dorzki\SlackNotifications\Enum;

defined( 'ABSPATH' ) || exit;


/**
 * Class Block_Type
 *
 * @package dorzki\SlackNotifications\Enum
 */
class Block_Type {
	const SECTION = 'section';
	const DIVIDER = 'divider';
	const IMAGE   = 'image';
	const CONTEXT = 'context';
	const HEADER  = 'header';
}
