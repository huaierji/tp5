<?php
namespace app\admin\controller;
use think\Controller;

class Tracking extends Controller{
	// 测试
	public function test(){
		return "方法路由测试";
	}	

	// 查询所有运输商以及在TrackingMore系统中相应运输商简码
	public function transporterList(){
        vendor ('Track.Track');                // 5.0版本可直接用vendor()引入第三方类  5.1取消
		$track = new \Trackingmore;
		$track = $track->getCarrierList();
		dump($track);die;	

	}

	// 根据快递单号获取运输商
	public function transporter(){
		vendor ('Track.Track');
		$track = new \Trackingmore;
		$trackingNumber = 'LZ518112434CN';
		$track = $track->detectCarrier($trackingNumber);
		// dump($track);die;
	}

	// 获取多个运单号的物流信息  
	/**
	* @param int $numbers Tracking numbers,eg:$numbers = LY044217709CN,UG561422482CN (optional)
	* @param int $orders Tracking order,eg:$orders = #123 (optional)
	* @param int $page  Page to display (optional)
	* @param int $limit Items per page (optional)
	* @param int $createdAtMin Start date and time of trackings created (optional)
	* @param int $createdAtMax End date and time of trackings created (optional)
	* @param int $update_time_min Start date and time of trackings updated (optional)
	* @param int $update_time_max End date and time of trackings updated (optional)
	* @param int $order_created_time_min Start date and time of order created (optional)
	* @param int $order_created_time_max End date and time of order created (optional)
	* @param int $lang Language,eg:$lang=cn(optional)
	* @return array
	*/      
	public function logisticsInfo(){
		vendor ('Track.Track');
		$track = new \Trackingmore;
		$numbers = 'LZ518112434CN';
		$orders = '#123';
		$page = 1;
		$limit = 50;
		$createdAtMin = time() - 7*24*60*60;
		$createdAtMax = time();
		$update_time_min = time() - 7*24*60*60;
		$update_time_max = time();
		$order_created_time_min = time() - 7*24*60*60;
		$order_created_time_max = time();
		$lang = 'en';
		$track = $track->getTrackingsList($numbers,$orders,$page,$limit,$createdAtMin,$createdAtMax,$update_time_min,$update_time_max,$order_created_time_min,$order_created_time_max,$lang);
		// dump($track);die;
	}

	// 查询账户剩余额度
	public function surplus(){
		vendor ('Track.Track');
		$track = new \Trackingmore;
		$track = $track->getUserInfoBalance();
		// dump($track);die;
	}

	// 查看不同状态快递数量  
	/**
     * update carrier code
     * @access public
     * @param int $created_at_min Start date and time of trackings created (optional)     物流开始时间
     * @param int $created_at_max End date and time of trackings created (optional)	   	  物流结束时间
     * @param int $order_created_time_min Start date and time of order created (optional) 订单开始时间
     * @param int $order_created_time_max End date and time of order created (optional)	  订单结束时间
     * @return array
     */
	public function statusNum(){
		vendor ('Track.Track');
		$track = new \Trackingmore;
		$track = $track->getStatusNumberCount();
		// dump($track);die;
	}

	// 查询收货地址是否偏远
	public function remote(){
		vendor ('Track.Track');
		$track = new \Trackingmore;


		$data[] = array(
		        "country"=>"CN",     	
		        "postcode"=>"400422"	
		        );
		$data[] = array(
		        "country"=>"CN",
		        "postcode"=>"412000"
		        );
		$track = $track->searchDeliveryIsRemote($data);
		// dump($track);die;
	}

	// 查询快递失效
	public function invalid(){
		vendor ('Track.Track');
		$track = new \Trackingmore;

		$data[] = array(
		        "original"=>"CN",
		        "destination"=>"US",
		        "carrier_code"=>"dhl"
		        );
		$data[] = array(
		        "original"=>"CN",
		        "destination"=>"RU",
		        "carrier_code"=>"dhl"
		        );
		$track = $track->getCarrierCostTime($data);
		// dump($track);die;
	}
}