<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ptn;

class PtnSeeder extends Seeder
{
    public function run(): void
    {
        $ptns = [
            'Universitas Indonesia',
            'Institut Teknologi Bandung',
            'Universitas Gadjah Mada',
            'Institut Pertanian Bogor',
            'Universitas Airlangga',
            'Universitas Diponegoro',
            'Institut Teknologi Sepuluh Nopember',
            'Universitas Brawijaya',
            'Universitas Padjadjaran',
            'Universitas Sebelas Maret',
            'Universitas Negeri Jakarta',
            'Universitas Pendidikan Indonesia',
            'Universitas Negeri Yogyakarta',
            'Universitas Negeri Semarang',
            'Universitas Negeri Surabaya',
            'Universitas Andalas',
            'Universitas Hasanuddin',
            'Universitas Sumatera Utara',
            'Universitas Syiah Kuala',
            'Universitas Udayana',
            'Universitas Sriwijaya',
            'Universitas Lampung',
            'Universitas Riau',
            'Universitas Jenderal Soedirman',
            'Universitas Negeri Malang',
            'Universitas Negeri Padang',
            'Universitas Negeri Medan',
            'Universitas Negeri Makassar',
            'Universitas Trunojoyo Madura',
            'Universitas Tanjungpura',
            'Universitas Islam Indonesia',
            'Universitas Islam Negeri Sunan Kalijaga',
            'Universitas Muhammadiyah Yogyakarta',
            'Universitas Katolik Parahyangan',
            'Universitas Kristen Petra',
            'Universitas Negeri Manado',
        ];

        foreach ($ptns as $name) {
            Ptn::firstOrCreate(['name' => $name]);
        }
    }
}
