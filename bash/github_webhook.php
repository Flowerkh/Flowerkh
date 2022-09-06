<?php
/**
 * Github deploy via WebHook
 * GitHub Webhooks URL: 
 * Payload URL: https://www.domain.com/github/payload.php
 * Content type: application/json
 * @since 2022-02-02
 * @author kyungha Kim
 */
$secret = "RBU4BswLvTMQyRe3Ez0xQS5ufPJFDAxS";
$workingcopy = "/ssd";
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE'];
$github_event = $_SERVER['HTTP_X_GITHUB_EVENT'];

if ($signature && $github_event == 'push') {
    $secrethash = "sha1=".hash_hmac('sha1', file_get_contents("php://input"), $secret);
    if (strcmp($signature, $secrethash) == 0) {
        $input = "sh deploy.sh 2>&1";
        $output = "";
        exec($input, $output);
        header("Content-type:application/json");
        $json = array(
            'github-event:' => $github_event,
            'secrethash:' => $secrethash,
            'signature:' => $signature,
            'result:' => $output
        );
        echo json_encode($json, JSON_PRETTY_PRINT);
    }
}
?>
