Cara Pemakaian
==============

Dokumen ini akan memandu Anda bagaimana mengsinstall GenIt di Openbiz Cubi Platform dan bagaimana cara menggunakannya.

Instalasi GenIt
---------------------

1. Silahkan download file GenIt dari link berikut : https://github.com/binexa/genit/archive/master.zip
2. Ektrak file .zip tersebut, hasilnya berupa direktori genit-master , silahkan rename menjadi genit saja.
3. Salin directori genit ke direktori bin dari Openbiz-Cubi Platform Anda.

Konsep Dasar dan Konfigurasi
-----------------------------
Setiap aplikasi, termasuk user interface dan proses di dalamnya, akan memiliki pola tertentu. 
GenIt digunakan untuk meng-generate aplikasi sesuai pola-pola tersebut. 
GenIt sudah memiliki banyak pola bawaan yang akan selalu ditambah sesuai kebutuhan pengembangan aplikasi.

Genit digunakan untuk membuat aplikasi berbasis Openbiz Cubi dengan menggunakan konfigurasi.
Setiap file konfigurasi akan menggunakan template aplikasi sesuai pola yang diperlukan.

Untuk mengekseskusi sebuah file konfigurasi, file tersebut perlu didaftarkan ke dalam file main.php dalam directori config (config/main.php)
dengan format sebagai berikut :

```php
return [
    [ 'tableName'=>'nama-tabel-di-database', 'type' => null ], // synfac_master2    
];
```