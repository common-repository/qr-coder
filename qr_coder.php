<?php
/**
 * Plugin Name: QR Coder
 * Plugin URI: https://www.matriz.it/projects/qr_coder/
 * Description: This plugin generate QR code of posts' links in admin section.
 * Version: 2.3.0
 * Requires at least: 4.0
 * Requires PHP: 7.4
 * Author: Mattia
 * Author URI: https://www.matriz.it
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

require_once(dirname(__FILE__).'/inc/qrcoder.class.php');
new QRCoder();