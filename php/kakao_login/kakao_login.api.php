<?php
header('Content-Type: application/json; charset=utf-8');

define('GET', 'GET');
define('POST', 'POST');
define('DELETE', 'DELETE');

///////////////////////////////////////////////////////////////////////////////

$REST_KEY = '';  // 디벨로퍼스의 앱 설정에서 확인할 수 있습니다.
$REDIRECT_URI = ''; // 설정에 등록한 사이트 도메인 + redirect uri
$REFRESH_TOKEN = '[YOUR REFRESH TOKEN]';

// test code
$kakao_api = new Kakao_REST_API_Helper();
$kakao_api->set_admin_key('');

// authorization code로 access token 얻기
$params = array();
$params['grant_type']    = 'authorization_code';
$params['client_id']     = $REST_KEY;
$params['redirect_uri']  = $REDIRECT_URI;
$params['code']          = $_GET['code']; // 동의를 한 후 발급되는 code
$token = json_decode($kakao_api->create_or_refresh_access_token($params));
$kakao_api = new Kakao_REST_API_Helper($token->access_token);

///////////////////////////////////////////////////////////////////////////////


class User_Management_Path
{
    public static $TOKEN          = "/oauth/token";
    public static $SIGNUP         = "/v1/user/signup";
    public static $UNLINK         = "/v1/user/unlink";
    public static $LOGOUT         = "/v2/user/logout";
    public static $ME             = "/v2/user/me";
    public static $UPDATE_PROFILE = "/v1/user/update_profile";
    public static $USER_IDS       = "/v1/user/ids";
}

class Story_Path
{
    public static $PROFILE        = "/v1/api/story/profile";
    public static $ISSTORYUSER    = "/v1/api/story/isstoryuser";
    public static $MYSTORIES      = "/v1/api/story/mystories";
    public static $MYSTORY        = "/v1/api/story/mystory";
    public static $DELETE_MYSTORY = "/v1/api/story/delete/mystory";
    public static $POST_NOTE      = "/v1/api/story/post/note";
    public static $UPLOAD_MULTI   = "/v1/api/story/upload/multi";
    public static $POST_PHOTO     = "/v1/api/story/post/photo";
    public static $LINKINFO       = "/v1/api/story/linkinfo";
    public static $POST_LINK      = "/v1/api/story/post/link";
}

class Push_Notification_Path
{
    public static $REGISTER   = "/v1/push/register";
    public static $TOKENS     = "/v1/push/tokens";
    public static $DEREGISTER = "/v1/push/deregister";
    public static $SEND       = "/v1/push/send";
}


class Kakao_REST_API_Helper
{
    public static $OAUTH_HOST = "https://kauth.kakao.com";
    public static $API_HOST = "https://kapi.kakao.com";

    private static $admin_apis;

    private $access_token;
    private $admin_key;

    public function __construct($access_token = '') {

        if ($access_token) {
            $this->access_token = $access_token;
        }

        self::$admin_apis = array(
            User_Management_Path::$USER_IDS,
            Push_Notification_Path::$REGISTER,
            Push_Notification_Path::$TOKENS,
            Push_Notification_Path::$DEREGISTER,
            Push_Notification_Path::$SEND
        );
    }

    public function request($api_path, $params = '', $http_method = GET)
    {
        if ($api_path != Story_Path::$UPLOAD_MULTI && is_array($params)) { // except for uploading
            $params = http_build_query($params);
        }

        $requestUrl = ($api_path == '/oauth/token' ? self::$OAUTH_HOST : self::$API_HOST) . $api_path;

        if (($http_method == GET || $http_method == DELETE) && !empty($params)) {
            $requestUrl .= '?'.$params;
        }

        $opts = array(
            CURLOPT_URL => $requestUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSLVERSION => 1,
        );

        if ($api_path != '/oauth/token')
        {
            if (in_array($api_path, self::$admin_apis)) {
                if (!$this->admin_key) {
                    throw new Exception('admin key should not be null or empty.');
                }
                $headers = array('Authorization: KakaoAK ' . $this->admin_key);

            } else {
                if (!$this->access_token) {
                    throw new Exception('access token should not be null or empty.');
                }
                $headers = array('Authorization: Bearer ' . $this->access_token);
            }

            $opts[CURLOPT_HEADER] = false;
            $opts[CURLOPT_HTTPHEADER] = $headers;
        }

        if ($http_method == POST) {
            $opts[CURLOPT_POST] = true;
            if ($params) {
                $opts[CURLOPT_POSTFIELDS] = $params;
            }
        } else if ($http_method == DELETE) {
            $opts[CURLOPT_CUSTOMREQUEST] = DELETE;
        }

        $curl_session = curl_init();
        curl_setopt_array($curl_session, $opts);
        $return_data = curl_exec($curl_session);

        if (curl_errno($curl_session)) {
            throw new Exception(curl_error($curl_session));
        } else {
            // 디버깅 시에 주석을 풀고 응답 내용 확인할 때
            //print_r(curl_getinfo($curl_session));
            curl_close($curl_session);
            return $return_data;
        }
    }

    public function set_access_token($access_token) {
        $this->access_token = $access_token;
    }

    public function set_admin_key($admin_key) {
        $this->admin_key = $admin_key;
    }

    ///////////////////////////////////////////////////////////////
    // User Management
    ///////////////////////////////////////////////////////////////

    public function create_or_refresh_access_token($params) {
        return $this->request(User_Management_Path::$TOKEN, $params, POST);
    }

    public function signup() {
        return $this->request(User_Management_Path::$SIGNUP);
    }

    public function unlink() {
        return $this->request(User_Management_Path::$UNLINK);
    }

    public function logout() {
        return $this->request(User_Management_Path::$UNLINK);
    }

    public function me() {
        return $this->request(User_Management_Path::$ME);
    }
}

//회원 정보
$user_info = json_decode($kakao_api->me());
$user_profil = $user_info->kakao_account;

//회원 탈퇴
//echo $kakao_api->unlink();
if(!empty($user_info->id))
{
    $user_email = $user_profil->email; //이메일
    $user_gender = $user_profil->gender; //성별
    try{
        //db 실행문
        $sql= "";
    } catch (mysqli_sql_exception $e) {
        error_log("[kakao_sql]" . date('Y-m-d') . " : ". $e->getMessage() ."<br/>", 3, '../kakao_error.log');
    } catch(Exception $e) {
        error_log("[kakao_exception]" . date('Y-m-d') . " : ". $e->getMessage() ."<br/>", 3, '../kakao_error.log');
    }
    if(!empty($row)){
        if($row['cnt']==0) {
            echo "신규";
        } else {
            echo "기존유저";
            //회원 유무 검색
            $sql = "";
        }
    }
}
else
{

}