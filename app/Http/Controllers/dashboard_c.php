<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Analytics;
use Spatie\Analytics\Period;

class dashboard_c extends Controller
{
    // -------------------------- ANALYTICS --------------------------
    function analytics()
    {
        $visitor = Analytics::fetchTotalVisitorsAndPageViews(Period::months(1));
        $view = Analytics::performQuery(Period::months(1), 'ga:pageviews', ['metrics' => 'ga:sessions, ga:pageviews, ga:transactions']);
        $view = $view;
        $mostVisitedPages = Analytics::fetchMostVisitedPages(Period::months(1), 10);
        return compact('visitor', 'view', 'mostVisitedPages');
    }
}
