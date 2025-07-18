<?php
/**
 * Created by PhpStorm.
 * User: kchapple
 * Date: 3/12/19
 * Time: 12:05 PM
 */

namespace ftrotter\Zermelo\Http\Controllers;


use ftrotter\Zermelo\Http\Requests\SocketWrenchRequest;
use ftrotter\Zermelo\Models\SocketUser;
use ftrotter\Zermelo\Models\Wrench;

class SocketWrenchController
{
    public function index( SocketWrenchRequest $request )
    {
        $socketUser = SocketUser::where( 'user_id', 1 )->first();
        $wrenches = Wrench::all();
        return $wrenches->toJson();
    }

    public function formSubmit( SocketWrenchRequest $request )
    {
        $socketUser = SocketUser::where( 'user_id', 1 )->first();
        $test = 0;
    }
}
