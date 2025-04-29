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
        // Ambil session
        $session = session();
        
        // Jika pengguna belum login, redirect ke halaman login
        if (! $session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        // Ambil role dan segment URL
        $role = $session->get('role');
        $uri = service('uri')->getSegment(1); // Ambil segment pertama dari URL

        // Jika user admin mencoba akses user-dashboard
        if ($role === 'admin' && $uri === 'user') {
            return redirect()->to('/admin');
        }

        // Jika user biasa mencoba akses admin-dashboard
        if ($role === 'user' && $uri === 'admin') {
            return redirect()->to('/user');
        }

        // Jika role sesuai dengan halaman yang diminta, lanjutkan
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
