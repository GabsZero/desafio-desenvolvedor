<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Status;
use Illuminate\Support\Str;

class StatusSeeder extends Seeder
{
    private $status = [
        'Pending',
        'Paid',
        'Cancelled'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->status as $status){
            $slug = Str::slug($status);
            Status::firstOrCreate([
                'name' => $status,
                'slug' => $slug
            ]);
        }
    }
}
