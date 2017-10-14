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

namespace App\Kernel\Mailer;

use PHPMailer\PHPMailer\PHPMailer;

/**
 * Class Mailer
 * @package Lib\Mailer
 */
class Mailer
{
    /**
     * @var PHPMailer
     */
    private $mailer;

    /**
     * Mailer constructor.
     */
    public function __construct()
    {
        $this->mailer = new PHPMailer();
        $this->mailer->addCustomHeader('X-Priority: 3');
        $this->mailer->addCustomHeader('Priority', 'normal');
        $this->mailer->isHTML(true);
        $this->setCharset('UTF-8');
    }

    /**
     * Add header
     * @param string $name
     * @param null $value
     * @return $this
     */
    public function addCustomHeader(string $name, $value = null)
    {
        $this->mailer->addCustomHeader($name, $value);

        return $this;
    }

    /**
     * Add recipient
     * @param string $mail
     * @param string $name
     * @return bool
     */
    public function addAddress(string $mail, string $name = ''): bool
    {
        return $this->mailer->addAddress($mail, $name);
    }

    /**
     * Set sender
     * @param string $mail
     * @param string $name
     * @return bool
     */
    public function setFrom(string $mail, string $name = ''): bool
    {
        return $this->mailer->setFrom($mail, $name);
    }

    /**
     * Mail is an HTML
     * @param bool $html
     */
    public function isHTML(bool $html = true): void
    {
        $this->mailer->isHTML($html);
    }

    /**
     * set charset encoding text
     * @param string $charset
     */
    public function setCharset(string $charset): void
    {
        $this->mailer->CharSet = $charset;
    }

    /**
     * Set subject
     * @param string $subject
     */
    public function setSubject(string $subject): void
    {
        $this->mailer->Subject = $subject;
    }

    /**
     * Set message
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->mailer->Body = $message;
    }

    /**
     * Send e-mail
     * @return bool
     */
    public function send(): bool
    {
        return $this->mailer->send();
    }
}
