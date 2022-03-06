<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\apiGitHub;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Home extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        View::renderTemplate('Home/index.html');
    }

    public function getReposAction()
    {
        $connGitHub = new apiGitHub($_POST);

        if(!isset($_POST['user']))
        {
            $this->redirect('/');
        }else{
            if($results = $connGitHub->getRepositories()){
                View::renderTemplate('Home/index.html', ['result' => $results, 'user' => $_POST['user']]);
            }else{
                $this->redirect('/');
            }
        }



       
    }
}
