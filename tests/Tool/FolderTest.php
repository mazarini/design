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

namespace App\Tests\Tool;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FolderTest extends WebTestCase
{
    private $folder = null;

    public function setUp()
    {
        $this->createClient();
        $this->folder = self::$container->get('Mazarini\DesignBundle\Tool\Folder');
    }

    public function testStepRoot()
    {
        $this->assertSame(
            $this->getRootDir().'/lib/Resources/views/steps',
            $this->folder->getStepRoot()
        );
    }

    public function testLayout()
    {
        $this->assertSame(
            $this->getRootDir().'/templates/layout.html.twig',
            $this->folder->getLayout()
        );
    }

    public function testHasLayout()
    {
        $this->assertTrue(
            $this->folder->hasLayout()
        );
    }

    protected function getRootDir(): string
    {
        return \dirname(__DIR__, 2);
    }
}
