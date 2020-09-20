<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CustomerType;
use Illuminate\Support\Str;


class CustomerTypeSeeder extends Seeder
{
    private $types = [
        'CPF',
        'CNPJ'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->types as $type){
            $slug = Str::slug($type);
            CustomerType::firstOrCreate([
                'name' => $type,
                'slug' => $slug
            ]);
        }
    }
}
