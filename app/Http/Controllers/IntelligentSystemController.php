<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

class IntelligentSystemController extends Controller
{
    public function showPlaceDetail ( $placeId )
    {
        $apiKey     = env ( 'GOOGLE_PLACES_API_KEY' );
        $proxy      = env ( 'SOCKS5_PROXY', '' );
        $url        = "https://places.googleapis.com/v1/places/$placeId";
        $maxWidthPx = 1024;

        // Configure the HTTP client
        $httpClient = Http::withHeaders ( [ 
            'X-Goog-Api-Key'   => $apiKey,
            'X-Goog-FieldMask' => 'displayName,rating,formattedAddress,photos,editorialSummary,userRatingCount,reviews.rating,reviews.text,reviews.authorAttribution'
        ] );

        if ( ! empty ( $proxy ) )
        {
            $httpClient = $httpClient->withOptions ( [ 'proxy' => $proxy ] );
        }

        // Make the request
        $response = $httpClient->get ( $url );

        if ( $response->successful () )
        {
            $placeDetails = $response->json ();

            // Process photos
            $photos = [];
            if ( isset ( $placeDetails[ 'photos' ] ) )
            {
                foreach ( $placeDetails[ 'photos' ] as $photo )
                {
                    $photoReference = $photo[ 'name' ] ?? null;
                    $photoUrl       = $photoReference
                        ? "https://places.googleapis.com/v1/{$photoReference}/media?key=$apiKey&maxWidthPx=$maxWidthPx"
                        : null;
                    if ( $photoUrl )
                    {
                        $photos[] = $photoUrl;
                    }
                }
            }

            // Create a structured object to pass to the view
            $place = (object) [ 
                'id'           => $placeId,
                'name'         => $placeDetails[ 'displayName' ][ 'text' ] ?? 'Unknown',
                'rating'       => $placeDetails[ 'rating' ] ?? 0,
                'review_count' => $placeDetails[ 'userRatingCount' ] ?? 0,
                'address'      => $placeDetails[ 'formattedAddress' ] ?? 'No address available',
                'reviews'      => $placeDetails[ 'reviews' ] ?? [],
                'photos'       => $photos,
            ];

            $active_navbar = 'recommendations';

            $isBookmarked = false;
            $bookmarkId = null;
            
            if (Auth::check()) {
                $bookmark = Auth::user()->bookmarksV2()->where('place_id', $placeId)->first();
                $isBookmarked = !is_null($bookmark);
                $bookmarkId = $bookmark ? $bookmark->id : null;
            }

            return view ( 'place-detail_v2', [ 
                'active_navbar' => $active_navbar,
                'place'         => $place,
                'isBookmarked' => $isBookmarked,
                'bookmarkId' => $bookmarkId
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

    public function surfing_index ( Request $request )
    {
        $apiKey = env ( 'GOOGLE_PLACES_API_KEY' );  // API key
        $proxy  = env ( 'SOCKS5_PROXY', '' ); // Proxy (optional)
        $url    = 'https://places.googleapis.com/v1/places:searchText';

        // Define the request body
        $body = [ 
            'textQuery' => 'Surf Spot in Indonesia',
        ];

        // Configure the HTTP client
        $httpClient = Http::withHeaders ( [ 
            'X-Goog-Api-Key'   => $apiKey,
            'X-Goog-FieldMask' => 'places.displayName,places.id,places.photos,places.formattedAddress',
        ] );

        if ( ! empty ( $proxy ) )
        {
            $httpClient = $httpClient->withOptions ( [ 'proxy' => $proxy ] );
        }

        // Make the request
        $response = $httpClient->post ( $url, $body );

        if ( $response->successful () )
        {
            $places = $response->json ()[ 'places' ] ?? [];

            // Extract name, address, and the first photo reference for each place
            $placeData = [];
            foreach ( $places as $place )
            {
                $name           = $place[ 'displayName' ][ 'text' ] ?? 'Unknown';
                $address        = $place[ 'formattedAddress' ] ?? 'No address available';
                $photoReference = isset ( $place[ 'photos' ][ 0 ][ 'name' ] ) ? $place[ 'photos' ][ 0 ][ 'name' ] : null;
                $maxWidthPx     = 700;
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

            $active_navbar = 'recommendations';
            $subtitle      = "Surfing";

            return view (
                'recommendations_v2',
                [ 
                    'active_navbar' => $active_navbar,
                    'subtitle'      => $subtitle,
                    'places'        => $placeData
                ]
            );
        }
        else
        {
            return response ()->json ( [ 
                'error'   => 'Failed to fetch data from Google Places API',
                'message' => $response->body (),
            ], $response->status () );
        }
    }

    public function trekking_index ( Request $request )
    {
        $apiKey = env ( 'GOOGLE_PLACES_API_KEY' );
        $proxy  = env ( 'SOCKS5_PROXY', '' );
        $url    = 'https://places.googleapis.com/v1/places:searchText';

        $body = [ 
            'textQuery' => 'Hiking and Trekking Spot in Indonesia',
        ];

        $httpClient = Http::withHeaders ( [ 
            'X-Goog-Api-Key'   => $apiKey,
            'X-Goog-FieldMask' => 'places.displayName,places.id,places.photos,places.formattedAddress',
        ] );

        if ( ! empty ( $proxy ) )
        {
            $httpClient = $httpClient->withOptions ( [ 'proxy' => $proxy ] );
        }

        $response = $httpClient->post ( $url, $body );

        if ( $response->successful () )
        {
            $places = $response->json ()[ 'places' ] ?? [];

            $placeData = [];
            foreach ( $places as $place )
            {
                $name           = $place[ 'displayName' ][ 'text' ] ?? 'Unknown';
                $address        = $place[ 'formattedAddress' ] ?? 'No address available';
                $photoReference = isset ( $place[ 'photos' ][ 0 ][ 'name' ] ) ? $place[ 'photos' ][ 0 ][ 'name' ] : null;
                $maxWidthPx     = 700;
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

            $active_navbar = 'recommendations';
            $subtitle      = "Trekking";

            return view (
                'recommendations_v2',
                [ 
                    'active_navbar' => $active_navbar,
                    'subtitle'      => $subtitle,
                    'places'        => $placeData
                ]
            );
        }
        else
        {
            return response ()->json ( [ 
                'error'   => 'Failed to fetch data from Google Places API',
                'message' => $response->body (),
            ], $response->status () );
        }
    }

    public function multiactivity_index ( Request $request )
    {
        $apiKey = env ( 'GOOGLE_PLACES_API_KEY' );
        $proxy  = env ( 'SOCKS5_PROXY', '' );
        $url    = 'https://places.googleapis.com/v1/places:searchText';

        $body = [ 
            'textQuery' => 'Adventure Park Tourist Attraction in Indonesia',  // Modified query for better results
        ];

        // ...existing HTTP client setup and response handling code...
        $httpClient = Http::withHeaders ( [ 
            'X-Goog-Api-Key'   => $apiKey,
            'X-Goog-FieldMask' => 'places.displayName,places.id,places.photos,places.formattedAddress',
        ] );

        if ( ! empty ( $proxy ) )
        {
            $httpClient = $httpClient->withOptions ( [ 'proxy' => $proxy ] );
        }

        $response = $httpClient->post ( $url, $body );

        if ( $response->successful () )
        {
            $places = $response->json ()[ 'places' ] ?? [];

            $placeData = [];
            foreach ( $places as $place )
            {
                $name           = $place[ 'displayName' ][ 'text' ] ?? 'Unknown';
                $address        = $place[ 'formattedAddress' ] ?? 'No address available';
                $photoReference = isset ( $place[ 'photos' ][ 0 ][ 'name' ] ) ? $place[ 'photos' ][ 0 ][ 'name' ] : null;
                $maxWidthPx     = 700;
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

            $active_navbar = 'recommendations';
            $subtitle      = "Multi-Activity";

            return view (
                'recommendations_v2',
                [ 
                    'active_navbar' => $active_navbar,
                    'subtitle'      => $subtitle,
                    'places'        => $placeData
                ]
            );
        }
        else
        {
            return response ()->json ( [ 
                'error'   => 'Failed to fetch data from Google Places API',
                'message' => $response->body (),
            ], $response->status () );
        }
    }

    public function outbond_index ( Request $request )
    {
        $apiKey = env ( 'GOOGLE_PLACES_API_KEY' );
        $proxy  = env ( 'SOCKS5_PROXY', '' );
        $url    = 'https://places.googleapis.com/v1/places:searchText';

        $body = [ 
            'textQuery' => 'Outbond Recreation Area in Indonesia',
        ];

        // ...existing HTTP client setup and response handling code...
        $httpClient = Http::withHeaders ( [ 
            'X-Goog-Api-Key'   => $apiKey,
            'X-Goog-FieldMask' => 'places.displayName,places.id,places.photos,places.formattedAddress',
        ] );

        if ( ! empty ( $proxy ) )
        {
            $httpClient = $httpClient->withOptions ( [ 'proxy' => $proxy ] );
        }

        $response = $httpClient->post ( $url, $body );

        if ( $response->successful () )
        {
            $places = $response->json ()[ 'places' ] ?? [];

            $placeData = [];
            foreach ( $places as $place )
            {
                $name           = $place[ 'displayName' ][ 'text' ] ?? 'Unknown';
                $address        = $place[ 'formattedAddress' ] ?? 'No address available';
                $photoReference = isset ( $place[ 'photos' ][ 0 ][ 'name' ] ) ? $place[ 'photos' ][ 0 ][ 'name' ] : null;
                $maxWidthPx     = 700;
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

            $active_navbar = 'recommendations';
            $subtitle      = "Outbond";

            return view (
                'recommendations_v2',
                [ 
                    'active_navbar' => $active_navbar,
                    'subtitle'      => $subtitle,
                    'places'        => $placeData
                ]
            );
        }
        else
        {
            return response ()->json ( [ 
                'error'   => 'Failed to fetch data from Google Places API',
                'message' => $response->body (),
            ], $response->status () );
        }
    }
}
