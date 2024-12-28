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
                'description'       => 'Garuda Wisnu Kencana (GWK) adalah taman budaya yang terletak di Ungasan, Kuta Selatan, Bali. Taman ini terkenal dengan patung raksasa Dewa Wisnu yang menunggangi burung Garuda, karya seniman I Nyoman Nuarta. Dengan tinggi mencapai 121 meter, patung ini menjadi salah satu yang tertinggi di dunia. 

Pembangunan patung GWK dimulai pada tahun 1997 dan memakan waktu sekitar 28 tahun hingga diresmikan pada 22 September 2018 oleh Presiden Joko Widodo. Patung ini melambangkan Dewa Wisnu sebagai pelindung alam semesta yang menunggangi Garuda, simbol dari kesetiaan dan pengabdian. Selain patung utama, kawasan GWK juga dilengkapi dengan berbagai fasilitas seperti Lotus Pond, area terbuka yang sering digunakan untuk acara budaya dan seni. 

Pengunjung dapat menikmati pemandangan indah dari ketinggian 263 meter di atas permukaan laut, menjadikan GWK sebagai salah satu destinasi wisata favorit di Bali. Selain itu, taman ini juga menawarkan berbagai pertunjukan seni dan budaya yang menggambarkan kekayaan tradisi Bali. Dengan luas mencapai 60 hektar, GWK menjadi tempat yang ideal untuk mengenal lebih dekat seni dan budaya Indonesia. ',
                'address'           => 'Jl. Raya Uluwatu, Ungasan, Kec. Kuta Sel., Kabupaten Badung, Bali',
                'province'          => 'Bali',
                'operating_hours'   => '09:00 - 18:00',
                'image_folder_path' => 'destinations\GWK_2',
                'ratings'           => 4.4,
                'review_count'      => 15000
            ],
            [ 
                'name'              => 'Ambrogio Patisserie',
                'description'       => 'Ambrogio Patisserie adalah kafe dan restoran yang berlokasi di Jalan Banda No.26, Citarum, Bandung Wetan, Kota Bandung. Tempat ini menawarkan berbagai macam pastry dan roti dengan cita rasa khas, menjadikannya destinasi populer bagi pecinta kuliner di Bandung. Dengan desain interior yang modern dan suasana yang nyaman, Ambrogio Patisserie menjadi tempat ideal untuk bersantai bersama teman atau keluarga. 

Selain aneka pastry, Ambrogio Patisserie juga menyajikan berbagai menu makanan mulai dari hidangan lokal hingga internasional. Beberapa menu andalannya antara lain Kouign Amann Milk Cheese, Honey Mustard Salad, dan Smoked Brisket Pizza. Untuk minuman, tersedia berbagai pilihan kopi, teh, dan jus segar yang dapat dinikmati sepanjang hari. 

Kafe ini buka setiap hari mulai pukul 08.00 hingga 22.00 WIB, memberikan fleksibilitas waktu bagi pengunjung untuk menikmati suasana dan hidangan yang ditawarkan. Dengan lokasi yang strategis di pusat kota Bandung, Ambrogio Patisserie mudah dijangkau dan sering menjadi pilihan utama bagi mereka yang mencari pengalaman kuliner yang berkesan. ',
                'address'           => 'Jl. Banda No.26, Citarum, Kec. Bandung Wetan, Kota Bandung',
                'province'          => 'West Java',
                'operating_hours'   => '08:00 - 22:00',
                'image_folder_path' => 'destinations\Ambrogio_2',
                'ratings'           => 4.5,
                'review_count'      => 2000
            ],
            [ 
                'name'              => 'Galeri Nasional Indonesia',
                'description'       => 'Galeri Nasional Indonesia adalah institusi seni yang terletak di Jalan Medan Merdeka Timur, Gambir, Jakarta Pusat. Galeri ini berfungsi sebagai pusat pameran dan edukasi seni rupa, menampilkan karya-karya seniman Indonesia dan internasional. Dengan koleksi yang beragam, galeri ini menjadi destinasi penting bagi pecinta seni dan budaya.

Selain ruang pameran permanen, Galeri Nasional juga rutin mengadakan pameran temporer, workshop, dan diskusi yang bertujuan untuk mengembangkan apresiasi seni di kalangan masyarakat. Fasilitas modern dan suasana yang inspiratif menjadikan galeri ini sebagai tempat yang nyaman untuk mengeksplorasi dunia seni rupa.

Galeri Nasional Indonesia buka setiap hari kecuali hari libur nasional, dengan jam operasional mulai pukul 10.00 hingga 18.00 WIB. Masuk ke galeri ini tidak dipungut biaya, sehingga dapat diakses oleh semua kalangan. Lokasinya yang strategis di pusat kota Jakarta memudahkan pengunjung untuk datang dan menikmati berbagai karya seni yang dipamerkan.',
                'address'           => 'Jl. Medan Merdeka Tim., Gambir, Jakarta Pusat',
                'province'          => 'Jakarta',
                'operating_hours'   => '10:00 - 18:00',
                'image_folder_path' => 'destinations\GaleriNasionalIndonesia',
                'ratings'           => 4.6,
                'review_count'      => 5000
            ],
            [ 
                'name'              => 'Tones No.6',
                'description'       => 'Tones No.6 adalah kafe dengan tema musik yang unik, menawarkan suasana yang cozy dan dekorasi yang menarik bagi para pengunjung. Kafe ini menjadi tempat favorit bagi pecinta musik yang ingin menikmati hidangan sambil mendengarkan alunan lagu. Dengan interior yang didesain khusus, Tones No.6 menciptakan pengalaman bersantap yang berbeda dari kafe lainnya.

Menu yang ditawarkan di Tones No.6 beragam, mulai dari makanan ringan hingga hidangan utama, serta berbagai pilihan minuman seperti kopi, teh, dan mocktail. Selain itu, kafe ini sering mengadakan live music performance yang menambah semarak suasana, menjadikannya tempat yang ideal untuk berkumpul bersama teman atau keluarga.

Berlokasi di alamat yang strategis, Tones No.6 mudah diakses oleh pengunjung. Kafe ini buka setiap hari dari pukul 10.00 hingga 22.00 WIB, memberikan fleksibilitas waktu bagi siapa saja yang ingin menikmati suasana dan hiburan yang ditawarkan. Dengan konsep yang unik dan pelayanan yang ramah, Tones No.6 menjadi salah satu destinasi kafe yang patut dikunjungi.',
                'address'           => 'Jl. Terusan Cisokan No.6, Cihaur Geulis, Kec. Cibeunying Kaler, Kota Bandung, Jawa Barat 40122
',
                'province'          => 'Jawa Barat',
                'operating_hours'   => '10:00 - 22:00',
                'image_folder_path' => 'destinations\TonesNo6',
                'ratings'           => 4.2,
                'review_count'      => 89
            ],
            [ 
                'name'              => 'Tahura',
                'description'       => 'Tahura atau Taman Hutan Raya adalah kawasan konservasi alam yang berlokasi di Dago Pakar, Bandung. Tempat ini dikenal sebagai salah satu destinasi wisata alam yang menawarkan keindahan hutan yang asri, udara segar, dan pemandangan yang menenangkan. Sebagai kawasan hijau terbesar di Bandung, Tahura juga berfungsi sebagai paru-paru kota, memberikan kontribusi penting bagi lingkungan dan ekosistem di sekitarnya.

Di Tahura, pengunjung dapat menikmati berbagai aktivitas luar ruangan seperti hiking, bersepeda, atau hanya berjalan-jalan menikmati suasana hutan. Tersedia jalur trekking yang sudah tertata dengan baik, memudahkan pengunjung menjelajahi keindahan alam sembari menikmati suara burung dan gemerisik dedaunan. Selain itu, terdapat banyak spot menarik seperti Goa Jepang dan Goa Belanda yang memiliki nilai sejarah.

Tempat ini juga menjadi habitat bagi berbagai flora dan fauna yang dilindungi, sehingga menjadi lokasi yang cocok untuk pengamatan alam dan pendidikan lingkungan. Buka setiap hari mulai pukul 06:00 hingga 18:00 WIB, Tahura merupakan pilihan yang tepat bagi mereka yang ingin menghabiskan waktu bersama keluarga atau teman sambil menikmati keindahan alam. Dengan akses yang mudah dan fasilitas yang memadai, Tahura menjadi salah satu destinasi wajib saat berkunjung ke Bandung.',
                'address'           => 'Kompleks Tahura, Jl. Ir. H. Juanda No.99, Ciburial, Kec. Cimenyan, Kabupaten Bandung, Jawa Barat 40198',
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
