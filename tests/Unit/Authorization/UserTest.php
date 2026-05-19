<?php

test('User sets USER and PWD for curl', function () {
    $curl = curl_init('https://authenticationtest.com/HTTPAuth/');
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
    $auth = new \nostriphant\HTTP\Authorization\User('user', 'pass');
    
    $auth($curl);
    
    expect(curl_exec($curl))->not()->toBeFalse();
    expect(curl_getinfo($curl, CURLINFO_HTTP_CODE))->toBe(200);
});