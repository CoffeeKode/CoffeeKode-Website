<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Check_Routes implements FilterInterface
{
  public function before(RequestInterface $request)
  {
    $uri = service('uri');
    $length = count(explode("/", $uri)) - 3;

    $segment = $uri->getSegment($length);

    if (!$uri->getSegment(1) == "producto" || !$uri->getSegment(1) == "orden") {
      if ($length > 1) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
      } else if ($segment == 'cart_controller' || $segment == 'commune_controller' || $segment == 'home_controller' || $segment == 'user_controller') {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
      }
    }
  }

  //--------------------------------------------------------------------

  public function after(RequestInterface $request, ResponseInterface $response)
  {
    // Do something here
  }
}
