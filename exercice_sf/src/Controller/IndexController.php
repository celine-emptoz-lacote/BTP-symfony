<?php

//declaration du controller dans ce namespace
namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
//instalation des annotations qui est plus partique que de switcher entre cette page et la page routes.yaml
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

    

Class IndexController extends Controller
{
    /**
     * @route("/" , name="HomePage")
     */
    public function Index(){
      
        //envoie infos et ou template a notre vue
        return $this->render("site/index.html.twig");
    }

}



?>