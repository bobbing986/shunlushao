<?php if (!defined('THINK_PATH')) exit();?>﻿
<?php if(!empty($config['type'])){ ?>

   <!--`     <a class="" href="<?php if(in_array('qq',$config['type'])){ echo addons_url('SyncLogin://Base/login',array('type'=>'qq'));} ?>">QQ</a>
        <a class="" href="<?php if(in_array('sina',$config['type'])){ echo addons_url('SyncLogin://Base/login',array('type'=>'sina'));} ?>">微博</a>
  <a class="" href="<?php if(in_array('tencent',$config['type'])){ echo addons_url('SyncLogin://Base/login',array('type'=>'tencent'));} ?>">QQ微博</a>
        <a class="" href="<?php if(in_array('t163',$config['type'])){ echo addons_url('SyncLogin://Base/login',array('type'=>'t163'));} ?>">网易微博</a>
        <a class="btn btn-warning btn-block" href="<?php if(in_array('Douban',$config['type'])){ echo addons_url('SyncLogin://Base/login',array('type'=>'douban'));} ?>">豆瓣</a>
        <a class="btn btn-primary btn-block" href="<?php if(in_array('renren',$config['type'])){ echo addons_url('SyncLogin://Base/login',array('type'=>'renren'));} ?>">人人</a>
 <a class="" href="<?php if(in_array('x360',$config['type'])){ echo addons_url('SyncLogin://Base/login',array('type'=>'x360'));} ?>">360</a>
        <a class="btn btn-warning btn-block" href="<?php if(in_array('github',$config['type'])){ echo addons_url('SyncLogin://Base/login',array('type'=>'github'));} ?>">github</a>
        <a class="btn btn-primary btn-block" href="<?php if(in_array('google',$config['type'])){ echo addons_url('SyncLogin://Base/login',array('type'=>'google'));} ?>">google</a>
<a class="" href="<?php if(in_array('msn',$config['type'])){ echo addons_url('SyncLogin://Base/login',array('type'=>'msn'));} ?>">msn</a>
        <a class="btn btn-warning btn-block" href="<?php if(in_array('diandian',$config['type'])){ echo addons_url('SyncLogin://Base/login',array('type'=>'diandian'));} ?>">点点</a>
     <a class="btn btn-primary btn-block" href="<?php if(in_array('taobao',$config['type'])){ echo addons_url('SyncLogin://Base/login',array('type'=>'taobao'));} ?>">淘宝网</a>   
 <a class="btn btn-warning btn-block" href="<?php if(in_array('baidu',$config['type'])){ echo addons_url('SyncLogin://Base/login',array('type'=>'baidu'));} ?>">百度</a>
     <a class="btn btn-primary btn-block" href="<?php if(in_array('kaixin',$config['type'])){ echo addons_url('SyncLogin://Base/login',array('type'=>'kaixin'));}1 ?>">开心</a> 
	<a class="btn btn-primary btn-block" href="<?php if(in_array('sohu',$config['type'])){ echo addons_url('SyncLogin://Base/login',array('type'=>'sohu'));} ?>">搜狐微博</a>  --> 
<?php } ?>
<?php if(is_array($config['type'])): foreach($config['type'] as $key=>$vo): ?><a  id="<?php echo ($vo); ?>" href="<?php if(in_array($vo,$config['type'])){echo addons_url('SyncLogin://Base/login',array('type'=> $vo));} ?>" title="<?php echo (get_sdk_title($vo)); ?>"> <img src="/Public/Home/images/sdk/<?php echo ($vo); ?>.png"></a><?php endforeach; endif; ?>