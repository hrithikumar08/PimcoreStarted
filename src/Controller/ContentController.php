<<<<<<< HEAD
<?php

namespace App\Controller;

use Pimcore\Controller\FrontendController;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContentController extends FrontendController
{
    #[Template('content/default.html.twig')]
    public function defaultAction (Request $request): array
    {
        return [];
    }
    
    public function productAction(Request $request): Response
    {
        return $this->render('content/product.html.twig');
    }
}
=======
<?php

namespace App\Controller;

use Pimcore\Controller\FrontendController;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContentController extends FrontendController
{
  
    #[Route('/tshirts')]
    public function productAction(Request $request): Response
    {
        return $this->render('content/product.html.twig');
        // return new Response('This is the response content.');
    }
    
}


?>
>>>>>>> 538ce99... object commit
