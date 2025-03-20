<?php

namespace Database\Seeders;

use App\Models\Website;
use Illuminate\Database\Seeder;

class WebsiteSeeder extends Seeder
{
    public function run(): void
    {
        $websites = [
            ['name' => 'Ádám-Radics-Radics', 'url' => 'https://akademia.suli.hu/12D2025/Szamitastechnikai-alapok-AdamRadicsRadics-main'],
            ['name' => 'Bodó-Tóth-Csonka', 'url' => 'https://akademia.suli.hu/12D2025/Szamitastechnikai-alapok-BodoTothCsonka-main'],
            ['name' => 'Borsos-Rohn-Nagy', 'url' => 'https://akademia.suli.hu/12D2025/Szamitastechnikai-alapok-BorsosRohnNagy-main'],
            ['name' => 'Cservenka-Kiss-Kováts', 'url' => 'https://akademia.suli.hu/12D2025/Szamitastechnikai-alapok-CservenkaKissKovats-main'],
            ['name' => 'Csizmadia-Téveli-Berze', 'url' => 'https://akademia.suli.hu/12D2025/Szamitastechnikai-alapok-CsizmadiaTeveliBerze-main'],
            ['name' => 'Dzal-Perák', 'url' => 'http://codega.me/dkquiz/'],
            ['name' => 'Gácsi-Huber-Pintér', 'url' => 'https://akademia.suli.hu/12D2025/Szamitastechnikai-alapok-GacsiHuberPinter-main'],
            ['name' => 'Titokzatos rackhostos', 'url' => 'http://h111-9.rackhostvps.com/home'],
            ['name' => 'Koszednár-Horváth-Ósbáth', 'url' => 'https://akademia.suli.hu/12D2025/Szamitastechnikai-alapok-KoszednarHorvathOsbath-main'],
            ['name' => 'Kovács-Szell', 'url' => 'https://akademia.suli.hu/12D2025/Szamitastechnikai-alapok-KovacsSzell-main'],
            ['name' => 'Nagy-Gayer-Kovács', 'url' => 'https://akademia.suli.hu/12D2025/Szamitastechnikai-alapok-NagyGayerKovacs-main'],
            ['name' => 'Somogyi-Nyitrai-Süle', 'url' => 'https://akademia.suli.hu/12D2025/Szamitastechnikai-alapok-SomogyiNyitraiSule-main'],
        ];

        foreach ($websites as $website) {
            Website::create($website);
        }
    }
}
