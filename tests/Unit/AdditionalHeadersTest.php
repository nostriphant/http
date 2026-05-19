<?php

test('invoke adds additional headers to a response array', function () {
    
    $response = new \nostriphant\HTTP\AdditionalHeaders()([
        'headers' => [
            'Content-Type' => 'text/plain'
        ]
    ]);
    
    expect($response['headers']['Content-Type'])->toBe('text/plain');
    expect($response['headers']['Access-Control-Allow-Origin'])->toBe('*');
    expect($response['headers'])->not()->toHaveKey('Content-Length');
});


test('invoke adds Content-Length header, when a body exists', function () {
    
    $response = new \nostriphant\HTTP\AdditionalHeaders()([
        'body'=> '123'
    ]);
    
    expect($response['headers']['Content-Length'])->toBe(3);
});
