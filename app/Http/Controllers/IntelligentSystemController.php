<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class IntelligentSystemController extends Controller
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
    private function configureHttpClient ()
    {
        $httpClient = Http::withHeaders ( [ 
            'X-Goog-Api-Key' => $this->apiKey,
        ] );

        if ( ! empty ( $this->proxy ) && $this->enableProxy )
        {
            $httpClient = $httpClient->withOptions ( [ 'proxy' => $this->proxy ] );
        }

        return $httpClient;
    }

    /**
     * Fetch place details from the Google Places API.
     */
    private function fetchPlaceDetails ( $placeId )
    {
        $url        = "{$this->baseUrl}/places/{$placeId}";
        $httpClient = $this->configureHttpClient ()->withHeaders ( [ 
            'X-Goog-FieldMask' => 'displayName,rating,formattedAddress,photos,editorialSummary,userRatingCount,reviews.rating,reviews.text,reviews.authorAttribution,googleMapsUri',
        ] );

        return $httpClient->get ( $url );
    }

    /**
     * Process photos for place details.
     */
    private function processPhotos ( $photos )
    {
        $processedPhotos = [];
        foreach ( $photos as $photo )
        {
            $photoReference = $photo[ 'name' ] ?? null;
            if ( $photoReference )
            {
                $processedPhotos[] = "{$this->baseUrl}/{$photoReference}/media?key={$this->apiKey}&maxWidthPx=1024";
            }
        }
        return $processedPhotos;
    }

    /**
     * Fetch search results from the Google Places API.
     */
    private function fetchSearchResults ( $query )
    {
        $url        = "{$this->baseUrl}/places:searchText";
        $httpClient = $this->configureHttpClient ()->withHeaders ( [ 
            'X-Goog-FieldMask' => 'places.displayName,places.id,places.photos,places.formattedAddress,places.rating',
        ] );

        return $httpClient->post ( $url, [ 'textQuery' => $query ] );
    }

    /**
     * Process search results.
     */
    private function processSearchResults ( $places )
    {
        $placeData = [];
        foreach ( $places as $place )
        {
            $photoReference = $place[ 'photos' ][ 0 ][ 'name' ] ?? null;
            $placeData[]    = [ 
                'id'        => $place[ 'id' ] ?? null,
                'name'      => $place[ 'displayName' ][ 'text' ] ?? 'Unknown',
                'address'   => $place[ 'formattedAddress' ] ?? 'No address available',
                'photo_url' => $photoReference
                    ? "{$this->baseUrl}/{$photoReference}/media?key={$this->apiKey}&maxWidthPx=700"
                    : null,
                'rating'    => $place[ 'rating' ] ?? 0, // Add rating to the place data
            ];
        }

        return $placeData;
    }

    /**
     * Display place details.
     */
    public function showPlaceDetail ( $placeId )
    {
        $response = $this->fetchPlaceDetails ( $placeId );

        if ( $response->successful () )
        {
            $placeDetails = $response->json ();
            $photos       = isset ( $placeDetails[ 'photos' ] ) ? $this->processPhotos ( $placeDetails[ 'photos' ] ) : [];

            $place = (object) [ 
                'id'           => $placeId,
                'name'         => $placeDetails[ 'displayName' ][ 'text' ] ?? 'Unknown',
                'rating'       => $placeDetails[ 'rating' ] ?? 0,
                'review_count' => $placeDetails[ 'userRatingCount' ] ?? 0,
                'address'      => $placeDetails[ 'formattedAddress' ] ?? 'No address available',
                'reviews'      => $placeDetails[ 'reviews' ] ?? [],
                'photos'       => $photos,
                'maps_link'    => $placeDetails[ 'googleMapsUri' ] ?? '',
            ];

            // Sort reviews by rating in descending order
            usort ( $place->reviews, function ($a, $b)
            {
                return $b[ 'rating' ] <=> $a[ 'rating' ];
            } );

            $isBookmarked = false;
            $bookmarkId   = null;

            if ( Auth::check () )
            {
                $bookmark     = Auth::user ()->bookmarksV2 ()->where ( 'place_id', $placeId )->first ();
                $isBookmarked = ! is_null ( $bookmark );
                $bookmarkId   = $bookmark ? $bookmark->id : null;
            }

            return view ( 'place-detail_v2', [ 
                'active_navbar' => 'recommendations',
                'place'         => $place,
                'isBookmarked'  => $isBookmarked,
                'bookmarkId'    => $bookmarkId,
            ] );
        }
        else
        {
            return response ()->json ( [ 
                'error'   => 'Failed to fetch place details',
                'message' => $response->body (),
            ], $response->status () );
        }
    }

    /**
     * Generic method to display search results.
     */
    private function displaySearchResults ( $query, $subtitle )
    {
        $response = $this->fetchSearchResults ( $query );

        if ( $response->successful () )
        {
            $places    = $response->json ()[ 'places' ] ?? [];
            $placeData = $this->processSearchResults ( $places );

            // Sort places by rating in descending order, handling null ratings
            usort ( $placeData, function ($a, $b)
            {
                $ratingA = $a[ 'rating' ] ?? 0;
                $ratingB = $b[ 'rating' ] ?? 0;
                return $ratingB <=> $ratingA;
            } );

            return view ( 'recommendations_v2', [ 
                'active_navbar' => 'recommendations',
                'subtitle'      => $subtitle,
                'places'        => $placeData,
            ] );
        }
        else
        {
            return response ()->json ( [ 
                'error'   => 'Failed to fetch data from Google Places API',
                'message' => $response->body (),
            ], $response->status () );
        }
    }

    public function surfing_index ( Request $request )
    {
        return $this->displaySearchResults ( 'Surf Spot in Indonesia', 'Surfing' );
    }

    public function trekking_index ( Request $request )
    {
        return $this->displaySearchResults ( 'Hiking and Trekking Spot in Indonesia', 'Trekking' );
    }

    public function multiactivity_index ( Request $request )
    {
        return $this->displaySearchResults ( 'Adventure Park Tourist Attraction in Indonesia', 'Multi-Activity' );
    }

    public function outbond_index ( Request $request )
    {
        return $this->displaySearchResults ( 'Outbond Recreation Area in Indonesia', 'Outbond' );
    }

    public function showBorobudurDetail ()
    {
        $borobudurPlaceId = 'ChIJl9anCfCMei4Ry8NNdDRD0w0'; // Example Place ID for Borobudur Temple
        return $this->showPlaceDetail ( $borobudurPlaceId );
    }

    public function showBorobudurAttractions ()
    {
        return $this->displaySearchResults ( 'Tourist Attractions in Borobudur', 'Borobudur Attractions' );
    }

    public function showPandawaAttractions ()
    {
        return $this->displaySearchResults ( 'Tourist Attractions near Pandawa', 'Attractions Around Pandawa' );
    }

    public function showTebingKeratonAttractions ()
    {
        return $this->displaySearchResults ( 'Tourist Attractions near Tebing Keraton Bandung', 'Attractions Around Tebing Keraton' );
    }

    public function showMonasAttractions ()
    {
        return $this->displaySearchResults ( 'Tourist Attractions near Monas Jakarta', 'Attractions Around Monas' );
    }
}
