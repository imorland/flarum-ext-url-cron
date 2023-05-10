<?php

namespace IanM\UrlCron\Controllers;

use Flarum\Foundation\Paths;
use Flarum\Settings\SettingsRepositoryInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CronController implements RequestHandlerInterface
{
    /** @var Paths */
    public $paths;

    /** @var SettingsRepositoryInterface */
    public $settings;
    
    public function __construct(Paths $paths, SettingsRepositoryInterface $settings)
    {
        $this->paths = $paths;
        $this->settings = $settings;
    }
    
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        chdir($this->paths->base);
        $phpPath = $this->settings->get('ianm-url-cron.php-path');
        $command = "$phpPath flarum schedule:run";

        $output = [];
        exec($command, $output);

        return new JsonResponse(json_encode($output));
    }
}
