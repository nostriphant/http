<?php

namespace nostriphant\HTTP;

use nostriphant\NIP01\Key;

function request(string $method, string $uri, $upload_resource = null, ?array $authorization = null, ?array $headers = []) : ServerResponse {
    $curl = curl_init($uri);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    
    if (isset($authorization)) {
        switch ($authorization[0]) {
            case 'nostr':
                $details = $authorization[1];
                
                $sender_key = Key::fromHex($details['key']);
                unset($details['key']);

                $tags = [];
                if (isset($details['expiration']) === false) {
                    $tags[] = ["expiration", time() + 3600];
                }
                foreach ($details as $tag => $value) {
                    $tags[] = [$tag, $value];
                }

                $headers[] = 'Authorization: ' . Headers::authorization($sender_key, $method, $uri, $tags);
                break;
            case 'user':
                $headers[] = 'Authorization: Basic '. base64_encode($authorization[1] . ":" . $authorization[2]);
                break;
        }
    }
    
    switch ($method) {
        case 'HEAD':
            curl_setopt($curl, CURLOPT_NOBODY, true);
            break;
        case 'PUT':
        case 'POST':
            if (is_string($upload_resource)) {
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $upload_resource);
                $headers[] = 'Content-Type:application/json';
            } else {
                curl_setopt($curl, CURLOPT_UPLOAD, 1);
                curl_setopt($curl, CURLOPT_READDATA, $upload_resource);
                curl_setopt($curl, CURLOPT_READFUNCTION, fn($ch, $fh, int $length) => fread($fh, $length));
            }
            break;
        default:
            break;

    }
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $raw_response = curl_exec($curl);
    if ($raw_response === false) {
        $error = curl_error($curl);
        curl_close($curl);
        sleep(5);
        return request(...func_get_args());
    }
    $info = curl_getinfo($curl);
    curl_close($curl);

    
    $headers = new Headers(explode("\r\n", substr($raw_response, 0, $info['header_size'])));
    $response_body = substr($raw_response, $info['header_size']);
    
    if (isset($headers['status']) === false) {
        throw new \Exception(var_export($raw_response, true));
    }
    
    return new ServerResponse($headers['protocol'], $headers['status'], $headers, $response_body);
}