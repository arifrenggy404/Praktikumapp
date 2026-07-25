<?php

namespace App\Providers;

use App\Models\PengaturanWeb;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        if (str_contains(config('app.url'), 'https')) {
            URL::forceScheme('https');
        }

        // Bagikan data $setting ke semua view Blade
        View::composer('*', function ($view) {
            if (Schema::hasTable('pengaturan_webs')) {
                $setting = PengaturanWeb::first() ?? new PengaturanWeb([
                    'nama_gereja' => 'Gereja Kristen Sumba Jemaat Kandara',
                    'singkatan_gereja' => 'GKS Kandara',
                    'tagline_gereja' => 'Bertumbuh dalam Iman, Teguh dalam Pengharapan, dan Melayani dalam Kasih',
                    'sambutan_nama' => 'Pdt. Andreas, S.Th',
                    'sambutan_jabatan' => 'Pendeta Jemaat GKS Kandara',
                    'sambutan_teks' => 'Selamat datang di portal resmi GKS Jemaat Kandara.',
                    'ayat_emas_teks' => 'Sebab di mana dua atau tiga orang berkumpul dalam Nama-Ku, di situ Aku ada di tengah-tengah mereka.',
                    'ayat_emas_kitab' => 'Matius 18:20',
                    'sejarah_gereja' => 'Sejarah GKS Kandara.',
                    'visi_gereja' => 'Menjadi Jemaat Mandiri.',
                    'misi_gereja' => 'Melayani dengan Kasih.',
                    'alamat_gereja' => 'Jl. Kandara, Waingapu, Sumba Timur.',
                    'no_wa_gereja' => '081234567890',
                    'email_gereja' => 'info@gkskandara.or.id',
                ]);
                $view->with('setting', $setting);
            }
        });
    }
}
