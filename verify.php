<?php
$secretKey = "0x4AAAAAAAf1gExVf5jkvkCw";
$responseKey = $_POST['cf-turnstile-response'];
$userIP = $_SERVER['REMOTE_ADDR'];

$verificationURL = "https://challenges.cloudflare.com/turnstile/v0/siteverify";

$data = [
    'secret' => $secretKey,
    'response' => $responseKey,
    'remoteip' => $userIP
];

$options = [
    'http' => [
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    ]
];

$context  = stream_context_create($options);
$response = file_get_contents($verificationURL, false, $context);
$result = json_decode($response);

if ($result->success) {
    header("Location: index.html"); // Redirect to the main page
    exit();
} else {
    echo "Verification failed. Please try again.";
}
?>
