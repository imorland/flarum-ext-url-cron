<?php

/*
 * This file is part of ianm/url-cron.
 *
 * Copyright (c) 2023 IanM.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace IanM\UrlCron\Tests\integration\api;

use Flarum\Testing\integration\TestCase;
use PHPUnit\Framework\Attributes\Test;

class TriggerCronTest extends TestCase
{
    /**
     * Path to the marker file written by the stub `flarum` binary. Its
     * existence proves the controller actually shelled out to the scheduler.
     */
    private string $marker;

    public function setUp(): void
    {
        parent::setUp();

        $this->extension('ianm-url-cron');

        $this->marker = $this->absoluteTmpDir().'/schedule-run-invoked';

        if (file_exists($this->marker)) {
            unlink($this->marker);
        }

        $this->writeStubBinary();
    }

    protected function tearDown(): void
    {
        foreach ([$this->marker, $this->absoluteTmpDir().'/flarum'] as $path) {
            if (file_exists($path)) {
                unlink($path);
            }
        }

        parent::tearDown();
    }

    /**
     * CI sets FLARUM_TEST_TMP_DIR_LOCAL to a relative path, and the controller
     * chdir()s before shelling out — so a relative marker path would resolve
     * against the wrong directory. Always work with an absolute one.
     */
    private function absoluteTmpDir(): string
    {
        return realpath($this->tmpDir()) ?: $this->tmpDir();
    }

    /**
     * The test install created by flarum/testing has no `flarum` console
     * binary, so we drop a stand-in into the tmp dir. It records the arguments
     * it was called with, letting us assert on the real `exec()` call the
     * controller makes rather than mocking it away.
     */
    private function writeStubBinary(): void
    {
        $marker = var_export($this->marker, true);

        file_put_contents($this->absoluteTmpDir().'/flarum', <<<PHP
            #!/usr/bin/env php
            <?php
            file_put_contents($marker, implode(' ', array_slice(\$argv, 1)));
            echo "Running scheduled command: dummy\\n";
            PHP);
    }

    #[Test]
    public function hitting_the_url_runs_the_scheduler()
    {
        $response = $this->send(
            $this->request('GET', '/api/cron/trigger')
        );

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertFileExists(
            $this->marker,
            'Expected the controller to invoke the flarum console binary.'
        );
        $this->assertEquals('schedule:run', file_get_contents($this->marker));

        // NOTE: the controller passes an already-encoded string to JsonResponse,
        // which encodes it a second time — so the body decodes to a JSON string
        // rather than an array. Asserted as-is to document current behaviour;
        // if the double-encoding is fixed, decode once and assertContains().
        $body = json_decode($response->getBody()->getContents(), true);

        $this->assertIsString($body);
        $this->assertContains('Running scheduled command: dummy', json_decode($body, true));
    }
}
