<?php
//配置以下的商户id和appkey即可使用
define('EBusinessID', '***');
define('AppKey', '***-***-***-***');
define('ReqURL', 'http://api.kdniao.com/Ebusiness/EbusinessOrderHandle.aspx');

$code = 806302089253836506; //根据运单编号查询物流信息

$logisticResult = getOrderInfoByJson($code);
if (is_array($logisticResult)) {
	var_dump($logisticResult); //打印物流信息
}else {
	echo $logisticResult; //输出错误信息
}

function getOrderInfoByJson($code){
	$requestData= "{'LogisticCode':'" . $code . "'}";
	$datas = array(
        'EBusinessID' => EBusinessID,
        'RequestType' => '2002',
        'RequestData' => urlencode($requestData) ,
        'DataType' => '2',
    );
    $datas['DataSign'] = encrypt($requestData, AppKey);
	$result=sendPost(ReqURL, $datas);	
	if ($result['Success'] == true) {
		return getOrderTracesByJson($result);
	} else {
		return $result['Reason'];	
	}
}

function getOrderTracesByJson($data){
	$requestData= "{'LogisticCode':'" . $data['LogisticCode'] . "','ShipperCode':'" . $data['Shippers'][0]['ShipperCode'] . "'}";
	$datas = array(
        'EBusinessID' => EBusinessID,
        'RequestType' => '1002',
        'RequestData' => urlencode($requestData) ,
        'DataType' => '2',
    );
    $datas['DataSign'] = encrypt($requestData, AppKey);
	$result=sendPost(ReqURL, $datas);
	return $result;
}
 
function sendPost($url, $datas) {
    $temps = array();	
    foreach ($datas as $key => $value) {
        $temps[] = sprintf('%s=%s', $key, $value);		
    }	
    $post_data = implode('&', $temps);
    $url_info = parse_url($url);
	if(empty($url_info['port']))
	{
		$url_info['port']=80;	
	}
    $httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
    $httpheader.= "Host:" . $url_info['host'] . "\r\n";
    $httpheader.= "Content-Type:application/x-www-form-urlencoded\r\n";
    $httpheader.= "Content-Length:" . strlen($post_data) . "\r\n";
    $httpheader.= "Connection:close\r\n\r\n";
    $httpheader.= $post_data;
    $fd = fsockopen($url_info['host'], $url_info['port']);
    fwrite($fd, $httpheader);
    $gets = "";
	$headerFlag = true;
	while (!feof($fd)) {
		if (($header = @fgets($fd)) && ($header == "\r\n" || $header == "\n")) {
			break;
		}
	}
    while (!feof($fd)) {
		$gets.= fread($fd, 128);
    }
    fclose($fd);
    return json_decode($gets,true);
}

function encrypt($data, $appkey) {
    return urlencode(base64_encode(md5($data.$appkey)));
}

?>
