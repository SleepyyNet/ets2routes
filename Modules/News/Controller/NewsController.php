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
use App\Kernel\QBuilder\QBuilder;
use DI\Container;
use GuzzleHttp\Psr7\Response;

class NewsController extends Controller
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->renderer->addPath('Modules/News/Views', 'News');
    }

    public function integratedNews()
    {
        /*$select = $this->container->get(QBuilder::class)->select('news');
        $select
            ->addField('id', 'news')
            ->addField('post_date', 'news')
            ->addField('change_date', 'news')
            ->addField('slug', 'news')
            ->addField('title', 'news')
            ->addField('text', 'news')
            ->addField('name', 'news_cat', 'category')
            ->addField('login', 'user')
            ->addJoin('INNER', 'news_cat', 'id', 'news', 'cat')
            ->addJoin('INNER', 'user', 'id', 'news', 'author')
            ->execute();
        $results = $select->fetchAll();*/

        $repos = $this->getManager()->getRepository(News::class);
        $results = $repos->findAll();

        //var_dump($results[1]->getAuthor()->getLogin()); exit;

        return $this->renderer->render('@News/Integrated/news.html.twig', ['newsList' => $results], 200, true);
    }
}
