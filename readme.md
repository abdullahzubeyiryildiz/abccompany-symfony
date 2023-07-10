# ABC Company Restful Coding Challenge

Symfony 5 interview projesidir. Müşteriler, bu servisler aracılığıyla sipariş oluşturabilir, siparişlerini güncelleyebilir ve görüntüleyebilir.
 
### Bilgisayarda Olması Gerekenler

Bu projenin çalışması için aşağıdaki yazılımların yüklü olması gerekmektedir:

- PHP 7.4 veya üzeri
- Composer
- Symfony CLI
- MySQL veritabanı
- Phpmyadmin

### Kurulum

1. Projeyi klonlayın:

   ```bash
   git clone https://github.com/abdullahzubeyiryildiz/abccompany-symfony.git

2. Proje klasörüne gidin ve .env dosyalarını ayarlayın:

   ```bash
   cd abc-company
   cp .env.example .env
   cp .env.test.example .env.test
   
   #env DATABASE_URL , DATABASE_URL_SECOND ve env.test deki DATABASE_URL alanlarını aşağıdaki örnek ile
   mysql://{kullaniciadi}:{sifre}@127.0.0.1:3306/abccompany_test
   #Kendi Phpmyadmin bilgileriniz ile güncelleyin

3. Symfony paketlerini kurun:

   ```bash 
   composer install  
4. Veritabanını terminalden kurun:

   ```bash 
   php bin/console doctrine:database:drop --force 
   php bin/console doctrine:database:create  
   php bin/console doctrine:migrations:migrate 
5. UnitTest için test veritabanını kurun: 
   ```bash 
   ### UnitTest Test Veritabanı Kur
   php bin/phpunit --env=test
   php bin/console doctrine:database:drop --force --env=test
   php bin/console doctrine:database:create --env=test
   php bin/console doctrine:migrations:migrate --env=test
   php bin/console doctrine:fixtures:load --env=test  
6. Sahte dataları yükleyin:

   ```bash 
   php bin/console doctrine:fixtures:load
7. JWT token için anahtar oluşturun:

   ```bash 
   cd/config
   mkdir jwt
   cd jwt
   openssl genpkey -algorithm RSA -out private.pem -pkeyopt rsa_keygen_bits:2048
   openssl rsa -pubout -in private.pem -out public.pem 
8. Postman Collection Import Dosyasını yükleyin:

   ```bash  
   Postman Giriş yapıp Import kısmından
   posman-collection klasör içindeki abcompany.postman_collection.json dosyası import edilmeli. 

9. UnitTest çalıştırıp kontrol edin: 
   ```bash   

    .\vendor\bin\phpunit tests/Controller/LoginControllerTest.php
    .\vendor\bin\phpunit tests/Controller/OrderControllerTest.php

10. Projeyi Başlat: 
    ```bash   
    php -S 127.0.0.1:8888 -t public   
### Özellikler 
Bu projede aşağıdaki API endpointleri mevcuttur: 
#### AuthController

- `POST /api/register`: Yeni bir kullanıcı kaydeder. Kullanıcının e-posta adresini ve parolasını alır.
- `POST /api/login`: Kullanıcının giriş yapmasını sağlar. E-posta ve parola alır ve başarılı bir giriş durumunda bir JWT token döndürür.
- `GET /api/some-protected-route`: JWT token kullanarak korunan bir rotaya erişim sağlar.

#### OrderController

- `POST /api/orders`: Yeni bir sipariş oluşturur. JWT token gerektirir ve productId, quantity, address ve shippingDate alır.
  ```bash  
   { 
   "productId": 2,
   "quantity": 3,
   "address": "Adres",
   #"shippingDate": "2023-07-09"
   } 

- `PUT /api/orders/{order_no}`: Mevcut bir siparişi günceller. JWT token gerektirir ve gönderim tarihini alır. Sipariş zaten sevk edildiyse siparişi güncellemez.
   ```bash  
   { 
   "productId": 1,
   "quantity": 2,
   "address": "Adres yeni",
   "shippingDate": "2023-07-09"
   } 


- `GET /api/orders/{order_no}`: Belirtilen siparişi görüntüler. JWT token gerektirir.
- `GET /api/orders`: Tüm siparişleri görüntüler. JWT token gerektirir.
