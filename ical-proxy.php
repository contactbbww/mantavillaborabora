<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: text/plain; charset=utf-8');

$url = $_GET['url'] ?? '';
if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
    http_response_code(400);
    exit('Invalid URL');
}
if (!preg_match('#^https://www\.airbnb\.(fr|com)/calendar/ical/#', $url)) {
    http_response_code(403);
    exit('URL not allowed');
}

// Essai 1 : curl
if (function_exists('curl_init')) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: text/calendar,*/*',
        'Accept-Language: fr-FR,fr;q=0.9,en;q=0.8',
    ]);
    $data = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($httpCode === 200 && !empty($data) && strpos($data, 'BEGIN:VCALENDAR') !== false) {
        header('Content-Type: text/calendar; charset=utf-8');
        echo $data;
        exit;
    }
}

// Essai 2 : file_get_contents
if (ini_get('allow_url_fopen')) {
    $opts = [
        'http' => [
            'timeout' => 10,
            'header' => implode("\r\n", [
                'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36',
                'Accept: text/calendar,*/*',
            ]),
        ],
        'ssl' => ['verify_peer' => false]
    ];
    $ctx = stream_context_create($opts);
    $data = @file_get_contents($url, false, $ctx);
    if (!empty($data) && strpos($data, 'BEGIN:VCALENDAR') !== false) {
        header('Content-Type: text/calendar; charset=utf-8');
        echo $data;
        exit;
    }
}

http_response_code(502);
echo 'Failed to fetch calendar';
