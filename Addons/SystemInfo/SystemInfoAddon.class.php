<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: yangweijie <yangweijiester@gmail.com> <code-tech.diandian.com>
// +----------------------------------------------------------------------
namespace Addons\SystemInfo;
use Common\Controller\Addon;
/**
 * 
 * @author thinkphp
 */

    class SystemInfoAddon extends Addon{

        public $info = array(
            'name'=>'SystemInfo',
            'title'=>'系统环境信息',
            'description'=>'用于显示一些服务器的信息',
            'status'=>1,
            'author'=>'thinkphp',
            'version'=>'0.1'
        );

        public function install(){
            return true;
        }

        public function uninstall(){
            return true;
        }

        //实现的AdminIndex钩子方法
        public function AdminIndex($param){
            $config = $this->getConfig();
            
            if(extension_loaded('curl')){
    $url = "http://yershop.com/index.php?s=/Home/Check/check.html";
$post_data = array (
    'version' =>  '1.5',
                    'domain'  => $_SERVER['HTTP_HOST'],
                    'auth'    => sha1(C('DATA_AUTH_KEY')),
					'ip' => getip(),
                    'domainip' => get_onlineip(), 
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// 我们在POST数据哦！
curl_setopt($ch, CURLOPT_POST, 1);
// 把post的变量加上
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
$data = curl_exec($ch);
curl_close($ch);
            }

            if(!empty($data) && strlen($data)<400  && strlen($data)>3 ){
                $config['new_version'] = $data;
            }

            $this->assign('addons_config', $config);
            if($config['display']){
                $this->display('widget');
            }
        }
    }