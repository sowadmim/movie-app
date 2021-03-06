<?php

namespace App\ViewModels;

use Carbon\Carbon;
use Spatie\ViewModels\ViewModel;

class ActorViewModel extends ViewModel
{
    public function __construct(public array $actor, public array $social, public array $credits)
    {
        //
    }

    public function actor()
    {
        $birthday = Carbon::parse($this->actor['birthday']);
        $deathday = $this->actor['deathday'] ? Carbon::parse($this->actor['deathday']) : null;

        return collect($this->actor)->merge([

            'profile_path' => $this->actor['profile_path']
            ? 'https://image.tmdb.org/t/p/w500' . $this->actor['profile_path']
            : 'https:ui-avatars.com/api?size=500$background=5555&color=fff&name=' . $this->actor['profile_path'],
            'birthday'     => $birthday->format('M d, Y'),
            'deathday'     => $deathday ? $deathday->format('M d, Y') : null,
            'age'          => $deathday
            ? $birthday->diffInYears($deathday)
            : Carbon::parse($this->actor['birthday'])->age,
        ]);
    }

    public function social()
    {
        return collect($this->social)
            ->merge([
                'twitter'   => $this->social['twitter_id'] ? "https://twitter.com/" . $this->social['twitter_id'] : null,
                'facebook'  => $this->social['facebook_id'] ? "https://www.facebook.com/" . $this->social['facebook_id'] : null,
                'instagram' => $this->social['instagram_id'] ? "https://www.instagram.com/" . $this->social['instagram_id'] : null,
            ]);
    }

    public function knownFor()
    {
        $castMovies = collect($this->credits)->get('cast');

        return collect($castMovies)->sortByDesc('popularity')->take(5)
            ->map(function ($media) {
                return collect($media)->merge([
                    'poster_path' => 'https://image.tmdb.org/t/p/w500' . $media['poster_path'],
                ]);
            });
    }

    public function credits()
    {
        $credits = collect($this->credits)->get('cast');

        return collect($credits)->map(function ($credit) {
            $releaseDate = isset($credit['release_date'])
            ? $credit['release_date']
            : (isset($credit['first_air_date']) ? $credit['first_air_date'] : null);

            $title = isset($credit['title'])
            ? $credit['title']
            : (isset($credit['name']) ? $credit['name'] : 'Untitled');

            return collect($credit)->merge([
                'release_date' => $releaseDate,
                'release_year' => $releaseDate ? Carbon::parse($releaseDate)->format('Y') : 'Future',
                'title'        => $title,
                'character'    => isset($credit['character']) ? $credit['character'] : '',
                'url'          => $credit['media_type'] == 'movie' ? route('movies.show', $credit['id']) : route('tv.show', $credit['id']),
            ]);
        })->sortByDesc('release_year');
    }
}
