<?php
namespace Controllers;

use Pangolin\Controller;
use Pangolin\Request;
use Pangolin\NotFoundException;

class DefaultController extends Controller
{

    public function indexAction()
    {
        return $this->render();
    }

    public function showAction(Request $request)
    {
        $this['name'] = $request->get('name');
        return $this->render();
    }

    public function userAction(Request $request)
    {
        try {
            $this['user'] = $this->getRepository('User')
                ->find($request->get('id'));
            $this->setOutputFormat('json');
            return $this->render();
        } catch (NotFoundException $e) {
            return $this->render('errors/404');
        }
    }

}
