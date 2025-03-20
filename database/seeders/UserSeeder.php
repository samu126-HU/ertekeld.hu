<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'Ádám Milán', 'email' => 'adam_milan@ertekeld.hu', 'password' => Hash::make('Adam_Milan123')],
            ['name' => 'Berze Kristóf', 'email' => 'berze_kristof@ertekeld.hu', 'password' => Hash::make('Berze_Kristof123')],
            ['name' => 'Bodó Levente', 'email' => 'bodo_levente@ertekeld.hu', 'password' => Hash::make('Bodo_Levente123')],
            ['name' => 'Bodó Zoltán', 'email' => 'bodo_zoltan@ertekeld.hu', 'password' => Hash::make('Bodo_Zoltan123')],
            ['name' => 'Borsos Levente', 'email' => 'borsos_levente@ertekeld.hu', 'password' => Hash::make('Borsos_Levente123')],
            ['name' => 'Cservenka Krisztián', 'email' => 'cservenka_krisztian@ertekeld.hu', 'password' => Hash::make('Cservenka_Krisztian123')],
            ['name' => 'Csizmadia Nóra', 'email' => 'csizmadia_nora@ertekeld.hu', 'password' => Hash::make('Csizmadia_Nora123')],
            ['name' => 'Csonka Patrik István', 'email' => 'csonka_patrik_istvan@ertekeld.hu', 'password' => Hash::make('Csonka_Patrik_Istvan123')],
            ['name' => 'Dzal Lara', 'email' => 'dzal_lara@ertekeld.hu', 'password' => Hash::make('Dzal_Lara123')],
            ['name' => 'Gayer Bence', 'email' => 'gayer_bence@ertekeld.hu', 'password' => Hash::make('Gayer_Bence123')],
            ['name' => 'Gothár Hanna', 'email' => 'gothar_hanna@ertekeld.hu', 'password' => Hash::make('Gothar_Hanna123')],
            ['name' => 'Gácsi Zsolt', 'email' => 'gacsi_zsolt@ertekeld.hu', 'password' => Hash::make('Gacsi_Zsolt123')],
            ['name' => 'Horváth Dorina', 'email' => 'horvath_dorina@ertekeld.hu', 'password' => Hash::make('Horvath_Dorina123')],
            ['name' => 'Huber Péter György', 'email' => 'huber_peter_gyorgy@ertekeld.hu', 'password' => Hash::make('Huber_Peter_Gyorgy123')],
            ['name' => 'Kiss Erik József', 'email' => 'kiss_erik_jozsef@ertekeld.hu', 'password' => Hash::make('Kiss_Erik_Jozsef123')],
            ['name' => 'Koszednár Dorina', 'email' => 'koszednar_dorina@ertekeld.hu', 'password' => Hash::make('Koszednar_Dorina123')],
            ['name' => 'Kovács Dominik Gábor', 'email' => 'kovacs_dominik_gabor@ertekeld.hu', 'password' => Hash::make('Kovacs_Dominik_Gabor123')],
            ['name' => 'Kovács Gergő', 'email' => 'kovacs_gergo@ertekeld.hu', 'password' => Hash::make('Kovacs_Gergo123')],
            ['name' => 'Kováts Hunor', 'email' => 'kovats_hunor@ertekeld.hu', 'password' => Hash::make('Kovats_Hunor123')],
            ['name' => 'Nagy Balázs', 'email' => 'nagy_balazs@ertekeld.hu', 'password' => Hash::make('Nagy_Balazs123')],
            ['name' => 'Nagy Bendegúz László', 'email' => 'nagy_bendeguz_laszlo@ertekeld.hu', 'password' => Hash::make('Nagy_Bendeguz_Laszlo123')],
            ['name' => 'Nyitrai László Kevin', 'email' => 'nyitrai_laszlo_kevin@ertekeld.hu', 'password' => Hash::make('Nyitrai_Laszlo_Kevin123')],
            ['name' => 'Osbáth Ádám', 'email' => 'osbath_adam@ertekeld.hu', 'password' => Hash::make('Osbath_Adam123')],
            ['name' => 'Perák András', 'email' => 'perak_andras@ertekeld.hu', 'password' => Hash::make('Perak_Andras123')],
            ['name' => 'Pintér Levente', 'email' => 'pinter_levente@ertekeld.hu', 'password' => Hash::make('Pinter_Levente123')],
            ['name' => 'Radics Martin Noel', 'email' => 'radics_martin_noel@ertekeld.hu', 'password' => Hash::make('Radics_Martin_Noel123')],
            ['name' => 'Rohn Bertold', 'email' => 'rohn_bertold@ertekeld.hu', 'password' => Hash::make('Rohn_Bertold123')],
            ['name' => 'Rádics Bence Géza', 'email' => 'radics_bence_geza@ertekeld.hu', 'password' => Hash::make('Radics_Bence_Geza123')],
            ['name' => 'Somogyi Soma', 'email' => 'somogyi_soma@ertekeld.hu', 'password' => Hash::make('Somogyi_Soma123')],
            ['name' => 'Szita Máté Ferenc', 'email' => 'szita_mate_ferenc@ertekeld.hu', 'password' => Hash::make('Szita_Mate_Ferenc123')],
            ['name' => 'Széll András', 'email' => 'szell_andras@ertekeld.hu', 'password' => Hash::make('Szell_Andras123')],
            ['name' => 'Süle Marcell', 'email' => 'sule_marcell@ertekeld.hu', 'password' => Hash::make('Sule_Marcell123')],
            ['name' => 'Teveli Kornél Krisztián', 'email' => 'teveli_kornel_krisztian@ertekeld.hu', 'password' => Hash::make('Teveli_Kornel_Krisztián123')],
            ['name' => 'Tóth Barnabás Márk', 'email' => 'toth_barnabas_mark@ertekeld.hu', 'password' => Hash::make('Toth_Barnabas_Mark123')],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
