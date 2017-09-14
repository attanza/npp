<?php

return [

    /*
    |---------------------------------------------------------------------------------------
    | Baris Bahasa untuk Validasi
    |---------------------------------------------------------------------------------------
    |
    | Baris bahasa berikut ini berisi standar pesan kesalahan yang digunakan oleh
    | kelas validasi. Beberapa aturan mempunyai multi versi seperti aturan 'size'.
    | Jangan ragu untuk mengoptimalkan setiap pesan yang ada di sini.
    |
    */

    'accepted'             => ':attribute harus diterima.',
    'active_url'           => ':attribute bukan URL yang valid.',
    'after'                => ':attribute harus tanggal setelah :date.',
    'after_or_equal'       => ':attribute harus berupa tanggal setelah atau sama dengan tanggal :date.',
    'alpha'                => ':attribute hanya boleh berisi huruf.',
    'alpha_dash'           => ':attribute hanya boleh berisi huruf, angka, dan strip.',
    'alpha_num'            => ':attribute hanya boleh berisi huruf dan angka.',
    'array'                => ':attribute harus berupa sebuah array.',
    'before'               => ':attribute harus tanggal sebelum :date.',
    'before_or_equal'      => ':attribute harus berupa tanggal sebelum atau sama dengan tanggal :date.',
    'between'              => [
        'numeric' => ':attribute harus antara :min dan :max.',
        'file'    => ':attribute harus antara :min dan :max kilobytes.',
        'string'  => ':attribute harus antara :min dan :max karakter.',
        'array'   => ':attribute harus antara :min dan :max item.',
    ],
    'boolean'              => ':attribute harus berupa true atau false',
    'confirmed'            => 'Konfirmasi :attribute tidak cocok.',
    'date'                 => ':attribute bukan tanggal yang valid.',
    'date_format'          => ':attribute tidak cocok dengan format :format.',
    'different'            => ':attribute dan :other harus berbeda.',
    'digits'               => ':attribute harus berupa angka :digits.',
    'digits_between'       => ':attribute harus antara angka :min dan :max.',
    'dimensions'           => 'Bidang :attribute tidak memiliki dimensi gambar yang valid.',
    'distinct'             => ':attribute memiliki nilai yang duplikat.',
    'email'                => ':attribute harus berupa alamat surel yang valid.',
    'exists'               => ':attribute yang dipilih tidak valid.',
    'file'                 => 'Bidang :attribute harus berupa sebuah berkas.',
    'filled'               => ':attribute harus diisi.',
    'image'                => ':attribute harus berupa gambar.',
    'in'                   => ':attribute yang dipilih tidak valid.',
    'in_array'             => ':attribute tidak terdapat dalam :other.',
    'integer'              => ':attribute harus merupakan bilangan bulat.',
    'ip'                   => ':attribute harus berupa alamat IP yang valid.',
    'json'                 => ':attribute harus berupa JSON string yang valid.',
    'max'                  => [
        'numeric' => ':attribute seharusnya tidak lebih dari :max.',
        'file'    => ':attribute seharusnya tidak lebih dari :max kilobytes.',
        'string'  => ':attribute seharusnya tidak lebih dari :max karakter.',
        'array'   => ':attribute seharusnya tidak lebih dari :max item.',
    ],
    'mimes'                => ':attribute harus dokumen berjenis : :values.',
    'mimetypes'            => ':attribute harus dokumen berjenis : :values.',
    'min'                  => [
        'numeric' => ':attribute harus minimal :min.',
        'file'    => ':attribute harus minimal :min kilobytes.',
        'string'  => ':attribute harus minimal :min karakter.',
        'array'   => ':attribute harus minimal :min item.',
    ],
    'not_in'               => ':attribute yang dipilih tidak valid.',
    'numeric'              => ':attribute harus berupa angka.',
    'present'              => ':attribute harus ada.',
    'regex'                => 'Format :attribute tidak valid.',
    'required'             => ':attribute harus diisi.',
    'required_if'          => ':attribute harus diisi bila :other adalah :value.',
    'required_unless'      => ':attribute harus diisi kecuali :other memiliki nilai :values.',
    'required_with'        => ':attribute harus diisi bila terdapat :values.',
    'required_with_all'    => ':attribute harus diisi bila terdapat :values.',
    'required_without'     => ':attribute harus diisi bila tidak terdapat :values.',
    'required_without_all' => ':attribute harus diisi bila tidak terdapat ada :values.',
    'same'                 => ':attribute dan :other harus sama.',
    'size'                 => [
        'numeric' => ':attribute harus berukuran :size.',
        'file'    => ':attribute harus berukuran :size kilobyte.',
        'string'  => ':attribute harus berukuran :size karakter.',
        'array'   => ':attribute harus mengandung :size item.',
    ],
    'string'               => ':attribute harus berupa string.',
    'timezone'             => ':attribute harus berupa zona waktu yang valid.',
    'unique'               => ':attribute sudah terdaftar.',
    'uploaded'             => ':attribute gagal diunggah.',
    'url'                  => 'Format :attribute tidak valid.',

    /*
    |---------------------------------------------------------------------------------------
    | Baris Bahasa untuk Validasi Kustom
    |---------------------------------------------------------------------------------------
    |
    | Di sini Anda dapat menentukan pesan validasi kustom untuk dengan menggunakan
    | konvensi "attribute.rule" dalam penamaan baris. Hal ini membuat cepat dalam
    | menentukan spesifik baris bahasa kustom untuk aturan yang diberikan.
    |
    */

    'custom'               => [
        'terms' => [
            'required' => 'Syarat dan ketentuan belum di centang',
        ],
    ],

    /*
    |---------------------------------------------------------------------------------------
    | Kustom Validasi     |---------------------------------------------------------------------------------------
    |
    | Baris bahasa berikut digunakan untuk menukar 'place-holders'
    | dengan sesuatu yang lebih bersahabat dengan pembaca seperti Alamat Surel daripada
    | "surel" saja. Ini benar-benar membantu kita membuat pesan sedikit bersih.
    |
    */

    'attributes'           => [
        'first_name' => 'Nama Depan',
        'last_name' => 'Nama Belakang',
        'name' => 'Nama',
        'email' => 'Alamat Email',
        'dob' => 'Tanggal Lahir',
        'gender' => 'Jenis Kelamin',
        'terms' => 'Syarat & ketentuan',
        'dream' => 'Mimpimu',
        'keyword' => 'Kata kunci',
        'title' => 'Judul',
        'description' => 'Deskripsi',
        'video_link' => 'Link Video',
        'old_password' => 'Password lama',
        'password_confirmation' => 'Konfirmasi Password',
        'address' => 'Alamat',
        'code' => 'Kode'
    ],

];
