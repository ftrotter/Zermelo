<?php

namespace ftrotter\Zermelo\Reports\Tabular;

use ftrotter\Zermelo\Interfaces\CacheInterface;
use ftrotter\Zermelo\Interfaces\GeneratorInterface;
use ftrotter\Zermelo\Models\ZermeloReport;
use ftrotter\Zermelo\Exceptions\InvalidDatabaseTableException;
use ftrotter\Zermelo\Exceptions\InvalidHeaderFormatException;
use ftrotter\Zermelo\Exceptions\InvalidHeaderTagException;
use ftrotter\Zermelo\Exceptions\UnexpectedHeaderException;
use ftrotter\Zermelo\Exceptions\UnexpectedMapRowException;
use \DB;

class ReportSummaryGenerator extends ReportGenerator implements GeneratorInterface
{

    public function toJson()
    {
        return [
            'Report_Name' => $this->cache->getReport()->GetReportName(),
            'Report_Description' => $this->cache->getReport()->GetReportDescription(),
            'selected-data-option' => $this->cache->getReport()->getParameter( 'data-option' ),
            'columns' => $this->runSummary(),
            'cache_meta_generated_this_request' => $this->cache->getGeneratedThisRequest(),
            'cache_meta_last_generated' => $this->cache->getLastGenerated(),
            'cache_meta_expire_time' => $this->cache->getExpireTime(),
            'cache_meta_cache_enabled' => $this->cache->getReport()->isCacheEnabled()
        ];
    }

    public function runSummary()
    {
        return $this->getHeader(true);
    }
}
