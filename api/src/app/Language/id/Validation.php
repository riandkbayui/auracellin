<?php

// override core en language system validation or define your own en language validation message
return [
	"invalid" => "Mohon isi formulir dengan benar.",
    "hasbeentaken" => "{0} sudah digunakan, mohon gunakan {0} lain.",

	// Pesan Inti
     'noRuleSets' => 'Tidak ada kumpulan aturan yang ditentukan dalam konfigurasi Validasi.',
     'ruleNotFound' => '{0} bukan aturan yang valid.',
     'groupNotFound' => '{0} bukan grup aturan validasi.',
     'groupNotArray' => '{0} grup aturan harus berupa larik.',
     'invalidTemplate' => '{0} bukan templat Validasi yang valid.',

     // Aturan Pesan
     'alpha' => 'Bidang {field} hanya boleh berisi karakter abjad.',
     'alpha_dash' => 'Bidang {field} hanya boleh berisi karakter alfanumerik, garis bawah, dan tanda hubung.',
     'alpha_numeric' => 'Bidang {field} hanya boleh berisi karakter alfanumerik.',
     'alpha_numeric_punct' => 'Bidang {field} hanya boleh berisi karakter alfanumerik, spasi, dan ~ ! # $% & * - _ + = | : . karakter.',
     'alpha_numeric_space' => 'Bidang {field} hanya boleh berisi karakter alfanumerik dan spasi.',
     'alpha_space' => 'Bidang {field} hanya boleh berisi karakter abjad dan spasi.',
     'decimal' => 'Bidang {field} harus berisi angka desimal.',
     'differs' => 'Bidang {field} harus berbeda dengan bidang {param}.',
     'equals' => 'Bidang {field} harus tepat: {param}.',
     'exact_length' => 'Panjang bidang {field} harus tepat {param} karakter.',
     'greater_than' => 'Bidang {field} harus berisi angka lebih besar dari {param}.',
     'greater_than_equal_to' => 'Bidang {field} harus berisi angka yang lebih besar dari atau sama dengan {param}.',
     'hex' => 'Bidang {field} hanya boleh berisi karakter heksadesimal.',
     'in_list' => 'Bidang {field} harus salah satu dari: {param}.',
     'integer' => 'Bidang {field} harus berisi bilangan bulat.',
     'is_natural' => 'Bidang {field} hanya boleh berisi angka.',
     'is_natural_no_zero' => 'Bidang {field} hanya boleh berisi angka dan harus lebih besar dari nol.',
     'is_not_unique' => 'Bidang {field} harus berisi nilai yang sudah ada sebelumnya di basis data.',
     'is_unique' => 'Bidang {field} harus berisi nilai yang unik.',
     'less_than' => 'Bidang {field} harus berisi angka kurang dari {param}.',
     'less_than_equal_to' => 'Bidang {field} harus berisi angka kurang dari atau sama dengan {param}.',
     'matches' => 'Bidang {field} tidak cocok dengan bidang {param}.',
     'max_length' => 'Panjang bidang {field} tidak boleh melebihi {param} karakter.',
     'min_length' => 'Panjang bidang {field} minimal harus {param} karakter.',
     'not_equals' => 'Bidang {field} tidak boleh berupa: {param}.',
     'not_in_list' => 'Bidang {field} tidak boleh salah satu dari: {param}.',
     'numeric' => 'Bidang {field} hanya boleh berisi angka.',
     'regex_match' => 'Format {field} salah.',
     'required' => 'Bidang {field} wajib diisi.',
     'required_with' => 'Bidang {field} wajib diisi jika ada {param}.',
     'required_without' => 'Bidang {field} diperlukan jika {param} tidak ada.',
     'string' => 'Bidang {field} harus berupa string yang valid.',
     'timezone' => 'Bidang {field} harus berupa zona waktu yang valid.',
     'valid_base64' => 'Bidang {field} harus berupa string base64 yang valid.',
     'valid_email' => 'Bidang {field} harus berisi alamat email yang valid.',
     'valid_emails' => 'Bidang {field} harus berisi semua alamat email yang valid.',
     'valid_ip' => 'Bidang {field} harus berisi IP yang valid.',
     'valid_url' => 'Bidang {field} harus berisi URL yang valid.',
     'valid_date' => 'Bidang {field} harus berisi tanggal yang valid.',

     // Kartu kredit
     'valid_cc_num' => '{field} tampaknya bukan nomor kartu kredit yang valid.',

     // File
     'uploaded' => '{field} bukan berkas unggahan yang valid.',
     'max_size' => '{field} file terlalu besar.',
     'is_image' => '{field} bukan berkas gambar unggahan yang valid.',
     'mime_in' => '{field} tidak memiliki tipe pantomim yang valid.',
     'ext_in' => '{field} tidak memiliki ekstensi berkas yang valid.',
     'max_dims' => '{field} mungkin bukan gambar, atau terlalu lebar atau tinggi.',
     'enum'  => '{field} tidak memiliki nilai enum yang valid.',
    "periodeformat" => '{field} format tidak sesuai.'
];
