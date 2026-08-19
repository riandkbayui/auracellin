<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mail System - <?= $office_name ?? "" ?></title>
  <style type="text/css">
    .mt-0 {
      margin-top: 0;
    }

    .mb-0 {
      margin-bottom: 0;
    }

    .my-0 {
      margin-top: 0;
      margin-bottom: 0;
    }

    tr > th,
    tr > td {
      text-align: left;
    }

    tr > td.numeric {
      text-align: right;
    }

    body {
      margin: 0;
    }

    .body {
      background-color: #f6f6f8;
      padding-top: 1rem;
      padding-bottom: 1rem;
    }

    .container {
      background: #fff;
      padding: 1rem;
      width: 540px;
      margin-left: auto;
      margin-right: auto;
    }

    .footer {
      border-top: solid #f6f6f8 2px;
      padding-top: 0.5rem;
      margin-top: 1.75rem;
      display: block;
    }

    .text-center {
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="body">
    <div class="container">
      <div class="content">
        <h1 class="text-center"><?= $office_name ?></h1>
        <?= $this->renderSection('content')  ?>
      </div>
      <div class="footer">
        <p class="my-0">Apabila anda membutuhkan bantuan silahkan hubungi kami di:</p>
        <table>
          <tr>
            <th align="left">Email</th>
            <td align="left">:</td>
            <td align="left"><?= $office_email ?? "" ?></td>
          </tr>
        </table>
        <p class="mb-0">Salam Hangat!</p>
        <p class="mt-0"><?= $office_name ?? "" ?></p>
      </div>
    </div>
  </div>
</body>
</html>