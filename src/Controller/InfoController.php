<?php

namespace App\Controller;

/**
 * Class InfoController
 * Creates info pages
 */
class InfoController extends SessionController
{
    public function faq(): string
    {
        return $this->twig->render('Info/faq.html.twig');
    }

    public function about(): string
    {
        return $this->twig->render('Info/about.html.twig');
    }

    public function legal(): string
    {
        return $this->twig->render('Info/legal.html.twig');
    }
}
