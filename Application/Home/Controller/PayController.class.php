<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 支付模型控制器
 * 文档模型列表和详情
 */
class PayController extends HomeController {

    public function index() {
        if ( !is_login() ) {
		    $this->error( "您还没有登陆",U("User/login") );
		}
		if (IS_POST) {
				//页面上通过表单选择在线支付类型，支付宝为alipay 财付通为tenpay

			/* 支付设置 */
				$payment= array(
			'tenpay' => array(
				// 加密key，开通财付通账户后给予
				'key' =>  C('TENPAYKEY'),
				// 合作者ID，财付通有该配置，开通财付通账户后给予
				'partner' => C('TENPAYPARTNER')
			),
			'alipay' => array(
				// 收款账号邮箱
				'email' =>C('ALIPAYEMAIL'),
				// 加密key，开通支付宝账户后给予
				'key' => C('ALIPAYKEY'),
				// 合作者ID，支付宝有该配置，开通易宝账户后给予
				'partner' => C('ALIPAYPARTNER')
			),
			'palpay' => array(
				'business' =>  C('PALPAYPARTNER')
			),
			'yeepay' => array(
				'key' =>  C('YEEPAYPARTNER'),
				'partner' =>  C('YEEPAYKEY')
			),
			'kuaiqian' => array(
				'key' =>  C('KUAIQIANPARTNER'),
				'partner' =>  C('KUAIQIANKEY')
			),
			'unionpay' => array(
				'key' =>  C('UNIONPARTNER'),
				'partner' =>  C('UNIONKEY')
			)
		);
        $paytype = I('post.paytype');
        $paytype=safe_replace($apitype);//过滤
        $pay = new \Think\Pay($paytype, $payment[$paytype]);
           
		if(!empty($_POST['orderid'])){ 
		     $order_no=I('post.orderid'); // 用strip_tags过滤trim($_POST['orderid']);//未付款订单号
			 $order_no=safe_replace($order_no);//过滤
			 $body= C('SITENAME')."订单";//商品描述
			 $title=C('SITENAME')."订单-".$order_no;//设置商品名称
	     }
			//else{
			// $order_no = $pay->createOrderNo(); //充值，生成订单号
			// $body= C('SITENAME')."会员充值"；//商品描述
				//}
         $info=$order->where("tag='$tag'")->find();
		 $money=$info['total_money'];			
        
		 $vo = new \Think\Pay\PayVo();
         $vo->setBody($body)
                    ->setFee($money) //支付金额
                    ->setOrderNo($order_no)//订单号
                    ->setTitle($title)//设置商品名称
                    ->setCallback("Home/Pay/success")/*** 设置支付完成后的后续操作接口 */
                    ->setUrl(U("Home/Pay/over")) /* 设置支付完成后的跳转地址*/
                    ->setParam(array('order_id' => $order_no));
            echo $pay->buildRequestForm($vo);
        } 
		else {

			/* uid调用*/
			$uid=is_login();
			$score=get_score($uid);

			/* 积分兑换*/
			$ratio= $score/C('RATIO');
			$this->assign('ratio', $ratio);
			$this->meta_title = '支付订单';
			//在此之前goods1的业务订单已经生成，状态为等待支付
			$id=I("get.orderid");
			$id=safe_replace($id);//过滤
			$order=D("order");
			$this->assign('codeid',$id);

			$total=$order->where("orderid='$id'")->getField('total_money');
			$this->assign('goodprice',$total);
			$this->display();
        }
    }


   public function chongzhi() {
      
        if ( !is_login() ) {
		    $this->error( "您还没有登陆",U("User/login") );
		}
		if (IS_POST) {
				//页面上通过表单选择在线支付类型，支付宝为alipay 财付通为tenpay

			/* 支付设置 */
				$payment= array(
			'tenpay' => array(
				// 加密key，开通财付通账户后给予
				'key' =>  C('TENPAYKEY'),
				// 合作者ID，财付通有该配置，开通财付通账户后给予
				'partner' => C('TENPAYPARTNER')
			),
			'alipay' => array(
				// 收款账号邮箱
				'email' =>C('ALIPAYEMAIL'),
				// 加密key，开通支付宝账户后给予
				'key' => C('ALIPAYKEY'),
				// 合作者ID，支付宝有该配置，开通易宝账户后给予
				'partner' => C('ALIPAYPARTNER')
			),
			'palpay' => array(
				'business' =>  C('PALPAYPARTNER')
			),
			'yeepay' => array(
				'key' =>  C('YEEPAYPARTNER'),
				'partner' =>  C('YEEPAYKEY')
			),
			'kuaiqian' => array(
				'key' =>  C('KUAIQIANPARTNER'),
				'partner' =>  C('KUAIQIANKEY')
			),
			'unionpay' => array(
				'key' =>  C('UNIONPARTNER'),
				'partner' =>  C('UNIONKEY')
			)
		);
        $paytype = I('post.paytype');
        $paytype=safe_replace($apitype);//过滤
	    $pay = new \Think\Pay($paytype, $payment[$paytype]);
		$order_no = $this->createOrderNo(); //充值，生成订单号
	    $body= C('SITENAME')."充值";//商品描述
		$title=C('SITENAME')."充值";//设置商品名称	
		$money=I('post.money');
        $money=safe_replace($money);//过滤
        $vo = new \Think\Pay\PayVo();
        $vo->setBody($body)
                    ->setFee($money) //支付金额
                    ->setOrderNo($order_no)//订单号
                    ->setTitle($title)//设置商品名称
                    ->setCallback("Home/Pay/successaccount")/*** 设置支付完成后的后续操作接口 */
                    ->setUrl(U("Home/Pay/over")) /* 设置支付完成后的跳转地址*/
                    ->setParam(array('money' => $money));
            echo $pay->buildRequestForm($vo);
        } 
		
		else {
  
			$this->meta_title = '账号充值';
			//在此之前goods1的业务订单已经生成，状态为等待支付
			
			$this->display();
        }
    }
  // 生成支付订单号
   public function createOrderNo(){
        if ( is_login() ) {
		      $uid=is_login();
		      $code=date('Ym',time()).substr(time(), 4).$uid;
	       return $code;
		}
    }
	/**
     * 订单支付成功
     * @param type $money
     * @param type $param
     */
    public function successaccount($money, $param) {
		if (session("pay_verify") == true) {
			session("pay_verify", null);			
			
			
			$uid=is_login();
			// 发送邮件
			 M("member")->where("uid='$uid'")->setField('account',$param['money']);
			
			
			$mail=get_email($uid);//获取会员邮箱
			$title="支付提醒";
			$content="您在<a href=\"".C('DAMAIN')."\" target='_blank'>".C('SITENAME').'</a>充值成功，交易号'.$param['order_id'];
			   if( C('MAIL_PASSWORD')){
				SendMail($mail,$title,$content);
			   }
		}
		else {
		   E("Access Denied");
		}
	}
    public function success($money, $param) {
		if (session("pay_verify") == true) {
			session("pay_verify", null);
			
			//处理订单
			$data = array('status'=>'1','ispay'=>'2');//订单已经支付,状态为已提交
			M('order')->where(array('tag' => $param['order_id']))->setField($data);
			
			
			// 发送邮件
			$uid=M("pay")->where(array('out_trade_no' => $param['order_id']))->getField('uid');
			$mail=get_email($uid);//获取会员邮箱
			$title="支付提醒";
			$content="您在<a href=\"".C('DAMAIN')."\" target='_blank'>".C('SITENAME').'</a>支付了订单，交易号'.$param['order_id'];
			   if( C('MAIL_PASSWORD')){
				   SendMail($mail,$title,$content);
			   }
	    }
	    else {
		  E("Access Denied");
	    }
	}
	 
	public function over() {
        $this->meta_title = '支付成功';
        $this->display('success');       
    }

}
