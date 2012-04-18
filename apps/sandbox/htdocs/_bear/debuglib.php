<?php
#############################################################
## Name          : debuglib for PHP5
## Author        : Thomas Schüßler <debuglib at atomar dot de>
## Last changed  : 31.03.2009 10:15:13
## Revision      : 45
## Website       : http://phpdebuglib.de
############################################################

/*
 * Copyright (C) 2004-2009 by Thomas Schüßler
 * Written by Thomas Schüßler <debuglib at atomar dot de>
 * All Rights Reserved
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
*/

if(function_exists('print_a')):

	return; // debuglib was already included before

else:

	if(!defined('USE_DEBUGLIB')) define('USE_DEBUGLIB', TRUE);

	if(!array_key_exists('DEBUGLIB_LVL',           $GLOBALS)) $GLOBALS['DEBUGLIB_LVL']           = 99;           // 99 debug levels should be enough for everyone
	if(!array_key_exists('DEBUGLIB_MAX_Y',         $GLOBALS)) $GLOBALS['DEBUGLIB_MAX_Y']         = 50;           // how much items per level should get displayed (max_y)
	if(!array_key_exists('DEBUGLIB_MAIL_ENCODING', $GLOBALS)) $GLOBALS['DEBUGLIB_MAIL_ENCODING'] = 'utf-8';      // encoding for the mail option
	if(!array_key_exists('USE_DEBUGLIB',           $GLOBALS)) $GLOBALS['USE_DEBUGLIB']           = USE_DEBUGLIB; // you can set this to TRUE if you have to overwrite the setting in a live environment

	$GLOBALS['DbugL_Globals'] = array();
	$GLOBALS['DbugL_Globals']['microtime_start'] = microtime(TRUE);
	$GLOBALS['DbugL_Globals']['initial_globals_count'] = count($GLOBALS);

	class DbugL {

		public static $first_call = TRUE;

		// shortcuts for the pros
		public static $alt_parameter_names = array(
			'trim_tabs'    => array('tt'),
			'label'        => array('l'),
			'max_y'        => array('y'),
			'return'       => array('r'),
			'window'       => array('w'),
			'window_link'  => array('wl'),
			'debug_level'  => array('lvl'),
			'show_objects' => array('so'),
			'pickle'       => array('p'),
			'mail'         => array('m'),
			'mail_encoding'=> array('me'),
			'escape_html'  => array('e'),
		);
		
		public static function help($return_mode = FALSE) {
			$html = '
				<style type="text/css">
					div.DbugL_help         {
						font-family: Verdana, Arial, Helvetica, Geneva, Swiss, SunSans-Regular, sans-serif; font-size:8pt; border:1px dashed black;
						width:850px;
						padding:5px;
					}

					div.DbugL_help h5 {
						display:inline;
						font-size:10pt;
						border-bottom:1px dotted black;
					}

					div.DbugL_help th, div.DbugL_help td {
						vertical-align:top;
						text-align:left;
					}

					span.new {
						color:lime;
						font-weight:bold;
					}
				</style>

				<div class="DbugL_help">
					<h5>print_a(mixed input [, string option_string])</h5><br />
					<br />
					The function you will use most often, prints a colorful representation of your PHP data<br />
					<br />
					$option_string must be in the CSS like syntax:<br />
					<br />
					e.g. "max_y:5;window:1;label:my_array"<br />
					<br />
					If there is no ":" in the options string, the whole string will be used as the text for the label. <span class="new">new</span><br />
					<br />
					Valid options:<br />

					<table>
						<tr><th>return:</th>                    <td>(0|1)</td>      <td>Do not print the output and instead return it as a string.</td></tr>
						<!--<tr><th>help:</th>                      <td>(1)</td>        <td>Show this text.</td></tr>-->
						<tr><th>label:</th>                     <td>(string)</td>   <td>Draw a fieldset/legend around the output.</td></tr>
						<tr><th>max_y:</th>                     <td>(1-n)</td>      <td>Maximum number of items on the same level. [...] (defaults to 50)</td></tr>
						<tr><th>pickle:</th>                    <td>(0|1)</td>      <td>Print a serialized representation of the array instead of printing it as a table.</td></tr>
						<tr><th>export:</th>                    <td>(0|1)</td>      <td>Print PHP sourcecode of the array. <span class="new">new</span></td></tr>
						<tr><th>trim_tabs:</th>                 <td>(0-n)</td>      <td>Trim the leading tabs in multiline strings and pad with n tabs.</td></tr>
						<tr><th>window:</th>                    <td>(string)</td>   <td>The output should open in a new window (javascript), the parameter is also the title for the window.</td></tr>
						<tr><th>window_link:</th>               <td>(0|1)</td>      <td>Don\'t open a window, just print a link which opens one when clicked. <span class="new">new</span></td></tr>
						<tr><th>debug_level:</th>               <td>(0-99)</td>     <td>Only do something if the debug level value is <= the global debug level ($GLOBALS[\'DEBUGLIB_LVL\'] default 99) <span class="new">new</span></td></tr>
						<tr><th></th>                           <td></td>           <td>You can also set it to an array with the levels you want to display e.g. $GLOBALS[\'DEBUGLIB_LVL\'] = array(3,5)</td></tr>
						<tr><th>avoid@:</th>                    <td>(0|1)</td>      <td>If a key starts with the character "@", assume it is a recursive reference and don\'t follow it.</td></tr>
						<tr><th>mail:</th>                      <td>(string)</td>   <td>Mail the ouput as HTML mail to the supplied email address. <span class="new">new</span></td></tr>
						<tr><th>mail_encoding:</th>             <td>(string)</td>   <td>encoding for the HTML mail. (defaults to "utf-8")</td></tr>
						
					</table>
					<br />

					'.print_a(self::$alt_parameter_names, 'return:1;label:You can also use these <br />short parameter names:').'
					<br />
					<h5>show_vars([string option_string])</h5><br />
					<br />
					Prints all superglobals like $_GET, $_POST, $_SESSION etc. in a big table.<br />
					Good for printing at the bottom of a page.<br />
					<br />
					Options are the same as for print_a + the following options:<br />
					verbose: also show $_SERVER and $_ENV<br />
					<br />
					<!--
					<h5>print_mysql_result(resource mysql_result[, bool return_mode])</h5><br />
					<br />
					Prints a mysql query result as a table<br />
					<br />
					-->

					<h5>script_runtime([bool return_mode [, string title [, string css_style]]] )</h5><br />
					<br />
					Prints the passed time since the start of the script (or the last script_runtime call) in seconds.<br />
					<br />

					<h5>pre(string string [, string option_string])</h5><br />
					<br />
					Print a string so the whitespaces are visible in HTML.<br />
					<br />

					option_string must be in the CSS like syntax:<br />
					<br />
					eg. "r:1;trim_tabs:0;"<br />
					<br />
					Possible options:<br />

					<table>
						<tr><th>return:</th>    <td>(0|1)</td> <td>return the output instead of printing it</td></tr>
						<tr><th>trim_tabs:</th> <td>(0-n)</td> <td>same as in print_a()</td></tr>
					</table>
					<br />

					You can disable the output of all the functions in a production environment by setting <strong>$GLOBALS[\'USE_DEBUGLIB\']</strong> to <strong>FALSE</strong> (e.g. trough auto_prepend in your php.ini).<br />
					<br />
					And if you have to do some online debugging you can enable it again somewhere in your script by setting it to <strong>TRUE</strong>.<br />
				</div>
			';

			if($return_mode) {
				return $html;
			} else {
				print $html;
			}

		}

		public $window_open_tracker = array();

		private $default_options = array(
			'label'               => NULL,
			'window'              => NULL,
			'window_link'         => FALSE,
			'max_y'               => 0,
			'test_for_recursions' => FALSE,
			'show_objects'        => TRUE,
			'trim_tabs'           => NULL,
			'avoid@'              => FALSE,
			'return'              => FALSE,
			'pickle'              => FALSE,
			'export'              => FALSE,
			'escape_html'         => 2,
			'mail'                => NULL,
			'mail_encoding'       => 'utf-8', // iso-8859-1
			'debug_level'         => 0,
		);

		public $options = array();
		public $single_value_flag = FALSE;

		private $element_counter = 0;
		private $window_html;
		private $color_cache  = array(); # cache the gradient colors
		private $open_windows = array();

		const runtime_precision  = 6; # used for the seconds output of script_runtime()

		const object_key_marker = '<:~!OBJECT_KEY!~:>'; #TODO# hackish

		// default colors for the gradient start
		const key_bg_color_default     = '00456A';
		const key_bg_color_array       = '10187E';
		const key_bg_color_object      = '60008F';
		const key_bg_color_object_data = '60008F';

		const color_step_width = 10;

		public static $css = '
			<style type="text/css" media="screen">

				*.DbugL                { font-family: Verdana, Arial, Helvetica, Geneva, Swiss, SunSans-Regular, sans-serif; }

				pre.DbugL              { display:inline; background:#F1F1F1; font-size:8pt; }
				div.DbugL              { margin-bottom:5px; }

				a.DbugL_window_link    { font-size:xx-small; color:black; border:1px solid darkorange; padding:3px; background:#F1F1F1; margin:2px;}

				div.DbugL_pre          { font-size:8pt; font-family: Verdana, Arial, Helvetica, Geneva, Swiss, SunSans-Regular, sans-serif; margin-bottom:10px; }
				
				/* Profont is a monospace bitmap font which absolutely rocks! see: http://www.tobias-jung.de/seekingprofont/  */
				span.DbugL_multi       { font-size:9pt; font-family: ProFontWindows, ProFont, Lucida Console, monospace, Courier New; background:#F0F0F9; line-height:100%; }
				span.DbugL_outer_space { background:gold; }
				span.DbugL_tabs        { border-right:1px solid #DDD; }

				/* arrgh.. if someone has a fix for the wrong widths of the fieldsets in IE7 please let me know :| */
				fieldset.DbugL_normal    { display:table-cell; border:1px solid black; padding:2px; }
				fieldset.DbugL_pickled   { width:90%; border:1px solid black; padding:2px; }
				legend.DbugL             { font-size:9pt; font-weight:bold; color:black; }
				div.DbugL_runtime        { font-family: Verdana, Arial, Helvetica, Geneva, Swiss, SunSans-Regular, sans-serif; font-size:9pt; font-weight:normal; color:black; background:yellow; padding:2px; }
				span.DbugL_runtime_label { font-weight:bold; }
				span.DbugL_type_other    { font-family: Verdana, Arial, Helvetica, Geneva, Swiss, SunSans-Regular, sans-serif; font-size:8pt; background:#ECEDFE; color:red;}
				span.DbugL_value_other   { font-family: Verdana, Arial, Helvetica, Geneva, Swiss, SunSans-Regular, sans-serif; font-size:8pt; white-space:nowrap; color:black;}

				table.DbugL                       { background:#D5D5EA; font-size:8pt; border-collapse:separate; }
				table.DbugL th                    { background:#1E32C8; color:white; text-align:left; padding-left:2px; padding-right:2px; font-weight:normal; }
				table.DbugL td                    { background:#DEDEEF; font-weight:normal; }

				table.DbugL th.key_single_value   { background:#FFFF00 !important; color:black !important; font-weight:normal !important; padding:3px;}
				table.DbugL th.key_string         { color:white; }
				table.DbugL th.key_number         { color:green; }
				table.DbugL th.key_array          { color:white; font-weight:bold; }
				table.DbugL th.key_object         { color:white; font-weight:bold; }

				table.DbugL td.value              { padding:0px; }
				table.DbugL td.value_bool_true    { color:#5BA800; padding:1px; }
				table.DbugL td.value_bool_false   { color:#D90062; padding:1px; }
				table.DbugL td.value_string       { color:black; padding:1px; }
				table.DbugL td.value_integer      { color:green; padding:1px; }
				table.DbugL td.value_double       { color:blue; padding:1px; }
				table.DbugL td.value_null         { color:darkorange; padding:1px; }
				table.DbugL td.value_empty_array  { color:darkorange; padding:1px; }
				table.DbugL td.value_empty_string { color:darkorange; padding:1px; }
				table.DbugL td.value_skipped      { color:#666666; padding:1px; }

				div.DbugL_SG                { color:black; font-weight:bold; font-size:9pt; }
				table.DbugL_SG              { width:100%; font-family: Verdana, Arial, Helvetica, Geneva, Swiss, SunSans-Regular, sans-serif;  font-size:8pt; }
				table.DbugL_SG td           { }
				table.DbugL_SG td.globals   { background:#7ACCC8; padding:2px; }
				table.DbugL_SG td.get       { background:#7DA7D9; padding:2px; }
				table.DbugL_SG td.post      { background:#F49AC1; padding:2px; }
				table.DbugL_SG td.files     { background:#82CA9C; padding:2px; }
				table.DbugL_SG td.session   { background:#FCDB26; padding:2px; }
				table.DbugL_SG td.cookie    { background:#A67C52; padding:2px; }
				table.DbugL_SG td.server    { background:#A186BE; padding:2px; }
				table.DbugL_SG td.env       { background:#7ACCC8; padding:2px; }
				

				div.DbugL_js_hr_first         { width:100%; border-bottom:1px dashed black; margin:10px 0px 10px 0px; font-size:xx-small; text-align:right; background:gold; }
				div.DbugL_js_hr               { width:100%; border-bottom:1px dashed black; margin:10px 0px 10px 0px; font-size:xx-small; text-align:right; background:#EFEFEF }
				div.DbugL_window_content      { padding-top:20px; }
				div.DbugL_window_clear_button { text-align:center; font-size:x-small; position:fixed; top:0px; left:0px; background:orange; width:100%; border-bottom:1px solid black; }
				
			</style>

			<style type="text/css" media="print">
				table.DbugL_Show_vars {
					display:none;
					visibility:invisible;
				}
			</style>
		';

		public function __construct() {

			$this->window_html = '
				<html>
					<head>
						'.self::$css.'
						<script type="text/javascript">
							//<![CDATA[
							
							var DbugL_test_var = true;
							
							function append_html(html) {
								document.getElementById("content").innerHTML += html;
								window.scrollTo(0, 1000000);
								window.focus();
							}
							
							function cls() {
								document.getElementById("content").innerHTML = "";
							}

							//]]>
						<\/script>
					</head>
					<body style="padding:2px;">
						<div class="DbugL DbugL_window_clear_button" onmouseup="cls();">- clear window -</div>
						<div id="content" class="DbugL DbugL_window_content"></div>
					</body>
				</html>
			';
		}


		// merge user options into default options
		public function set_options($options_string) {
			$this->options_string = $options_string;
			$this->default_options['max_y']         = $GLOBALS['DEBUGLIB_MAX_Y'];
			$this->default_options['mail_encoding'] = $GLOBALS['DEBUGLIB_MAIL_ENCODING'];
			$this->options = array_merge($this->default_options, self::parse_options($options_string, DbugL::$alt_parameter_names));
		}

		// wrapper function.. #TODO#
		public static function get_type($value) {
			return gettype($value);
		}


		// ouput the css block only if the first time one of the output functions get called
		public static function html_prefix() {
			if(self::$first_call) {
				self::$first_call = FALSE;
				return DbugL::$css;
			} else {
				return '';
			}
		}

		// #TODO#
		public static function test_level($level) {

			if(is_array($GLOBALS['DEBUGLIB_LVL'])) {
				return in_array($level, $GLOBALS['DEBUGLIB_LVL']);
			} else {
				return $level <= $GLOBALS['DEBUGLIB_LVL'];
			}
		}

		// remove leading tabs
		public static function trim_leading_tabs( $string, $tab_padding = NULL ) {
			/* remove whitespace lines at the start and end of the string */
			$string = preg_replace(array('/^\s*\n/', '/\s*$/'), array('',''), $string);

			// find the smallest leading tab count
			preg_match_all('/^\t+/', $string, $matches);

			if(count($matches[0]) > 0) {
				$min_tab_count = strlen(min($matches[0]));

				// und entfernen
				$string = preg_replace('/^\t{'.$min_tab_count.','.$min_tab_count.'}/m', (isset($tab_padding) ? str_repeat("\t", $tab_padding) : ''), $string);
			}

			return $string;
		}

		public static function _handle_whitespace( $string ) {
			// replace 2 or more spaces with nobreaks (for special markup)
			$string = preg_replace_callback(
				'/ {2,}/',
				create_function(
					'$matches',
					'return str_repeat("&nbsp;", strlen($matches[0]));'
				),
				$string
			);
				
			$string = preg_replace(array('/&nbsp;$/', '/^&nbsp;/'), '<span class="DbugL_outer_space">&nbsp;</span>', $string); # mark spaces at the start/end of the string with red underscores
			$string = str_replace("\t", '&nbsp;&nbsp;<span class="DbugL_tabs">&nbsp;</span>', $string); # replace tabulators with '  »'
			return $string;
		}

		// format strings for output to html
		public static function format_string($string, $trim_tabs = NULL, $escape_html = 2) {

			$escape_html == 2 and $string = htmlspecialchars($string);
			if($escape_html == 0) return $string;

			$is_multiline = strpos($string, "\n") !== FALSE;
			
			if($is_multiline && isset($trim_tabs)) {
				$string = self::trim_leading_tabs($string, $trim_tabs);
			}

			$string = self::_handle_whitespace($string);
			$string = nl2br($string);
			if($is_multiline) {
				$string = '<span class="DbugL_multi">'.$string.'</span>';
			}

			return $string;
		}

		// parse the options string in css syntax
		public static function parse_options($options_string = NULL, $alt_parameter_names = array()) {
			
			$options = array();

			$alt_parameter_mapping = array();
			foreach($alt_parameter_names as $parameter_name => $alt_names) {
				$alt_parameter_mapping[$parameter_name] = $parameter_name;
				foreach($alt_names as $alt_name) {
					$alt_parameter_mapping[$alt_name] = $parameter_name;
				}
			}

			if(!$options_string) return $options;

			if(strpos($options_string, ':') !== FALSE) {
				$pairs = explode(';', $options_string);

				foreach($pairs as &$pair) {
					
					$pair = trim($pair);
					if($pair == '') continue;
					
					if(strpos($pair, ':') !== FALSE) {
					
						list($option, $value) = explode(':', $pair);
	
						if(isset($alt_parameter_mapping[$option])) {
							$options[$alt_parameter_mapping[$option]] = $value;
						} else {
							$options[$option] = $value;
						}
						
					}

				}
			} else { // if the options string has no ":" in it, consider it to be the label
				$options['label'] = $options_string;
			}
			
			return $options;
		}

		#TODO#
		private function _block_s($class = 'null', $title = NULL) { return '<table '.(isset($title) ? 'title="'.$title.'" ' : '').' cellpadding="0" cellspacing="1" class="DbugL">'; }
		private function _block_e()                { return '</table>'; }

		private function _row_s  ($class = 'null') { return '<tr>'; }
		private function _row_e  ()                { return '</tr>'; }

		private function _key_s  ($bg_color, $class, $value) {
			$value_type = self::get_type($value);
			if($this->single_value_flag == TRUE) $class .= ' key_single_value';
			if($value_type == 'array'  && count($value) == 0) $value_type = 'array (empty)';
			if($value_type == 'string' && $value == '')       $value_type = 'string (empty)';
			$html = '<th '.(isset($class) ? 'class="'.$class.'"' : '').' style="background:#'.$bg_color.'" title="'.$value_type.'">';
			if($this->single_value_flag == TRUE) $this->single_value_flag = FALSE;
			return $html;
		}
		private function _key_e  ()                { return '</th>'; }

		private function _value_s($class = 'null') { return '<td class="value '.$class.'">'; }
		private function _value_e()                { return '</td>'; }

		// lighten up the key background color with each iteration
		private function _make_key_bg_color($base_color, $iter) {

			if(!isset($this->color_cache[$base_color][$iter])) {
				if( $iter ) {
					for($i=0; $i<6; $i+=2) {
						$component = substr( $base_color, $i, 2 );
						$component = hexdec( $component );
						( $component += self::color_step_width * $iter ) > 255 and $component = 255;
						isset($tmp_key_bg_color) or $tmp_key_bg_color = '';
						$tmp_key_bg_color .= sprintf( "%02X", $component );
					}
					$key_bg_color = $tmp_key_bg_color;
				}

				$this->color_cache[$base_color][$iter] = $key_bg_color; // save the color so we dont have to compute it again for this level
			}

			return $this->color_cache[$base_color][$iter];
		}

		// format the key
		private function _format_key($key, $value, $iter, $special_type = NULL) {

			$this->element_counter++;

			$key_type   = self::get_type($key);
			$value_type = self::get_type($value);

			if(strpos($key, self::object_key_marker) !== FALSE) {
				$key = str_replace(self::object_key_marker, '', $key);
				$value_type = 'OBJECT_DATA';
			}

			switch($value_type) {

				case 'array':
					return self::_key_s($this->_make_key_bg_color(self::key_bg_color_array,   $iter), 'key_array', $value). $key .self::_key_e();
					break;

				case 'object':
					return self::_key_s($this->_make_key_bg_color(self::key_bg_color_object,  $iter), 'key_object', $value).'<span title="Class: '.(get_class($value)).'">'.$key .'</span>'.self::_key_e();
					break;

				case 'OBJECT_DATA':
					return self::_key_s($this->_make_key_bg_color(self::key_bg_color_object_data,  $iter), 'key_object_data', $value). $key .self::_key_e();
					break;

				default:

					return self::_key_s($this->_make_key_bg_color(self::key_bg_color_default, $iter), NULL, $value).self::format_string($key, $this->options['trim_tabs']).self::_key_e();
					break;
			}

			return self::_key_s('key_string').$key.self::_key_e();
		}

		// format the value
		private function _format_value($value) {

			$value_type = self::get_type($value);

			switch($value_type) {

				case 'boolean':
					if( $value == TRUE ) {
						return self::_value_s('value_bool_true'). 'TRUE' .self::_value_e();
					} else {
						return self::_value_s('value_bool_false'). 'FALSE' .self::_value_e();
					}
					break;

				case 'string':
					if($value == '') {
						return self::_value_s('value_empty_string')."''".self::_value_e();
					} else {
						return self::_value_s('value_string'). self::format_string($value, $this->options['trim_tabs'], $this->options['escape_html']). self::_value_e();
					}
					break;

				case 'integer':
					return self::_value_s('value_integer'). $value .self::_value_e();
					break;

				case 'double':
					return self::_value_s('value_double'). $value .self::_value_e();
					break;

				case 'NULL':
					return self::_value_s('value_null'). 'NULL' .self::_value_e();
					break;

				case 'array':
					return self::_value_s('value_empty_array'). '[]' .self::_value_e();
					break;

				case 'object':
					return self::_value_s('value_empty_array'). '{}' .self::_value_e();
					break;
			}
		}

		// called by the global interface function
		public function print_a($input, &$html, $iter = 0) {
			
			$iter++;

			$input_type = self::get_type($input);

			// input was neither an array nor an object
			if(! in_array($input_type, array('array', 'object'))) {
				if($input_type == 'resource') {
					$html = '<span nowrap="nowrap" class="DbugL_value_other"><span class="DbugL_type_other">('.$input_type.')</span> '.$input.'</span>';
				} else {
					$html = '<span nowrap="nowrap" class="DbugL_value_other"><span class="DbugL_type_other">('.$input_type.')</span> '.self::format_string($input, $this->options['trim_tabs']).'</span>';
				}
				return;
			}
			
			if($iter == 1) {
				$bt = debug_backtrace();
				$bt = $bt[1];
				$title = "({$bt['line']}) {$bt['file']}";
				#TODO# .(isset($bt['function']) ? '    function:'.$bt['function'] : '');
			} else {
				$title = NULL;	
			}
			
			$html .= self::_block_s(NULL, $title);

			$loop_i = 0;
			foreach($input as $key => $value) {
				$html .= self::_row_s();

				if($this->options['max_y'] > 0 && $loop_i >= $this->options['max_y']) {
					$html .= $this->_format_key('...', $value, $iter);
					$html .= self::_value_s('value_skipped').'<span title="'.(count($input) - $loop_i).' items at this level were skipped (max_y='.$this->options['max_y'].').">['. (count($input) - $loop_i).'&nbsp;skipped]</span>' .self::_value_e();
					break;
				}

				$html .= $this->_format_key($key, $value, $iter);

				if($this->options['avoid@'] == '1' && $key[0] == '@') {
					$html .= $this->_format_value('Recursion');
					
				} elseif(is_array($value) && !empty($value)) {

					$html .= self::_value_s();
					$this->print_a($value, $html, $iter);
					$html .= self::_value_e();

				} elseif(is_object($value)) {
					$html .= self::_value_s();
					if($this->options['show_objects']) {
						$this->print_a($value, $html, $iter);
					} else {
						$html .= '<span title="not shown due to the option &quot;show_objects:0&quot;">...</span>';
					}
					$html .= self::_value_e();

				} else {

					$html .= $this->_format_value($value);

				}

				$html .= self::_row_e();

				$loop_i++;
			}

			$html .= self::_block_e();

		}

		// called by the global interface function
		public function js_for_popup($html) {
			
			$title = $this->options['window'];
			$window_name = 'DbugL_'.md5($_SERVER['HTTP_HOST']).'_'.$title;

			if(array_key_exists($window_name, $this->window_open_tracker)) {
				$hr_class = 'DbugL_js_hr';
			} else {
				$this->window_open_tracker[$window_name] = TRUE;
				$hr_class = 'DbugL_js_hr_first';
			}

			$print_css = in_array($window_name, $this->open_windows) ? FALSE : TRUE;

			$this->open_windows[] = $window_name;

			$debugwindow_origin = $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];

			$html = self::escape_js($html);
			
	 		return '

	 			'.( $this->options['window_link'] ? '<a class="DbugL_window_link" href="javascript:open_'.$window_name.'();">print_a( $array, '.$this->options_string.' )</a>' : '' ).'

				<script type="text/javascript">

					//<![CDATA[

						'.($this->options['window_link'] ? 'function open_'.$window_name.'() {' : '').'
							
							try {
								
								if(window["'.$window_name.'"] == undefined) {
									window["'.$window_name.'"] = window.open("", "W'.$window_name.'", "menubar=no,scrollbars=yes,resizable=yes,width=640,height=480");
								}
								
								if(window["'.$window_name.'"].DbugL_test_var == undefined) {
									with (window["'.$window_name.'"].document) {
										open();
										write("'.self::escape_js($this->window_html).'");
										close();
										title = "'.$title.' Debugwindow for : http(s)://'.$debugwindow_origin.'";
									}
								}
								
								window["'.$window_name.'"].append_html("<div class=\"'.$hr_class.'\">"+ new Date().toLocaleString() +"</div>");
								window["'.$window_name.'"].append_html("'.$html.'");
							
							} catch(e) {
								if(window["DbugL_popup_flag"] == undefined) {
									alert("print_a() could not open window. Please enable popups!");
								}
							}

						'.($this->options['window_link'] ? '}' : '').'

					//]]>

				</script>
	    ';

		}

		public static function escape_js($string) {
			$string = str_replace(array("\r\n", "\n", "\r"), '\n', $string);
			$string = str_replace('</', '<\\/', $string);
			$string = str_replace('"', '\"', $string);
			return $string;
		}

		public function get_html($html) {
			if(isset($this->options['label'])) {
				if($this->options['pickle'] == TRUE || $this->options['export'] == TRUE) {
					$html = '<form"><fieldset class="DbugL_pickled"><legend class="DbugL">'.$this->options['label'].'</legend>'.$html.'</fieldset></form>';
				} else {
					$html = '<form style="display:table;"><fieldset class="DbugL_normal"><legend class="DbugL">'.$this->options['label'].'</legend>'.$html.'</fieldset></form>';
				}

			}
			$html = '<div class="DbugL">'.$html.'</div>';
			return $html;
		}

		// used by show_vars to get all globals defined in a script (minus the core PHP stuff)
		public static function script_globals() {
			$varcount = 0;
			$script_globals = array();

			foreach($GLOBALS as $variable_name => $variable_value) {
				if(++$varcount > $GLOBALS['DbugL_Globals']['initial_globals_count']) {

					/* die wollen wir nicht! */
					if ($variable_name != 'HTTP_SESSION_VARS' && $variable_name != '_SESSION') {
						$script_globals[$variable_name] = $variable_value;
					}

				}
			}

			unset($GLOBALS['DbugL_Globals']['initial_globals_count']);
			return $script_globals;
		}

	} // DbugL





	// ------------------------------- here come the global user functions ------------------------------- //



	function pre($string, $options_string = NULL) {
		if(!$GLOBALS['USE_DEBUGLIB']) return;

		$options = DbugL::parse_options($options_string);

		if(isset($options['debug_level']) && $options['debug_level'] > $GLOBALS['DEBUGLIB_LVL'] ) return;

		if(isset($options['trim_tabs'])) {
			$string = DbugL::trim_leading_tabs($string, $options['trim_tabs']);
		}

		$html = DbugL::html_prefix().'<div class="DbugL_pre"><span>'.DbugL::format_string($string).'</span></div>';

		if(isset($options['return']) && $options['return'] == '1') {
			return $html;
		} else {
			print $html;
		}
	}

	function pre_die($string, $options_string = NULL) {
		if(!$GLOBALS['USE_DEBUGLIB']) return;

		pre($string, $options_string);
		die;
	}

	// shows time elapsed since last call
	function script_runtime($label = '', $style = '', $return_mode = FALSE) {
		
		$bt = debug_backtrace();
		$bt = $bt[1];
		$title = "({$bt['line']}) {$bt['file']}";

		if($label != '') $label = '<span class="DbugL_runtime_label">['.$label.']</span> ';
		
		if(!$GLOBALS['USE_DEBUGLIB']) return;

		$now_time = microtime(TRUE);
		if(isset($GLOBALS['DbugL_Globals']['last_microtime'])) {
			$step_time = $now_time - $GLOBALS['DbugL_Globals']['last_microtime'];
		}
		$GLOBALS['DbugL_Globals']['last_microtime'] = $now_time;

		$elapsed_time = sprintf('%01.'.DbugL::runtime_precision.'f', $now_time - $GLOBALS['DbugL_Globals']['microtime_start']);

		$html = DbugL::html_prefix().'<div class="DbugL_runtime" style="'.$style.'" title="'.$title.'">'.$label.' time: '.$elapsed_time.(isset($step_time) ? ' ('.sprintf('%01.'.DbugL::runtime_precision.'f', $step_time).' since last call)' : '').'</div>';

		if($return_mode) {
			return $html;
		} else {
			print $html;
		}
	}

	// the interface function for Debuglib::_print_a()
	function print_a($input, $options_string = NULL) {
		if(!$GLOBALS['USE_DEBUGLIB']) return;

		static $DbugL;

		if(!$DbugL) $DbugL = new DbugL;
		$DbugL->set_options($options_string);

		if(!is_array($input) && !is_object($input) || (is_array($input) && count($input) == 0)) {
			$DbugL->single_value_flag = TRUE; #hackish
			$input = array('('.gettype($input).')' => $input);
		}

		if(! Dbugl::test_level($DbugL->options['debug_level'])) return;

		$html = '';
		
		// use print_r() to check for a recursion in the structure
		if($DbugL->options['test_for_recursions'] && strpos(print_r($input, 1), '*RECURSION*') !== FALSE) {
			$html = 'RECURSION detected!';
		} else {
			$DbugL->print_a($input, $html);
		}

		// open a window for the output?
		if(isset($DbugL->options['window'])){

			if($DbugL->options['pickle'] == TRUE) {

				$pickled_input = serialize($input);
				$pickled_input = str_replace("'", "\\\'", $pickled_input );
				$pickled_input = '<textarea style="width:100%;height:200px;">' . $pickled_input .'</textarea>';
				$html = $DbugL->js_for_popup($DbugL->get_html($pickled_input));

			} elseif($DbugL->options['export'] == TRUE) {

				$export_input = var_export($input, TRUE);
				$export_input = '<textarea style="width:100%;height:200px;">' . $export_input .'</textarea>';
				$html = $DbugL->js_for_popup($DbugL->get_html($export_input));

			} else {
				$html = $DbugL->js_for_popup($DbugL->get_html($html));
			}
		} else {
			$html = DbugL::html_prefix().$DbugL->get_html($html);
		}

		if(isset($DbugL->options['help'])) {
			$html = DbugL::help($DbugL->options['return']);
		}
		
		if($DbugL->options['mail']) {
			$headers  = 'MIME-Version: 1.0' . "\r\nContent-type: text/html; charset=".$DbugL->options['mail_encoding']."\r\nFrom: debuglib\r\n";
			$message = '<html><head><title>debuglib.php @ '.$_SERVER['HTTP_HOST'].'</title></head><body>'.DbugL::$css.$html.'</body></html>';
			mail($DbugL->options['mail'], 'debuglib.php @ '.$_SERVER['HTTP_HOST'], $message, $headers);
		} elseif($DbugL->options['return'] == '1') {
			return $html;
		} else {
			print $html;
		}

	}

	// call print_a() and die (RIP)
	function print_a_die($input, $options_string = NULL) {
		if(!$GLOBALS['USE_DEBUGLIB']) return;

		print_a($input, $options_string);
		die;
	}


	// deprecated
	function die_a($input, $options_string = NULL) {
		if(!$GLOBALS['USE_DEBUGLIB']) return;

		print_a($input, $options_string);
		die;
	}

	// good for printing all kind of superglobals at the bottom of a page
	function show_vars($options_string = NULL) {
		if(!$GLOBALS['USE_DEBUGLIB']) return;

		$options = DbugL::parse_options($options_string, DbugL::$alt_parameter_names);

		$print_a_options = $options_string.';return:1;';

		$superglobals = array(
			'Script $GLOBALS' => DbugL::script_globals(),
			'$_GET'           => $_GET,
			'$_POST'          => $_POST,
			'$_FILES'         => $_FILES,
			'$_SESSION'       => $_SESSION,
			'$_COOKIE'        => $_COOKIE,
		);


		if(isset($options['verbose']) && $options['verbose'] == '1') {
			$superglobals['$_SERVER'] = $_SERVER;
			$superglobals['$_ENV']    = $_ENV;
		}

		$html = DbugL::html_prefix().script_runtime('before show_vars','background:#BBB;',TRUE,TRUE);
		$html .= '<table class="DbugL_SG" cellpadding="0" cellspacing="0">';

		foreach($superglobals as $name => $reference) {
			if(empty($reference)) continue;
			$class_name = $name == 'Script $GLOBALS' ? 'globals' : strtolower(str_replace('$_', '', $name));
			$html .= '<tr><td class="'.$class_name.'"><div class="DbugL_SG">'.$name.'</div>';
			$html .= print_a($reference, $print_a_options);
			$html .= '</td></tr>';
		}

		$html .= '</table>'.script_runtime('after show_vars','background:#BBB;',TRUE,TRUE);

		if(@$options['return'] == '1') {
			return $html;
		} else {
			print $html;
		}

	}

	// prints out a mysql result.. work in progress.. use at your own risk
	function print_mysql_result($mysql_result, $return_mode = FALSE) {
		if(!$GLOBALS['USE_DEBUGLIB']) return;

		if(!$mysql_result || mysql_num_rows($mysql_result) < 1) return;

		$field_count = mysql_num_fields($mysql_result);

		$tables = array();

		for($i=0; $i<$field_count; $i++) {
			if(isset($tables[mysql_field_table($mysql_result, $i)])) {
				$tables[mysql_field_table($mysql_result, $i)]++;
			} else {
				$tables[mysql_field_table($mysql_result, $i)] = 1;
			}
		}

		$html = '
			<style type="text/css">
				table.DbugL_PR           { font-family: Verdana, Arial, Helvetica, Geneva, Swiss, SunSans-Regular, sans-serif; background:black; margin-bottom:10px; }
				table.DbugL_PR th.t_name { font-size:9pt; font-weight:bold; color:white; }
				table.DbugL_PR th.f_name { font-size:7pt; font-weight:bold; color:white; }
				table.DbugL_PR td        { padding-left:2px;font-size:7pt; white-space:nowrap; vertical-align:top; }
			</style>
			<script type="text/javascript">
				//<![CDATA[

				var DbugL_last_id;
				function DbugL_highlight(id) {
					if(DbugL_last_id) {
						DbugL_last_id.style.color = "#000000";
						DbugL_last_id.style.textDecoration = "none";
					}
					var highlight_td;
					highlight_td = document.getElementById(id);
					highlight_td.style.color ="#FF0000";
					highlight_td.style.textDecoration = "underline";
					DbugL_last_id = highlight_td;
				}

				//]]>
			</script>
		';

		$html .= '<table class="DbugL_PR" cellspacing="1" cellpadding="1">';
		$html .= '<tr>';
		foreach($tables as $tableName => $tableCount) {
			(!isset($col) || $col == '#006F05') ? $col = '#00A607' : $col = '#006F05';
			$html .= '<th colspan="'.$tableCount.'" class="t_name" style="background:'.$col.';">'.$tableName.'</th>';
		}
		$html .= '</tr>';

		$html .= '<tr>';
		for($i=0;$i < mysql_num_fields($mysql_result);$i++) {
			$field = mysql_field_name($mysql_result, $i);
			$col == '#0054A6' ? $col = '#003471' : $col = '#0054A6';
			$html .= '<th style="background:'.$col.';" class="f_name">'.$field.'</th>';
		}
		$html .= '</tr>';

		mysql_data_seek($mysql_result, 0);

		$toggle = FALSE;
		$pointer = 0;

		$table_id = str_replace('.', '', microtime(TRUE));
		while($db_row = mysql_fetch_array($mysql_result, MYSQL_NUM)) {
			$pointer++;
			if($toggle) {
				$col1 = "#E6E6E6";
				$col2 = "#DADADA";
			} else {
				$col1 = "#E1F0FF";
				$col2 = "#DAE8F7";
			}

			$toggle = !$toggle;
			$id = 'DbugL_'.$table_id.'_'.$pointer;
			$html .= '<tr id="'.$id.'" onMouseDown="DbugL_highlight(\''.$id.'\');">';
			foreach($db_row as $i => $value) {
				$col == $col1 ? $col = $col2 : $col = $col1;
				$flags = mysql_field_flags($mysql_result, $i);
				$primary_flag = strpos($flags, 'primary_key') !== FALSE;
				$html .= '<td style="background:'.$col.';'.($primary_flag ? 'font-weight:bold;' : '').'" nowrap="nowrap">'.nl2br($value).'</td>';
			}
			$html .= '</tr>';
		}
		$html .= '</table>';
		mysql_data_seek($mysql_result, 0);

		if($return_mode) {
			return $html;
		} else {
			print $html;
		}
	}

endif;

#TODO#
/*
	inject css through javascript (inline style is bad... m'kay?)
	unify options parsing
	debuglevel and default parameter arrays for every function
	fix fieldset width in IEx
	debug backtrace issues
	write a C extension that can test for reference recursions
	start from scratch :)
*/

