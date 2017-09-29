<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Language Filter in Object
 *
 * Get data object with current language.
 *
 * @access	public
 * @param	object	object
 * @param	string	property
 * @return	string	
 */ 
if (!function_exists('lang_filter'))
{
	function lang_filter($object, $property) // subfix
	{
		$CI =& get_instance();
		if (is_object($object)) {
			$language = $CI->session->userdata('site_language');
			switch ($language) {
				case 'thai':
					$property .= '_th';
					break;
				case 'japaness':
					$property .= '_jp';
					break;
				default:
					$property .= '_en';
			}
			return $object->{$property};
		}
		return NULL;
	}
}

/**
 * Money Formatter
 *
 * Money formatting by number_format() in PHP
 *
 * @access	public
 * @param	int		number
 * @param	int		num_decimal_places
 * @return	string	
 */
 
if (! function_exists('to_money_format'))
{
	function to_money_format($number, $num_decimal_places = 2)
	{
		$format = '-';
		if (is_numeric($number)){
			$format = number_format(abs($number), $num_decimal_places);
			if ($number < 0) {
				$format = '('.$format.')';
			}
		}
		return $format;
	}
}

/**
 * Number Formatter
 *
 * Number formatting by number_format() in PHP
 *
 * @access	public
 * @param	int		number
 * @param	int		num_decimal_places
 * @return	string		
 */
 
if (! function_exists('to_number_format'))
{
	function to_number_format($number, $num_decimal_places = 0)
	{
		$format = '-';
		if (is_numeric($number)){
			$format = number_format(abs($number), $num_decimal_places);
		}
		return $format;
	}
}

/**
 * Time Format
 *
 * Time formatting by gmdate() in PHP
 *
 * @access	public
 * @param	type	name
 * @return	type	
 */
 
if (! function_exists('to_duration_format'))
{
	function to_duration_format($start, $end)
	{
		if (!empty($start) && !empty($end)) {
			return gmdate("H:i", abs(strtotime($start) - strtotime($end)));
		}else{
			return '-';
		}
	}
}

function today() {
	return date('Y-m-d');
}

function is_today($date) {
	return $date == date('Y-m-d');
}