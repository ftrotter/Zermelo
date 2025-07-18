<?php

namespace ftrotter\Zermelo\Http\Controllers;

use ftrotter\Zermelo\Http\Requests\CardsReportRequest;
use ftrotter\ZermeloBladeTreeCard\TreeCardPresenter;
use Illuminate\Support\Facades\Auth;

class TreeCardController
{
    public function show( CardsReportRequest $request )
    {
        $presenter = new TreeCardPresenter( $request->buildReport() );

        $presenter->setApiPrefix( api_prefix() );
        $presenter->setReportPath( tree_api_prefix() );

        $user = Auth::guard()->user();
        if ( $user ) {
            $presenter->setToken( $user->getRememberToken() );
        }

        $view = config("zermelo.TREE_CARD_VIEW_TEMPLATE");

        return view( $view, [ 'presenter' => $presenter ] );
    }
}
