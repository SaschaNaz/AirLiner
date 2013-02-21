<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>AirLiner BT</title>
</head>
<body>
<?php

// 1.업로드 상태여부를 체크
//if (isset($_POST['upload_check'])) {

	// 2.업로드된 파일의 존재여부 및 전송상태 확인
	if (isset($_FILES['file']) && !$_FILES['file']['error']) {

		// 3-1.허용할 영상 종류를 배열로 저장
		$videoKind = array ('video/mp4', 'video/avi', 'video/mov', 'video/m4v', 'video/mkv');
		
		// 3-2.videoKind 배열내에 $_FILES['file']['type']에 해당되는 타입(문자열) 있는지 체크
		if (in_array(str_replace(";", "", $_FILES['file']['type']), $videoKind)||in_array(str_replace(";", "", $_FILES['file']['type']), $videoKind[0])) {

		$MovieName=preg_replace("/\\s/", "_", $_FILES['file']['name']);
		$SubName=preg_replace("/\\s/", "_", $_FILES['subtitle']['name']);
		$MovieName=str_replace('(', "", $MovieName);
		$MovieName=str_replace(')', "", $MovieName);
		$OnlyMovieName=str_replace(".mp4", "", $MovieName);
		$OnlyMovieName=str_replace(".avi", "", $OnlyMovieName);
		$OnlyMovieName=str_replace(".mov", "", $OnlyMovieName);
		$OnlyMovieName=str_replace(".m4v", "", $OnlyMovieName);
		$OnlyMovieName-str_replace(".mkv", "", $OnlyMovieName);
		$width=$_POST['width'];
		$height=$_POST['height'];
		$scale=$width." ".$height;

			// 4.허용하는 영상파일이라면 지정된 위치로 이동
			if (move_uploaded_file ($_FILES['file']['tmp_name'], "AirLiner/Store/{$MovieName}")) {
				move_uploaded_file($_FILES['subtitle']['tmp_name'], "./AirLiner/Store/{$SubName}");

				// 5.업로드된 영상 파일
				echo '<p>파일명: '.$_FILES['file']['name'].'</p>';
				echo '영상이름 : '.$MovieName;
				echo '<br/>';
				echo '인코딩 시작<br><br>';
				
				$returndata1 = shell_exec("mp4convert /usr/share/nginx/html/AirLiner/Store/".$MovieName." ".$scale); // 쉘 작업
 			    $temp1 = strrchr($returndata1, "Trem:   "); // Trem: 을 통해 문자열 뽑아옴
  			    $temp1 = str_replace("Trem:   ", "", $temp1); // Trem: 제거
   			    $temp1 = substr($temp1, 0, 12); // 남은시간과 예상용량만 뽑아옴
   			    $temp1 = str_replace("0min ", "", $temp1); // min 제거
			    //echo "mp4default /usr/share/nginx/html/AirLiner/Store/".$MovieName." ".$_POST['width']." ".$_POST['height']; 
			    //echo $returndata1;
			    
			    echo '인코딩 완료<br/><br/>';
			    echo '인코딩이 엄청 빨리 끝났다면 인코딩이 실패한 것이니 다시시도해 보시고 또 그런다면 관리자에게 리포트를 부탁드리겠습니다.';
			    echo "다운로드: <a href='/AirLiner/Store/".$OnlyMovieName."_enc.mp4'>".$OnlyMovieName."_enc.mp4</a>";
			    echo "</br>용량 ".$temp1;

			} //if , move_uploaded_file
			
		} else { // 3-3.허용된 영상 타입이 아닌경우
			echo '<p>mp4, avi, mov 파일만 업로드 가능합니다.</p>';
		}//if , inarray

//	} //if , isset
	

	// 6.에러가 존재하는지 체크
	if ($_FILES['file']['error'] > 0) {
		echo '<p>파일 업로드 실패 이유: <strong>';
	
		// 실패 내용을 출력
		switch ($_FILES['file']['error']) {
			case 1:
				echo 'PHP 최대용량 초과';
				break;
			case 2:
				echo 'MAX_FILE_SIZE초과';
				break;
			case 3:
				echo '파일 일부만 업로드 됨';
				break;
			case 4:
				echo '업로드된 파일이 없음';
				break;
			case 6:
				echo '사용가능한 임시폴더가 없음';
				break;
			case 7:
				echo '디스크에 저장할수 없음';
				break;
			case 8:
				echo '파일 업로드 중지됨';
				break;
			default:
				echo '시스템 오류 발생';
				break;
		} // switch
		
		echo '</strong></p>';
		
	} // if
	
	// 7.임시파일이 존재하는 경우 삭제
	if (file_exists ($_FILES['file']['tmp_name']) && is_file($_FILES['file']['tmp_name']) ) {
		unlink ($_FILES['file']['tmp_name']);
	}
			
} // if
?>
