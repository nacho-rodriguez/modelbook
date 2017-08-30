<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LanguageLoader
{
    function initialize() {
        $ci = &get_instance();
        $siteLang = $ci->session->userdata('site_lang');

        if ($siteLang) {
            $ci->lang->load('strings', $siteLang);
        } else {
            $ci->lang->load('strings', 'spanish');
        }
    }
}
