<?php

namespace Database\Seeders;

use App\Models\Cemeteries;
use Illuminate\Database\Seeder;

class CemeterySeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Cemeteries::create([
            'name' => 'Hakkenberg Uitvaartzorg BV',
            'municipality_id' => 1,
            'grave_types' => 'particulier graf, algemeen graf',
            'grave_sorts' => 'enkel graf,urnengraf,familie graf,kinder graf',
            'city' => 'Zwolle',
            'address' => 'Straat 1',
            'zip_code' => '8000AA',
            'image_hash_url' => 'cemetery.jpg',
        ]);

        Cemeteries::create([
            'name' => 'Begraafplaats Kranenburg',
            'municipality_id' => 1,
            'grave_types' => 'particulier graf, algemeen graf',
            'grave_sorts' => 'enkel graf,urnengraf,familie graf,kinder graf',
            'city' => 'Zwolle',
            'address' => 'Straat 2',
            'zip_code' => '8001BB',
            'image_hash_url' => 'cemetery.jpg',
        ]);

        Cemeteries::create([
            'name' => 'Begraafplaats Essenhof',
            'municipality_id' => 2,
            'grave_types' => 'particulier graf, algemeen graf',
            'grave_sorts' => 'enkel graf,urnengraf,familie graf,kinder graf',
            'city' => 'Kampen',
            'address' => 'Straat 3',
            'zip_code' => '8300CC',
            'image_hash_url' => 'cemetery.jpg',
        ]);

        Cemeteries::create([
            'name' => 'Begraafplaats Rusthof',
            'municipality_id' => 2,
            'grave_types' => 'particulier graf, algemeen graf',
            'grave_sorts' => 'enkel graf,urnengraf,familie graf,kinder graf',
            'city' => 'Kampen',
            'address' => 'Straat 4',
            'zip_code' => '8301DD',
            'image_hash_url' => 'cemetery.jpg',
        ]);

        Cemeteries::create([
            'name' => 'Begraafplaats De Hoek',
            'municipality_id' => 3,
            'grave_types' => 'particulier graf, algemeen graf',
            'grave_sorts' => 'enkel graf,urnengraf,familie graf,kinder graf',
            'city' => 'Utrecht',
            'address' => 'Straat 5',
            'zip_code' => '3500EE',
            'image_hash_url' => 'cemetery.jpg',
        ]);

        Cemeteries::create([
            'name' => 'Begraafplaats Vredenhof',
            'municipality_id' => 3,
            'grave_types' => 'particulier graf, algemeen graf',
            'grave_sorts' => 'enkel graf,urnengraf,familie graf,kinder graf',
            'city' => 'Utrecht',
            'address' => 'Straat 6',
            'zip_code' => '3501FF',
            'image_hash_url' => 'cemetery.jpg',
        ]);

        Cemeteries::create([
            'name' => 'Begraafplaats Zonnehof',
            'municipality_id' => 4,
            'grave_types' => 'particulier graf, algemeen graf',
            'grave_sorts' => 'enkel graf,urnengraf,familie graf,kinder graf',
            'city' => 'Deventer',
            'address' => 'Straat 7',
            'zip_code' => '7400GG',
            'image_hash_url' => 'cemetery.jpg',
        ]);

        Cemeteries::create([
            'name' => 'Begraafplaats Heidehof',
            'municipality_id' => 4,
            'grave_types' => 'particulier graf, algemeen graf',
            'grave_sorts' => 'enkel graf,urnengraf,familie graf,kinder graf',
            'city' => 'Deventer',
            'address' => 'Straat 8',
            'zip_code' => '7401HH',
            'image_hash_url' => 'cemetery.jpg',
        ]);

        Cemeteries::create([
            'name' => 'Begraafplaats Lelystad Centrum',
            'municipality_id' => 5,
            'grave_types' => 'particulier graf, algemeen graf',
            'grave_sorts' => 'enkel graf,urnengraf,familie graf,kinder graf',
            'city' => 'Lelystad',
            'address' => 'Straat 9',
            'zip_code' => '8200II',
            'image_hash_url' => 'cemetery.jpg',
        ]);

        Cemeteries::create([
            'name' => 'Begraafplaats Oostvaarders',
            'municipality_id' => 5,
            'grave_types' => 'particulier graf, algemeen graf',
            'grave_sorts' => 'enkel graf,urnengraf,familie graf,kinder graf',
            'city' => 'Lelystad',
            'address' => 'Straat 10',
            'zip_code' => '8201JJ',
            'image_hash_url' => 'cemetery.jpg',
        ]);

        Cemeteries::create([
            'name' => 'Begraafplaats Almere Haven',
            'municipality_id' => 6,
            'grave_types' => 'particulier graf, algemeen graf',
            'grave_sorts' => 'enkel graf,urnengraf,familie graf,kinder graf',
            'city' => 'Almere',
            'address' => 'Straat 11',
            'zip_code' => '1300KK',
            'image_hash_url' => 'cemetery.jpg',
        ]);

        Cemeteries::create([
            'name' => 'Begraafplaats Noorderplassen',
            'municipality_id' => 6,
            'grave_types' => 'particulier graf, algemeen graf',
            'grave_sorts' => 'enkel graf,urnengraf,familie graf,kinder graf',
            'city' => 'Almere',
            'address' => 'Straat 12',
            'zip_code' => '1301LL',
            'image_hash_url' => 'cemetery.jpg',
        ]);

        Cemeteries::create([
            'name' => 'Begraafplaats Amsterdam West',
            'municipality_id' => 7,
            'grave_types' => 'particulier graf, algemeen graf',
            'grave_sorts' => 'enkel graf,urnengraf,familie graf,kinder graf',
            'city' => 'Amsterdam',
            'address' => 'Straat 13',
            'zip_code' => '1000MM',
            'image_hash_url' => 'cemetery.jpg',
        ]);

        Cemeteries::create([
            'name' => 'Begraafplaats Amsterdam Oost',
            'municipality_id' => 7,
            'grave_types' => 'particulier graf, algemeen graf',
            'grave_sorts' => 'enkel graf,urnengraf,familie graf,kinder graf',
            'city' => 'Amsterdam',
            'address' => 'Straat 14',
            'zip_code' => '1001NN',
            'image_hash_url' => 'cemetery.jpg',
        ]);

        Cemeteries::create([
            'name' => 'Begraafplaats Rotterdam Noord',
            'municipality_id' => 8,
            'grave_types' => 'particulier graf, algemeen graf',
            'grave_sorts' => 'enkel graf,urnengraf,familie graf,kinder graf',
            'city' => 'Rotterdam',
            'address' => 'Straat 15',
            'zip_code' => '3000OO',
            'image_hash_url' => 'cemetery.jpg',
        ]);

        Cemeteries::create([
            'name' => 'Begraafplaats Rotterdam Zuid',
            'municipality_id' => 8,
            'grave_types' => 'particulier graf, algemeen graf',
            'grave_sorts' => 'enkel graf,urnengraf,familie graf,kinder graf',
            'city' => 'Rotterdam',
            'address' => 'Straat 16',
            'zip_code' => '3001PP',
            'image_hash_url' => 'cemetery.jpg',
        ]);
    }
}