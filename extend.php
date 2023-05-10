<?php

/*
 * This file is part of ianm/url-cron.
 *
 * Copyright (c) 2023 IanM.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace IanM\UrlCron;

use Flarum\Extend;

return [
    (new Extend\Frontend('admin'))
        ->js(__DIR__ . '/js/dist/admin.js'),

    new Extend\Locales(__DIR__ . '/locale'),

    (new Extend\Routes('api'))
        ->get('/cron/trigger', 'ianm.url-cron.trigger', Controllers\CronController::class),

    (new Extend\Settings())
        ->default('ianm-url-cron.php-path', 'php')
];
