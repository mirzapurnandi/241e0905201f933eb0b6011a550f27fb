# Proses Register & Login menggunakan Redis Queue
## _oleh:mirzapurnandi_

[![N|Solid](https://cldup.com/dTxpPi9lDf.thumb.png)](https://nodesource.com/products/nsolid)

Membuat REST API untuk proses Register dan Login menggunakan Redis Queue ini membantu pengguna untuk melakukan register di suatu aplikasi dengan mudah tanpa menunggu proses pengiriman email yang memakan waktu mungkin beberapa detik. Untuk proses login juga di sertakan JWT untuk mendapatkan token login agar dapat digunakan di aplikasi lain.

### Required:
- PHP 7.4
- ext-php: redis
- ext-php: pgsql


## Installasi
Ikuti langkah berikut
- git clone https://github.com/mirzapurnandi/241e0905201f933eb0b6011a550f27fb
- composer install
- Ubah setting koneksi postgresql, file config/Connect.php
    ```sh
    $host = 'localhost';
    $port = '5432';
    $dbname = 'sending';
    $user = 'mirza';
    $password = '';
    ```
- Ubah setting koneksi pengiriman Email, file config/MailConnect.php
    ```sh
    $this->mail->Host = 'smtp.mailtrap.io';
    $this->mail->SMTPAuth = true;
    $this->mail->Port = 2525;
    $this->mail->Username = '5751a43d1e1234';
    $this->mail->Password = '456798268195c6';
    ```
- Selesai, jalankan sesuai installasi (misalnya menggunakan XAMPP)

## REST API
Berikut ini list point api

| METHOD | KETERANGAN | URL |
| ------ | ------ | ------ | 
| POST | Register | http://send-mail.test/index.php/register |
| POST | Login | http://send-mail.test/index.php/login |
| GET | Profile | http://send-mail.test/index.php/me |

## CARA PENGGUNAAN
Gunakan Postman untuk dapat menjalankan API diatas.
### Register
| POST | Register | http://send-mail.test/index.php/register |
| ------ | ------ | ------ | 
```sh
body {
    "name": "Mirza",
    "email": "mirza@gmail.com",
    "password": "mirzapurnandi"
}
```

### Login
| POST | Login | http://send-mail.test/index.php/login |
| ------ | ------ | ------ | 
```sh
body {
    "email": "testing4@gmail.com",
    "password": "password"
}
```

### Profile
| GET | Profile | http://send-mail.test/index.php/me |
| ------ | ------ | ------ | 
```sh
header {
    "Authorization": "Bearer <token>"
}
```
