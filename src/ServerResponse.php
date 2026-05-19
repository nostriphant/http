<?php

namespace nostriphant\HTTP;


readonly class ServerResponse {
    
    public function __construct(
            public string $protocol,
            public string $status,
            public Headers $headers,
            public string $body
    ) {
        ;
    }
    
}
