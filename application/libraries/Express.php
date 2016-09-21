<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'third_party/Snoopy.class.php';
//快递100 查询接口，一天 2000次
class Express extends CI_Controller {
    function __construct() {
        $this->ci = & get_instance();
       
    }
    public function search($com, $number){

        $AppKey='503e861d375d24f3';//请将XXXXXX替换成您在http://kuaidi100.com/app/reg.html申请到的KEY

// var_dump($com);
// var_dump($number);die;
        // $com = '';
        // $number = '3903300539521';

        // $url ='http://api.kuaidi100.com/api?id='.$AppKey.'&com='.$com.'&nu='.$number.'&show=2&muti=1&order=asc';
        // $url ='http://www.kuaidi100.com/applyurl?key='.$AppKey.'&com='.$com.'&nu='.$number.'&show=2&muti=1&order=asc';
        $url = 'http://www.kuaidi100.com/query?id=1&type='.$com.'&postid='.$number.'&valicode=&temp='.time();
        //请勿删除变量$powered 的信息，否者本站将不再为你提供快递接口服务。
        //$powered = '查询数据由：<a href="http://kuaidi100.com" target="_blank">KuaiDi100.Com （快递100）</a> 网站提供 ';


        //优先使用curl模式发送数据
        if (function_exists('curl_init') == 1){
          $curl = curl_init();
          curl_setopt ($curl, CURLOPT_URL, $url);
          curl_setopt ($curl, CURLOPT_HEADER,0);
          curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt ($curl, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
          curl_setopt ($curl, CURLOPT_TIMEOUT,5);
          $get_content = curl_exec($curl);
          curl_close ($curl);
        }else{
          include("snoopy.php");
          $snoopy = new snoopy();
          $snoopy->referer = 'http://www.zuinanfen.com/';//伪装来源
          $snoopy->fetch($url);
          $get_content = $snoopy->results;
        }
        return $get_content;
    }

}
