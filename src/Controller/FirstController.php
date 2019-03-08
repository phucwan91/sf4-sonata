<?php
/**
 * Created by PhpStorm.
 * User: phucvo
 * Date: 2/22/19
 * Time: 12:01 PM.
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class FirstController extends AbstractController
{
    /**
     * @return Response
     */
    public function greeting()
    {
        echo '<h2> Hey :D </h2>';

        return new Response();
    }
}
