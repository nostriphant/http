<?php

test('it wraps itself around body', function () {
    
    $request = new \nostriphant\HTTP\ServerRequest([], [], 'test');
    
    foreach ($request as $line) {
        expect($line)->toBe('test');
    }
});


test('it wraps itself around streamed body', function () {
    
    $resource = fopen("php://memory", "r+");
    fwrite($resource, 'test');
    fseek($resource, 0);
    
    $request = new \nostriphant\HTTP\ServerRequest([], [], $resource);
    
    foreach ($request as $line) {
        expect($line)->toBe('test');
    }
});



test('it parses authorzation header', function () {
    
    $request = new \nostriphant\HTTP\ServerRequest([
        'HTTP_AUTHORIZATION' => nostriphant\HTTP\Headers::authorization(\nostriphant\NIP01\Key::generate(), 'get', '/', [])
    ], [], '');
    
    expect($request->authorization)->toBeInstanceOf(nostriphant\NIP01\Event::class);
});