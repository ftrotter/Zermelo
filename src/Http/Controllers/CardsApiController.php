<?php

namespace ftrotter\Zermelo\Http\Controllers;

use ftrotter\Zermelo\Http\Requests\CardsReportRequest;
use ftrotter\Zermelo\Http\Requests\ZermeloRequest;
use ftrotter\Zermelo\Models\DatabaseCache;
use ftrotter\Zermelo\Reports\Tabular\ReportGenerator;
use ftrotter\Zermelo\Reports\Tabular\ReportSummaryGenerator;

class CardsApiController
{
    public function index( ZermeloRequest $request )
    {
        $report = $request->buildReport();
        $cache = new DatabaseCache( $report, zermelo_cache_db() );
        $generator = new ReportGenerator( $cache );
        return $generator->toJson();
    }

    public function summary( ZermeloRequest $request )
    {
        $report = $request->buildReport();
        // Wrap the report in cache
        $cache = new DatabaseCache( $report, zermelo_cache_db() );
        $generator = new ReportSummaryGenerator( $cache );
        return $generator->toJson();
    }
}
