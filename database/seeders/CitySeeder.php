<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $cities = [
            'Cotonou' => [
                // Les existants + Ajouts précédents
                'Akpakpa', 'Haie Vive', 'Zongo', 'Gbedjromede', 
                'Togbin', 'Agla', 'Vêdoko', 'Cadjehoun', 
                'Saint Michel', 'Fidjrossè', 'Ganhi', 'Scoa Gbeto', 
                'Jonquet', 'Gbégamey', 'Sainte Rita', 'Kouhounou', 
                'Menontin', 'Avotrou', 'Dantokpa', 'Hindé', 
                'Suru-Léré', 'Fifadji', 'Ahouansori', 'Akogbato', 'Yagbé'
            ],

            'Porto-Novo' => [
                // Les existants + Ajouts précédents
                'Aflagbeto', 'Adjohoun', 'Avakpa', 'Tokpota', 
                'Djassin', 'Ouando', 'Kandévié', 'Dowa', 
                'Gun-Vi', 'Oganla', 'Catchi', 'Houinmè', 
                'Adjarra-Docodji', 'Louho', 'Foun-Foun', 'Anavié'
            ],

            'Abomey-Calavi' => [
                'Godomey', 'Zoundja', 'Hêvié', 'Akassato', 
                'Zinvié', 'Glo-Djigbé', 'Kpanroun', 'Ouèdo', 
                'Togba', 'Womey', 'Tankpè', 'Maria-Gléta', 
                'Cococodji', 'Tokan', 'Aïtchédji', 'Arconville', 'Parana'
            ],

            'Parakou' => [
                'Madina', 'Banikanni', 'Guema', 'Albarika', 
                'Titirou', 'Zongo (Parakou)', 'Arafat', 'Gah', 
                'Okedama', 'Camp Adagbè', 'Nima', 'Wansirou', 
                'Amawignon', 'Ladji-Farani', 'Baka', 'Kpébié'
            ],
                        
            'Bohicon' => [
                'Sokponta', 'Passagon', 'Ouassaho', 'Lissazoun', 
                'Agonli', 'Houngon', 'Zoungoudo', 'Djidja', 'Zakpo'
            ],
            
            'Abomey' => [
                'Djogbé', 'Agongointo', 'Vidolé', 'Sèhoun', 'Sèvè', 
                'Tankessin', 'Hounli', 'Kponou'
            ],
            
            'Ouidah' => [
                'Djekan', 'Adjido', 'Zomaï', 'Avléketé', 'Togbadji', 
                'Pédah', 'Togbin-Adjidogon', 'Dangbo'
            ],

            'Natitingou' => [
                'Natitingou-ville', 'Tanta', 'Dassari', 'Kouandata', 
                'Winyérou', 'Sokotindé', 'Boriyouré'
            ],
            
            'Djougou' => [
                'Pélima', 'Zongo (Djougou)', 'Brougou', 'Baparapé', 
                'Bara-Tem', 'Pabégou', 'Taïfa'
            ],
            
            'Kandi' => [
                'Kandi-ville', 'Kassakou', 'Angaradébou', 'Guésou-sud', 
                'Saka', 'Gando'
            ]
        ];

        foreach ($cities as $name => $quarters) {
            $city = City::firstOrCreate(['name' => $name]);
            foreach ($quarters as $q) {
                $city->quarters()->firstOrCreate(['name' => $q]);
            }
        }
    }
}
