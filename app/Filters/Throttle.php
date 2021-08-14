<?php namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class Throttle implements FilterInterface
{
        /**
         * This is a demo implementation of using the Throttler class
         * to implement rate limiting for your application.
         *
         * @param RequestInterface|\CodeIgniter\HTTP\IncomingRequest $request
         * @param array|null                                         $arguments
         *
         * @return mixed
         */
        public function before(RequestInterface $request, $arguments = null)
        {
                $throttler = Services::throttler();

                // Restrict an IP address to no more
                // than 1 request per second across the
                // entire site.
                
                //해당 아이피가 보유한 토큰수는 60인데 할당된 시간내에 너무 많은 토큰이 사용되었는지 확인한다.
                //매번 확인할때마다 사용가능한 토큰은 성공하면 $cost를 차감한다. 
                if ($throttler->check($request->getIPAddress(), 60, MINUTE) === false)
                {
                        return Services::response()->setStatusCode(429);
                }
        }

        //--------------------------------------------------------------------

        /**
         * We don't have anything to do here.
         *
         * @param RequestInterface|\CodeIgniter\HTTP\IncomingRequest $request
         * @param ResponseInterface|\CodeIgniter\HTTP\Response       $response
         * @param array|null                                         $arguments
         *
         * @return mixed
         */
        public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
        {
        }
}