# Danegeh
N'olduğunu tam olarak bende bilmiyorum ama işimi gören bir sınıf.
Bu sınıf üzerine çok sarmak istemediğim için kılavuzu Türkçe yazıp geçiyorum.
Eğer vakti olan varsa pull request atabilir.

## Kullanımı
Kodu içeri aktarın:
```php
<?php

require "./danegeh.php";

```

Sınıfı çağırın(?):
```php
(...)
$deneme = new Danegeh("deneme", "veri");
(...)
```

Burada `deneme`, dosyanın başlığı (`title`) ve `veri`, dosyanın adı oluyor.
Burada, `veri.json` dosyası kullanılıyor. Kendinizin `veri.json` dosyanızı oluşturmasına
gerek yok. Dosyayı kendisi oluşturur. Ancak klasör içinde olacaksa, klasörleri kendiniz
oluşturmanız gerekir.

```php
(...)
$main = $deneme->branch("main");
$verilerim = $deneme->branch("verilerim");
(...)
```

Burada ana dalı ve `verilerim` dalını değişkenlere kaydettik.

```php
(...)
$verilerim("anahtarım", "değerim");
(...)
```

Burada `verilerim` dalı içine `anahtarım` diye bir anahtar oluşturup, `değerim`
değerini veriyoruz.

```php
(...)
$deneme->push();
(...)
```

Burada değişiklikleri `veri.json` dosyasına kaydediyoruz.

```php
(...)
$deneme->pull();
(...)
```

Burada `veri.json` dosyasını çekiyoruz. Bu sayede başka bir istek üzerine dosyanın
değişmiş olma ihtimaline karşın üzerinde çalıştığımız kodu yeniliyoruz.

**Örnek bir program `deneme.php` dosyasında mevcut**

