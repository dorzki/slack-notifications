<?php
/**
 * Text Format Enum
 *
 * @package   dorzki\SlackNotifications\Enum
 * @author    Dor Zuberi <admin@dorzki.io>
 * @copyright 2022 dorzki
 * @version   1.0.0
 */

namespace dorzki\SlackNotifications\Enum;

defined( 'ABSPATH' ) || exit;


/**
 * Class Text_Format
 *
 * @package dorzki\SlackNotifications\Enum
 */
class Text_Format {
	const PLAIN    = 'plain_text';
	const MARKDOWN = 'mrkdwn';
}
