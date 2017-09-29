<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Language extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function change($language = NULL)
	{
		$available	= $this->config->item('language_available_list');
		if (!empty($language) && in_array($language, $available)) {
			$this->session->set_userdata('site_language', $language);
		}
		redirect($this->agent->referrer());
	}

}

/* End of file Language.php */
/* Location: ./application/controllers/Language.php */