<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ngo;


class MembershipSeeder extends Seeder
{

    public function run()
    {
        $ngos = [
            ['ngo_name' => 'ACR/Caritas Australia', 'abbreviation' => 'ACR Caritas'],
            ['ngo_name' => 'Action For Development', 'abbreviation' => 'AFD'],
            ['ngo_name' => 'American Friends Service Committee', 'abbreviation' => 'AFSC'],
            ['ngo_name' => 'Banteay Srei', 'abbreviation' => 'BS'],
            ['ngo_name' => 'Building Community Voice', 'abbreviation' => 'BCV'],
            ['ngo_name' => 'Cambodian Development Mission for Disability', 'abbreviation' => 'CDMD'],
            ['ngo_name' => 'Cambodian Disabled People\'s Organization', 'abbreviation' => 'CDPO'],
            ['ngo_name' => 'Cambodian Health and Education For Community', 'abbreviation' => 'CHEC'],
            ['ngo_name' => 'Cambodian Women\'s Crisis Center', 'abbreviation' => 'CWCC'],
            ['ngo_name' => 'Cambodian Women\'s Development Association', 'abbreviation' => 'CWDA'],
            ['ngo_name' => 'Catholic Relief Services', 'abbreviation' => 'CRS'],
            ['ngo_name' => 'Centre d\'Etude et de Developpement Agricole Cambodgien', 'abbreviation' => 'CDAC'],
            ['ngo_name' => 'Community Council for Development', 'abbreviation' => 'CCDO'],
            ['ngo_name' => 'Community Legal Education Center', 'abbreviation' => 'CLEC'],
            ['ngo_name' => 'Community Sanitation and Recycling Organisation', 'abbreviation' => 'CSRO'],
            ['ngo_name' => 'Cooperation for Alleviation of Poverty', 'abbreviation' => 'COFAP'],
            ['ngo_name' => 'Cooperation for Development of Cambodia', 'abbreviation' => 'CODECKT'],
            ['ngo_name' => 'Cooperation for Social Services and Development', 'abbreviation' => 'CSSD'],
            ['ngo_name' => 'Culture and Environment Preservation Association', 'abbreviation' => 'CEPA'],
            ['ngo_name' => 'DANMISSION', 'abbreviation' => 'DANMISSION'],
            ['ngo_name' => 'Development and Partnership in Action', 'abbreviation' => 'DPA'],
            ['ngo_name' => 'Diaconia ECCB – Center of Relief and Development', 'abbreviation' => 'DE–CoRaD'],
            ['ngo_name' => 'Farmer Livelihood Development Organization', 'abbreviation' => 'FLD'],
            ['ngo_name' => 'Fisheries Action Coalition Team', 'abbreviation' => 'FACT'],
            ['ngo_name' => 'ForumCiv', 'abbreviation' => 'ForumCiv'],
            ['ngo_name' => 'Gender And Development for Cambodia', 'abbreviation' => 'GADC'],
            ['ngo_name' => 'Groupe de Recherche et d\'Echanges Technologiques', 'abbreviation' => 'GRET'],
            ['ngo_name' => 'HEKS/EPER-Swiss Church Aid', 'abbreviation' => 'HEKS'],
            ['ngo_name' => 'Help Age Cambodia', 'abbreviation' => 'HAC'],
            ['ngo_name' => 'HALO Trust Cambodia', 'abbreviation' => 'HALO'],
            ['ngo_name' => 'Hurredo', 'abbreviation' => 'Hurredo'],
            ['ngo_name' => 'Indigenous Community Support Organization', 'abbreviation' => 'ICSO'],
            ['ngo_name' => 'Jesuit Service Cambodia', 'abbreviation' => 'JRC'],
            ['ngo_name' => 'Khmer Angka for Development of Rural Areas', 'abbreviation' => 'KADRA'],
            ['ngo_name' => 'Khmer Community for Agricultural Development', 'abbreviation' => 'KCAD'],
            ['ngo_name' => 'Legal Aid of Cambodia', 'abbreviation' => 'LAC'],
            ['ngo_name' => 'Mennonite Central Committee', 'abbreviation' => 'MCC'],
            ['ngo_name' => 'Minority Rights Organization', 'abbreviation' => 'MIRO'],
            ['ngo_name' => 'Mission Alliance', 'abbreviation' => 'MA'],
            ['ngo_name' => 'Mlup Baitong', 'abbreviation' => 'MB'],
            ['ngo_name' => 'Mlup Promviheathor Center Organization', 'abbreviation' => 'MPC'],
            ['ngo_name' => 'My Village', 'abbreviation' => 'Mvi'],
            ['ngo_name' => 'Norwegian People\'s Aid', 'abbreviation' => 'NPA'],
            ['ngo_name' => 'Occupation of Rural Economic Development and Agriculture', 'abbreviation' => 'OREDA'],
            ['ngo_name' => 'OXFAM', 'abbreviation' => 'Oxf'],
            ['ngo_name' => 'Partnership for Development in Kampuchea', 'abbreviation' => 'PADEK'],
            ['ngo_name' => 'People\'s Action for Inclusive Development', 'abbreviation' => 'PAFID'],
            ['ngo_name' => 'Phnom Srey Association for Development', 'abbreviation' => 'PSOD'],
            ['ngo_name' => 'Plan International Cambodia', 'abbreviation' => 'Plan'],
            ['ngo_name' => 'Por Thom Elderly Association', 'abbreviation' => 'PTEA'],
            ['ngo_name' => 'Prom Vihear Thor Organization', 'abbreviation' => 'Promvihearthor'],
            ['ngo_name' => 'Rural Aid Organization', 'abbreviation' => 'RAO'],
            ['ngo_name' => 'Rural Community and Environment Development Organization', 'abbreviation' => 'RCEDO'],
            ['ngo_name' => 'Save the Children', 'abbreviation' => 'SC'],
            ['ngo_name' => 'Urban Poor Women Development', 'abbreviation' => 'UPWD'],
            ['ngo_name' => 'Women\'s Media Centre of Cambodia', 'abbreviation' => 'WMC'],
            ['ngo_name' => 'World Renew', 'abbreviation' => 'WR'],
            ['ngo_name' => 'World Vision International - Cambodia', 'abbreviation' => 'WVI-C'],
            ['ngo_name' => 'Youth for Peace Organisation', 'abbreviation' => 'YPO'],
            ['ngo_name' => 'Environment and Health Education', 'abbreviation' => 'EHE'],
            ['ngo_name' => 'Buddhism for Social Development Action', 'abbreviation' => 'BSDA'],
            ['ngo_name' => 'Passerelles Numériques Cambodia', 'abbreviation' => 'PNC'],
        ];


        foreach ($ngos as $ngo) {
            Ngo::create($ngo);
        }
    }
}
