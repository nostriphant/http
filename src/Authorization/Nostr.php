<?php

namespace nostriphant\HTTP\Authorization;

readonly class Nostr implements \nostriphant\HTTP\Authorization {
    
    public function __construct(private \nostriphant\NIP01\Key $sender_key, private array $tags) {
        ;
    }
    
    #[\Override]
    public function __invoke($curl): ?string {
        $info = curl_getinfo($curl);
        return 'Authorization: ' . \nostriphant\HTTP\Headers::authorization($this->sender_key, $info['effective_method'], $info['url'], $this->tags);
    }
}
