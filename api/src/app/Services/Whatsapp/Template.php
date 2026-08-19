<?php

namespace App\Services\Whatsapp;

use App\Services\BaseServices;
use Exception;

class Template extends BaseServices {

    private $office;

    public function __construct() {
        $this->office = office();
    }

    public function welcome($data) {
        $data = (object) $data;
        $member_url = landing_url('auth/login');
        return "Halo *{$data->name}*,
Selamat! 🎉 Pendaftaran Anda di Star Community telah berhasil.

Berikut adalah data akun Anda untuk login ke Support System:

👤 Username : {$data->username}
🔑 Password : {$data->password}

🔗 Login sekarang di: {$member_url}

✨ Dengan bergabung, Anda sudah resmi menjadi bagian dari komunitas hebat yang siap tumbuh bersama.

Jika ada kendala login, silakan hubungi Admin Support: {$this->office->office_phone}.

Terima kasih,
Salam sukses 🚀
Star Community Support System";
    }

    public function forgot($data) {
        $data = (object) $data;

        return "Halo *{$data->name}*,  

Kami menerima permintaan reset sandi akun *{$data->username}*.  
Gunakan kode berikut untuk mengatur ulang sandi:  

*Link Reset:* {$data->link}   

Terima kasih,
Salam sukses 🚀
Star Community Support System";
    }

    public function prospect($data){
        $data = (object) $data;
        return "Halo bos {$data->name} (*{$data->username}*) 👋

🚀 Ada prospek baru yang masuk ke ITB STARCOM!

📌 Detail Prospek:
👤 Nama : $data->prospect_name
🏙️ Kota : $data->prospect_city
📱 No. Telp : $data->prospect_phone

💡 Segera follow up, jangan sampai ketinggalan momentum. Siapa cepat dia dapat! ⚡

Salam sukses,
✨ Support System ITB STARCOM;";
    }
}
