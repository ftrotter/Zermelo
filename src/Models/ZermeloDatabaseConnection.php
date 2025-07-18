<?php
/**
 * Created by PhpStorm.
 * User: kchapple
 * Date: 4/8/19
 * Time: 11:15 AM
 *
 * Wrapper for a database connection
 */

namespace ftrotter\Zermelo\Models;


class ZermeloDatabaseConnection
{
    protected $connectionName = '';

    public function __construct( $connectionName )
    {
        $this->connectionName = $connectionName;
    }

    public function connectionName()
    {
        return $this->connectionName;
    }

}