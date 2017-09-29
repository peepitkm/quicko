<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LanguageLoader
{
	public function initialize() {
		$CI =& get_instance();

		$language	= $CI->session->userdata('site_language');
		$available	= $CI->config->item('language_available_list');
		if (!empty($language) && in_array($language, $available)) {
			$CI->lang->load('message', $language);
		} else {
			$CI->lang->load('message', $CI->config->item('language'));
		}
	}
}