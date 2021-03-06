<?php

namespace TmlpStats\Http\Controllers;

use Cache;
use Illuminate\Http\Request;
use TmlpStats\CourseData;
use TmlpStats\Http\Requests;
use TmlpStats\StatsReport;

class CoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function getByStatsReport($id)
    {
        $cacheKey = "statsReport{$id}:courses";
        $courses = (static::USE_CACHE) ? Cache::tags(["statsReport{$id}"])->get($cacheKey) : false;

        if (!$courses) {
            $statsReport = StatsReport::find($id);
            if (!$statsReport) {
                return null;
            }

            $courses = [];
            $courseData = CourseData::byStatsReport($statsReport)->with('course')->get();
            foreach ($courseData as $data) {
                $courses[] = $data;
            }
        }
        Cache::tags(["statsReport{$id}"])->put($cacheKey, $courses, static::STATS_REPORT_CACHE_TTL);

        return $courses;
    }
}
