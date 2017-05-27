<?php
use Illuminate\Database\Seeder;
use App\Domain;

class DomainsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        $domains = [
            "amazon.com.au",
            "amazon.ca",
            "amazon.com",
            "amazon.co.uk",
            "amazon.de",
            "amazon.es",
            "amazon.fr",
            "amazon.in",
            "amazon.it",
            "amazon.jp"
        ];
        if (Domain::count() == 0) {
            foreach($domains as $domain) {
                $row = Domain::firstOrNew(['name' => $domain]);
                $row->name = $domain;
                $row->save();
            }
        }
    }
}
