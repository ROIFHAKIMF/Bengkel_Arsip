<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
public function before(RequestInterface $request, $arguments = null)
{
    $session = session();

    // Cek apakah sudah login
    if (! $session->get('isLoggedIn')) {
        return redirect()->to('/login');
    }

    // Ambil role dan segment URL
    $role = $session->get('role');
    $segment1 = service('uri')->getSegment(1);

    // Kalau rolenya bukan admin, redirect ke login (jaga-jaga kalau role corrupt)
    if ($role !== 'admin') {
        return redirect()->to('/login');
    }

    // Kalau URL bukan /admin atau child-nya, redirect paksa ke /admin
    if ($segment1 !== 'admin') {
        return redirect()->to('/admin');
    }
}

    

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return ResponseInterface|void
     */

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
