<?php
/**
 * Plugin Name: Flipboard Magazine Widget
 * Description: Add a Flipboard magazine widget (https://share.flipboard.com/) to your sidebar
 * Author Name: Tracy Rotton
 * Author URI: http://www.taupecat.com
 * Plugin URI: https://github.com/taupecat/flipboard-magazine-widget
 * License: MIT
 * Version: 2.0.0
 *
 * @package Flipboard Magazine Widget
 */

namespace taupecat;

require_once __DIR__ . '/class-flipboard.php';

( new Flipboard() )->init();
