<?php

namespace App\Http\Controllers;

use App\ViewModels\ActorsViewModel;
use App\ViewModels\ActorViewModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ActorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($page = 1)
    {
        abort_if($page > 500, 204);

        $actors = Http::withToken(config('services.tmdb.token'))
            ->get(config('services.tmdb.base_url') . "/person/popular?page=" . $page)
            ->json()['results'];

        return view('actors.index', new ActorsViewModel($actors, $page));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $actor = Http::withToken(config('services.tmdb.token'))
            ->get(config('services.tmdb.base_url') . "/person/$id")
            ->json();

        abort_if(isset($actor['status_code']) && $actor['status_code'] = 34, 404);

        $social = Http::withToken(config('services.tmdb.token'))
            ->get(config('services.tmdb.base_url') . "/person/$id/external_ids")
            ->json();

        $credits = Http::withToken(config('services.tmdb.token'))
            ->get(config('services.tmdb.base_url') . "/person/$id/combined_credits")
            ->json();

        // dd($credits['cast'][0]);

        return view('actors.show', new ActorViewModel($actor, $social, $credits));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
