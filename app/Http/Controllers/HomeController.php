<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    private $apiKey;
    private $proxy;
    private $baseUrl;
    private $enableProxy;

    public function __construct()
    {
        $this->apiKey = env('GOOGLE_PLACES_API_KEY');
        $this->baseUrl = 'https://places.googleapis.com/v1';
        
        // Default values if ENV variables are not set
        $this->proxy = env('SOCKS5_PROXY') ?? '';
        $this->enableProxy = filter_var(env('ENABLE_PROXY', false), FILTER_VALIDATE_BOOLEAN);
        
        // Set no_proxy if provided
        if (env('NO_PROXY')) {
            putenv('no_proxy=' . env('NO_PROXY'));
        }
    }

    /**
     * Configure the HTTP client with common settings.
     */
    private function configureHttpClient ( $fieldMask = null )
    {
        $headers = [ 
            'X-Goog-Api-Key' => $this->apiKey,
        ];

        if ( $fieldMask )
        {
            $headers[ 'X-Goog-FieldMask' ] = $fieldMask;
        }

        $httpClient = Http::withHeaders ( $headers );

        if ( ! empty ( $this->proxy ) && $this->enableProxy )
        {
            $httpClient = $httpClient->withOptions ( [ 'proxy' => $this->proxy ] );
        }

        return $httpClient;
    }

    /**
     * Fetch places from the API.
     */
    private function fetchPlaces ( $query, $maxResults = null )
    {
        $body = [ 'textQuery' => $query ];
        if ( $maxResults )
        {
            $body[ 'maxResultCount' ] = $maxResults;
        }

        $httpClient = $this->configureHttpClient ( 'places.displayName,places.id,places.photos,places.formattedAddress,places.rating' );
        return $httpClient->post ( "{$this->baseUrl}/places:searchText", $body );
    }

    /**
     * Process place data for consistency.
     */
    private function processPlaces ( $places, $maxWidthPx )
    {
        $processedPlaces = array_map ( function ($place) use ($maxWidthPx)
        {
            $photoReference = $place[ 'photos' ][ 0 ][ 'name' ] ?? null;
            return [ 
                'id'        => $place[ 'id' ] ?? null,
                'name'      => $place[ 'displayName' ][ 'text' ] ?? 'Unknown',
                'address'   => $place[ 'formattedAddress' ] ?? 'No address available',
                'photo_url' => $photoReference
                    ? "{$this->baseUrl}/{$photoReference}/media?key={$this->apiKey}&maxWidthPx={$maxWidthPx}"
                    : null,
                'rating'    => $place[ 'rating' ] ?? 0,
            ];
        }, $places );

        // Sort places by rating in descending order
        usort ( $processedPlaces, function ($a, $b)
        {
            $ratingA = $a[ 'rating' ] ?? 0;
            $ratingB = $b[ 'rating' ] ?? 0;
            return $ratingB <=> $ratingA;
        } );

        return $processedPlaces;
    }

    /**
     * Get bookmarks with place details.
     */
    private function getBookmarksWithDetails ( $limit = null )
    {
        if ( ! Auth::check () )
        {
            return [];
        }
        // Get V2 bookmarks
        $bookmarksV2Query = Auth::user ()->bookmarksV2 ();
        if ( $limit )
        {
            $bookmarksV2Query->oldest ( 'created_at' )->limit ( $limit );  // Changed from latest to oldest
        }
        $bookmarksV2 = $bookmarksV2Query->get ();

        $placesBookmarks = [];
        foreach ( $bookmarksV2 as $bookmark )
        {
            $response = $this->configureHttpClient ( 'displayName,rating,formattedAddress,photos,userRatingCount' )
                ->get ( "{$this->baseUrl}/places/{$bookmark->place_id}" );

            if ( $response->successful () )
            {
                $placeDetails = $response->json ();
                $photoUrl     = isset ( $placeDetails[ 'photos' ][ 0 ][ 'name' ] )
                    ? "{$this->baseUrl}/{$placeDetails[ 'photos' ][ 0 ][ 'name' ]}/media?key={$this->apiKey}&maxWidthPx=700"
                    : null;

                $placesBookmarks[] = [ 
                    'id'        => $bookmark->id,
                    'place_id'  => $bookmark->place_id,
                    'name'      => $placeDetails[ 'displayName' ][ 'text' ] ?? 'Unknown',
                    'address'   => $placeDetails[ 'formattedAddress' ] ?? 'No address',
                    'photo_url' => $photoUrl,
                ];
            }
        }

        return $placesBookmarks;
    }

    /**
     * Onboarding page to show place categories.
     */
    public function onboarding_index ()
    {
        $categories = [ 
            'surfing'       => 'Surf Spot in Indonesia',
            'trekking'      => 'Hiking and Trekking Spot in Indonesia',
            'multiactivity' => 'Adventure Park Tourist Attraction in Indonesia',
            'outbond'       => 'Outbond Recreation Area in Indonesia',
        ];

        $places = [];
        foreach ( $categories as $category => $query )
        {
            $response = $this->fetchPlaces ( $query, 5 ); // Fetch more places to find highest rated
            if ( $response->successful () )
            {
                $placesData = $response->json ()[ 'places' ] ?? [];
                if ( ! empty ( $placesData ) )
                {
                    $processedPlaces = $this->processPlaces ( $placesData, 1024 );
                    if ( ! empty ( $processedPlaces ) )
                    {
                        // Since processPlaces already sorts by rating, just take the first one
                        $places[] = array_merge ( $processedPlaces[ 0 ], [ 'category' => $category ] );
                    }
                }
            }
        }

        // Get 4 most recent bookmarks
        $placesBookmarks = $this->getBookmarksWithDetails ( 4 );

        return view ( 'onboarding', [ 
            'active_navbar'   => 'onboarding',
            'places'          => $places,
            'placesBookmarks' => $placesBookmarks,
        ] );
    }

    /**
     * Recommendations page for categories.
     */
    public function recommendations_index ()
    {
        $categories = [ 
            'Surfing'        => 'Surf Spot in Indonesia',
            'Trekking'       => 'Hiking and Trekking Spot in Indonesia',
            'Multi Activity' => 'Adventure Park Tourist Attraction in Indonesia',
            'Outbond'        => 'Outbond Recreation Area in Indonesia',
        ];

        $allPlaces = [];
        foreach ( $categories as $category => $query )
        {
            $response = $this->fetchPlaces ( $query, 4 );
            if ( $response->successful () )
            {
                $placesData             = $response->json ()[ 'places' ] ?? [];
                $processedPlaces        = $this->processPlaces ( $placesData, 1024 );
                $allPlaces[ $category ] = $processedPlaces;
            }
        }

        return view ( 'recommendations', [ 
            'categories'    => $allPlaces,
            'active_navbar' => 'recommendations',
        ] );
    }

    /**
     * Bookmarks page.
     */
    public function bookmarks_index ()
    {
        $active_navbar   = 'bookmarks';
        $placesBookmarks = [];

        if ( Auth::check () )
        {
            $bookmarksV2 = Auth::user ()->bookmarksV2 ()->orderBy ( 'updated_at', 'desc' )->get ();

            foreach ( $bookmarksV2 as $bookmark )
            {
                $response = $this->configureHttpClient ( 'displayName,rating,formattedAddress,photos,userRatingCount' )
                    ->get ( "{$this->baseUrl}/places/{$bookmark->place_id}" );

                if ( $response->successful () )
                {
                    $placeDetails = $response->json ();
                    $photoUrl     = isset ( $placeDetails[ 'photos' ][ 0 ][ 'name' ] )
                        ? "{$this->baseUrl}/{$placeDetails[ 'photos' ][ 0 ][ 'name' ]}/media?key={$this->apiKey}&maxWidthPx=700"
                        : null;

                    $placesBookmarks[] = [ 
                        'id'           => $bookmark->id,
                        'place_id'     => $bookmark->place_id,
                        'name'         => $placeDetails[ 'displayName' ][ 'text' ] ?? 'Unknown',
                        'address'      => $placeDetails[ 'formattedAddress' ] ?? 'No address',
                        'rating'       => $placeDetails[ 'rating' ] ?? 0,
                        'review_count' => $placeDetails[ 'userRatingCount' ] ?? 0,
                        'photo_url'    => $photoUrl,
                        'type'         => 'google_place',
                    ];
                }
            }
        }

        return view ( 'bookmarks', [ 
            'active_navbar'   => $active_navbar,
            'placesBookmarks' => $placesBookmarks,
        ] );
    }

    /**
     * Search functionality.
     */
    public function search ( Request $request )
    {
        $query = trim ( $request->get ( 'query' ) );

        if ( empty ( $query ) )
        {
            return $request->ajax ()
                ? response ()->json ( [ 'html' => view ( 'components.search-default-message' )->render () ] )
                : redirect ()->back ();
        }

        $response = $this->fetchPlaces ( "{$query} in Indonesia", 4 );

        if ( $response->successful () )
        {
            $places    = $response->json ()[ 'places' ] ?? [];
            $placeData = $this->processPlaces ( $places, 1024 );

            if ( $request->ajax () )
            {
                return response ()->json ( [ 
                    'data' => $placeData,
                    'html' => view ( 'components.search-results', [ 'places' => $placeData ] )->render (),
                ] );
            }
        }

        return redirect ()->back ();
    }
}
