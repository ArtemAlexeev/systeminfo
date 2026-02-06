<?php

require_once __DIR__ . '/../vendor/autoload.php';

use ArtemAlieksieiev\SystemInfo\OpcacheStatus;

(new OpcacheStatus())->display();
