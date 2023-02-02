<?php
// Curl 함수 20220329 수정
function integralCurl(string $url, bool $isSsl = false, string $method = "GET", array $sendData = [], array $option = [], array $header = []): array
{
      // $certificateLoc = $_SERVER['DOCUMENT_ROOT'] . "/inc/cacert.pem";
      $certificateLoc = "";
      $method = strtoupper($method);
 
      $defaultOptions = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 10
      );
 
      $ch = curl_init();
      curl_setopt_array($ch, $defaultOptions);
 
      curl_setopt($ch, CURLOPT_POST, $method === "POST");
 
      if ($method === "POST") {
            // $sendData 샘플
            // [
            //       "a" => 1,
            //       "b" => "22"
            // ]
 
            if (count($sendData) >= 1) {
                  curl_setopt($ch, CURLOPT_POSTFIELDS, $sendData);
            }
      } elseif ($method === "GET") {
            if (count($sendData) >= 1) {
                  $paramsUrl = http_build_query($sendData);
                  $url .= "?" . $paramsUrl;
            }
      } elseif ($method === "PUT") {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
 
            if (count($sendData) >= 1) {
                  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendData));
            }
      } elseif ($method === "DELETE") {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
 
            if (count($sendData) >= 1) {
                  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendData));
            }
      }
 
      curl_setopt($ch, CURLOPT_URL, $url);
 
      if (count($option) >= 1) {
            // $option 샘플
            // [
            //       CURLOPT_HEADER => false,
            //       CURLOPT_USERAGENT => "test"
            // ]
 
            curl_setopt_array($ch, $option);
      }
 
      if (count($header) >= 1) {
            // $header 샘플
            // ['Authorization: Bearer '.$accessToken, 'Content-Type: application/x-www-form-urlencoded;charset=utf-8']
 
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
      }
 
      if ($isSsl === true && $certificateLoc != "") {
            curl_setopt($ch, CURLOPT_CAINFO, $certificateLoc);
      }
 
      $returnData  = curl_exec($ch);
      $returnState = curl_getinfo($ch, CURLINFO_HTTP_CODE);
 
      if ($returnData === false) {
            $returnErr = "CURL ERROR: " . curl_error($ch);
      } else {
            $returnErr = "success";
      }
 
      curl_close($ch);
 
      return [
            "data" => $returnData,
            "code" => $returnState,
            "msg" => $returnErr
      ];
}
?>
