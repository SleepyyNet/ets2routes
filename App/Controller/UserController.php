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
use App\Kernel\Mailer\Mailer;
use App\Kernel\QBuilder\Repository;
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
                $login = $globals->post()->get('login');
                $mail = $globals->post()->get('mail');

                return $this->renderer->render(
                    '@App/User/register.html.twig',
                    ['login' => $login, 'mail' => $mail]
                );
            }

            $user = new User();
            $user
                ->setLogin($globals->post()->get('login'))
                ->setPassword(hash('sha256', $globals->post()->get('password')))
                ->setMail($globals->post()->get('mail'))
                ->setUserGroup(1)
                ->setValidationCode($this->generateCode(32));

            $this->getManager()->persist($user);
            $this->getManager()->flush();

            if ($user->getId() > 0) {
                $mailer = new Mailer();
                $mailer->addCustomHeader('Reply-To', $this->parameters['mail']['sender']);
                $mailer->addAddress($user->getMail());
                $mailer->setFrom($this->parameters['mail']['sender'], $this->parameters['mail']['sendername']);
                $mailer->setSubject($this->translation->translate('register.mail'));
                $mailer->setMessage($this->renderer->render(
                    '@App/User/register_mail.html.twig',
                    [
                        'username' => $user->getLogin(),
                        'validation_code' => $user->getValidationCode()
                    ],
                    200,
                    true
                ));
                $mailer->send();

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

            return $this->redirectToRoute('index');
        }

        return $this->renderer->render('@App/User/register.html.twig');
    }

    /**
     * Terms of Service
     * @return \Psr\Http\Message\ResponseInterface|string
     */
    public function tosAction()
    {
        return $this->renderer->render('@App/User/tos.html.twig');
    }

    /**
     * Validation code
     * @param $code
     * @return \GuzzleHttp\Psr7\Response
     */
    public function validationAction($code)
    {
        $globals = $this->container->get(SuperGlobals::class);

        if (!is_null($code)) {
            $this->registerValidation($code);
            return $this->redirectToRoute('index');
        }

        if ($globals->post()->isSubmit()) {
            $check = new CheckForm($this->container);

            if ($check->check('App/Config/Forms/user_validation.json')) {
                if ($this->registerValidation($globals->post()->get('code'))) {
                    return $this->redirectToRoute('index');
                }
            }

            return $this->renderer->render('@App/User/validation.html.twig');
        }

        return $this->renderer->render('@App/User/validation.html.twig');
    }

    /**
     * User connection
     * @return \GuzzleHttp\Psr7\Response
     */
    public function loginAction()
    {
        $globals = $this->container->get(SuperGlobals::class);

        if ($globals->post()->isSubmit()) {
            $check = new CheckForm($this->container);

            if ($check->check('App/Config/Forms/user_login.json')) {
                $repos = $this->getManager()->getRepository(User::class);
                $user = $repos->findOneBy([
                    'login' => $globals->post()->get('login'),
                    'password' => hash('sha256', $globals->post()->get('password'))
                ]);

                if ($user instanceof User) {
                    $user->setLastLogin(date_create());
                    $this->getManager()->persist($user);
                    $this->getManager()->flush();

                    $globals->session()
                        ->set('id', $user->getId())
                        ->set('login', $user->getLogin());

                    return $this->redirectToRoute('index');
                }

                $globals->session()
                    ->setFlashMessage('error', $this->translation->translate('flash.connection.error'));
                return $this->renderer->render('@App/User/login.html.twig', [
                    'login' => $globals->post()->get('login')
                ]);
            }
        }

        return $this->renderer->render('@App/User/login.html.twig');
    }

    /**
     * Disconnect user
     * @return \GuzzleHttp\Psr7\Response
     */
    public function disconnectAction()
    {
        $globals = $this->container->get(SuperGlobals::class);
        $globals
            ->session()
            ->delete('id')
            ->delete('login')
            ->setFlashMessage('success', $this->translation->translate('flash.disconnect'));

        return $this->redirectToRoute('index');
    }

    /**
     * Validation register with code
     * @param $code
     * @return bool
     */
    private function registerValidation($code): bool
    {
        $bool = false;
        $globals = $this->container->get(SuperGlobals::class);
        $repos = $this->getManager()->getRepository(User::class);

        $user = $repos->findOneBy(['validationCode' => $code]);

        if ($user instanceof User) {
            $user
                ->setValidationCode(null)
                ->setValidate(true);
            $this->getManager()->persist($user);
            $this->getManager()->flush();

            $globals->session()->setFlashMessage(
                'success',
                $this->translation->translate('flash.validation.success')
            );

            return true;
        }

        $globals->session()->setFlashMessage(
            'error',
            $this->translation->translate('flash.validation.error')
        );
    }
}
