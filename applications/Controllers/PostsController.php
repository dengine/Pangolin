<?php

namespace Controllers;

use Pangolin\Controller;
use Pangolin\Request;
use Pangolin\NotFoundException;

/**
 * Class PostsController
 * @package Controllers
 *
 * Page responsible for posts
 */
class PostsController extends Controller
{
    /**
     * Action executing by default
     */
    public function indexAction()
    {
        return $this->render();
    }


}

