<?php

test('Nostr returns authorization header', function () {
    $curl = curl_init('https://authenticationtest.com/HTTPAuth/');
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
    $auth = new \nostriphant\HTTP\Authorization\Nostr(nostriphant\NIP01\Key::generate(), []);
    
    $header = $auth($curl);
    
    expect($header)->toStartWith('Authorization: Nostr');
});