<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supply;

class SuppliesSeeder extends Seeder
{
    public function run(): void
    {
        $supplies = [
            [
                'name' => 'Popeline', 
                'sale_mode' => 'measure', 
                'unit' => 'm', 
                'image_url' => '/images/supplies/popeline.jpg',
                'description' => 'Popeline disponible en différentes couleurs'
            ],
            [
                'name' => 'Satin', 
                'sale_mode' => 'measure', 
                'unit' => 'm', 
                'image_url' => '/images/supplies/satin_bleu.jpeg',
                'description' => 'Satin disponible en différentes couleurs'
            ],
            [
                'name' => 'Mousseline', 
                'sale_mode' => 'measure', 
                'unit' => 'm', 
                'image_url' => '/images/supplies/mousseline_white.jpg',
                'description' => 'Mousseline disponible en différentes couleurs'
            ],
            [
                'name' => 'Fleurs', 
                'sale_mode' => 'quantity', 
                'unit' => 'unité', 
                'image_url' => '/images/supplies/fleur.jpg',
                'description' => 'Fleurs décoratives en fonction de la quantité'
            ],
            [
                'name' => 'Fil de couture', 
                'sale_mode' => 'quantity', 
                'unit' => 'bobine', 
                'image_url' => '/images/supplies/fil.jpeg',
                'description' => 'Fil de couture disponible en petit, moyen et grand'
            ],
            [
                'name' => 'Broderie', 
                'sale_mode' => 'quantity', 
                'unit' => 'unité', 
                'image_url' => '/images/supplies/broderie.jpg',
                'description' => 'Broderie décorative'
            ],
            [
                'name' => 'Fermeture', 
                'sale_mode' => 'quantity', 
                'unit' => 'unité', 
                'image_url' => '/images/supplies/fermeture.jpg',
                'description' => 'Fermeture disponible en différentes longueurs'
            ],
            [
                'name' => 'Guipure tissu', 
                'sale_mode' => 'measure', 
                'unit' => 'm', 
                'image_url' => '/images/supplies/guipure_tissus.jpg',
                'description' => 'Guipure en tissu'
            ],
            [
                'name' => 'Guipure dentelle', 
                'sale_mode' => 'measure', 
                'unit' => 'm', 
                'image_url' => '/images/supplies/guipure_dentelle.jpg',
                'description' => 'Guipure en dentelle'
            ],
            [
                'name' => 'Scotch', 
                'sale_mode' => 'measure', 
                'unit' => 'm', 
                'image_url' => '/images/supplies/scotch.jpg',
                'description' => 'Scotch disponible en blanc et noir'
            ],
            [
                'name' => 'Cigarette', 
                'sale_mode' => 'measure', 
                'unit' => 'm', 
                'image_url' => '/images/supplies/cigarette.jpg',
                'description' => 'Cigarette unique couleur blanc, disponible en moux et dure'
            ],
            [
                'name' => 'Enjoliveurs', 
                'sale_mode' => 'measure', 
                'unit' => 'm', 
                'image_url' => '/images/supplies/enjoliveur.jpg',
                'description' => 'Enjoliveurs disponibles en différentes couleurs'
            ],
            [
                'name' => 'Fillet', 
                'sale_mode' => 'measure', 
                'unit' => 'm', 
                'image_url' => '/images/supplies/fillet.jpg',
                'description' => 'Fillet décoratif'
            ],
            [
                'name' => 'Anneaux', 
                'sale_mode' => 'quantity', 
                'unit' => 'unité', 
                'image_url' => '/images/supplies/anneaux.jpg',
                'description' => 'Anneaux disponibles en argent et or, fonction du numéro'
            ],
            [
                'name' => 'Pierres fillets', 
                'sale_mode' => 'measure', 
                'unit' => 'm', 
                'image_url' => '/images/supplies/pierre_fillet.jpg',
                'description' => 'Pierres fillets disponibles en différentes couleurs'
            ],
            [
                'name' => 'Duchesse', 
                'sale_mode' => 'measure', 
                'unit' => 'm', 
                'image_url' => '/images/supplies/duchesse.jpg',
                'description' => 'Tissu duchesse'
            ],
            [
                'name' => 'Crin', 
                'sale_mode' => 'measure', 
                'unit' => 'm', 
                'image_url' => '/images/supplies/crin.jpg',
                'description' => 'Crin pour renfort'
            ],
            [
                'name' => 'Baleine', 
                'sale_mode' => 'measure', 
                'unit' => 'm', 
                'image_url' => '/images/supplies/baleine.jpg',
                'description' => 'Baleine pour corsets et structures'
            ],
            [
                'name' => 'Bouton doré', 
                'sale_mode' => 'quantity', 
                'unit' => 'unité', 
                'image_url' => '/images/supplies/bouton_dore.jpg',
                'description' => 'Boutons dorés'
            ],
            [
                'name' => 'Aiguilles', 
                'sale_mode' => 'quantity', 
                'unit' => 'unité', 
                'image_url' => '/images/supplies/aiguilles.jpg',
                'description' => 'Aiguilles de couture'
            ],
            [
                'name' => 'Foufou', 
                'sale_mode' => 'measure', 
                'unit' => 'm', 
                'image_url' => '/images/supplies/foufou.jpg',
                'description' => 'Foufou disponible en différentes couleurs'
            ],
            [
                'name' => 'Chaîne', 
                'sale_mode' => 'measure', 
                'unit' => 'm', 
                'image_url' => '/images/supplies/chaine.jpg',
                'description' => 'Chaîne disponible en or et argent'
            ]
        ];

        foreach ($supplies as $item) {
            // Use updateOrCreate to ensure existing records get their image_url and other attributes updated
            Supply::updateOrCreate(['name' => $item['name']], $item);
        }

        $this->command->info(count($supplies).' fournitures ajoutées.');
    }
}
