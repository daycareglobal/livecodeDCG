<?php
class LanguageLoader
{

    function initialize() {
       
        $ci =& get_instance();
        $ci->load->helper('language');
        $siteLang = $ci->session->userdata('site_lang');
        if ($siteLang) {
            $ci->lang->load('Customer_login',$siteLang);
            $ci->lang->load('Customer_page',$siteLang);
            $ci->lang->load('Customer_signup',$siteLang);
            $ci->lang->load('footer',$siteLang);
            $ci->lang->load('header',$siteLang);
            $ci->lang->load('restaurant_contactus',$siteLang);
            $ci->lang->load('restaurant_login',$siteLang);
            $ci->lang->load('restaurant_page',$siteLang);
            $ci->lang->load('restaurant_signup',$siteLang);
        } else {
            $ci->lang->load('Customer_login','english');
            $ci->lang->load('Customer_page','english');
            $ci->lang->load('Customer_signup','english');
            $ci->lang->load('footer','english');
            $ci->lang->load('header','english');
            $ci->lang->load('restaurant_contactus','english');
            $ci->lang->load('restaurant_login','english');
            $ci->lang->load('restaurant_page','english');
            $ci->lang->load('restaurant_signup','english');

        }
    }
}
