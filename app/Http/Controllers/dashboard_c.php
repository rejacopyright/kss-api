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
        $view = Analytics::get(Period::months(1), ['activeUsers', 'totalUsers', 'screenPageViews'], ['country']);
        $report = collect($view)->map(function ($data) {
            return ['country' => $data['country'], 'users' => $data['totalUsers'], 'views' => $data['screenPageViews']];
        });
        $mostVisitedPages = Analytics::fetchMostVisitedPages(Period::months(1), 10);
        $mostVisitedPages = collect($mostVisitedPages)->map(function ($m) {
            $m['fullPageUrl'] = str_replace('localhost/', '/', $m['fullPageUrl']);
            if (str_contains($m['fullPageUrl'], '.co.id')) {
                $m['fullPageUrl'] = 'https://' . $m['fullPageUrl'];
            }
            return $m;
        });
        $visitor = $visitor->map(function ($m) {
            $date = Carbon::parse($m['date']);
            $m['date'] = $date->translatedFormat('Y-m-d');
            $m['day'] = $date->translatedFormat('l');
            return $m;
        });
        return compact('visitor', 'report', 'mostVisitedPages');
    }
}
