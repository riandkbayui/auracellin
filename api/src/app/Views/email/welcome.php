<?= $this->extend('email/template') ?>
<?= $this->section('content') ?>
<p class="mb-0">YTH <?= "<b>{$name}</b> ({$username})" ?></p>
<p class="mt-0">Selamat anda terdaftar di support system, <?= $office_name ?? "" ?>. Berikut adalah detail login akun anda.</p>
<table>
  <tr>
    <th align="left">Username</th>
    <td align="left">:</td>
    <td align="left"><?= $username ?? "" ?></td>
  </tr>
  <tr>
    <th align="left">Email</th>
    <td align="left">:</td>
    <td align="left"><?= $email ?? "" ?></td>
  </tr>
  <tr>
    <th align="left">Password</th>
    <td align="left">:</td>
    <td align="left"><?= $password ?? "" ?></td>
  </tr>
</table>
<p>Mohon langsung mengganti password anda begitu anda login.</p> 
<?= $this->endSection() ?>