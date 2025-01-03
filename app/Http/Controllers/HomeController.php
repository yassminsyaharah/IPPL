<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function onboarding_index ()
    {
        $apiKey     = env ( 'GOOGLE_PLACES_API_KEY' );
        $proxy      = env ( 'SOCKS5_PROXY', '' );
        $maxWidthPx = 1024;

        // Define queries for each category
        $categories = [ 
            'surfing'       => 'Surf Spot in Indonesia',
            'trekking'      => 'Hiking and Trekking Spot in Indonesia',
            'multiactivity' => 'Adventure Park Tourist Attraction in Indonesia',
            'outbond'       => 'Outbond Recreation Area in Indonesia'
        ];

        $allPlaces = [];

        foreach ( $categories as $category => $query )
        {
            $httpClient = Http::withHeaders ( [ 
                'X-Goog-Api-Key'   => $apiKey,
                'X-Goog-FieldMask' => 'places.displayName,places.id,places.photos,places.formattedAddress',
            ] );

            if ( ! empty ( $proxy ) )
            {
                $httpClient = $httpClient->withOptions ( [ 'proxy' => $proxy ] );
            }

            $response = $httpClient->post ( 'https://places.googleapis.com/v1/places:searchText', [ 
                'textQuery' => $query,
            ] );

            if ( $response->successful () )
            {
                $places = $response->json ()[ 'places' ] ?? [];
                if ( ! empty ( $places ) )
                {
                    // Take only the first result from each category
                    $place          = $places[ 0 ];
                    $name           = $place[ 'displayName' ][ 'text' ] ?? 'Unknown';
                    $address        = $place[ 'formattedAddress' ] ?? 'No address available';
                    $photoReference = isset ( $place[ 'photos' ][ 0 ][ 'name' ] ) ? $place[ 'photos' ][ 0 ][ 'name' ] : null;
                    $placeId        = $place[ 'id' ] ?? null;

                    $photoUrl = $photoReference
                        ? "https://places.googleapis.com/v1/{$photoReference}/media?key=$apiKey&maxWidthPx=$maxWidthPx"
                        : null;

                    $allPlaces[] = [ 
                        'id'        => $placeId,
                        'name'      => $name,
                        'address'   => $address,
                        'photo_url' => $photoUrl,
                        'category'  => $category
                    ];
                }
            }
        }

        $active_navbar = 'onboarding';

        return view ( 'onboarding', [ 
            'active_navbar' => $active_navbar,
            'places'        => $allPlaces,
        ] );
    }

    public function recommendations_index ()
    {
        $apiKey     = env ( 'GOOGLE_PLACES_API_KEY' );
        $proxy      = env ( 'SOCKS5_PROXY', '' );
        $maxWidthPx = 1024;

        // Define queries for each category
        $categories = [ 
            'Surfing'        => 'Surf Spot in Indonesia',
            'Trekking'       => 'Hiking and Trekking Spot in Indonesia',
            'Multi Activity' => 'Adventure Park Tourist Attraction in Indonesia',
            'Outbond'        => 'Outbond Recreation Area in Indonesia'
        ];

        $allPlaces = [];

        foreach ( $categories as $category => $query )
        {
            $httpClient = Http::withHeaders ( [ 
                'X-Goog-Api-Key'   => $apiKey,
                'X-Goog-FieldMask' => 'places.displayName,places.id,places.photos,places.formattedAddress',
            ] );

            if ( ! empty ( $proxy ) )
            {
                $httpClient = $httpClient->withOptions ( [ 'proxy' => $proxy ] );
            }

            $response = $httpClient->post ( 'https://places.googleapis.com/v1/places:searchText', [ 
                'textQuery'      => $query,
                'maxResultCount' => 4
            ] );

            if ( $response->successful () )
            {
                $places         = array_slice ( $response->json ()[ 'places' ] ?? [], 0, 4 );
                $categoryPlaces = [];

                foreach ( $places as $place )
                {
                    $name           = $place[ 'displayName' ][ 'text' ] ?? 'Unknown';
                    $address        = $place[ 'formattedAddress' ] ?? 'No address available';
                    $photoReference = isset ( $place[ 'photos' ][ 0 ][ 'name' ] ) ? $place[ 'photos' ][ 0 ][ 'name' ] : null;
                    $placeId        = $place[ 'id' ] ?? null;

                    $photoUrl = $photoReference
                        ? "https://places.googleapis.com/v1/{$photoReference}/media?key=$apiKey&maxWidthPx=$maxWidthPx"
                        : null;

                    $categoryPlaces[] = [ 
                        'id'        => $placeId,
                        'name'      => $name,
                        'address'   => $address,
                        'photo_url' => $photoUrl,
                    ];
                }

                $allPlaces[ $category ] = $categoryPlaces;
            }
        }

        $active_navbar = 'recommendations';

        return view ( 'recommendations', [ 
            'categories'    => $allPlaces,
            'active_navbar' => $active_navbar,
        ] );
    }

    public function bookmarks_index ()
    {
        $active_navbar   = 'bookmarks';
        $bookmarks       = [];
        $placesBookmarks = [];

        if ( Auth::check () )
        {
            // Get local bookmarks with destinations
            $bookmarks = Auth::user ()->bookmarks ()->with ( 'destination' )->get ();

            // Get Google Places bookmarks
            $bookmarksV2 = Auth::user ()->bookmarksV2 ()->get ();

            // Fetch details for each Google Place
            $apiKey     = env ( 'GOOGLE_PLACES_API_KEY' );
            $proxy      = env ( 'SOCKS5_PROXY', '' );
            $maxWidthPx = 700;

            // Configure the HTTP client
            $httpClient = Http::withHeaders ( [ 
                'X-Goog-Api-Key'   => $apiKey,
                'X-Goog-FieldMask' => 'displayName,rating,formattedAddress,photos,userRatingCount'
            ] );

            if ( ! empty ( $proxy ) )
            {
                $httpClient = $httpClient->withOptions ( [ 'proxy' => $proxy ] );
            }

            foreach ( $bookmarksV2 as $bookmark )
            {
                $response = $httpClient->get ( "https://places.googleapis.com/v1/places/{$bookmark->place_id}" );

                if ( $response->successful () )
                {
                    $placeDetails = $response->json ();

                    // Get the first photo if available
                    $photoUrl = null;
                    if ( isset ( $placeDetails[ 'photos' ][ 0 ][ 'name' ] ) )
                    {
                        $photoReference = $placeDetails[ 'photos' ][ 0 ][ 'name' ];
                        $photoUrl       = "https://places.googleapis.com/v1/{$photoReference}/media?key={$apiKey}&maxWidthPx={$maxWidthPx}";
                    }

                    $placesBookmarks[] = [ 
                        'id'           => $bookmark->id,
                        'place_id'     => $bookmark->place_id,
                        'name'         => $placeDetails[ 'displayName' ][ 'text' ] ?? 'Unknown',
                        'address'      => $placeDetails[ 'formattedAddress' ] ?? 'No address',
                        'rating'       => $placeDetails[ 'rating' ] ?? 0,
                        'review_count' => $placeDetails[ 'userRatingCount' ] ?? 0,
                        'photo_url'    => $photoUrl,
                        'type'         => 'google_place'
                    ];
                }
            }
        }

        return view ( 'bookmarks', [ 
            'active_navbar'   => $active_navbar,
            'bookmarks'       => $bookmarks,
            'placesBookmarks' => $placesBookmarks
        ] );
    }

    public function search ( Request $request )
    {
        $query = $request->get ( 'query' );

        if ( empty ( trim ( $query ) ) )
        {
            if ( $request->ajax () )
            {
                return response ()->json ( [ 
                    'html' => view ( 'components.search-default-message' )->render ()
                ] );
            }
            return redirect ()->back ();
        }

        $apiKey     = env ( 'GOOGLE_PLACES_API_KEY' );
        $proxy      = env ( 'SOCKS5_PROXY', '' );
        $maxWidthPx = 1024;

        $httpClient = Http::withHeaders ( [ 
            'X-Goog-Api-Key'   => $apiKey,
            'X-Goog-FieldMask' => 'places.displayName,places.id,places.photos,places.formattedAddress',
        ] );

        if ( ! empty ( $proxy ) )
        {
            $httpClient = $httpClient->withOptions ( [ 'proxy' => $proxy ] );
        }

        $response = $httpClient->post ( 'https://places.googleapis.com/v1/places:searchText', [ 
            'textQuery'      => $query . ' in Indonesia',
            'maxResultCount' => 4  // Add this line to limit results
        ] );

        if ( $response->successful () )
        {
            $places    = array_slice ( $response->json ()[ 'places' ] ?? [], 0, 4 ); // Ensure max 4 results
            $placeData = [];

            foreach ( $places as $place )
            {
                $name           = $place[ 'displayName' ][ 'text' ] ?? 'Unknown';
                $address        = $place[ 'formattedAddress' ] ?? 'No address available';
                $photoReference = isset ( $place[ 'photos' ][ 0 ][ 'name' ] ) ? $place[ 'photos' ][ 0 ][ 'name' ] : null;
                $placeId        = $place[ 'id' ] ?? null;

                $photoUrl = $photoReference
                    ? "https://places.googleapis.com/v1/{$photoReference}/media?key=$apiKey&maxWidthPx=$maxWidthPx"
                    : null;

                $placeData[] = [ 
                    'id'        => $placeId,
                    'name'      => $name,
                    'address'   => $address,
                    'photo_url' => $photoUrl,
                ];
            }

            if ( $request->ajax () )
            {
                return response ()->json ( [ 
                    'data' => $placeData,
                    'html' => view ( 'components.search-results', [ 'places' => $placeData ] )->render ()
                ] );
            }
        }

        return redirect ()->back ();
    }
}
