<?php

/**
 * @Project NUKEVIET 4.x
 * @Author NV Systems (hoangnt@nguyenvan.vn)
 * @Copyright (C) 2018 NV Systems. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvtools/
 * @Createdate Wed, 13 Jun 2018 03:19:45 GMT
 */

 
if ( ! defined( 'NV_IS_MOD_LOGISTICS' ) ) die( 'Stop!!!' );

$page_title = $module_info['custom_title'];
$key_words = $module_info['keywords'];

//print_r($array_op);die;
$array_data = array();

if(!empty($array_op[1]))
{
	// LẤY RA ID VẬN ĐƠN
	$array_data = $db->query(" SELECT * FROM ". $db_config['prefix'] . "_" . $module_data . "_rows WHERE bill like '". $array_op[1] ."'")->fetch();
	
	if(empty($array_data))
	{
		Header( 'Location: ' . NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=main' );
		die();
	}
	else
	{
		// LẤY DANH SÁCH LỊCH TRÌNH

		$array_data['lichtrinh'] = $db->query('SELECT * FROM '.$db_config['prefix'] . '_' . $module_data . '_schedule_bill t1, '.$db_config['prefix'] . '_' . $module_data . '_schedule t2  WHERE t1.status = t2.id AND t2.status = 1 AND t1.id_bill ='. $array_data['id'] .' AND t1.active = 1 ORDER BY t1.weight DESC')->fetchAll();
	
	}
}

// LẤY DANH SÁCH TÀI LIỆU HÓA
	$list_document = $db->query('SELECT * FROM '.$db_config['prefix'] . '_' . $module_data . '_document WHERE status = 1 ORDER BY weight ASC')->fetchAll();
	
// LẤY DANH SÁCH DỊCH VỤ
	$list_service = $db->query('SELECT * FROM '.$db_config['prefix'] . '_' . $module_data . '_service WHERE status = 1 ORDER BY weight ASC')->fetchAll();
	
// LẤY DANH SÁCH PHỤ THU
	$list_surcharge = $db->query('SELECT * FROM '.$db_config['prefix'] . '_' . $module_data . '_surcharge WHERE status = 1 ORDER BY weight ASC')->fetchAll();

//print_r($list_lichtrinh);die;





$contents = nv_theme_logistics_detail( $array_data, $list_document, $list_service, $list_surcharge );

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';
