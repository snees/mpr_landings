<?php
class Bases {

	public function Alert($msg) {
		echo "
		<script type=\"text/javascript\">
			alert('{$msg}');
		</script>
		";
	}
	/**
	 * alert창을 띄우고 이동한다.
	 */
	public function gotoAlert($msg = null, $url = null) {
		if ( trim($msg) && trim($url) ) {
			echo "
			<script type=\"text/javascript\">
				alert('{$msg}');
				location.href='{$url}';
			</script>
			";
			exit;
		} else if ( trim($msg) && !trim($url) ) {
			echo "
			<script type=\"text/javascript\">
				alert('{$msg}');
				history.go(-1);
			</script>
			";
			exit;
		} else if ( !trim($msg) && trim($url) ) {
			$this->gotoUrl($url);
		} else {
			$this->gotoBack();
		}
	}

	// 메타태그를 이용한 URL 이동
	// header("location:URL") 을 대체
	public function gotoUrl($url)	{
		$url = str_replace("&amp;", "&", $url);

		if (!headers_sent())
			header('Location: '.$url);
		else {
			echo "
			<script type=\"text/javascript\">
			";
			echo 'location.replace("'.$url.'");';
			echo "
			</script>
			";
			echo '<noscript>';
			echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
			echo '</noscript>';
		}
		exit;
	}

	/**
	 * 이전페이지로 보낸다.
	 */
	public function gotoBack($msg = null) {
		echo "
		<script type=\"text/javascript\">
		";
		if ( trim($msg) ) {
			echo "alert('{$msg}');";
		}
		echo "history.go(-1);";
		echo "
		</script>
		";
		exit;
	}

	/**
	 * 페이징 체크
	 */
	public function pagination($totalCount, $list, $block, $page, $querystring) {
		global $_SERVER;

		//---- $SelfPage = trim($_SERVER['PHP_SELF']);
		$SelfPage = '';

		$pageList = $list;
		$returnData['getLimit'] = $pageList;
		$pageBlock = $block;

		$pageNum = ceil($totalCount/$pageList); // 총 페이지
		$blockNum = ceil($pageNum/$pageBlock); // 총 블록
		$nowBlock = ceil($page/$pageBlock);

		$s_page = ($nowBlock * $pageBlock) - ($pageBlock - 1);

		if ($s_page <= 1) {
			$s_page = 1;
		}
		$e_page = $nowBlock*$pageBlock;

		if ($pageNum <= $e_page) {
			$e_page = $pageNum;
		}
		$s_point = ($page-1) * $pageList;
		$returnData['getCount'] = $s_point;

		$prePage = $page - 1;

		$strPage = "<ul class=\"pagination pagination-sm\">";
		$strClass = ($prePage <= 0) ? " disabled":'';

		//$strFirstHref = (intval($prePage) > 0) ? "{$SelfPage}?page=1{$querystring}":"javascript:alert('첫번째 페이지입니다.');";
		$strPreHref = ($prePage > 0) ? "{$SelfPage}?page={$prePage}{$querystring}":"javascript:alert('첫번째 페이지입니다.');";

		$strPage.= "<li class=\"page-item waves-effect\"><a class=\"page-link{$strClass}\" href=\"{$strPreHref}\" aria-label=\"Previous\"><span aria-hidden=\"true\"><i class=\"material-icons\"><</i></span> <span class=\"sr-only\">이전</span> </a></li>";
		//---- chevron_left

		for ($p=$s_page; $p<=$e_page; $p++) {
			$activClass = ($p == $page) ? ' active':' waves-effect';
			//--- $strPage.= "<a class=\"{$activClass}\" href=\"{$SelfPage}?page={$p}{$querystring}\">{$p}</a>";
			$strPage.= "<li class=\"page-item{$activClass}\"><a class=\"page-link\" href=\"{$SelfPage}?page={$p}{$querystring}\">{$p}</a></li>";
		}

		$nextPage = $page + 1;

		$strClass		= (intval($nextPage) <= intval($pageNum)) ? "":' disabled';
		$strNextHref	= (intval($nextPage) <= intval($pageNum)) ? "{$SelfPage}?page={$nextPage}{$querystring}":"javascript:alert('마지막 페이지입니다.');";
		//$strEndHref = (intval($nextPage) <= intval($e_page)) ? "{$SelfPage}?page={$pageNum}{$querystring}":"javascript:alert('마지막 페이지입니다.');";

		$strPage .= "<li class=\"page-item waves-effect\"><a class=\"page-link{$strClass}\" href=\"{$strNextHref}\" aria-label=\"Next\"><span aria-hidden=\"true\"><i class=\"material-icons\">></i></span> <span class=\"sr-only\">다음</span></a></li>";
		//---- chevron_right

		$strPage.= "</ul>";
		$returnData['pagination'] = $strPage;

		return $returnData;
	}

	/**
	 * 모바일 접속여부 체크
	 */
	public function isMobile(){
		$arr_browser = array ("iphone", "android", "ipod", "iemobile", "mobile", "lgtelecom", "ppc", "symbianos", "blackberry", "ipad");
		$httpUserAgent = strtolower($_SERVER['HTTP_USER_AGENT']);

		// 기본값으로 모바일 브라우저가 아닌것으로 간주함
		$mobile_browser = false;

		// 모바일브라우저에 해당하는 문자열이 있는 경우 $mobile_browser 를 true로 설정
		for($i = 0 ; $i < count($arr_browser) ; $i++){
			if(strpos($httpUserAgent, $arr_browser[$i]) == true){
				$mobile_browser = true;
				break;
			}
		}
		return $mobile_browser;
	}

	/**
	 * utf8 문자열 자르기..
	 */
	public function strcut_utf8($str, $len, $checkmb=false, $tail='...') {
		preg_match_all('/[\xEA-\xED][\x80-\xFF]{2}|./', $str, $match);

		$m    = $match[0];
		$slen = strlen($str);  // length of source string
		$tlen = strlen($tail); // length of tail string
		$mlen = count($m); // length of matched characters

		if ($slen <= $len) return $str;
		if (!$checkmb && $mlen <= $len) return $str;

		$ret   = array();
		$count = 0;

		for ($i=0; $i < $len; $i++) {
			$count += ($checkmb && strlen($m[$i]) > 1)?2:1;

			if ($count + $tlen > $len) break;
			$ret[] = $m[$i];
		}

		return join('', $ret).$tail;
	}

	/**
	 * 로그인 체크
	 * 로그인을 하지 않아도 접근가능한 페이지를 설정한다. 디렉토리 포함
	 * 애매할땐 확장자까지 붙여서 파일명 전체를 적으면...
	 */
	public function isAllowPage () {
		global $_SERVER;

		$isAllowPage = false;
		$allowPage = array('login', 'popup', 'layer', 'join');
		for ( $i=0; $i<count($allowPage); $i++ ) {
			$allow = trim($allowPage[$i]);

			//echo $allow;
		
			if ( strripos($_SERVER['PHP_SELF'], $allow) === false ) {
				$isAllowPage = false;
			} else {
				$isAllowPage = true;
				break;
			}
		}

		if ( !$isAllowPage ) {
			if ( !trim($_SESSION['sess_email']) ) {
				$this->gotoAlert('로그인 후에 이용가능합니다.', '/login.php');
				exit;
			}
		}
	}

	private function makeDir($dir) {
		/* echo $dir.'<br>'; */
		$dir = str_replace(W_ROOT, '', $dir);
		$arrDir = explode('/', $dir);

		/* echo '<pre>';
		print_r($arrDir);
		echo '</pre>'; */

		$strDir = '';
		for ($i=0; $i<count($arrDir); $i++) {
			if ( trim($arrDir[$i]) ) {
				$strDir.= '/'.trim($arrDir[$i]);
				
				$fullDir = W_ROOT.$strDir;
				/* echo $fullDir.'<br />'; */
				if ( !is_dir($fullDir) ) {
					@mkdir($fullDir, 0777, true);
					@chmod($fullDir, 0777);
				}
			}

		}
	}


	public function attachFiles ($getTable, $getCode, $setBoardTable='mpr_board_files') {
		global $DB, $_FILES;

        if ( strpos($getTable, '_')!==false ) {
            list(, $dirCode, ) = explode('_', $getTable);
        } else {
            $dirCode = $getTable;
        }

		//---- [2021-07-01] 첨부파일 시작 ---------------------------------------
		$fileSaveDir = W_ROOT ."/data/{$dirCode}";
		$this->makeDir($fileSaveDir);
		
		$allowed_extend = array('jpg','jpeg','png','gif','pdf');

		$arrayFiles = $_FILES["files"]['name'];
		$arrayTypes = $_FILES["files"]['type'];
		$arraySizes = $_FILES["files"]['size'];
		$arrayErros = $_FILES["files"]['error'];
		$arrayTemps = $_FILES["files"]['tmp_name'];

		for ($i=0; $i<=count($arrayFiles); $i++) {
			$txtErros = $arrayErros[$i];
			$tmpFiles = $arrayTemps[$i];
			$orgFiles = $arrayFiles[$i];
			$orgSizes = $arraySizes[$i];
			$orgTypes = $arrayTypes[$i];

			if ( trim($orgFiles) ) {
				$extend = strtolower(@end(@explode('.', $orgFiles)));

				if( $txtErros != UPLOAD_ERR_OK ) {
					switch( $txtErros ) {
						case UPLOAD_ERR_INI_SIZE:
						case UPLOAD_ERR_FORM_SIZE:
							echo "
							<script>
								alert(' 파일이 너무 큽니다. ($txtErros) ');
								window.history.back();
							</script>
							";
							break;
						case UPLOAD_ERR_NO_FILE:
							echo "
							<script>
								alert(' 파일이 첨부되지 않았습니다. ($txtErros) ');
								window.history.back();
							</script>
							";
							break;
						default:
							echo "
							<script>
								alert(' 파일이 제대로 업로드되지 않았습니다. ($txtErros) ');
								window.history.back();
							</script>
							";
					}
					exit;
				}

				// 확장자 확인
				if( !in_array($extend, $allowed_extend) ) {
					echo "
					<script>
						alert(' 허용되지 않는 확장자입니다.($extend) !!');
						window.history.back();
					</script>
					";
					exit;
				}

				// 파일 이동
				$chagename = str_replace(".{$extend}", '', trim($orgFiles));
				$filename = md5(time().$chagename).'.'.$extend;

				if ( !move_uploaded_file( $tmpFiles, "{$fileSaveDir}/{$filename}") ) {

					echo "
					<script>
						alert(' 첨부파일에 의심되는 문제가 발생하였습니다. ');
						window.history.back();
					</script>
					";
					exit;

				} else {

					try {
						$DB->beginTransaction();

						$fileArray = array(
							'tcode'	=>	$dirCode,
							'ecode'	=>	$getCode,
							'locate'=>	'W',
							'oname'=>	$orgFiles,
							'cname'=>	$filename,
							'ftype'	=>	$orgTypes,
							'fsize'	=>	$orgSizes
						);
						
						//echo '<pre>';print_r($fileArray);echo '</pre>';

						$DB->insert($setBoardTable, $fileArray);

						$DB->commit();

					} catch(Exception $ex) {

						$DB->rollBack();
						echo "
						<script>
							alert(' 첨부파일에 의심되는 문제가 발생하였습니다. ');
							window.history.back();
						</script>
						";
					}
				}

			}
		}

		return true;
		//---- [2021-07-01] 첨부파일 종료 ---------------------------------------		
	}

	/**
	 * 이메일을 알듯 말듯 보여준다.
	 * $getEmail : 변경해서 보여줄 원본 이메일
	 * $intCut : @앞쪽 문자열을 자를 수
	 * $agentCut : @뒤쪽 문자열을 자를 수
	 * $chChar : 대체 문자
	 */
	public function cutEmail ($getEmail, $intCut=2, $agentCut=1, $chChar='*') {
		list($eid, $eagent) = explode('@', $getEmail);
		$intLength = strlen($eid) - $intCut;
		$strRepeat = str_repeat('*', $intLength);
		$emailId = substr($eid, 0,$intCut). $strRepeat;
		
		$arrAgent = explode('.', $eagent);
		$intLength = strlen($arrAgent[0])-$agentCut;
		$strRepeat = str_repeat($chChar, $intLength);
		$arrAgent[0] = substr($eagent, 0,$agentCut).$strRepeat;
		$strAgent = implode('.', $arrAgent);
		
		$strEmail = $emailId.'＠'.$strAgent;
		
		return $strEmail;
	}

	/**
	 * $string : 변경해서 보여줄 원본 문자열
	 * $intCut : 첫자에서 자를 문자열 수
	 * $chChar : 대체 문자
	 */
	public function cutString ($string, $intCut=3, $chChar='*') {
		
		$intLength = strlen($string);
		$intNumb = $intLength - $intCut;
		$cutString = substr($string, 0, $intCut);
		$chgString = str_repeat($chChar, $intNumb);

		$string = $cutString.$chgString;
		
		return $string;
	}
	/**
	 * 한글을 자를때는... UTF-8일 경우 한글은 3자리씩 잡아먹으니까.. 자르고 나머지 글자를 3으로 나눠서 보여준다.
	 */
	public function cutKoString ($string, $intCut=3, $chChar='*') {
		$intLength = strlen($string);
		$intNumb = $intLength - ($intCut*3);
		$intNumb = round($intNumb / 3);
		$cutString = mb_substr($string, 0, $intCut, 'utf-8');
		$chgString = str_repeat($chChar, $intNumb);

		$string = $cutString.$chgString;
		
		return $string;
	}

}

$Bases = new Bases();
?>