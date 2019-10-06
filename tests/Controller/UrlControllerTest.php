<?php

/*
 * Copyright (C) 2019 Mazarini <mazarini@protonmail.com>.
 * This file is part of mazarini/design.
 *
 * mazarini/design is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.
 *
 * mazarini/design is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for
 * more details.
 *
 * You should have received a copy of the GNU General Public License
 */

namespace App\Tests\Controller;

use Mazarini\DesignBundle\Tools\Folder;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UrlControllerTest extends WebTestCase
{
    /**
     * @dataProvider getUrls
     */
    public function testUrls(string $url)
    {
        $client = static::createClient();
        $client->request('GET', $url);

        $this->assertSame(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode(),
            sprintf('The %s public URL loads correctly.', $url)
        );
    }

    public function testPostUrls()
    {
        $folder = new Folder(\dirname(\dirname(__DIR__)));
        $steps = $folder->getSteps();
        foreach ($steps as $step) {
            $this->postUrls($step);
            $pages = $folder->getPages($step);
            foreach ($pages as $page) {
                $this->postUrls($step, $page);
            }
        }
    }

    protected function postUrls(string $step, string $page = '')
    {
        $client = static::createClient();
        $client->request('POST', '/', ['step' => $step, 'page' => $page]);

        $this->assertSame(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode(),
            sprintf('The / with[%s,%s] public URL with loads correctly.', $step, $page)
        );
    }

    public function getUrls()
    {
        yield ['/'];
        yield ['/install'];
        yield ['/base'];
    }
}
