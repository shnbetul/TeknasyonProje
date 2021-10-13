# Teknasyon Bootcamp Docker

## Build & Run

```bash
$ cp .env.example .env
$ docker-compose up
```

## Test

- [http://localhost/index.php](http://localhost)
- [http://localhost/info.php](http://localhost/info.php)
- [http://localhost/permission.php](http://localhost/permission.php)
- [phpmyadmin](http://localhost:8081)
- [adminer](http://localhost:8082)

## MariaDB

- Server: `mariadb`
- Username: `root`
- Password: `root`

## NOT 
- Docker ortamını kendim yapmadım.ERAY Hocanın hazırlayıp bize verdiği ortam.

## Kullanıcılar
- name: papatya
  email: papatya@gmail.com
  password: 123
  role: moderatör

- name:numan
  email:ultraaslan@hotmail.com
  password:123456
  role:editör

- name:kullanici
  email:kullanici@gmail.com
  password:987
  role:kullanıcı

- name:kullanici1
  email:kullanici1@gmail.com
  password:987
  role:kullanıcı

- name:kullanıcı
  email:kullanici2@gmail.com
  password:bilmiyorum
  role:kullanıcı

- name:betuş
  email:shn_betul_9506@hotamil.com
  password:1234567890
  role:admin

## Rotaların POSTMAN çıktısı
- resources dosyası içinde

## LOG kayıtları
- File ve Database olarak iki yolla yapıldı
- File: storage/logs içinde
