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

## WORKER
Ketika menggunakan Redis, maka dibutuhkan file worker untuk menjalankan key di redis yang masih tersimpan. di dalam folder ini sudah disediakan sebuah file worker.php, untuk menjalankannya harus menggunakan command dengan perintah berikut:
```sh
php worker.php
```
jika ingin melakukannya secara realtime maka di butuhkan aplikasi seperti Supervisor atau systemd yang dapat berjalan di background process yang berkelanjutan.

## HASIL PENGERJAAN
- proses Register
  ![register](https://user-images.githubusercontent.com/49771487/215573407-f5bb2c81-53c0-41bc-bf7d-3f0af3c1d359.png)

- proses Login
  ![login](https://user-images.githubusercontent.com/49771487/215573391-a2cd8985-091d-422d-8991-11330cc279e3.png)

- proses Profile
  ![profile](https://user-images.githubusercontent.com/49771487/215573399-aa01a8a2-b542-4fff-b867-e10983a38685.png)

- Hasil Queue/Antrian di redis
  ![redis_queue](https://user-images.githubusercontent.com/49771487/215573403-886beb7e-6dff-4ec9-800f-04cbd217175b.png)

## License
MIT
**regard, mirza**
