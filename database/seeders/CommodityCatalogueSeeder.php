<?php

namespace Database\Seeders;

use App\Models\CommodityItem;
use Illuminate\Database\Seeder;

class CommodityCatalogueSeeder extends Seeder
{
    /**
     * Transcribed verbatim from the society's paper Commodity Loan
     * Application Form (71 line items).
     */
    public function run(): void
    {
        $items = [
            ['Suphagetti', 'Golden Peny', 'Carton'],
            ['Suphagetti', 'Doga', 'Carton'],
            ['Suphagetti', 'IRS', 'Carton'],
            ['Suphagetti', 'Gonca', 'Carton'],
            ['Suphagetti', 'Crown', 'Carton'],
            ['Semovita', 'Golden Peny', 'Sachet Pack'],
            ['Semovita', 'Golden Peny', 'Bag Pack'],
            ['Knor Cubs Maggi', '14 Pieces x100', 'Carton-PC20'],
            ['Maggi Star', '20 Pieces', 'Carton'],
            ['Maggi Star', 'Pieces x100', 'Packet'],
            ['BUA Sugar', 'Bua Sugar', '50Kg Bag'],
            ['Golden Peny Sugar', 'Cubs Carton', 'Carton'],
            ['Golden Peny Sugar', 'Cubs Packet', '1 Packet'],
            ['Flour', 'IRS', '50kg Bag'],
            ['Golden Peny', 'Cous-Cous', '500gx20'],
            ['Golden Peny', 'Macarony Carton', 'x20 Piece'],
            ['Gaia Cous-Cous', 'Foriengn', 'Carton'],
            ['Kings Oil', '25 Litres', '25 Litres'],
            ['Kings Oil', '5 Litres', '5 Litres'],
            ['Kings Oil', '3 Litres', '3 Litres'],
            ['Kings Oil', '1 Litre', '1 Litre'],
            ['Red/Palm Oil', '25 Litres', '25 Litres'],
            ['Red/Palm Oil', '3 Litres', '3 Litres'],
            ['Red/Palm Oil', '1 Litre', '1 Litre'],
            ['Red/Palm Oil', '1 Bottle', 'Bottle'],
            ['Toilet Soap', 'Viva Carton', '100 Pieces'],
            ['Toilet Soap', 'Viva Carton Extra', '24 Pieces'],
            ['Toilet Soap', 'Viva Carton Plus', '24 Pieces'],
            ['Detagents Viva', 'Carton 170g', 'x26 Piece'],
            ['Detagents Viva', 'Carton 80g', 'x50 Piece'],
            ['Detagents Viva', 'Carton 22g', 'x162 Piece'],
            ['Detagents Klin', 'Carton 170g', 'x26 Piece'],
            ['Detagents Klin', 'Carton 20g', 'x150 Piece'],
            ['Maize', 'Bag 100kg (A)', 'x40 (Kwano)'],
            ['Garin Buski', 'Bag 50kg', 'x40 (Kwano)'],
            ['Garin Masara', 'Bag 50kg', 'x40 (Kwano)'],
            ['Rices', 'Gerawa Rice', '50Kg Bag'],
            ['Rices', 'BUA Rice', '50Kg Bag'],
            ['Rices', 'Pure Thailan Rice', '50Kg Bag'],
            ['Rices', 'Mama Africa Rice', '50Kg Bag'],
            ['Rices', 'Local Rice 100kg (A)', 'x40 (Kwano)'],
            ['Shinkafan Tuwu', '100kg', 'x40 (Kwano)'],
            ['Toilet/Bathing Soap', 'Siri Soap Packet', 'x6 Piece'],
            ['Toilet/Bathing Soap', 'LewarBeauty 120g', 'x4 Piece'],
            ['Toilet/Bathing Soap', 'Tetmosol Big', 'x6 Piece'],
            ['Toilet/Bathing Soap', 'Tetmosol Small', 'x6 Piece'],
            ['Toilet/Bathing Soap', 'Sure Soap Big 120g', 'x6 Piece'],
            ['Toilet/Bathing Soap', 'Sure Soap Small', 'x6 Piece'],
            ['Tea', 'Lipton Yellow', '1 Packet'],
            ['Tea', 'Top Tea', '1 Packet'],
            ['Tea', 'Top Tea', '1 Packet'],
            ['Instant Nooddles', 'Big Carton', '42 Piece'],
            ['Instant Nooddles', 'Small Carton', '42 Piece'],
            ['Whate/Alkama', 'Kwano', 'Kwano'],
            ['Accha', 'Kwano', 'Kwano'],
            ['Milo', 'Milo 800g', 'Sachet Pack'],
            ['Milo', 'Milo 400g', 'Sachet Pack'],
            ['Milo', 'Mio 20g', 'Roll - 10Pieces'],
            ['Milk', 'Peak Milk 900g', 'Sachet Pack'],
            ['Milk', 'Peak Milk 850g', 'Tin'],
            ['Milk', 'Peak Milk 400g', 'Tin'],
            ['Milk', 'Peak Milk 14g', 'Roll - 10Pieces'],
            ['Milk', 'Cow Bell Milk 350g', 'Sachet'],
            ['Milk', 'Cow Bell Milk 12g', 'Roll - 10Pieces'],
            ['Milk', 'Dano Milk 350g', 'Sachet'],
            ['Sardine Fish', 'Super Delicienge', '1 Piece'],
            ['Tomoto', 'Tomoto Nagiko Tin 2200g', '6Pieces'],
            ['Tomoto', 'Tomoto Nagiko Tin 400g', '24Piece'],
            ['Tomoto', 'Tomoto Triple', '8 Piece'],
            ['Red Beans', 'Bag 100kg', 'x40 (Kwano)'],
            ['White Beans', 'Bag 100kg', 'x40 (Kwano)'],
        ];

        foreach ($items as [$description, $typeBrand, $packUnit]) {
            CommodityItem::query()->firstOrCreate([
                'description' => $description,
                'type_brand' => $typeBrand,
                'pack_unit' => $packUnit,
            ], [
                'is_active' => true,
            ]);
        }
    }
}
