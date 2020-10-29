<?php
class Mailsending_model extends CI_Model {
	var $from = "";
	//var $sendermail = "test@shopformeslc.com";
	var $sender_name 	= 'Daycare Fees';
	var $sitelogo 		= '';
	var $site_title 	= '';
	var $contact_email 	= '';
	var $banner_image 	= '';
	var $mailtype 		= 'html';
	var $social_icons 	= '';
	 
	function __construct() {
		$this->load->library('email');
		$config['protocol'] 	= "smtp";
      	$config['smtp_host'] 	= getSiteOption('smtp_host',true);
      	$config['smtp_port'] 	= getSiteOption('smtp_port',true);
      	$config['smtp_user'] 	= getSiteOption('smtp_user',true);
      	$config['smtp_pass'] 	= getSiteOption('smtp_pass',true);      	
      	$config['charset'] 		= "utf-8";
      	$this->email->initialize($config);
	}

	//Forgot Password email for admin sending url by controller
	function forgotPasswordUserMailSending($userId, $forgotPasswordKey, $url) {
		$template = $this->templatechoose('forgot-password');
		$subject = $template->subject;
		$user = $this->getUserRecordById($userId);
		$name = $user->name;
		$emailAddress = $user->email;
		$siteURL = '<a href="'.site_url().'">Visit Daycare Fees</a>';
		$logo = getSiteOption('website_logo',true);
		$logoURL = '<img src="'.$this->config->item('assets').'uploads/website_logo/'.$logo.'" alt="logo" class="logo-default"/>';
		$resetURL = $url;
		$str = $template->content;
		$str = str_replace('{{Logo}}', $logoURL, $str);
		$str = str_replace('{{Name}}', $name, $str);
		$str = str_replace('{{Email_Address}}', $emailAddress, $str);
		$str = str_replace('{{Website_URL}}', $siteURL, $str);
		$str = str_replace('{{Forgot_Password}}', $resetURL, $str);
		$this->sendEmail($emailAddress, $str, $subject);
	}

	//send email for notification
	function send_email_notification($userId, $template_id) {
		$template = $this->getTemplateById($template_id);
		$subject = $template->subject;
		$user = $this->getUserRecordById($userId);
		$name = $user->name;
		$emailAddress = $user->email;
		$siteURL = '<a href="'.site_url().'">Visit Daycare Fees</a>';
		$logo = getSiteOption('website_logo',true);
		$logoURL = '<img src="'.$this->config->item('assets').'uploads/website_logo/'.$logo.'" alt="logo" class="logo-default"/>';
		$str = $template->content;
		/*$str = str_replace('{{Logo}}', $logoURL, $str);
		$str = str_replace('{{Name}}', $name, $str);
		$str = str_replace('{{Email_Address}}', $emailAddress, $str);
		$str = str_replace('{{Website_URL}}', $siteURL, $str);*/
		$this->sendEmail($emailAddress, $str, $subject);
	}

	//Forgot Password email for app user sending otp by controller
	function forgotPasswordAppUser($otp, $name, $email) {
		$template = $this->templatechoose('forgot-password-user');
		$subject = $template->subject;
		$siteURL = '<a href="'.site_url().'">Visit Daycare Fees</a>';
		$logo = getSiteOption('website_logo',true);
		$logoURL = '<img src="'.$this->config->item('assets').'uploads/website_logo/'.$logo.'" alt="logo" class="logo-default"/>';
		$str = $template->content;
		$str = str_replace('{{Logo}}', $logoURL, $str);
		$str = str_replace('{{NAME}}', $name, $str);
		$str = str_replace('{{EMAIL}}', $email, $str);
		$str = str_replace('{{Website_URL}}', $siteURL, $str);
		$str = str_replace('{{FORGOT_PASSWORD_CODE}}', $otp, $str);
		$this->sendEmail($email, $str, $subject);
	}

	function thankYouEmail($name, $email) {
		$template = $this->templatechoose('thankyou-email');
		$subject = $template->subject;
		$siteURL = '<a href="'.site_url().'">Visit Daycare Fees</a>';
		$logo = getSiteOption('website_logo',true);
		$logoURL = '<img src="'.$this->config->item('assets').'uploads/website_logo/'.$logo.'" alt="logo" class="logo-default"/>';
		$str = $template->content;
		$str = str_replace('{{Logo}}', $logoURL, $str);
		$str = str_replace('{{Name}}', $name, $str);
		$this->sendEmail($email, $str, $subject);
	}

	//Get user by user id
	function getUserRecordById($id) {
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('tbl_users');
		$result = $query->row();
		return $result;
	}

	function getContactQueryById($id) {
		$this->db->select('*');
		$this->db->where('id',$id);
		$query = $this->db->get('tbl_contact_us');
		$result = $query->row();
		return $result;
	}
	
	function templatechoose($slug) {
		$this->db->where('slug', $slug);
		$query = $this->db->get('tbl_emails');
		return $query->row();
	}

	function getTemplateById($id) {
		$this->db->where('id', $id);
		$query = $this->db->get('tbl_send_emails_template');
		return $query->row();
	}
		
	function sendEmail($emailAddress, $data, $subject) {
		$smtpUser = getSiteOption('smtp_user', true);
		$this->email->from($smtpUser,'Daycare Fees');
		$this->email->to($emailAddress);
		$this->email->mailtype = $this->mailtype;
		$this->email->set_newline("\r\n");
	    $this->email->subject($subject);
        $this->email->message($data);
        $this->email->send();
	}

	//Email verified link sending according to language
	function sendEmailUserVerifiedLink($userId, $emailVerifiedKey)
	{
		$template = $this->templatechoose('welcome-new-user');
		$subject = $template->subject;
		$user = $this->getUserRecordById($userId);

		$firstName = $user->name;
		$lastName = $user->last_name;
		$emailAddress = $user->email;
		$siteURL = '<a href="'.site_url().'">Visit Daycare Fees</a>';
		// $logoURL = '';
		$logoURL = '<img src="'.$this->config->item('uploads').'website_logo/logo.png" alt="logo" class="logo-default"/>';
		$link = '<a href="'.site_url('users/verify_account/'.$emailVerifiedKey).'">Verified Link</a>';
		$str = $template->content;
		$str = str_replace('{{Logo}}', $logoURL, $str);
		$str = str_replace('{{Name}}', $firstName, $str);
		$str = str_replace('{{Email_Address}}', $emailAddress, $str);
		$str = str_replace('{{Website_URL}}', $siteURL, $str);
		$str = str_replace('{{Email_verified}}', $link, $str);
		$this->sendEmail($emailAddress, $str, $subject);				
	}

	//Email verified link sending for update profile
	function sendEmailUpdateVerifiedLink($userId, $emailVerifiedKey, $email)
	{
		$template = $this->templatechoose('welcome-new-user');
		$subject = $template->subject;
		$user = $this->getUserRecordById($userId);

		$firstName = $user->name;
		$lastName = $user->last_name;
		$emailAddress = $email;
		$siteURL = '<a href="'.site_url().'">Visit Daycare Fees</a>';
		// $logoURL = '';
		$logoURL = '<img src="'.$this->config->item('uploads').'website_logo/logo.png" alt="logo" class="logo-default"/>';
		$link = '<a href="'.site_url('users/verify_new_email/'.$emailVerifiedKey).'">Verified Link</a>';
		$str = $template->content;		$str 	= str_replace('{{Logo}}', $logoURL, $str);
		$str = str_replace('{{First_Name}}', $firstName, $str);
		$str = str_replace('{{Last_Name}}', $lastName, $str);
		$str = str_replace('{{Email_Address}}', $emailAddress, $str);
		$str = str_replace('{{Website_URL}}', $siteURL, $str);
		$str = str_replace('{{Email_verified}}', $link, $str);
		$this->sendEmail($emailAddress, $str, $subject);				
	}

	function send_email_by_admin_add_new_user($firstName,$lastName,$phoneNumber,$emailAddress,$password)
	{
		$template 		= $this->templatechoose('new-user');
		$subject 		= $template->subject;
		// $user 			= $this->getUserRecordById($userId);
		// $firstName 		= $user->first_name;
		// $lastName 		= $user->last_name;
		// $emailAddress 	= $user->email;
		$siteURL 		= '<a href="'.site_url().'">Visit Daycare Fees</a>';
		// $logoURL = '';
		$logoURL 		= '<img src="'.$this->config->item('uploads').'website_logo/logo.png" alt="logo" class="logo-default"/>';
		$str 	= $template->content;
		$str 	= str_replace('{{Logo}}', $logoURL, $str);
		$str 	= str_replace('{{First_Name}}', $firstName, $str);
		$str 	= str_replace('{{Last_Name}}', $lastName, $str);
		$str 	= str_replace('{{Phone_Number}}', $phoneNumber, $str);
		$str 	= str_replace('{{Email_Address}}', $emailAddress, $str);
		$str 	= str_replace('{{Password}}', $password, $str);
		$str 	= str_replace('{{Website_URL}}', $siteURL, $str);
		$this->sendEmail($emailAddress,$str,$subject);				
	}

	function replyContactQuery($replyMessage, $id) {

		$template = $this->templatechoose('reply-contact-query');
		$contactQuery = $this->getContactQueryById($id);

		if ($contactQuery) {
			$name = ($contactQuery->name)?$contactQuery->name:'';			
		}

		$replyMessage = $replyMessage;
		$emailAddress = $contactQuery->email;	
		$replySubject = $template->subject;
		$logo = getSiteOption('website_logo', true);
		$logoURL = '<img src="'.$this->config->item('assets').'uploads/website_logo/'.$logo.'" alt="logo" class="logo-default"/>';

		$visitor_query = $contactQuery->message;
		$str = $template->content;
		$str = str_replace('{{Logo}}', $logoURL, $str);
		$str = str_replace('{{Name}}', $name, $str);
		$str = str_replace('{{Email_Address}}',$emailAddress, $str);
		$str = str_replace('{{Visitor_query}}', $visitor_query, $str);
		$str = str_replace('{{Reply_Message}}', $replyMessage, $str);
		$str = str_replace('{{Reply_Subject}}', $replySubject, $str);
		$this->sendEmail($emailAddress, $str, $replySubject);
	}

	function send_contact_us_email_form_website($user_info) {
      //  pr($user_info); die;
		$template 		= $this->templatechoose('contact-us');
		$firstName 		= $user_info['name'];
		$email 			= $user_info['email'];
		$message 		= $user_info['query_message'];
		//$query_type 	= str_replace('_', ' ', $user_info['query_type']);
		$subject 		= "Contact Query From Website";
		$admin_detail 	= $this->get_admin_detail();
		$emailAddress 	= $admin_detail->email;
		$logoURL 		= '<img src="'.$this->config->item('uploads').'website_logo/logo.png" alt="logo" class="logo-default"/>';
		$str = $template->content;
		$str = str_replace('{{Logo}}', $logoURL, $str);
		$str = str_replace('{{First_Name}}', $firstName, $str);
		$str = str_replace('{{Email_Address}}', $email, $str);
		$str = str_replace('{{query_type}}', $email, $str);
		$str = str_replace('{{Message}}', $message, $str);
		$this->sendEmail($emailAddress,$str,$subject);
	}

	function send_customer_query_email_form_website($user_info) {

		$template 		= $this->templatechoose('contact-us');
		$firstName 		= $user_info['first_name'];
		$lastName 		= $user_info['last_name'];
		$email 			= $user_info['email'];
		$phoneNumber	= $user_info['contact_number'];
		$message 		= $user_info['message'];
		$subject 		= "Contact Us Message From Website";
		$admin_detail 	= $this->get_admin_detail();
		$emailAddress 	= $admin_detail->email;
		$logoURL 		= '<img src="'.$this->config->item('uploads').'website_logo/logo.png" alt="logo" class="logo-default"/>';
		$str = $template->content;
		$str = str_replace('{{Logo}}', $logoURL, $str);
		$str = str_replace('{{First_Name}}', $firstName, $str);
		$str = str_replace('{{Last_Name}}', $lastName, $str);
		$str = str_replace('{{Email_Address}}', $email, $str);
		$str = str_replace('{{Contact_Number}}', $phoneNumber, $str);
		$str = str_replace('{{Message}}', $message, $str);
		$this->sendEmail($emailAddress,$str,$subject);
	}

	function get_admin_detail(){
		$type = 'Admin';
		$this->db->select('email');
		$this->db->where('user_type', $type);
		$query = $this->db->get('tbl_users');
		return $query->row();
	}

	function SendApproveMail($id){
		$restaurant         = $this->get_restaurant_by_request($id);
		$restaurantName     = $restaurant->restaurant_name;
		$email     = $restaurant->email;
	    $template 		    = $this->templatechoose('approved-by-admin');
		$subject 			= $template->subject;
		$siteURL 			= '<a href="'.base_url().'reataurant/login"> Visit Daycare Fees </a>';
		$logoURL 			= '<img src="'.$this->config->item('uploads').'website_logo/logo.png" alt="logo" class="logo-default"/>';
		$str                = $template->content;
		$str = $template->content;
		$str = str_replace('{{Logo}}', $logoURL, $str);
		$str = str_replace('{{Restaurant_Name}}', $restaurantName, $str);
		$str = str_replace('{{Website_URL}}', $siteURL, $str);
		$this->sendEmail($email,$str,$subject);	
	}

	function send_quote_email($quote_basic_data, $email, $trading_name, $business_service, $provision_name, $special_education,$reference_number,$quote_session_data,$fees,$quote_expire_date,$company_registration_number,$distance_miles) {

		$template = $this->templatechoose('send-quote-request');
		$subject = $template->subject;
		$miles = $distance_miles;
		$post_code_1 = $quote_basic_data->post_code_1;
		$post_code_2 = '';
		if($quote_basic_data->post_code_2) {
			$post_code_2 = $quote_basic_data->post_code_2;
		}
		$bank_holidays = '';
		$christmas_week = '';
		$open_all_year = '';
		$week_summer = '';
		$week_spring = '';
		$week_autumn = '';
		$ofsted_registered = '';
		$ofsted_rating = '';
		$tax_free = '';
		$fifteen_funded_three_four_year = '';
		$fifteen_funded_two_year = '';
		$thirty_funded_three_four_year = '';
		$icon_url ='';
		$iconURL = '<img src="'.$this->config->item('assets').'front/images/icon.jpg" alt="icon" width="18"/>';

		if ($business_service->business_logo) {
			$business_logo = '<img src="'.$this->config->item('assets').'uploads/business_logo/'.$business_service->business_logo.'" height="110" width="110" alt="business logo"/>';
		} else {
			$business_logo = '<img src="'.$this->config->item('assets').'uploads/no_image.jpg" height="110" width="110" alt="business logo"/>';
		}
		
		if ($business_service->business_image_one) {
			$business_image_one = '<img src="'.$this->config->item('assets').'uploads/business_logo/'.$business_service->business_image_one.'" height="50px" width="50px" alt="business logo"/>';
		} else {
			$business_image_one = '';
		}

		if ($business_service->business_image_two) {
			$business_image_two = '<img src="'.$this->config->item('assets').'uploads/business_logo/'.$business_service->business_image_two.'"  height="50px" width="50px" alt="business logo"/>';
		} else {
			$business_image_two = '';
		}
		
		if ($business_service->business_image_three) {
			$business_image_three = '<img src="'.$this->config->item('assets').'uploads/business_logo/'.$business_service->business_image_three.'" alt="business logo"  height="50px" width="50px"/>';
		} else {
			$business_image_three = '';
		}
		
		if ($business_service->business_image_four) {
			$business_image_four = '<img src="'.$this->config->item('assets').'uploads/business_logo/'.$business_service->business_image_four.'" alt="business logo"  height="50px" width="50px"/>';
		} else {
			$business_image_four = '';
		}
		
		if ($business_service->business_image_five) {
			$business_image_five = '<img src="'.$this->config->item('assets').'uploads/business_logo/'.$business_service->business_image_five.'" alt="business logo"  height="50px" width="50px"/>';
		} else {
			$business_image_five = "";
		}
		
		if ($business_service->bank_holidays == 'Yes') { 
        	$bank_holidays = '<td><span style="font-weight: 500; font-family: "Montserrat", sans-serif; font-size: 18px; color: #111111;">Bank Holiday</span></td>';
        	
    	}

    	if ($business_service->christmas_week == 'Yes') { 
        	$christmas_week = '<td><span style="font-weight: 500; font-family: "Montserrat", sans-serif; font-size: 18px; color: #111111;">Christmas Week</span></td>';
       	} 

       	if ($business_service->open_all_year == 'Yes') { 
        	$open_all_year = '<td><span style="font-weight: 500; font-family: "Montserrat", sans-serif; font-size: 18px; color: #111111;">Open all Year Round</span></td>';
       	} 

        if ($business_service->summer_terms) { 
       		$week_summer = '<td><span style="font-weight: 500; font-family: "Montserrat", sans-serif; font-size: 18px; color: #111111;">'.$business_service->summer_terms.' weeks in Summer terms</span></td>';
        } 

       if ($business_service->spring_terms) { 
        	$week_spring = '<td><span style="font-weight: 500; font-family: "Montserrat", sans-serif; font-size: 18px; color: #111111;">'.$business_service->spring_terms.' weeks in Spring terms</span></td>';
       } 

       if ($business_service->autumn_terms) { 
       		$week_autumn = '<td><span style="font-weight: 500; font-family: "Montserrat", sans-serif; font-size: 18px; color: #111111;">'.$business_service->autumn_terms.' weeks in Autumn terms</span></td>';
       } 
       
		if ($business_service->ofsted_registered == 'Yes') { 
        	$ofsted_registered = '<td valign="middle" width="20">'.$iconURL.'</td>'.'<td valign="middle"><span style="font-weight: 400; font-size: 16px; font-family: "Montserrat", sans-serif; color: #333333;">Ofsted Registered</span></td>';
    	}

		if ($business_service->ofsted_rating) { 
        	$ofsted_rating = '<td valign="middle" width="20">'.$iconURL.'</td>'.'<td valign="middle"><span style="font-weight: 400; font-size: 16px; font-family: "Montserrat", sans-serif; color: #333333;">'.$business_service->ofsted_rating.'</span></td>';
    	}

		if ($business_service->tax_free == 'Yes') { 
        	$tax_free = '<td valign="middle" width="20">'.$iconURL.'</td>'.'<td valign="middle"><span style="font-weight: 400; font-size: 16px; font-family: "Montserrat", sans-serif; color: #333333;">Tax-free childcare scheme</span></td>';
    	}
    	
    	if ($business_service->fifteen_funded_two_year == 'Yes') { 
        	$ofsted_registered = '<td valign="middle" width="20">'.$iconURL.'</td>'.'<td valign="middle"><span style="font-weight: 400; font-size: 16px; font-family: "Montserrat", sans-serif; color: #333333;">15 funded hours for 2 years old</span></td>';
    	}

    	if ($business_service->fifteen_funded_three_four_year == 'Yes') { 
        	$fifteen_funded_three_four_year = '<td valign="middle" width="20">'.$iconURL.'</td>'.'<td valign="middle"><span style="font-weight: 400; font-size: 16px; font-family: "Montserrat", sans-serif; color: #333333;">15 funded hours for 3 and 5 years old</span></td>';
    	}

    	if ($business_service->thirty_funded_three_four_year == 'Yes') {
        	$thirty_funded_three_four_year = '<td valign="middle" width="20">'.$iconURL.'</td>'.'<td valign="middle"><span style="font-weight: 400; font-size: 16px; font-family: "Montserrat", sans-serif; color: #333333;">30 funded hours for 3 and 5 years old</span></td>';
    	} 

		$siteURL = '<a href="'.site_url().'">Visit Daycare</a>';
		$logo = getSiteOption('website_logo',true);
		$logoURL = '<img src="'.$this->config->item('assets').'uploads/website_logo/'.$logo.'" alt="logo" class="logo-default"/>';
		$str = $template->content;
		$str = str_replace('{{Logo}}', $logoURL, $str);
		$str = str_replace('{{trading_name}}', $trading_name, $str);
		$str = str_replace('{{business_logo}}', $business_logo, $str);
		$str = str_replace('{{business_image_one}}', $business_image_one, $str);
		$str = str_replace('{{business_image_two}}', $business_image_two, $str);
		$str = str_replace('{{business_image_three}}', $business_image_three, $str);
		$str = str_replace('{{business_image_four}}', $business_image_four, $str);
		$str = str_replace('{{business_image_five}}', $business_image_five, $str);
		$str = str_replace('{{miles}}', $miles, $str);
		$str = str_replace('{{post_code_1}}', $post_code_1, $str);
		$str = str_replace('{{post_code_2}}', $post_code_2, $str);
		$str = str_replace('{{provision_name}}', $provision_name, $str);
		$str = str_replace('{{special_education}}', $special_education, $str);
		$str = str_replace('{{bank_holidays}}', $bank_holidays, $str);
		$str = str_replace('{{christmas_week}}', $christmas_week, $str);
		$str = str_replace('{{open_all_year}}', $open_all_year, $str);
		$str = str_replace('{{week_summer}}', $week_summer, $str);
		$str = str_replace('{{week_spring}}', $week_spring, $str);
		$str = str_replace('{{week_autumn}}', $week_autumn, $str);
		$str = str_replace('{{$ofsted_registered}}', $ofsted_registered, $str);
		$str = str_replace('{{$ofsted_rating}}', $ofsted_rating, $str);
		$str = str_replace('{{$tax_free}}', $tax_free, $str);
		$str = str_replace('{{$fifteen_funded_three_four_year}}', $fifteen_funded_three_four_year, $str);
		$str = str_replace('{{$fifteen_funded_two_year}}', $fifteen_funded_two_year, $str);
		$str = str_replace('{{$thirty_funded_three_four_year}}', $thirty_funded_three_four_year, $str);
		$str = str_replace('{{reference_number}}', $reference_number, $str);
		$str = str_replace('{{quote_session_data}}', $quote_session_data, $str);
		$str = str_replace('{{company_registration_number}}', $company_registration_number, $str);
		$str = str_replace('{{fees}}', $fees, $str);
		$str = str_replace('{{quote_expire_date}}', date('d-M-Y', strtotime($quote_expire_date)), $str);
		$this->sendEmail($email, $str, $subject);
	}
}