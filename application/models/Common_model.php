<?php
class Common_Model extends CI_Model
{
	function __construct()
	{
		global $URI, $CFG, $IN;
        $ci = get_instance(); 
        $ci->load->config('config');
        $this->setSiteConfigData();
        $this->setMemberConfigData();
        // $this->setCookieLangage();
        $this->setLocalTimeZone();

	}
	function setSiteConfigData()
	{
		$this->config->set_item('per_page',20);
		$this->config->set_item('per_page_front',4);
	}
	function setMemberConfigData()
	{
		if($this->session->userdata('user_id'))
		{
			$userData = $this->getUserDataById($this->session->userdata('user_id'));
			if($userData)
			{
				$this->config->set_item('name',$userData->name);
			}
		}
	}
	function getUserDataById($user_id)
	{
		$this->db->where('id',$user_id);
		$query = $this->db->get('tbl_users');
		$result = $query->row();
		return $result;
	}
	function setLocalTimeZone()
	{	
		if (!$this->session->userdata('local_time_zone'))
		{	
			$ip = $_SERVER['REMOTE_ADDR'];
			$ipInfo = file_get_contents('http://ip-api.com/json/' . $ip);
			$ipInfo = json_decode($ipInfo);

			if(isset($ipInfo->timezone) && !empty($ipInfo->timezone)){
				$timezone = $ipInfo->timezone;
			} else {
				$timezone = 'Asia/Kolkata';
			}
			
			$this->session->set_userdata('local_time_zone',$timezone);
			
		} 
		date_default_timezone_set($this->session->userdata('local_time_zone'));
	}
	function checkAdminLogin()
	{
		if($this->session->userdata('admin_id'))
		{
			return true;
		}
		else
		{
			if($this->input->is_ajax_request())
			{
				$data['success'] = false;
				$data['message'] = 'Please login first';
				$data['error_type'] = 'auth';
				echo json_encode($data); die;
			}
			else
			{
				redirect('admin/login');				
			}	
		}
	}

	function checkChildcareLogin()
	{
		if ($this->session->userdata('childcare_id')) {
			return true;

		} else {

			if ($this->input->is_ajax_request()) {
				$data['success'] = false;
				$data['message'] = 'Please login first';
				$data['error_type'] = 'auth';
				echo json_encode($data); die;

			} else {
				redirect('login');				
			}	
		}
	}

	function checkChildcareLoginInCustomer()
	{
		if ($this->session->userdata('childcare_id')) {
			redirect('dashboard');
		}
	}

	function checkAlreadyLogin()
	{
		if($this->session->userdata('USER_ID'))
		{
			$redirect = site_url();
			if($this->session->userdata('USER_TYPE') == 'Admin')
			{
				$redirect = site_url('');
			}
			else if($this->session->userdata('USER_TYPE') == 'User')
			{
				$redirect = site_url('applicant');
			}
			redirect($redirect);
		}
	}
	
	function checkRequestedDataExists($data)
	{
		if(!$data)
		{
			show_404();
		}
		return true;
	}
	function createSlugForTable($title,$table)
	{
		$slug = url_title($title);
		$slug = strtolower($slug);
		$i = 0;
		$params = array ();
		$params['slug'] = $slug;
		while ($this->db->where($params)->get($table)->num_rows()) 
		{
			if (!preg_match ('/-{1}[0-9]+$/', $slug )) 
			{
				$slug .= '-' . ++$i;
			}
			else 
			{
				$slug = preg_replace ('/[0-9]+$/', ++$i, $slug );
			}
			$params ['slug'] = $slug;
		}
		return $slug;
	}  
	function getOptionValue($slug = '', $language_abbr = '')
	{
		$this->db->select('*');
		$this->db->where('website_setting.slug',$slug);
		if($language_abbr)
			$this->db->where('website_setting.language_abbr',$language_abbr);
		$query = $this->db->get('website_setting');		
		$result = $query->row();
		if($result)
			return $result->value;
	}

	

	function checkLoginAdminStatus()
	{
		$user = $this->getLoginAdmin();
		if($user)
		{
			return true;
		}
		else
		{
			$this->session->sess_destroy();
			redirect('admin/login');
			return false;
		}
	}

	function getLoginAdmin()
	{
		$userId = $this->session->userdata('admin_id');
		$this->db->where('id', $userId);
		$this->db->where('status', 'Active');
		$query = $this->db->get('tbl_users');
		$result = $query->row();
		return $result;
	}
	
	function getDefaultToGMTTime($time)
	{
		$gmtTime = local_to_gmt($time);
		return $gmtTime;
	}
	function getDefaultToGMTDate($time,$format = 'Y-m-d H:i:s')
	{
		$gmtTime = local_to_gmt($time);
		return date($format,$gmtTime);
	}
	function getGMTDateToLocalDate($date, $format = 'Y-m-d H:i:s')
	{
		$date = new DateTime($date, new DateTimeZone('GMT'));
		$date->setTimeZone(new DateTimeZone($this->session->userdata('local_time_zone')));
		return $date->format($format);
	}
	function getGMTDateToUserLocalDate($date, $time_zone, $format = 'Y-m-d H:i:s')
	{
		$date = new DateTime($date, new DateTimeZone('GMT'));
		$date->setTimeZone(new DateTimeZone($time_zone));
		return $date->format($format);
	}
	function showLimitedText($string,$len) 
	{
		$string = strip_tags($string);
		if (strlen($string) > $len)
			$string = mb_substr($string, 0, $len-3) . "...";
		return $string;
	}
	function checkUserLogin()
	{
		if($this->session->userdata('user_id'))
		{
			return true;
		}
		else
		{
			if($this->input->is_ajax_request())
			{
				$data['success'] = false;
				$data['message'] = 'Please login first';
				$data['error_type'] = 'auth';
				echo json_encode($data); die;
			}
			else
			{
				redirect('login');				
			}
		}
	}

	function checkLoginUserStatus()
	{
		$user = $this->getLoginUser();
		if($user)
		{

		}
		else
		{
			$this->session->sess_destroy();
			redirect('login');
			return false;
		}
	}

	function getLoginUser()
	{
		$userId = $this->session->userdata('user_id');
		$this->db->where('id',$userId);
		$this->db->where('status','Active');
		// $this->db->where('is_email_verified','Yes');
		$query = $this->db->get('tbl_users');
		$result = $query->row();
		return $result;
	}

	//Check Login user for front
	function checkUseAlreadyLogin()
	{
		$userId = $this->session->userdata('user_id');
		
		if ($userId) {
			redirect('classes');
		
		} else {
			return false;
		}
	}

	function getUserImageUrl($user_id =NULL,$width =200, $height =200)
	{
		
		if (!$user_id) {
			$image = site_url('assets/uploads/required/no_image_user.png');
			return $image;
		}
		$userData = $this->getUserDataById($user_id);
		
		if ($userData && $userData->profile_image) {
			$image = site_url('assets/uploads/users/'.$userData->profile_image);
		
		} else {
			$image = site_url('assets/uploads/required/no_image_user.png');
		}
		return $image;
	}

	public function resize_image($directory,$image_url, $height, $width)
    {

        @mkdir($directory,0777,true);
        @chmod($directory, 0777);
        $config['image_library'] = 'gd2';
        $config['source_image'] = $image_url;
        $config['create_thumb'] = false;
        $config['maintain_ratio'] = true;
        $config['width'] = $width;
        $config['height'] = $height;
        $config['new_image'] = './'.$directory;
        $config['thumb_marker'] = '';
        $this->image_lib->clear();
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
    }
	
	public function resize_image1($directory,$image_url, $height, $width, $image_name)
    {
        // $this->load->library('image_magician');
        @mkdir($directory,0777,true);
        @chmod($directory, 0777);
        $config['image_library'] = 'gd2';
        $config['source_image'] = $image_url;
        $config['create_thumb'] = false;
        $config['maintain_ratio'] = true;
        $config['width'] = $width;
        $config['height'] = $height;
        $config['new_image'] = './'.$directory;
        $config['thumb_marker'] = '';
        $this->image_lib->clear();
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
        // $imgdata=exif_read_data($config['source_image']);
        
        $rotation_angle = 0;
      
        $config['image_library'] = 'gd2';
        $config['source_image'] = './'.$directory.$image_name;
        // switch($imgdata['Orientation'])
        // {
        //         case 1: // no need to perform any changes
        //         break;
        
        //         case 2: // horizontal flip
        //         $oris[] = 'hor';
        //         break;
                                        
        //         case 3: // 180 rotate left
        //             $oris[] = '180';
        //         break;
                            
        //         case 4: // vertical flip
        //             $oris[] = 'ver';
        //         break;
                        
        //         case 5: // vertical flip + 90 rotate right
        //             $oris[] = 'ver';
        //         $oris[] = '270';
        //         break;
                        
        //         case 6: // 90 rotate right
        //             $oris[] = '270';
        //         break;
                        
        //         case 7: // horizontal flip + 90 rotate right
        //             $oris[] = 'hor';
        //         $oris[] = '270';
        //         break;
                        
        //         case 8: // 90 rotate left
        //             $oris[] = '90';
        //         break;
                
        //     default: break;
        // }
       
        // foreach ($oris as $ori) {
        //     $config['rotation_angle'] = $ori;
        //     $this->image_lib->initialize($config);
        //     $this->image_lib->rotate();
        // }
    }

    function checkChildcarePlanPurchase()
	{
		$user_id = $this->session->userdata('childcare_id');

		if ($user_id) {
			$user_plan = $this->getRunningPlan($user_id);

			if (!$user_plan) {
				redirect('purchase-plan');

			} else {
				return $user_plan;
			}

			if ($this->input->is_ajax_request() && !$user_plan) {
				$data['success'] = false;
				$data['message'] = 'Please purchase plan first';
				echo json_encode($data); die;
			}

		} else {

			if ($this->input->is_ajax_request()) {
				redirect('login');				

			} else {
				redirect('login');				
			}	
		}
	}

	function getRunningPlan($user_id) {
        $this->db->where('user_id',$user_id);
        $this->db->where('plan_status','Running');
        $records = $this->db->get('tbl_user_membership_plan');
        return $records->row();
    }
}