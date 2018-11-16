<?php
defined('IN_PHPCMS') or exit('No permission resources.');
//模型缓存路径
define('CACHE_MODEL_PATH',CACHE_PATH.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);
pc_base::load_app_func('util','content');
class index {
	private $db;
    private $user_db;
	function __construct() {
		$this->db = pc_base::load_model('content_model');
		$this->user_db= pc_base::load_model('member_model');
		$this->_userid = param::get_cookie('_userid');
		$this->_username = param::get_cookie('_username');
		$this->_groupid = param::get_cookie('_groupid');
	}
	//首页
	public function init() {
		if(isset($_GET['siteid'])) {
			$siteid = intval($_GET['siteid']);
		} else {
			$siteid = 1;
		}
		$siteid = $GLOBALS['siteid'] = max($siteid,1);
		define('SITEID', $siteid);
		$_userid = $this->_userid;
		$_username = $this->_username;
		$_groupid = $this->_groupid;
		//SEO
		$SEO = seo($siteid);
		$sitelist  = getcache('sitelist','commons');
		$default_style = $sitelist[$siteid]['default_style'];
		$CATEGORYS = getcache('category_content_'.$siteid,'commons');
		include template('content','index',$default_style);
	}
	//内容页
	public function show() {
		$catid = intval($_GET['catid']);
		$id = intval($_GET['id']);

        $wc=$_GET['wc'];
        if(isset($wc) && !empty($wc) && $wc==1){
            $siteids = getcache('category_content','commons');
            $siteid = $siteids[$catid];
            $CATEGORYS = getcache('category_content_'.$siteid,'commons');
            if(!isset($CATEGORYS[$catid]) || $CATEGORYS[$catid]['type']!=0) showmessage(L('information_does_not_exist'),'blank');
            $this->category = $CAT = $CATEGORYS[$catid];
            $this->category_setting = $CAT['setting'] = string2array($this->category['setting']);


            try {
                $mongodb = new MongodbClient(['dbname'=>'porn','collection'=>'porns']);
                $id = $_GET['id'];
                $data_xv = $mongodb->getId($id);
            }
            catch (Exception $e) {
                showmessage('异常或者无数据','blank');
            }

            if(!$data_xv){
                showmessage('异常或者无数据','blank');
            }
            //$data_xv->hls
            $xq_data=$data_xv[0];
            $pageurlst=$xq_data->pageUrl;
            $m_calss=getFreeClass();//获取免费分类
            $xv_title = $xq_data->cntitle;
            $data_xv = $data_xv[0];
            if(strpos($pageurlst,$m_calss) == false) {//如果不是免费的就进行会员权限识别
                $_groupid = param::get_cookie('_groupid');
                $_groupid = intval($_groupid);
                if (!$_groupid) {
                    $forward = urlencode(get_url());
                    showmessage(L('login_website'), APP_PATH . 'index.php?m=member&c=index&a=login&forward=' . $forward);
                }

                if (!in_array($_groupid, [2, 4, 5, 6])) showmessage(L('no_priv'));



                $user_id = param::get_cookie('_userid');
                $user_datas = $this->user_db->get_one(array('userid' => $user_id));
                if (!$user_datas) {
                    showmessage('用户数据异常', 'blank');
                }
                if ($_groupid == 2) {//新手就只能免费观看多少部
                    $free_data = explode(",", $user_datas['free_watch']);
                    if (!in_array($id, $free_data)) {//如果不存在就判断是否超次数
                        if (count($free_data) > returnFreeWatch()) {//超次数就提示升级会员
                            showmessage('免费观看次数已经用完，请升级会员', APP_PATH . 'index.php?m=member&c=index&a=account_manage_upgrade&t=1');
                        } else {//没有超次数就记录该次
                            array_push($free_data, $id);
                            $in_free_watch = implode(",", $free_data);
                            $in_free_watch = trim($in_free_watch, ',');
                            $re = $this->user_db->update(['free_watch' => $in_free_watch], array('userid' => $user_id));
                        }
                    }
                }
            }

            $template = $template ? $template : $CAT['setting']['show_template'];
            if (!$template) $template = 'show';

            include template('content',$template);
            exit();


        }

		if(!$catid || !$id) showmessage(L('information_does_not_exist'),'blank');
		$_userid = $this->_userid;
		$_username = $this->_username;
		$_groupid = $this->_groupid;

		$page = intval($_GET['page']);
		$page = max($page,1);
		$siteids = getcache('category_content','commons');
		$siteid = $siteids[$catid];
		$CATEGORYS = getcache('category_content_'.$siteid,'commons');
		
		if(!isset($CATEGORYS[$catid]) || $CATEGORYS[$catid]['type']!=0) showmessage(L('information_does_not_exist'),'blank');
		$this->category = $CAT = $CATEGORYS[$catid];
		$this->category_setting = $CAT['setting'] = string2array($this->category['setting']);
		$siteid = $GLOBALS['siteid'] = $CAT['siteid'];
		
		$MODEL = getcache('model','commons');
		$modelid = $CAT['modelid'];
		
		$tablename = $this->db->table_name = $this->db->db_tablepre.$MODEL[$modelid]['tablename'];
		$r = $this->db->get_one(array('id'=>$id));
		if(!$r || $r['status'] != 99) showmessage(L('info_does_not_exists'),'blank');
		
		$this->db->table_name = $tablename.'_data';
		$r2 = $this->db->get_one(array('id'=>$id));
		$rs = $r2 ? array_merge($r,$r2) : $r;

		//再次重新赋值，以数据库为准
		$catid = $CATEGORYS[$r['catid']]['catid'];
		$modelid = $CATEGORYS[$catid]['modelid'];
		
		require_once CACHE_MODEL_PATH.'content_output.class.php';
		$content_output = new content_output($modelid,$catid,$CATEGORYS);
		$data = $content_output->get($rs);
		extract($data);
		
		//检查文章会员组权限
		if($groupids_view && is_array($groupids_view)) {
			$_groupid = param::get_cookie('_groupid');
			$_groupid = intval($_groupid);
			if(!$_groupid) {
				$forward = urlencode(get_url());
				showmessage(L('login_website'),APP_PATH.'index.php?m=member&c=index&a=login&forward='.$forward);
			}
			if(!in_array($_groupid,$groupids_view)) showmessage(L('no_priv'));
		} else {
			//根据栏目访问权限判断权限
			$_priv_data = $this->_category_priv($catid);
			if($_priv_data=='-1') {
				$forward = urlencode(get_url());
				showmessage(L('login_website'),APP_PATH.'index.php?m=member&c=index&a=login&forward='.$forward);
			} elseif($_priv_data=='-2') {
				showmessage(L('no_priv'));
			}
		}
		if(module_exists('comment')) {
			$allow_comment = isset($allow_comment) ? $allow_comment : 1;
		} else {
			$allow_comment = 0;
		}
		//阅读收费 类型
		$paytype = $rs['paytype'];
		$readpoint = $rs['readpoint'];
		$allow_visitor = 1;
		if($readpoint || $this->category_setting['defaultchargepoint']) {
			if(!$readpoint) {
				$readpoint = $this->category_setting['defaultchargepoint'];
				$paytype = $this->category_setting['paytype'];
			}
			
			//检查是否支付过
			$allow_visitor = self::_check_payment($catid.'_'.$id,$paytype);
			if(!$allow_visitor) {
				$http_referer = urlencode(get_url());
				$allow_visitor = sys_auth($catid.'_'.$id.'|'.$readpoint.'|'.$paytype).'&http_referer='.$http_referer;
			} else {
				$allow_visitor = 1;
			}
		}
		//最顶级栏目ID
		$arrparentid = explode(',', $CAT['arrparentid']);
		$top_parentid = $arrparentid[1] ? $arrparentid[1] : $catid;
		
		$template = $template ? $template : $CAT['setting']['show_template'];
		if(!$template) $template = 'show';
		//SEO
		$seo_keywords = '';
		if(!empty($keywords)) $seo_keywords = implode(',',$keywords);
		$SEO = seo($siteid, $catid, $title, $description, $seo_keywords);
		
		define('STYLE',$CAT['setting']['template_list']);
		if(isset($rs['paginationtype'])) {
			$paginationtype = $rs['paginationtype'];
			$maxcharperpage = $rs['maxcharperpage'];
		}
		$pages = $titles = '';
		if($rs['paginationtype']==1) {
			//自动分页
			if($maxcharperpage < 10) $maxcharperpage = 500;
			$contentpage = pc_base::load_app_class('contentpage');
			$content = $contentpage->get_data($content,$maxcharperpage);
		}
		if($rs['paginationtype']!=0) {
			//手动分页
			$CONTENT_POS = strpos($content, '[page]');
			if($CONTENT_POS !== false) {
				$this->url = pc_base::load_app_class('url', 'content');
				$contents = array_filter(explode('[page]', $content));
				$pagenumber = count($contents);
				if (strpos($content, '[/page]')!==false && ($CONTENT_POS<7)) {
					$pagenumber--;
				}
				for($i=1; $i<=$pagenumber; $i++) {
					$pageurls[$i] = $this->url->show($id, $i, $catid, $rs['inputtime']);
				}
				$END_POS = strpos($content, '[/page]');
				if($END_POS !== false) {
					if($CONTENT_POS>7) {
						$content = '[page]'.$title.'[/page]'.$content;
					}
					if(preg_match_all("|\[page\](.*)\[/page\]|U", $content, $m, PREG_PATTERN_ORDER)) {
						foreach($m[1] as $k=>$v) {
							$p = $k+1;
							$titles[$p]['title'] = strip_tags($v);
							$titles[$p]['url'] = $pageurls[$p][0];
						}
					}
				}
				//当不存在 [/page]时，则使用下面分页
				$pages = content_pages($pagenumber,$page, $pageurls);
				//判断[page]出现的位置是否在第一位 
				if($CONTENT_POS<7) {
					$content = $contents[$page];
				} else {
					if ($page==1 && !empty($titles)) {
						$content = $title.'[/page]'.$contents[$page-1];
					} else {
						$content = $contents[$page-1];
					}
				}
				if($titles) {
					list($title, $content) = explode('[/page]', $content);
					$content = trim($content);
					if(strpos($content,'</p>')===0) {
						$content = '<p>'.$content;
					}
					if(stripos($content,'<p>')===0) {
						$content = $content.'</p>';
					}
				}
			}
		}
		$this->db->table_name = $tablename;
		//上一页
		$previous_page = $this->db->get_one("`catid` = '$catid' AND `id`<'$id' AND `status`=99",'*','id DESC');
		//下一页
		$next_page = $this->db->get_one("`catid`= '$catid' AND `id`>'$id' AND `status`=99",'*','id ASC');

		if(empty($previous_page)) {
			$previous_page = array('title'=>L('first_page'), 'thumb'=>IMG_PATH.'nopic_small.gif', 'url'=>'javascript:alert(\''.L('first_page').'\');');
		}

		if(empty($next_page)) {
			$next_page = array('title'=>L('last_page'), 'thumb'=>IMG_PATH.'nopic_small.gif', 'url'=>'javascript:alert(\''.L('last_page').'\');');
		}
		include template('content',$template);
	}
	//列表页
	public function lists() {
		$catid = $_GET['catid'] = intval($_GET['catid']);
		$_priv_data = $this->_category_priv($catid);
		if($_priv_data=='-1') {
			$forward = urlencode(get_url());
			showmessage(L('login_website'),APP_PATH.'index.php?m=member&c=index&a=login&forward='.$forward);
		} elseif($_priv_data=='-2') {
			showmessage(L('no_priv'));
		}
		$_userid = $this->_userid;
		$_username = $this->_username;
		$_groupid = $this->_groupid;

		if(!$catid) showmessage(L('category_not_exists'),'blank');
		$siteids = getcache('category_content','commons');
		$siteid = $siteids[$catid];
		$CATEGORYS = getcache('category_content_'.$siteid,'commons');
		if(!isset($CATEGORYS[$catid])) showmessage(L('category_not_exists'),'blank');
		$CAT = $CATEGORYS[$catid];
		$siteid = $GLOBALS['siteid'] = $CAT['siteid'];
		extract($CAT);
		$setting = string2array($setting);

        if($setting['meta_title']=='xvideos'){//如果在META Title（栏目标题）针对搜索引擎设置的标题设置为xvideos就进入
            $xv_title=$CAT['catname'];
            $template = $setting['category_template'] ? $setting['category_template'] : 'category';
            $template_list = $setting['list_template'] ? $setting['list_template'] : 'list';
            $template = $child ? $template : $template_list;

            $page = intval($_GET['page']);

            $mongodb = new MongodbClient(['dbname'=>'porn','collection'=>'porns']);
            if(isset($_GET['lxa']) && !empty($_GET['lxa'])){
                $p=[
                    'pageUrl' => ['$in' => [new \MongoDB\BSON\Regex('^.*?'.$_GET['lxa'].'.*?$','i')]]
                ];
            }else{
                $p=[];
            }

            $data = $mongodb->page($p,$page,16,['createTime'=>-1]);

            $data_v=array();
            $i=0;
            foreach($data['data'] as $v) {
                if(!empty($v)){
                    $ob_id=json_encode($v->_id);
                    $ob_id=json_decode($ob_id,true);
                    $data_v[$i]['id']=$ob_id['$oid'];
                    $data_v[$i]['thumb']=$v->thumb;
                    $data_v[$i]['cntitle']=$v->cntitle;
                    $data_v[$i]['durString']=$v->durString;
                    $data_v[$i]['url']='index.php?m=content&c=index&a=show&catid='.$catid.'&id='.$ob_id['$oid'].'&wc=1';
                    $i++;
                }
            }

///index.php?m=content&c=index&a=show&catid=16&id=46

            $pge_str='';
            if(!empty($data)){
                $url='/index.php?m=content&c=index&a=lists&catid='.$catid.'&page=';
                $pge_str='<a>'.$data['count'].'条</a>';

                if($page<1 || $page==1){
                    $s_c=1;
                }else{
                    $s_c=$page-1;
                }
                $s_ye=$url.$s_c;//上一页
                $s_ye_str='<a href="'.$s_ye.'" class="a1">上一页</a>';

                if($page>$data['page'] || $page==$data['page']){
                    $x_c=$data['page'];
                }else{
                    $x_c=$page+1;
                }
                $x_ye=$url.$x_c;//下一页
                $x_ye_str='<a href="'.$x_ye.'" class="a1">下一页</a>';

                if($page<4){//后补齐
                    if($data['page']>7){
                        $qiamn_buqi='';
                        for ($x=0; $x<($page-1); $x++) {//前页
                            $qiamn_buqi=$qiamn_buqi.'<a href="'.$url.($x+1).'">'.($x+1).'</a>';
                        }
                        $mes='<span>'.$page.'</span>';
                        $hou_buqi='';
                        for ($x=($page+1); $x<($page+1)+(7-$page); $x++) {//后页
                            $hou_buqi=$hou_buqi.'<a href="'.$url.$x.'">'.$x.'</a>';
                        }

                        $re_page=$qiamn_buqi.$mes.$hou_buqi;
                    }else{
                        $qiamn_buqi='';
                        for ($x=0; $x<($page-1); $x++) {//前页
                            $qiamn_buqi=$qiamn_buqi.'<a href="'.$url.($x+1).'">'.($x+1).'</a>';
                        }
                        $mes='<span>'.$page.'</span>';
                        $hou_buqi='';
                        for ($x=($page+1); $x<($data['page']+1); $x++) {//后页
                            $hou_buqi=$hou_buqi.'<a href="'.$url.$x.'">'.$x.'</a>';
                        }

                        $re_page=$qiamn_buqi.$mes.$hou_buqi;
                    }
                }
                if(($page>4 || $page==4) && ($page<($data['page']-3))){//中间位
                    $qiamn_buqi='';
                    for ($x=($page-3); $x<$page; $x++) {//前页
                        $qiamn_buqi=$qiamn_buqi.'<a href="'.$url.$x.'">'.$x.'</a>';
                    }
                    $mes='<span>'.$page.'</span>';
                    $hou_buqi='';
                    for ($x=($page+1); $x<($page+4); $x++) {//后页
                        $hou_buqi=$hou_buqi.'<a href="'.$url.$x.'">'.$x.'</a>';
                    }
                    $re_page=$qiamn_buqi.$mes.$hou_buqi;
                }
                if($page>($data['page']-4)  && $data['page']>7){//后位
                    $qiamn_buqi='';
                    for ($x=($data['page']-6); $x<$page; $x++) {//前页
                        $qiamn_buqi=$qiamn_buqi.'<a href="'.$url.$x.'">'.$x.'</a>';
                    }
                    $mes='<span>'.$page.'</span>';
                    $hou_buqi='';
                    for ($x=($page+1); $x<($data['page']+1); $x++) {//后页
                        $hou_buqi=$hou_buqi.'<a href="'.$url.$x.'">'.$x.'</a>';
                    }
                    $re_page=$qiamn_buqi.$mes.$hou_buqi;
                }
                $pge_str=$pge_str.$s_ye_str.$re_page.$x_ye_str;
                $pge_str=$pge_str.'<a>共'.$data['page'].'页</a>';


            }


            include template('content',$template);
            exit();
        }




        if($setting['meta_title']=='xvideos_free'){//免费栏目如果在META Title（栏目标题）针对搜索引擎设置的标题设置为xvideos就进入
            $xv_title=$CAT['catname'];
            $template = $setting['category_template'] ? $setting['category_template'] : 'category';
            $template_list = $setting['list_template'] ? $setting['list_template'] : 'list';
            $template = $child ? $template : $template_list;

            $page = intval($_GET['page']);

            $mongodb = new MongodbClient(['dbname'=>'porn','collection'=>'porns']);
            $zf=getFreeClass();
            $p=[
                'pageUrl' => ['$in' => [new \MongoDB\BSON\Regex('^.*?'.$zf.'.*?$','i')]]
            ];
//            $data = $mongodb->page($p,$page,16,['createTime'=>-1]);
//            print_r($data);
//            exit();
            $data = $mongodb->page($p,$page,16,['createTime'=>-1]);

            $data_v=array();
            $i=0;
            foreach($data['data'] as $v) {
                if(!empty($v)){
                    $ob_id=json_encode($v->_id);
                    $ob_id=json_decode($ob_id,true);
                    $data_v[$i]['id']=$ob_id['$oid'];
                    $data_v[$i]['thumb']=$v->thumb;
                    $data_v[$i]['cntitle']=$v->cntitle;
                    $data_v[$i]['cntitle']=$v->cntitle;
                    $data_v[$i]['durString']=$v->durString;
                    $data_v[$i]['url']='index.php?m=content&c=index&a=show&catid='.$catid.'&id='.$ob_id['$oid'].'&wc=1';
                    $i++;
                }
            }

///index.php?m=content&c=index&a=show&catid=16&id=46

            $pge_str='';
            if(!empty($data)){
                $url='/index.php?m=content&c=index&a=lists&catid='.$catid.'&page=';
                $pge_str='<a>'.$data['count'].'条</a>';

                if($page<1 || $page==1){
                    $s_c=1;
                }else{
                    $s_c=$page-1;
                }
                $s_ye=$url.$s_c;//上一页
                $s_ye_str='<a href="'.$s_ye.'" class="a1">上一页</a>';

                if($page>$data['page'] || $page==$data['page']){
                    $x_c=$data['page'];
                }else{
                    $x_c=$page+1;
                }
                $x_ye=$url.$x_c;//下一页
                $x_ye_str='<a href="'.$x_ye.'" class="a1">下一页</a>';

                if($page<4){//后补齐
                    if($data['page']>7){
                        $qiamn_buqi='';
                        for ($x=0; $x<($page-1); $x++) {//前页
                            $qiamn_buqi=$qiamn_buqi.'<a href="'.$url.($x+1).'">'.($x+1).'</a>';
                        }
                        $mes='<span>'.$page.'</span>';
                        $hou_buqi='';
                        for ($x=($page+1); $x<($page+1)+(7-$page); $x++) {//后页
                            $hou_buqi=$hou_buqi.'<a href="'.$url.$x.'">'.$x.'</a>';
                        }

                        $re_page=$qiamn_buqi.$mes.$hou_buqi;
                    }else{
                        $qiamn_buqi='';
                        for ($x=0; $x<($page-1); $x++) {//前页
                            $qiamn_buqi=$qiamn_buqi.'<a href="'.$url.($x+1).'">'.($x+1).'</a>';
                        }
                        $mes='<span>'.$page.'</span>';
                        $hou_buqi='';
                        for ($x=($page+1); $x<($data['page']+1); $x++) {//后页
                            $hou_buqi=$hou_buqi.'<a href="'.$url.$x.'">'.$x.'</a>';
                        }

                        $re_page=$qiamn_buqi.$mes.$hou_buqi;
                    }
                }
                if(($page>4 || $page==4) && ($page<($data['page']-3))){//中间位
                    $qiamn_buqi='';
                    for ($x=($page-3); $x<$page; $x++) {//前页
                        $qiamn_buqi=$qiamn_buqi.'<a href="'.$url.$x.'">'.$x.'</a>';
                    }
                    $mes='<span>'.$page.'</span>';
                    $hou_buqi='';
                    for ($x=($page+1); $x<($page+4); $x++) {//后页
                        $hou_buqi=$hou_buqi.'<a href="'.$url.$x.'">'.$x.'</a>';
                    }
                    $re_page=$qiamn_buqi.$mes.$hou_buqi;
                }
                if($page>($data['page']-4) && $data['page']>7){//后位
                    $qiamn_buqi='';
                    for ($x=($data['page']-6); $x<$page; $x++) {//前页
                        $qiamn_buqi=$qiamn_buqi.'<a href="'.$url.$x.'">'.$x.'</a>';
                    }
                    $mes='<span>'.$page.'</span>';
                    $hou_buqi='';
                    for ($x=($page+1); $x<($data['page']+1); $x++) {//后页
                        $hou_buqi=$hou_buqi.'<a href="'.$url.$x.'">'.$x.'</a>';
                    }
                    $re_page=$qiamn_buqi.$mes.$hou_buqi;
                }
                $pge_str=$pge_str.$s_ye_str.$re_page.$x_ye_str;
                $pge_str=$pge_str.'<a>共'.$data['page'].'页</a>';


            }


            include template('content',$template);
            exit();
        }

		//SEO
		if(!$setting['meta_title']) $setting['meta_title'] = $catname;
		$SEO = seo($siteid, '',$setting['meta_title'],$setting['meta_description'],$setting['meta_keywords']);
		define('STYLE',$setting['template_list']);
		$page = intval($_GET['page']);

		$template = $setting['category_template'] ? $setting['category_template'] : 'category';
		$template_list = $setting['list_template'] ? $setting['list_template'] : 'list';
		
		if($type==0) {
			$template = $child ? $template : $template_list;
			$arrparentid = explode(',', $arrparentid);
			$top_parentid = $arrparentid[1] ? $arrparentid[1] : $catid;
			$array_child = array();
			$self_array = explode(',', $arrchildid);
			//获取一级栏目ids
			foreach ($self_array as $arr) {
				if($arr!=$catid && $CATEGORYS[$arr][parentid]==$catid) {
					$array_child[] = $arr;
				}
			}
			$arrchildid = implode(',', $array_child);
			//URL规则
			$urlrules = getcache('urlrules','commons');
			$urlrules = str_replace('|', '~',$urlrules[$category_ruleid]);
			$tmp_urls = explode('~',$urlrules);
			$tmp_urls = isset($tmp_urls[1]) ?  $tmp_urls[1] : $tmp_urls[0];
			preg_match_all('/{\$([a-z0-9_]+)}/i',$tmp_urls,$_urls);
			if(!empty($_urls[1])) {
				foreach($_urls[1] as $_v) {
					$GLOBALS['URL_ARRAY'][$_v] = $_GET[$_v];
				}
			}
			define('URLRULE', $urlrules);
			$GLOBALS['URL_ARRAY']['categorydir'] = $categorydir;
			$GLOBALS['URL_ARRAY']['catdir'] = $catdir;
			$GLOBALS['URL_ARRAY']['catid'] = $catid;
			include template('content',$template);
		} else {
		//单网页
			$this->page_db = pc_base::load_model('page_model');
			$r = $this->page_db->get_one(array('catid'=>$catid));
			if($r) extract($r);
			$template = $setting['page_template'] ? $setting['page_template'] : 'page';
			$arrchild_arr = $CATEGORYS[$parentid]['arrchildid'];
			if($arrchild_arr=='') $arrchild_arr = $CATEGORYS[$catid]['arrchildid'];
			$arrchild_arr = explode(',',$arrchild_arr);
			array_shift($arrchild_arr);
			$keywords = $keywords ? $keywords : $setting['meta_keywords'];
			$SEO = seo($siteid, 0, $title,$setting['meta_description'],$keywords);
			include template('content',$template);
		}
	}
	
	//JSON 输出
	public function json_list() {
		if($_GET['type']=='keyword' && $_GET['modelid'] && $_GET['keywords']) {
		//根据关键字搜索
			$modelid = intval($_GET['modelid']);
			$id = intval($_GET['id']);

			$MODEL = getcache('model','commons');
			if(isset($MODEL[$modelid])) {
				$keywords = safe_replace(new_html_special_chars($_GET['keywords']));
				$keywords = addslashes(iconv('utf-8','gbk',$keywords));
				$this->db->set_model($modelid);
				$result = $this->db->select("keywords LIKE '%$keywords%'",'id,title,url',10);
				if(!empty($result)) {
					$data = array();
					foreach($result as $rs) {
						if($rs['id']==$id) continue;
						if(CHARSET=='gbk') {
							foreach($rs as $key=>$r) {
								$rs[$key] = iconv('gbk','utf-8',$r);
							}
						}
						$data[] = $rs;
					}
					if(count($data)==0) exit('0');
					echo json_encode($data);
				} else {
					//没有数据
					exit('0');
				}
			}
		}

	}
	
	
	/**
	 * 检查支付状态
	 */
	protected function _check_payment($flag,$paytype) {
		$_userid = $this->_userid;
		$_username = $this->_username;
		if(!$_userid) return false;
		pc_base::load_app_class('spend','pay',0);
		$setting = $this->category_setting;
		$repeatchargedays = intval($setting['repeatchargedays']);
		if($repeatchargedays) {
			$fromtime = SYS_TIME - 86400 * $repeatchargedays;
			$r = spend::spend_time($_userid,$fromtime,$flag);
			if($r['id']) return true;
		}
		return false;
	}
	
	/**
	 * 检查阅读权限
	 *
	 */
	protected function _category_priv($catid) {
		$catid = intval($catid);
		if(!$catid) return '-2';
		$_groupid = $this->_groupid;
		$_groupid = intval($_groupid);
		if($_groupid==0) $_groupid = 8;
		$this->category_priv_db = pc_base::load_model('category_priv_model');
		$result = $this->category_priv_db->select(array('catid'=>$catid,'is_admin'=>0,'action'=>'visit'));
		if($result) {
			if(!$_groupid) return '-1';
			foreach($result as $r) {
				if($r['roleid'] == $_groupid) return '1';
			}
			return '-2';
		} else {
			return '1';
		}
	 }
}
?>