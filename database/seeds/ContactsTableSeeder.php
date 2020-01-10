<?php

use Illuminate\Database\Seeder;

class ContactsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contacts = storage_path('app/public/sample.json');
        $contacts = json_decode(file_get_contents($contacts), true);
        $data = [];
        foreach ($contacts as $contact) {
            $data [] = [
                'names'   => $contact['names'],
//                'hits' => json_encode(array_fill(0, count(json_decode($contact['names'])), 0))
            ];
        }
        \App\Contact::insert($data);
    }
}
