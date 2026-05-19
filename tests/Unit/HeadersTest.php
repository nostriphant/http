<?php

test('it wraps itself around raw headers', function () {
    
    $headers = new \nostriphant\HTTP\Headers([
        'Content-Type: text/plain'
    ]);
    
    expect($headers['content-type'])->toBe('text/plain');
    expect($headers->content_type)->toBe('text/plain');
});

test('it parses status line', function () {
    
    $headers = new \nostriphant\HTTP\Headers([
        'HTTP/1.1 200 Ok'
    ]);
    
    expect($headers['status'])->toBe('200');
    expect($headers['protocol'])->toBe('HTTP/1.1');
});


test('it parses multiple values', function () {
    
    $headers = new \nostriphant\HTTP\Headers([
        'Content-Type: text/plain; utf-8'
    ]);
    
    expect($headers['content-type'])->toBe(['text/plain', 'utf-8']);
    expect($headers->content_type)->toBe(['text/plain', 'utf-8']);
});

test('it filters empty headers', function () {
    
    $headers = new \nostriphant\HTTP\Headers([
        ''
    ]);
    
    expect($headers)->toHaveCount(0);
});

test('can be iterated', function () {
    
    $headers = new \nostriphant\HTTP\Headers([
        'Content-Type: text/plain'
    ]);
    
    foreach ($headers as $header => $values) {
        expect($header)->toBe('content-type');
        expect($values)->toBe(['text/plain']);
    }
});