<?php

namespace nostriphant\HTTP;

interface Authorization {
    function __invoke($curl) : ?string;
}
