<?php 
function showLimitedText($string,$len = 10) 
{
	$string = strip_tags($string);
	if (strlen($string) > $len)
		$string = mb_substr($string, 0, $len-3) . "...";
	return $string;
}


if (!function_exists('pr')) {

    function pr($arr) {
        echo '<pre>';
        print_r($arr);
        echo '</pre>';
    }
}

  function sms_code_send($to, $message) {
        // Check SMS Balance, if it has credit. It will send the message with $to, $message parameters.
            //Your message to send, Add URL encoding here.
            $message = urlencode($message);

            //Define route
            $route = "4";

            //Prepare you post parameters
            $postData = '{
                "sender": "daycar",
                "route": "'.$route.'",
                "country": "91",
                "sms": [
                    {
                        "message": "'.$message.'",
                        "to": [
                            "'.$to.'"
                        ]
                    }
                ]
            }';        

            //API URL
            $url="https://control.msg91.com/api/sendhttp.php";

            // init the resource
            $ch = curl_init();
            curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",

            // CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTPHEADER => array(
                "authkey: '293790ATaXFu8F5d7a6109'",
                "content-type: application/json"),
            ));

            //get response
            $response = curl_exec($ch);
            $err = curl_error($ch);
            
            curl_close($ch);

            if ($err) {
              echo "cURL Error #:" . $err;
            }
            else
            {
                $result = json_decode($response);

                if ($result){
                    return TRUE;
                }
                else{

                    return FALSE;
                }        
            }

                
  }


if(!function_exists('escape_text')){
  function escape_text($s = ''){
      return str_replace('&#039;', "'", htmlspecialchars_decode(html_entity_decode($s)));
  } 
}

function get_social_link(){
  $ci = & get_instance();
  $query = $ci->db->get('website_setting');
  $result = $query->result();
  return $result;
}

function getSiteOption($key = '', $value = false){
  	if($key == ''){
    	return false;
  	}
  	$CI = & get_instance();
  	$CI->load->model('admin/website_model', 'website');
  	$value = $CI->website->getValueBySlug($key, $value);
  	return $value;
}

function getHomePageOption($key = '', $value = false){
    if($key == ''){
      return false;
    }
    $CI = & get_instance();
    $CI->load->model('front/home_model', 'home');
    $value = $CI->home->getValueBySlug($key, $value);
    return $value;
}

if(!function_exists('is_logged_in')){
  function is_logged_in(){
    global $CI;
    $CI = & get_instance(); 
    if($CI->session->userdata('admin_id')){
       return true;
    }
    else
    {
       return false;
    } 
    return false;
  }
}

if(!function_exists('is_childcare_logged_in')){
  function is_childcare_logged_in(){
    global $CI;
    $CI = & get_instance(); 
    if($CI->session->userdata('user_id')){
       return true;
    }
    else
    {
       return false;
    } 
    return false;
  }
}

if(!function_exists('is_user_logged_in')){
  function is_user_logged_in(){
    global $CI;
    $CI = & get_instance(); 
    if($CI->session->userdata('user_id')){
       return true;
    }
    else
    {
       return false;
    } 
    return false;
  }
}

function getMailConstants(){
  $constants = [
    'Logo'                => '{{Logo}}',
    'Email_Address'       => '{{Email_Address}}',
    'Subject'             => '{{Subject}}',
    'Website_UR'          => '{{Website_URL}}',
    'Unsubscription_Link' => '{{Unsubscription_Link}}',
  ];
  return $constants;
}

function getImageURL($content)
{
    preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', $content, $img);       
    $url = $img[1];
    if($url)
    {
        return $url;
    }
    else
    {
        return false;
    }
}

function get_random_string($length = 10) 
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function getUserDetailByToken($token)
{
  $CI = & get_instance();
  $CI->load->model('api/user_model', 'users');
  
  if (!empty($token)) {
    $user_detail = $CI->users->getRecordByToken($token);
    
    if ($user_detail) {
      
      if ($user_detail->status == 'Inactive') {

        $response = array('status'=>'error','message' => 'You have been Inactive from administrator, Please contact to administrator.','error_code' => 'inactive_user','data'=>array());
        $CI->response($response, 200);
      
      } else {
        return $user_detail;
      }

    } else {
      $response = array('status'=>'error','message' => 'Session Expired it Seems Someone Login with Your Credential in Another Device!!!','error_code' => 'delete_user','data'=>array());
      $CI->response($response, 200);
    }

  } else {
    $response = array('status'=>'error','message' => 'Token is required.','error_code' => 'delete_user','data'=>array());
    $CI->response($response, 200);
  }

}

function imageUplaod( $directory = '', $image = array(), $img = '' )
{
  $data = array();

  @mkdir($directory,0777,true);
  @chmod($directory, 0777);
  $timestamp_str = time();
  $file_name = $timestamp_str.'_'.$image[$img]['name'];
  $file_type = $image[$img]['type'];

  if ($file_type == "image/jpeg" || $file_type == "image/jpg" || $file_type == "image/png") {
    $target = $directory. $file_name;
    
    if (move_uploaded_file($image[$img]['tmp_name'], $target)) {
      $data['file_name'] = $file_name;
      $data['file_type'] = $file_type;
      $data['message'] = 'success';
    
    } else {
      $data['file_name'] = '';
      $data['file_type'] = '';
      $data['message'] = "Error in uploading image."; 
    }

  } else {
    $data['file_name'] = '';
    $data['file_type'] = '';
    $data['message'] = "File Type Not Supported.";
  }

  return $data;
}

function sentOtp($otp, $mobile_number){
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => "http://2factor.in/API/V1/04c5337d-6eb4-11ea-9fa5-0200cd936042/SMS/".$mobile_number."/".$otp,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_POSTFIELDS => "",
    CURLOPT_HTTPHEADER => array(
      "content-type: application/x-www-form-urlencoded"
    ),
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);

  curl_close($curl);

  if ($err) {
    return false;
  } else {
    return true;
  }

}