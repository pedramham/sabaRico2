<?php
/**
 * Created by PhpStorm.
 * User: mori
 * Date: 11/02/20
 * Time: 09:36
 */

namespace App\Service;

use Symfony\Component\Cache\Adapter\TraceableAdapter;
use Psr\Cache\CacheItemPoolInterface;
class CacheRedis
{
    /**
     * @var CacheItemPoolInterface
     */
    private $cache;

    public function __construct(CacheItemPoolInterface $cache)
    {
        $this->cache = $cache;
    }

}