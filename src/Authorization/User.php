<?php

namespace nostriphant\HTTP\Authorization;

readonly class User implements \nostriphant\HTTP\Authorization {
    
    public function __construct(private string $username, private string $password) {
        
    }
    
    #[\Override]
    public function __invoke($curl): ?string {
        curl_setopt($curl, CURLOPT_USERNAME, $this->username);
        curl_setopt($curl, CURLOPT_USERPWD, $this->password);
        return null;
    }
}
