<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ngo;

class NgoSeeder extends Seeder
{
    public function run()
    {
        $data = [

            ['name' => 'ACR/Caritas Australia', 'abbreviation' => 'ACR Caritas'],
            ['name' => 'Action For Development', 'abbreviation' => 'AFD'],
            ['name' => 'American Friends Service Committee', 'abbreviation' => 'AFSC'],
            ['name' => 'Banteay Srei', 'abbreviation' => 'BS'],
            ['name' => 'Building Community Voice', 'abbreviation' => 'BCV'],
            ['name' => 'Cambodian Development Mission for Disability', 'abbreviation' => 'CDMD'],
            ['name' => 'Cambodian Disabled People\'s Organization', 'abbreviation' => 'CDPO'],
            ['name' => 'Cambodian Health and Education For Community', 'abbreviation' => 'CHEC'],
            ['name' => 'Cambodian Women\'s Crisis Center', 'abbreviation' => 'CWCC'],
            ['name' => 'Cambodian Women\'s Development Association', 'abbreviation' => 'CWDA'],
            ['name' => 'Catholic Relief Services', 'abbreviation' => 'CRS'],
            ['name' => 'Centre d\'Etude et de Developpement Agricole Cambodgien', 'abbreviation' => 'CDAC'],
            ['name' => 'Community Council for Development', 'abbreviation' => 'CCDO'],
            ['name' => 'Community Legal Education Center', 'abbreviation' => 'CLEC'],
            ['name' => 'Community Sanitation and Recycling Organisation', 'abbreviation' => 'CSRO'],
            ['name' => 'Cooperation for Alleviation of Poverty', 'abbreviation' => 'COFAP'],
            ['name' => 'Cooperation for Development of Cambodia', 'abbreviation' => 'CODECKT'],
            ['name' => 'Cooperation for Social Services and Development', 'abbreviation' => 'CSSD'],
            ['name' => 'Culture and Environment Preservation Association', 'abbreviation' => 'CEPA'],
            ['name' => 'DANMISSION', 'abbreviation' => 'DANMISSION'],
            ['name' => 'Development and Partnership in Action', 'abbreviation' => 'DPA'],
            ['name' => 'Diaconia ECCB – Center of Relief and Development', 'abbreviation' => 'DE–CoRaD'],
            ['name' => 'Farmer Livelihood Development Organization', 'abbreviation' => 'FLD'],
            ['name' => 'Fisheries Action Coalition Team', 'abbreviation' => 'FACT'],
            ['name' => 'ForumCiv', 'abbreviation' => 'ForumCiv'],
            ['name' => 'Gender And Development for Cambodia', 'abbreviation' => 'GADC'],
            ['name' => 'Groupe de Recherche et d\'Echanges Technologiques', 'abbreviation' => 'GRET'],
            ['name' => 'HEKS/EPER-Swiss Church Aid', 'abbreviation' => 'HEKS'],
            ['name' => 'Help Age Cambodia', 'abbreviation' => 'HAC'],
            ['name' => 'HALO Trust Cambodia', 'abbreviation' => 'HALO'],
            ['name' => 'Hurredo', 'abbreviation' => 'Hurredo'],
            ['name' => 'Indigenous Community Support Organization', 'abbreviation' => 'ICSO'],
            ['name' => 'Jesuit Service Cambodia', 'abbreviation' => 'JRC'],
            ['name' => 'Khmer Angka for Development of Rural Areas', 'abbreviation' => 'KADRA'],
            ['name' => 'Khmer Community for Agricultural Development', 'abbreviation' => 'KCAD'],
            ['name' => 'Legal Aid of Cambodia', 'abbreviation' => 'LAC'],
            ['name' => 'Mennonite Central Committee', 'abbreviation' => 'MCC'],
            ['name' => 'Minority Rights Organization', 'abbreviation' => 'MIRO'],
            ['name' => 'Mission Alliance', 'abbreviation' => 'MA'],
            ['name' => 'Mlup Baitong', 'abbreviation' => 'MB'],
            ['name' => 'Mlup Promviheathor Center Organization', 'abbreviation' => 'MPC'],
            ['name' => 'My Village', 'abbreviation' => 'Mvi'],
            ['name' => 'Norwegian People\'s Aid', 'abbreviation' => 'NPA'],
            ['name' => 'Occupation of Rural Economic Development and Agriculture', 'abbreviation' => 'OREDA'],
            ['name' => 'OXFAM', 'abbreviation' => 'Oxf'],
            ['name' => 'Partnership for Development in Kampuchea', 'abbreviation' => 'PADEK'],
            ['name' => 'People\'s Action for Inclusive Development', 'abbreviation' => 'PAFID'],
            ['name' => 'Phnom Srey Association for Development', 'abbreviation' => 'PSOD'],
            ['name' => 'Plan International Cambodia', 'abbreviation' => 'Plan'],
            ['name' => 'Por Thom Elderly Association', 'abbreviation' => 'PTEA'],
            ['name' => 'Prom Vihear Thor Organization', 'abbreviation' => 'Promvihearthor'],
            ['name' => 'Rural Aid Organization', 'abbreviation' => 'RAO'],
            ['name' => 'Rural Community and Environment Development Organization', 'abbreviation' => 'RCEDO'],
            ['name' => 'Save the Children', 'abbreviation' => 'SC'],
            ['name' => 'Urban Poor Women Development', 'abbreviation' => 'UPWD'],
            ['name' => 'Women\'s Media Centre of Cambodia', 'abbreviation' => 'WMC'],
            ['name' => 'World Renew', 'abbreviation' => 'WR'],
            ['name' => 'World Vision International - Cambodia', 'abbreviation' => 'WVI-C'],
            ['name' => 'Youth for Peace Organisation', 'abbreviation' => 'YPO'],
            ['name' => 'Environment and Health Education', 'abbreviation' => 'EHE'],
            ['name' => 'Buddhism for Social Development Action', 'abbreviation' => 'BSDA'],
            ['name' => 'Deutsche Welthungerhilfe German Agro Action', 'abbreviation' => 'WHH'],

        ];

        foreach ($data as $ngo) {
            Ngo::create($ngo);
        }
    }
}
