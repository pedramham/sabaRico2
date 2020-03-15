<?php
/**
 * Created by PhpStorm.
 * User: mori
 * Date: 11/02/20
 * Time: 16:43
 */

namespace App\Service;

use Symfony\Component\Cache\Adapter\MemcachedAdapter;
class Memcached
{
    public static function createConnection($dns)
    {
        $options = [
            'persistent_id' => 'some id'
        ];

        // Some more custom logic. Maybe adding some custom options
        // For example for AWS Elasticache

        if (defined('Memcached::OPT_CLIENT_MODE') && defined('Memcached::DYNAMIC_CLIENT_MODE')) {
            $options['CLIENT_MODE'] = \Memcached::DYNAMIC_CLIENT_MODE;
        }

        return \Symfony\Component\Cache\Adapter\MemcachedAdapter::createConnection($dns, $options);
    }
}