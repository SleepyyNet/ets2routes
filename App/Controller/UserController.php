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

namespace App\Controller;

use App\Kernel\CheckForm\CheckForm;
use App\Kernel\Controller;
use App\Entity\User;
use App\Kernel\SuperGlobals\SuperGlobals;

class UserController extends Controller
{
    /**
     * Create new user
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function registerAction()
    {
        $globals = $this->container->get(SuperGlobals::class);

        if ($globals->post()->isSubmit()) {
            $check = new CheckForm($this->container);

            if (!$check->check('App/Config/Forms/user_register.json')) {
                return $this->renderer->render('@App/User/register.html.twig');
            }

            $user = new User();
            $user
                ->setLogin($globals->post()->get('login'))
                ->setPassword(hash('sha256', $globals->post()->get('password')))
                ->setMail($globals->post()->get('mail'))
                ->setUserGroup(1);

            if ($this->entityManager->execute($user)) {
                $globals->session()->setFlashMessage(
                    'success',
                    $this->translation->translate('flash.register.success')
                );

                return $this->redirectToRoute('index');
            }

            $globals->session()->setFlashMessage(
                'error',
                $this->translation->translate('flash.register.error')
            );
        }

        return $this->renderer->render('@App/User/register.html.twig');
    }
}
