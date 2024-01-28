<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'organization_name'=>'Agriculture Department, Mizoram',
                'organization_code' => '',
            ],
            [
                'organization_name'=>'Animal Husbandry and Veterinary Department, Mizoram',
            ],
            [
                'organization_name'=>'Co-operation Department, Mizoram',
            ],
            [
                'organization_name'=>'Disaster management and Rehabilitation Department, Mizoram',
            ],
            [
                'organization_name'=>'District Council Affairs Department, Mizoram',
            ],
            [
                'organization_name'=>'Economics and Statistics Department, Mizoram',
            ],
            [
                'organization_name'=>'Election Department, Mizoram',
            ],
            [
                'organization_name'=>'Environment and Forest Department, Mizoram',
            ],
            [
                'organization_name'=>'Excise and Narcotic Department, Mizoram',
            ],
            [
                'organization_name'=>'Finance Department, Mizoram',
            ],
            [
                'organization_name'=>'Fisheries Department, Mizoram',
            ],
            [
                'organization_name'=>'Food, Civil Supplies and Consumer Affairs Department, Mizoram',
            ],
            [
                'organization_name'=>'General Administration Department, Mizoram',
            ],
            [
                'organization_name'=>'Health and Family Welfare Department, Mizoram',
            ],
            [
                'organization_name'=>'Higher and Technical Education Department, Mizoram',
            ],
            [
                'organization_name'=>'Home Department, Mizoram',
            ],
            [
                'organization_name'=>'Horticulture Department, Mizoram',
            ],
            [
                'organization_name'=>'Industries Department, Mizoram',
            ],
            [
                'organization_name'=>'Information and Communication Technology Department, Mizoram',
            ],
            [
                'organization_name'=>'Information and Public Relations Department, Mizoram',
            ],
            [
                'organization_name'=>'Land Revenue and Settlement Department, Mizoram',
            ],
            [
                'organization_name'=>'Law and Judicial Department, Mizoram',
            ],
            [
                'organization_name'=>'Local Administration Department, Mizoram',
            ],
            [
                'organization_name'=>'Minor Irrigation Department, Mizoram',
            ],
            [
                'organization_name'=>'Personnel and Administrative Reforms Department, Mizoram',
            ],
            [
                'organization_name'=>'Planning and Programme Implementation Department, Mizoram',
            ],
            [
                'organization_name'=>'Police Department, Mizoram',
            ],
            [
                'organization_name'=>'Political and Cabinet Department, Mizoram',
            ],
            [
                'organization_name'=>'Power and Electricity Department, Mizoram',
            ],
            [
                'organization_name'=>'Prisons Department, Mizoram',
            ],
            [
                'organization_name'=>'Public Health Engineering Department, Mizoram',
            ],
            [
                'organization_name'=>'Public Works Department, Mizoram',
            ],
            [
                'organization_name'=>'Rural Development Department, Mizoram',
            ],
            [
                'organization_name'=>'Sainik Welfare & Resettlement Department, Mizoram',
            ],
            [
                'organization_name'=>'School Education Department, Mizoram',
            ],
            [
                'organization_name'=>'Sericulture Department, Mizoram',
            ],
            [
                'organization_name'=>'Social Welfare Department, Mizoram',
            ],
            [
                'organization_name'=>'Soil and Water Conservation Department, Mizoram',
            ],
            [
                'organization_name'=>'Sports and Youth Services Department, Mizoram',
            ],
            [
                'organization_name'=>'Taxation Department, Mizoram',
            ],
            [
                'organization_name'=>'Tourism Department, Mizoram',
            ],
            [
                'organization_name'=>'Trade and Commerce Department, Mizoram',
            ],
            [
                'organization_name'=>'Transport Department, Mizoram',
            ],
            [
                'organization_name'=>'Urban Development and Poverty Alleviation Department, Mizoram',
            ],
            [
                'organization_name'=>'Vigilance Department, Mizoram',
            ],
            [
                'organization_name'=>'DC Aizawl',
            ],
            [
                'organization_name'=>'DC Lunglei',
            ],
            [
                'organization_name'=>'DC Siaha',
            ],
            [
                'organization_name'=>'DC Champhai',
            ],
            [
                'organization_name'=>'DC Serchhip',
            ],
            [
                'organization_name'=>'DC Kolasib',
            ],
            [
                'organization_name'=>'DC Lawngtlai',
            ],
            [
                'organization_name'=>'DC Mamit',
            ],
            [
                'organization_name'=>'DC Saitual',
            ],
            [
                'organization_name'=>'DC Khawzawl',
            ],
            [
                'organization_name'=>'DC Hnahthial',
            ],
        ];

        foreach($departments as $department){
            Department::create($department);
        }
    }
}
