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

namespace Mazarini\DesignBundle\Controller;

use Mazarini\DesignBundle\Tool\Folder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DesignController extends AbstractController
{
    /**
     * @Route("/{page}", name="design_page", requirements={"page"="install|info|layout|base"})
     */
    public function page(Folder $folder, string $page)
    {
        $pages = [
            'install' => 'Install',
            'base' => 'base.html.twig',
//          'info' => 'Info',
//          'layout' => 'layout.html.twig',
        ];
        foreach ($pages as $item => $label) {
            if ($item === $page) {
                $menu[$label] = '';
            } else {
                $menu[$label] = $this->generateUrl('design_page', ['page' => $item]);
            }
        }
        $param['menu'] = $menu;
        $param['folder'] = $folder;

        return $this->render('@MazariniDesign/page/'.$page.'.html.twig', $param);
    }

    /**
     * @Route("/{debug}", name="design", methods={"GET","POST"})
     */
    public function index(Request $request, Folder $folder, string $debug = '')
    {
        if (!$folder->hasLayout()) {
            return $this->page($folder, 'install');
        }
        $data = $request->request->get('form');
        $step = isset($data['step']) ? $data['step'] : '';
        $page = isset($data['page']) ? $data['page'] : '';
        $steps = $folder->getSteps();
        if (!\in_array($step, $steps, true)) {
            $step = reset($steps);
        }

        $pages = $folder->getPages($step);
        if (!\in_array($page, $pages, true)) {
            $page = reset($pages);
        }

        $data = ['step' => $step, 'page' => $page];
        $form = $this->createFormBuilder($data)
        ->add('step', ChoiceType::class, ['choices' => $steps, 'attr' => ['onchange' => 'submit();']])
        ->add('page', ChoiceType::class, ['choices' => $pages, 'attr' => ['onchange' => 'submit();']])
        ->add('refresh', SubmitType::class)
        ->getForm();

        if ('' === $debug) {
            $template = '@MazariniDesign/step/'.$step.'/'.$page;
        } else {
            $template = '@MazariniDesign/debug.html.twig';
        }

        $ArrayDatas = [];
        for ($i = 1; $i < 8; ++$i) {
            for ($j = 1; $j < 4; ++$j) {
                $ArrayDatas[$i]['col'.$j] = 'data-'.$i.'-'.$j;
            }
        }

        return $this->render($template, [
            'template' => $template,
            'form_design' => $form->createView(),
            'current' => ['step' => $step, 'page' => $page],
            'steps' => $steps,
            'pages' => $pages,
            'arrayDatas' => $ArrayDatas,
        ]);
    }
}
