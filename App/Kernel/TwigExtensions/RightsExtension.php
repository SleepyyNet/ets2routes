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

namespace App\Kernel\TwigExtensions;

use App\Entity\User;
use App\Kernel\SuperGlobals\SessionGlobal;
use App\Kernel\SuperGlobals\SuperGlobals;
use DI\Container;

/**
 * Class RightsExtension
 * @package App\Kernel\TwigExtensions
 * @author Christophe Daloz - De Los Rios <christophedlr@gmail.com>
 * @version 1.0
 */
class RightsExtension extends \Twig_Extension
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var SessionGlobal
     */
    private $session;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->session = $this->container->get(SuperGlobals::class)->session();
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('auth', [$this, 'checkRight'])
        ];
    }

    /**
     * Check if user is authorized for desired action
     * @param string $type
     * @param string $access
     * @param User $user
     * @return int
     */
    public function checkRight(string $type, string $access)
    {
        global $entityManager;

        $parameters = $this->container->get('parameters');
        $repos = $entityManager->getRepository(User::class);
        $id = $this->session->get('id');

        if (!is_null($id)) {
            $user = $repos->find($id);

            return $user->getAccess() & $parameters['rights'][$type][$access]['code'];
        }

        return false;
    }
}
