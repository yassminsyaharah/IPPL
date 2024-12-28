<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Destination;

class DestinationSeeder extends Seeder
{
    public function run ()
    {
        $destinations = [ 
            [ 
                'name'              => 'Garuda Wisnu Kencana (GWK)',
                'description'       => 'A cultural park in Bali.',
                'address'           => 'Jl. Raya Uluwatu, Ungasan, Kec. Kuta Sel., Kabupaten Badung, Bali',
                'province'          => 'Bali',
                'operating_hours'   => '09:00 - 18:00',
                'image_folder_path' => 'destinations\GWK_2',
                'ratings'           => 4.4,
                'review_count'      => 15000
            ],
            [ 
                'name'              => 'Ambrogio Patisserie',
                'description'       => 'A popular patisserie in Bandung.',
                'address'           => 'Jl. Banda No.26, Citarum, Kec. Bandung Wetan, Kota Bandung',
                'province'          => 'West Java',
                'operating_hours'   => '08:00 - 22:00',
                'image_folder_path' => 'destinations\Ambrogio_2',
                'ratings'           => 4.5,
                'review_count'      => 2000
            ],
            [ 
                'name'              => 'Galeri Nasional Indonesia',
                'description'       => 'An art gallery in Jakarta.',
                'address'           => 'Jl. Medan Merdeka Tim., Gambir, Jakarta Pusat',
                'province'          => 'Jakarta',
                'operating_hours'   => '10:00 - 18:00',
                'image_folder_path' => 'destinations\GaleriNasionalIndonesia',
                'ratings'           => 4.6,
                'review_count'      => 5000
            ],
            [ 
                'name'              => 'Tones No.6',
                'description'       => 'A music-themed cafe.',
                'address'           => 'Jalan abc',
                'province'          => 'Unknown',
                'operating_hours'   => '10:00 - 22:00',
                'image_folder_path' => 'destinations\TonesNo6',
                'ratings'           => 4.2,
                'review_count'      => 89
            ],
            [ 
                'name'              => 'Tahura',
                'description'       => 'A nature reserve in Bandung.',
                'address'           => 'Jalan Dago Pakar',
                'province'          => 'West Java',
                'operating_hours'   => '06:00 - 18:00',
                'image_folder_path' => 'destinations\Tahura',
                'ratings'           => 4.6,
                'review_count'      => 200
            ]
        ];

        foreach ( $destinations as $destination )
        {
            Destination::create ( $destination );
        }
    }
}
