<?php
/**
 * Created by PhpStorm.
 * User: kchapple
 * Date: 4/13/18
 * Time: 12:08 PM
 */

namespace ftrotter\Zermelo\Interfaces;


use ftrotter\Zermelo\Models\ZermeloReport;

interface GeneratorInterface
{
    public function addFilter( array $filters );

    public function orderBy( array $orders );

    public function paginate( $length );

    public function init( array $params = null );

    public function toJson();
}
