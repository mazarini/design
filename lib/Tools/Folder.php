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

namespace Mazarini\DesignBundle\Tools;

class Folder
{
    /*
     * @var string
     */
    private $layout;
    /*
     * @var string
     */
    private $base;
    /*
     * @var string
     */
    private $stepRoot;
    /*
     * @var string
     */
    private $bundleRoot;

    public function __construct(string $projectRoot)
    {
        $this->layout = $projectRoot.'/templates/layout.html.twig';
        $this->base = $projectRoot.'/templates/base.html.twig';
        $this->stepRoot = \dirname(__DIR__).'/Resources/views/steps';
        $this->bundleRoot = \dirname(__DIR__, 2);
    }

    public function getBase(): string
    {
        return $this->base;
    }

    public function getLayout(): string
    {
        return $this->layout;
    }

    public function hasBase(): bool
    {
        return file_exists($this->getBase());
    }

    public function hasLayout(): bool
    {
        return file_exists($this->getLayout());
    }

    public function getBundleRoot(): string
    {
        return $this->bundleRoot;
    }

    public function getStepRoot(): string
    {
        return $this->stepRoot;
    }

    public function getSteps(): array
    {
        $dirs = glob($this->stepRoot.'/??-*');
        $steps = [];
        if (\is_array($dirs)) {
            foreach ($dirs as $dir) {
                $step = basename($dir);
                $steps[mb_substr($step, 3)] = $step;
            }
        }

        return $steps;
    }

    public function getPages(string $step): array
    {
        $dirs = glob($this->stepRoot.'/'.$step.'/??-*\.html\.twig');
        $pages = [];
        if (\is_array($dirs)) {
            foreach ($dirs as $dir) {
                $pages[mb_substr(basename($dir, '.html.twig'), 3)] = basename($dir);
            }
        }

        return $pages;
    }
}
