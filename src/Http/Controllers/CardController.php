<?php

namespace ftrotter\Zermelo\Http\Controllers;

use ftrotter\Zermelo\Http\Controllers\AbstractWebController;
use ftrotter\Zermelo\Http\Requests\CardsReportRequest;
use ftrotter\Zermelo\Interfaces\ZermeloReportInterface;
use ftrotter\Zermelo\Models\ZermeloReport;

class CardController extends AbstractWebController
{
    /**
     * @return \Illuminate\Config\Repository|mixed
     *
     * Get the view template
     */
    public  function getViewTemplate()
    {
        return config("zermelo.CARD_VIEW_TEMPLATE");
    }

    /**
     * @return string
     *
     * Specify the path to this report's API
     * This report uses the tabular api prefix
     */
    public function getReportApiPrefix()
    {
        return tabular_api_prefix();
    }

    /**
     * @param $report
     *
     * Build presenter and push our required varialbes for this web view
     */
    public function onBeforeShown(ZermeloReportInterface $report)
    {
        $bootstrap_css_location = asset(config('zermelo.BOOTSTRAP_CSS_LOCATION','/css/bootstrap.min.css'));
        $report->pushViewVariable('bootstrap_css_location', $bootstrap_css_location);
        $report->pushViewVariable('report_uri', $this->getReportUri($report));
        $report->pushViewVariable('summary_uri', $this->getSummaryUri($report));
    }

    /**
     * @param $report
     * @return string
     *
     * Protected method, specific to this controller, to build the report URI (though as of now it's the same as tabular)
     */
    protected function getReportUri($report)
    {
        $parameterString = implode("/", $report->getMergedParameters() );
        $report_api_uri = "/{$this->getApiPrefix()}/{$this->getReportApiPrefix()}/{$report->uriKey()}/{$parameterString}";
        return $report_api_uri;
    }

    protected function getSummaryUri($report)
    {
        $parameterString = implode("/", $report->getMergedParameters() );
        $summary_api_uri = "/{$this->getApiPrefix()}/{$this->getReportApiPrefix()}/{$report->uriKey()}/Summary/{$parameterString}";
        return $summary_api_uri;
    }
}
