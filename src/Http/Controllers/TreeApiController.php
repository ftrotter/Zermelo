<?php

namespace ftrotter\Zermelo\Http\Controllers;

use ftrotter\Zermelo\Http\Requests\ZermeloRequest;
use ftrotter\Zermelo\Reports\Tree\CachedTreeReport;
use ftrotter\Zermelo\Reports\Tree\TreeReportGenerator;
use ftrotter\Zermelo\Reports\Tree\TreeReportSummaryGenerator;

class TreeApiController
{
    public function index( ZermeloRequest $request )
    {
        $report = $request->buildReport();
        $cache = new CachedTreeReport( $report, zermelo_cache_db() );
        $generator = new TreeReportGenerator( $cache );
        return $generator->toJson();
    }

    public function summary( ZermeloRequest $request )
    {
        $report = $request->buildReport();
        // Wrap the report in cache
        $cache = new CachedTreeReport( $report, zermelo_cache_db() );
        $generator = new TreeReportSummaryGenerator( $cache );
        return $generator->toJson();
    }
}
