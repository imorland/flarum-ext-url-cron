<?php

namespace IanM\UrlCron\Controllers;

use Flarum\Foundation\Paths;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CronController implements RequestHandlerInterface
{
    public $paths;
    
    public function __construct(Paths $paths)
    {
        $this->paths = $paths;
    }
    
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        chdir($this->paths->base);
        $command = 'php flarum schedule:run';

        $output = [];
        exec($command, $output);

        return new JsonResponse(json_encode($output));
    }
}
