<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SIGMA_Validation extends CI_Validation
{

    function __construct()
    {
        parent::__construct();
    }
    
    function recaptcha_matches()
    {
        $CI =& get_instance();
        $CI->config->load('recaptcha');
        $public_key = $CI->config->item('recaptcha_public_key');
        $private_key = $CI->config->item('recaptcha_private_key');
        $response_field = $CI->input->post('recaptcha_response_field');
        $challenge_field = $CI->input->post('recaptcha_challenge_field');
        $response = recaptcha_check_answer($private_key,
                                           $_SERVER['REMOTE_ADDR'],
                                           $challenge_field,
                                           $response_field);
        if ($response->is_valid)
        {
            return TRUE;
        }
        else
        {
            $CI->validation->recaptcha_error = $response->error;
            $CI->validation->set_message('recaptcha_matches', 'The %s is incorrect. Please try again.');
            return FALSE;
        }
    }

}