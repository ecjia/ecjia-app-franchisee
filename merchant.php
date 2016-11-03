<?php
defined('IN_ECJIA') or exit('No permission resources.');

class merchant extends ecjia_merchant {
	
	public function __construct() {
		parent::__construct();
		
		$this->db_region = RC_Loader::load_model('region_model');

        RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('jquery-ui');
        RC_Script::enqueue_script('smoke');
        RC_Style::enqueue_style('uniform-aristo');
		
        RC_Script::enqueue_script('franchisee', RC_App::apps_url('statics/js/franchisee.js', __FILE__), array(), false, false);
        
		// input file 长传
		RC_Style::enqueue_style('ecjia-mh-bootstrap-fileupload-css');
		RC_Script::enqueue_script('ecjia-mh-bootstrap-fileupload-js');
		
		// 步骤导航条
		RC_Style::enqueue_style('bar', RC_App::apps_url('statics/css/bar.css', __FILE__), array());
		RC_Script::enqueue_script('migrate', RC_App::apps_url('statics/js/migrate.js', __FILE__) , array() , false, true);
		RC_Script::enqueue_script('region',RC_Uri::admin_url('statics/lib/ecjia-js/ecjia.region.js'));
		
		RC_Loader::load_app_func('functions');
		assign_adminlog_content();
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('商家入驻', RC_Uri::url('franchisee/merchant/init')));
	}

	public function init() {
		$step = isset($_GET['step']) ? $_GET['step'] : 1;
		$type = !empty($_GET['type']) ? trim($_GET['type']) : '';
		$mobile = !empty($_GET['mobile']) ? trim($_GET['mobile']) : '';
		
		$data = array();
		if ($step == 1) {
			$this->unset_session();
			
			if ($type == 'edit_apply') {
				$data = RC_DB::table('store_preaudit')->where('contact_mobile', $mobile)->first();
			}
			if (empty($data['validate_type'])) {
				$data['validate_type'] = 1;
			}
			$this->assign('info', $data);
			
		} elseif ($step == 2) {
			//个人信息
			$info = array(
				'validate_type' 		=> isset($_SESSION['validate_type']) 		? intval($_SESSION['validate_type']) 		: 1,
				'responsible_person' 	=> isset($_SESSION['responsible_person']) 	? trim($_SESSION['responsible_person']) 	: '',
				'email' 				=> isset($_SESSION['email']) 				? trim($_SESSION['email']) 					: '',
			);
			$this->assign('info', $info);
			
			if ($type == 'edit_apply') {
				$data = RC_DB::table('store_preaudit')->where('contact_mobile', $mobile)->first();
			}
			$province   = $this->db_region->get_regions(1, 1);
			$city       = $this->db_region->get_regions(2, $data['province']);
			$district   = $this->db_region->get_regions(3, $data['city']);
			$this->assign('province', $province);
			$this->assign('city', $city);
			$this->assign('district', $district);
			$data['identity_pic_front']  	= !empty($data['identity_pic_front'])		? RC_Upload::upload_url($data['identity_pic_front']) 		: '';
			$data['identity_pic_back']    	= !empty($data['identity_pic_back'])		? RC_Upload::upload_url($data['identity_pic_back']) 		: '';
			$data['personhand_identity_pic']= !empty($data['personhand_identity_pic'])	? RC_Upload::upload_url($data['personhand_identity_pic']) 	: '';
			$data['business_licence_pic'] 	= !empty($data['business_licence_pic'])		?  RC_Upload::upload_url($data['business_licence_pic']) 	: '';
			$this->assign('data', $data);
			
			$cat_list = $this->get_cat_select_list();
			$this->assign('cat_list', $cat_list);
			
			$certificates_list = array(
				'1' => '身份证',
				'2' => '护照',
				'3' => '港澳通行证',
			);
			$this->assign('certificates_list', $certificates_list);
			$this->assign('contact_mobile', $_SESSION['mobile']);
		} elseif ($step == 3) {
			$this->unset_session(true);
			$this->assign('edit_apply', RC_Uri::url('franchisee/merchant/init', array('type' => 'edit_apply', 'step' => 1, 'mobile' => $mobile)));
			$this->assign('remove_apply', RC_Uri::url('franchisee/merchant/remove_apply', array('mobile' => $mobile)));
			
		} elseif ($step == 4) {
			$data = $refuse_info = '';
			$this->unset_session();
			
			if (!empty($mobile) && $mobile == $_SESSION['mobile']) {
				$data = RC_DB::table('store_preaudit')->where('contact_mobile', $mobile)->first();
				if (!empty($data)) {
					if ($data['check_status'] == 1) {
						$message = '<span class="ecjiafc-blue">正在审核中，请耐心等待...</span>';
					} elseif ($data['check_status'] == 3) {
						$message = '<span class="ecjiafc-red">很抱歉，审核未通过，您可以点击右侧按钮修改申请信息</span>';
						$id = RC_DB::table('store_check_log')->where('store_id', $data['id'])->max('id');
						$refuse_info = RC_DB::table('store_check_log')->where('id',$id)->first();
						$this->assign('refuse_info', $refuse_info['info']);
					}
					$check_log_list = RC_DB::table('store_check_log')->where('store_id', $data['id'])->get();
					
					$this->assign('edit_apply', RC_Uri::url('franchisee/merchant/init', array('type' => 'edit_apply', 'step' => 1, 'mobile' => $mobile)));
					$this->assign('remove_apply', RC_Uri::url('franchisee/merchant/remove_apply', array('mobile' => $mobile)));
				} else {
					$data = RC_DB::table('store_franchisee')->where('contact_mobile', $mobile)->first();
					$message = '<span class="ecjiafc-blue">恭喜您，审核通过</span>';
					$check_log_list = RC_DB::table('store_check_log')->where('store_id', $data['store_id'])->get();
				}
				
				$data['province']				= !empty($data['province'])					? $this->get_region_name($data['province']) : '';
				$data['city']					= !empty($data['city'])						? $this->get_region_name($data['city'])		: '';
				$data['district']				= !empty($data['district'])					? $this->get_region_name($data['district'])	: '';
				$data['identity_pic_front']  	= !empty($data['identity_pic_front'])		? RC_Upload::upload_url($data['identity_pic_front']) 		: '';
				$data['identity_pic_back']    	= !empty($data['identity_pic_back'])		? RC_Upload::upload_url($data['identity_pic_back']) 		: '';
				$data['personhand_identity_pic']= !empty($data['personhand_identity_pic'])	? RC_Upload::upload_url($data['personhand_identity_pic']) 	: '';
				$data['business_licence_pic'] 	= !empty($data['business_licence_pic'])		?  RC_Upload::upload_url($data['business_licence_pic']) 	: '';
				$data['cat_name'] 				= RC_DB::table('store_category')->where('cat_id', $data['cat_id'])->pluck('cat_name');
				
				if (!empty($check_log_list)) {
					foreach ($check_log_list as $k => $v) {
						$check_log_list[$k]['time'] = RC_Time::local_date('Y-m-d H:i:s', $v['time']);
					}
				}
				$this->assign('check_log_list', $check_log_list);
				$this->assign('message', $message);
				$this->assign('data', $data);
			} else {
				$links[] = array('text' => '返回申请入驻', 'href' => RC_Uri::url('franchisee/merchant/init'));
				$this->showmessage('操作失败', ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => $links));
			}
		}
		$province   = $this->db_region->get_regions(1, 1);
		$city       = $this->db_region->get_regions(2, $data['province']);
		$district   = $this->db_region->get_regions(3, $data['city']);
		$this->assign('province', $province);
		$this->assign('city', $city);
		$this->assign('district', $district);
		
		if ($type == 'edit_apply') {
			$ur_here = '修改申请';
		} else {
			$ur_here = '申请入驻';
			$this->assign('action_link', array('href' => RC_Uri::url('franchisee/merchant/view'), 'text' => '查询审核进度'));
		}
		
		$this->assign('ur_here', $ur_here);
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($ur_here));
		
		$this->assign('type', $type);
		$this->assign('step', $step);
		
		if (!empty($type)) {
			$arr['type'] = $type;
		}
		$arr['step'] = $step;
		$arr['mobile'] = $mobile;
		$this->assign('form_action', RC_Uri::url('franchisee/merchant/insert', $arr));
		
		$this->display('franchisee.dwt');
	}
	
	public function get_code_value() {
		$mobile = isset($_GET['mobile']) ? $_GET['mobile'] : '';
		if (empty($mobile)){
			$this->showmessage('请输入手机号码', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
// 		$_SESSION['mobile'] 		= $mobile;
// 		$_SESSION['temp_code'] 		= 1234;
// 		$_SESSION['temp_code_time'] = RC_Time::gmtime();
// 		$this->showmessage('手机验证码发送成功，请注意查收', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		
		$code = rand(100000, 999999);
		$tpl_name = 'sms_get_validate';
		$tpl = RC_Api::api('sms', 'sms_template', $tpl_name);

		if (!empty($tpl)) {
			$this->assign('code', $code);
			$this->assign('service_phone', 	ecjia::config('service_phone'));
			$content = $this->fetch_string($tpl['template_content']);

			$options = array(
				'mobile' 		=> $mobile,
				'msg'			=> $content,
				'template_id' 	=> $tpl['template_id'],
			);
			$response = RC_Api::api('sms', 'sms_send', $options);

			if ($response === true) {
				$_SESSION['mobile'] 	= $mobile;
				$_SESSION['temp_code'] 	= $code;
				$_SESSION['temp_code_time'] = RC_Time::gmtime();
				$this->showmessage('手机验证码发送成功，请注意查收', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
			} else {
				$this->showmessage('手机验证码发送失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		};
	}
	
	public function insert() {
		$step = !empty($_GET['step']) ? $_GET['step'] : 1;
		$type = !empty($_GET['type']) ? $_GET['type'] : '';
		
		if ($step == 1) {
			$code 	= !empty($_POST['code'])   ? $_POST['code'] 		: '';
			$mobile = !empty($_POST['mobile']) ? trim($_POST['mobile']) : '';
			$email  = !empty($_POST['email'])  ? trim($_POST['email'])	: '';
			$time = RC_Time::gmtime() - 6000*3;
			
			if (empty($email)) {
				$this->showmessage('请输入电子邮箱', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			
			$_SESSION['mobile'] 			= $mobile;
			$_SESSION['validate_type'] 		= !empty($_POST['validate_type']) 		? intval($_POST['validate_type'])		: 1;	//个人1  企业2
			$_SESSION['responsible_person'] = !empty($_POST['responsible_person']) 	? trim($_POST['responsible_person'])	: '';	//负责人
			$_SESSION['email']		 		= $email;	//电子邮箱
			
			if (!empty($code) && $code == $_SESSION['temp_code'] && $time < $_SESSION['temp_code_time'] && $mobile == $_SESSION['mobile']) {
				if ($type != 'edit_apply') {
					//判断该手机号是否已申请
					$count_preaudit = RC_DB::table('store_preaudit')->where('contact_mobile', $mobile)->count();
					$count_franchisee = RC_DB::table('store_franchisee')->where('contact_mobile', $mobile)->count();
						
					if ($count_preaudit != 0) {
						$this->showmessage('该手机号正在申请入驻，无法再次申请', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
					} elseif ($count_franchisee != 0) {
						$this->showmessage('该手机号已申请入驻，无法再次申请', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
					}
					
					//判断邮箱是否已存在
					$count_preaudit_email = RC_DB::table('store_preaudit')->where('email', $email)->count();
					$count_franchisee_email = RC_DB::table('store_franchisee')->where('email', $email)->count();
					
					if ($count_preaudit_email != 0 || $count_franchisee_email != 0) {
						$this->showmessage('该邮箱已存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
					}
				}
				if (!empty($type)) {
					$arr['type'] = $type;
				}
				$arr['step'] = 2;
				$arr['mobile'] = $mobile;
				
				$this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => RC_Uri::url('franchisee/merchant/init', $arr)));
			} else {
				$this->showmessage('请输入正确的手机验证码', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}

		} elseif ($step == 2) {
			$cat_id 			= !empty($_POST['store_cat'])			? intval($_POST['store_cat'])	  		: 0;			//店铺分类
			$merchants_name 	= !empty($_POST['merchants_name'])  	? trim($_POST['merchants_name'])		: '';			//店铺名称
			$shop_keyword 		= !empty($_POST['shop_keyword'])  		? trim($_POST['shop_keyword'])			: '';			//店铺名称
			
			$validate_type 		= !empty($_SESSION['validate_type']) 		? intval($_SESSION['validate_type'])		: 1;			//个人1  企业2
			$responsible_person = !empty($_SESSION['responsible_person']) 	? trim($_SESSION['responsible_person'])		: '';			//负责人
			$email		 		= !empty($_SESSION['email'])  				? trim($_SESSION['email'])					: '';			//电子邮箱
			$address			= !empty($_POST['address'])  			? trim($_POST['address'])				: '';			//通讯地址
			$contact_mobile		= !empty($_POST['contact_mobile'])  	? trim($_POST['contact_mobile'])		: '';			//联系方式
			
			$province			= !empty($_POST['province'])			? intval($_POST['province'])			: 0;			//省
			$city				= !empty($_POST['city'])				? intval($_POST['city'])				: 0;			//城市
			$district			= !empty($_POST['district'])			? intval($_POST['district'])			: 0;			//地区
			
			$identity_type		= !empty($_POST['identity_type'])		? intval($_POST['identity_type'])		: 1;			//证件类型
			$identity_number	= !empty($_POST['identity_number'])		? trim($_POST['identity_number'])		: '';			//证件号码

			//银行账户信息
			$bank_name 			= !empty($_POST['bank_name']) 			? trim($_POST['bank_name']) 			: '';
			$bank_branch_name 	= !empty($_POST['bank_branch_name']) 	? trim($_POST['bank_branch_name']) 		: '';
			$bank_account_number= !empty($_POST['bank_account_number']) ? trim($_POST['bank_account_number']) 	: '';
			$bank_account_name 	= !empty($_POST['bank_account_name']) 	? trim($_POST['bank_account_name']) 	: '';
			$bank_address 		= !empty($_POST['bank_address']) 		? trim($_POST['bank_address']) 			: '';
			
			$longitude			= !empty($_POST['longitude'])			? $_POST['longitude']					: '';
			$latitude			= !empty($_POST['latitude'])			? $_POST['latitude']					: '';
			
			//判断该手机号是否已申请
			$count_franchisee = RC_DB::table('store_franchisee')->where('contact_mobile', $contact_mobile)->count();
			$count_preaudit = RC_DB::table('store_preaudit')->where('contact_mobile', $contact_mobile)->count();
			$mobile = !empty($_GET['mobile']) ? trim($_GET['mobile']) : '';
			
			if (empty($mobile) || $mobile != $_SESSION['mobile']) {
				$this->showmessage('手机号不正确', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			
			if ($type != 'edit_apply') {
				if ($count_franchisee != 0 || $count_preaudit != 0) {
					$this->showmessage('该手机号已申请入驻，无法再次申请', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			}
			
			if (empty($merchants_name)) {
				$this->showmessage('店铺名称不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			
			$info = RC_DB::table('store_preaudit')->where('contact_mobile', $mobile)->first();
			if (!empty($info)) {
				$old_identity_pic_front 		= $info['identity_pic_front'];
				$old_identity_pic_back 			= $info['identity_pic_back'];
				$old_personhand_identity_pic 	= $info['personhand_identity_pic'];
				$old_business_licence_pic 		= $info['business_licence_pic'];
			}
			$identity_pic_front = $identity_pic_back = $personhand_identity_pic = $business_licence_pic = '';
			
			$upload = RC_Upload::uploader('image', array('save_path' => 'data/merchant', 'auto_sub_dirs' => false));
			//证件正面
			if ((isset($_FILES['identity_pic_front']['error']) && $_FILES['identity_pic_front']['error'] == 0) || (!isset($_FILES['identity_pic_front']['error']) && isset($_FILES['identity_pic_front']['tmp_name'] ) &&$_FILES['identity_pic_front']['tmp_name'] != 'none')) {
				$identity_pic_front_info = $upload->upload($_FILES['identity_pic_front']);
				if (!empty($identity_pic_front_info)) {
					$identity_pic_front = $upload->get_position($identity_pic_front_info);
					
					//删除旧的
					if (!empty($old_identity_pic_front)) {
						$upload->remove($old_identity_pic_front);
					}
				} else {
					$this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			}
			
			//证件反面
			if ((isset($_FILES['identity_pic_back']['error']) && $_FILES['identity_pic_back']['error'] == 0) || (!isset($_FILES['identity_pic_back']['error']) && isset($_FILES['identity_pic_back']['tmp_name'] ) &&$_FILES['identity_pic_back']['tmp_name'] != 'none')) {
				$identity_pic_back_info = $upload->upload($_FILES['identity_pic_back']);
				if (!empty($identity_pic_back_info)) {
					$identity_pic_back = $upload->get_position($identity_pic_back_info);
					
					//删除旧的
					if (!empty($old_identity_pic_back)) {
						$upload->remove($old_identity_pic_back);
					}
				} else {
					$this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			}
			
			//手持证件
			if ((isset($_FILES['personhand_identity_pic']['error']) && $_FILES['personhand_identity_pic']['error'] == 0) || (!isset($_FILES['personhand_identity_pic']['error']) && isset($_FILES['personhand_identity_pic']['tmp_name'] ) &&$_FILES['personhand_identity_pic']['tmp_name'] != 'none')) {
				$personhand_identity_pic_info = $upload->upload($_FILES['personhand_identity_pic']);
				if (!empty($personhand_identity_pic_info)) {
					$personhand_identity_pic = $upload->get_position($personhand_identity_pic_info);
					
					//删除旧的
					if (!empty($old_personhand_identity_pic)) {
						$upload->remove($old_personhand_identity_pic);
					}
				} else {
					$this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			}
			
			$company_name = $business_licence = '';
			if ($validate_type == 2) {
				$company_name		= !empty($_POST['company_name'])		? trim($_POST['company_name'])		: '';			//公司名称
				$business_licence 	= !empty($_POST['business_licence'])	? trim($_POST['business_licence'])	: '';			//营业执照注册号
				
				//营业执照电子版
				if ((isset($_FILES['business_licence_pic']['error']) && $_FILES['business_licence_pic']['error'] == 0) || (!isset($_FILES['business_licence_pic']['error']) && isset($_FILES['business_licence_pic']['tmp_name'] ) &&$_FILES['business_licence_pic']['tmp_name'] != 'none')) {
					$business_licence_pic_info = $upload->upload($_FILES['business_licence_pic']);
					if (!empty($business_licence_pic_info)) {
						$business_licence_pic = $upload->get_position($business_licence_pic_info);
						
						//删除旧的
						if (!empty($old_business_licence_pic)) {
							$upload->remove($old_business_licence_pic);
						}
					} else {
						$this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
					}
				}
			}
			$data = array(
				'cat_id'   	   				=> $cat_id,
				'validate_type'				=> $validate_type,
				'merchants_name'   			=> $merchants_name,
				'shop_keyword'      		=> $shop_keyword,
// 				'identity_status'			=> $identity_status,		//证件认证状态，0待审核，1审核中，2审核通过，3拒绝通过'
				
				'responsible_person'		=> $responsible_person,
				'company_name'      		=> $company_name,
				'check_status'				=> 1, 						//待审核
				'email'      				=> $email,
				'contact_mobile'    		=> $contact_mobile,
				'apply_time'				=> RC_Time::gmtime(),
				
				'province'					=> $province,
				'city'						=> $city,
				'district'					=> $district,
				'address'      				=> $address,		//通讯地址
					
				'identity_type'     		=> $identity_type,
				'identity_number'   		=> $identity_number,
				'identity_pic_front'		=> $identity_pic_front,
				'identity_pic_back' 		=> $identity_pic_back,
				'personhand_identity_pic'	=> $personhand_identity_pic,
					
				'bank_name'      	   		=> $bank_name,
				'bank_branch_name'     		=> $bank_branch_name,
				'bank_account_name' 	 	=> $bank_account_name,
				'bank_account_number' 	 	=> $bank_account_number,
				'bank_address'         		=> $bank_address,
				
				'business_licence'  		=> $business_licence,
				'business_licence_pic' 		=> $business_licence_pic,
					
				'longitude'					=> $longitude,
				'latitude'					=> $latitude,
			);
			
			$this->unset_session();
			if ($type != 'edit_apply') {
				$id = RC_DB::table('store_preaudit')->insertGetId($data);
				
				ecjia_merchant::admin_log('店铺名称为：'.$merchants_name.'，'.'联系号码为：'.$mobile, 'add', 'apply_franchisee');
				
				if (!empty($id)) {
					$this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => RC_Uri::url('franchisee/merchant/init', array('step' => 3, 'mobile' => $mobile))));
				} else {
					$this->showmessage('申请失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			} else {
				RC_DB::table('store_preaudit')->update($data);
				
				ecjia_merchant::admin_log('店铺名称为：'.$merchants_name.'，'.'联系号码为：'.$mobile, 'edit', 'apply_franchisee');
				
// 				if (isset($info['id'])) {
// 					//清空原来的审核日志
// 					RC_DB::table('store_check_log')->where('store_id', $info['id'])->delete();
// 				}
				$this->showmessage('修改申请成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('franchisee/merchant/init', array('type' => 'edit_view', 'step' => 3, 'mobile' => $mobile))));
			}
		}
	}
	
	public function view() {
		$this->assign('ur_here', '查看申请进度');
		$this->assign('action_link', array('href' => RC_Uri::url('franchisee/merchant/init'), 'text' => '申请入驻'));
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('查看申请进度'));
		
		$step = isset($_GET['step']) ? $_GET['step'] : 1;
		$mobile = !empty($_GET['mobile']) ? trim($_GET['mobile']) : '';
		
		if ($step != 1) {
			if (empty($mobile) || $mobile != $_SESSION['mobile']) {
				$links[] = array('text' => '返回查看申请进度', 'href' => RC_Uri::url('franchisee/merchant/view'));
				$this->showmessage('操作失败', ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => $links));
			}
		}
		if ($step == 1) {
			$this->unset_session();
		}
		$this->assign('step', $step);
		$this->assign('form_action', RC_Uri::url('franchisee/merchant/view_post', array('step' => $step, 'mobile' => $mobile)));
		
		$this->display('franchisee_view.dwt');
	}
	
	public function view_post() {
		$step = !empty($_GET['step']) ? $_GET['step'] : 1;
		if ($step == 1) {
			$code 	= !empty($_POST['code']) ? $_POST['code'] : '';
			$mobile = !empty($_POST['mobile']) ? trim($_POST['mobile']) : '';
				
			$_SESSION['mobile'] = $mobile;
			$time = RC_Time::gmtime() - 6000*3;
			if (!empty($code) && $code == $_SESSION['temp_code'] && $time < $_SESSION['temp_code_time'] && $mobile == $_SESSION['mobile']) {
				
				//判断该手机号是否已申请
				$count_preaudit_info = RC_DB::table('store_preaudit')->where('contact_mobile', $mobile)->first();
				$count_franchisee_info = RC_DB::table('store_franchisee')->where('contact_mobile', $mobile)->first();
					
				if (empty($count_preaudit_info) && empty($count_franchisee_info)) {
					$this->showmessage('没有关于该手机号入驻信息', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
				
// 				$check_log = RC_DB::table('store_check_log')->where('store_id', $count_preaudit_info['id'])->count();
// 				if ($check_log != 0) {
// 					$step = 4;
// 				} else {
// 					$step = 3;
// 				}
				if ($count_preaudit_info['check_status'] == 1) {
					$step = 3;
				} elseif ($count_preaudit_info['check_status'] == 3) {
					$step = 4;
				}
				$this->unset_session();
				$this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => RC_Uri::url('franchisee/merchant/init', array('type' => 'view', 'step' => $step, 'mobile' => $mobile))));
			} else {
				$this->showmessage('请输入正确的手机验证码', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
	}
	
	public function remove_apply() {
		$mobile = !empty($_GET['mobile']) ? trim($_GET['mobile']) : '';
		
		if (!empty($mobile)) {
			$store_preaudit_info = RC_DB::table('store_preaudit')->where('contact_mobile', $mobile)->first();
			if (!empty($store_preaudit_info)) {
				RC_DB::table('store_preaudit')->where('contact_mobile', $mobile)->delete();
				$this->unset_session(true);
			}
			ecjia_merchant::admin_log('店铺名称为：'.$store_preaudit_info['merchants_name'].'，'.'联系号码为：'.$store_preaudit_info['contact_mobile'], 'cancel', 'apply_franchisee');
			
			$this->showmessage('撤销成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('franchisee/merchant/init')));
		} else {
			$this->showmessage('撤销失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	public function drop_file() {
		$code = isset($_GET['code']) ? trim($_GET['code']) : '';
		
		$info = RC_DB::table('store_preaudit')->where('contact_mobile', $_SESSION['mobile'])->first();
		
		$file = !empty($info[$code])? RC_Upload::upload_path($info[$code]) : '';
		$disk = RC_Filesystem::disk();
		$disk->delete($file);
		
		RC_DB::table('store_preaudit')->where('contact_mobile', $_SESSION['mobile'])->update(array($code => ''));
		
		if ($code == 'identity_pic_front') {
			$msg = '证件正面';
		} elseif ($code == 'identity_pic_back') {
			$msg = '证件反面';
		} elseif ($code == 'personhand_identity_pic') {
			$msg = '手持证件';
		} elseif ($code == 'business_licence_pic') {
			$msg = '营业执照电子版';
		}
		// 记录日志
		ecjia_merchant::admin_log('删除'.$msg, 'edit', 'apply_franchisee');
		$this->showmessage('成功删除', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 获取指定地区的子级地区
	 */
	public function get_region(){
		$type      		= !empty($_GET['type'])   ? intval($_GET['type'])   : 0;
		$parent        	= !empty($_GET['parent']) ? intval($_GET['parent']) : 0;
		$arr['regions'] = $this->db_region->get_regions($type, $parent);
		$arr['type']    = $type;
		$arr['target']  = !empty($_GET['target']) ? stripslashes(trim($_GET['target'])) : '';
		$arr['target']  = htmlspecialchars($arr['target']);
		echo json_encode($arr);
	}
	
	/**
	 * 获取店铺分类表
	 */
	private function get_cat_select_list() {
		$data = RC_DB::table('store_category')
			->select('cat_id', 'cat_name')
			->orderBy('cat_id', 'desc')
			->get();
		$cat_list = array();
		if (!empty($data)) {
			foreach ($data as $row ) {
				$cat_list[$row['cat_id']] = $row['cat_name'];
			}
		}
		return $cat_list;
	}
	
	/**
	 * 删除指定session
	 */
	private function unset_session($bool = false) {
		if (isset($_SESSION['validate_type'])) {
			unset($_SESSION['validate_type']);
		}
		if (isset($_SESSION['responsible_person'])) {
			unset($_SESSION['responsible_person']);
		}
		if (isset($_SESSION['email'])) {
			unset($_SESSION['email']);
		}
		if (isset($_SESSION['temp_code'])) {
			unset($_SESSION['temp_code']);
		}
		if (isset($_SESSION['temp_code_time'])) {
			unset($_SESSION['temp_code_time']);
		}
		if ($bool) {
			if (isset($_SESSION['mobile'])) {
				unset($_SESSION['mobile']);
			}
		}
	}
	
	/**
	 * 获取地区名称
	 */
	private function get_region_name($id){
		return $this->db_region->where(array('region_id' => $id))->get_field('region_name');
	}
}

// end