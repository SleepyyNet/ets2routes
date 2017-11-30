<?php
/**
 *  Copyright Christophe Daloz - De Los Rios, 2017
 *
 *  Permission is hereby granted, free of charge, to any person obtaining a copy
 *  of this software and associated documentation files (the “Software”), to deal
 *  in the Software without restriction, including without limitation the rights
 *  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *  copies of the Software, and to permit persons to whom the Software is
 *  furnished to do so, subject to the following conditions:
 *
 *  The above copyright notice and this permission notice shall be included in
 *  all copies or substantial portions of the Software.
 *
 *  The Software is provided “as is”, without warranty of any kind, express or
 *  implied, including but not limited to the warranties of merchantability,
 *  fitness for a particular purpose and noninfringement. In no event shall the
 *  authors or copyright holders be liable for any claim, damages or other liability,
 *  whether in an action of contract, tort or otherwise, arising from, out of or in
 *  connection with the software or the use or other dealings in the Software.
 */

namespace Modules\News\Controller;

use App\Entity\News;
use App\Kernel\Controller;
use App\Kernel\SuperGlobals\SuperGlobals;
use DI\Container;

/**
 * Class NewsController
 * @package Modules\News\Controller
 * @author Christophe Daloz - De Los Rios
 * @version 1.0
 */
class NewsController extends Controller
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->renderer->addPath('Modules/News/Views', 'News');
    }

    /**
     * Integrated news in template
     * @return string
     */
    public function integratedNews()
    {
        $get = $this->container->get(SuperGlobals::class)->get();
        $repos = $this->getManager()->getRepository(News::class);

        $limitPerPage = $this->container->get('parameters')['modules']['news']['limitPerPage'];
        $page = (int)$get->get('page');
        $totalPages = (int)ceil($repos->count()/$limitPerPage);

        if ($page > 0) {
            $results = $repos->findBy([], ['postDate' => 'ASC'], $limitPerPage, ( $limitPerPage*($page-1) ));
        } else {
            $page = 1;
            $results = $repos->findBy([], ['postDate' => 'ASC'], $limitPerPage, 0);
        }

        return $this->renderer->render(
            '@News/Integrated/news.html.twig',
            ['newsList' => $results, 'total' => $totalPages, 'page' => $page],
            200,
            true
        );
    }
}
