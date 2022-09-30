<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Analytics;
use Spatie\Analytics\Period;
use Carbon\Carbon;

class dashboard_c extends Controller
{
    // -------------------------- ANALYTICS --------------------------
    function analytics()
    {
        $visitor = Analytics::fetchTotalVisitorsAndPageViews(Period::days(6));
        $view = Analytics::performQuery(Period::months(1), 'ga:pageviews', [
            'dimensions' => 'ga:country',
            'metrics' => 'ga:sessions, ga:pageviews'
        ]);
        $report = collect($view->rows)->map(function ($data) {
            return ['country' => $data[0], 'users' => $data[1], 'views' => $data[2]];
        });
        $mostVisitedPages = Analytics::fetchMostVisitedPages(Period::months(1), 10);
        $visitor = $visitor->map(function ($m) {
            $date = Carbon::parse($m['date']);
            $m['date'] = $date->translatedFormat('Y-m-d');
            $m['day'] = $date->translatedFormat('l');
            return $m;
        });
        return compact('visitor', 'report', 'mostVisitedPages');
    }
}
