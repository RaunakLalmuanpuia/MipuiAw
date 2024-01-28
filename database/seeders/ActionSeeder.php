<?php

namespace Database\Seeders;

use App\Models\Action;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $actions =[
            [
                'name'=>'no action required',
                'label'=>'NO ACTION REQUIRED (Case Closed)',
                'visible'=>true,
            ],
            [
                'name'=>'examine at our level',
                'label'=>'EXAMINE AT OUR LEVEL',
                'visible'=>true,
            ],
            [
                'name'=>'take up with subordinate organization',
                'label'=>'TAKE UP WITH SUBORDINATE ORGANIZATION',
                'visible'=>true,
            ],
            [
                'name'=>'case dispose of',
                'label'=>'CASE DISPOSE OF (Case Closed)',
                'visible'=>true,
            ],
            [
                'name'=>'transfer to other department',
                'label'=>'TRANSFER TO OTHER DEPARTMENT',
                'visible'=>true,
            ],
            [
                'name'=>'appeal',
                'label'=>'APPEAL',
                'visible'=>false,
            ],
            [
                'name'=>'closed',
                'label'=>'CLOSED',
                'visible'=>false,
            ],
            [
                'name'=>'received the grievance',
                'label'=>'RECEIVED THE GRIEVANCE',
                'visible'=>false,
            ],
            [
                'name'=>'grievance submission',
                'label'=>'GRIEVANCE SUBMISSION',
                'visible'=>false,
            ],
            [
                'name'=>'transfer to sub organization & closed',
                'label'=>'TRANSFER TO SUB ORGANIZATION & CAN CLOSED',
                'visible'=>false,
            ],
            [
                'name'=>'no action required by Sub Organization',
                'label'=>'NO ACTION REQUIRED BY SUB ORGANIZATION',
                'visible'=>false,
            ],
            [
                'name'=>'examine at our level by Sub Organization',
                'label'=>'EXAMINE AT OUR LEVEL BY SUB ORGANIZATION',
                'visible'=>false,
            ],
          
            [
                'name'=>'examine at our level by Sub Organization Mark Closed',
                'label'=>'EXAMINE AT OUR LEVEL BY SUB ORGANIZATION MARK CLOSED',
                'visible'=>false,
            ],
            
        ];

        foreach($actions as $action){
            Action::create($action);
        }
    }
}
