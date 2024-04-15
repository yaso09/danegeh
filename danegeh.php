<?php

/**
 * Bu sınıf, JSON formatındaki verileri yönetmek için kullanılır.
 * @author Yasir Eymen KAYABAŞI <yasirator04@gmail.com>
 * @license LGPL-3.0
 * Github: https://github.com/yaso09/danegeh
 */

class Danegeh {
    public $title; // Danegeh nesnesinin başlığı
    public $src; // Verilerin depolandığı JSON dosyası yolu
    private $data; // JSON verilerini içeren dizi
    public function __construct($title, $src) {
        $this->title = $title;
        $this->src = "$src.json";
        $data = json_decode(file_get_contents($this->src), true);
        if (isset($data)) $this->data = $data;
        else {
            // Eğer dosya bulunamazsa veya boşsa, varsayılan veri yapısı oluşturulur ve kaydedilir.
            $this->data = [
                "title"=> $this->title,
                "branches"=> [
                    "main" => [
                        "creationDate"=> new DateTime()
                    ]
                ]
            ];
            $this->push();
        }
    }

    /**
     * Belirli bir dalın özelliklerini ayarlamak için kullanılır
     * @param string $branch İşlem yapılacak dal adıdır.
     * @return callable İlgili özelliklere erişmek veya ayarlamak için bir işlev döndürür.
     */
    public function branch($branch) {
        $t = function (
            string $var, string | array $val = null, bool $save = false
        ) use ($branch) {
            if (isset($val)) {
                if (!isset($this->data["branches"][$branch])) {
                    $this->data["branches"][$branch]["creationDate"] =
                        new DateTime();
                }
                $this->data["branches"][$branch][$var] = $val;
            } else return
                $this->data["branches"][$branch][$var];
            if ($save) $this->push();
        };
        return $t;
    }

    /**
     * Bir dalı diğerine birleştirir
     * @param string $from Birleştirilecek dalın adıdır.
     * @param string $to Birleştirilen dalın adıdır.
     * @param bool $save Veriyi işlemden sonra dosyaya kaydedip kaydetmeme durumudur.
     */
    public function merge(
        string $from, string $to, bool $save = false, bool $afterdelete = true
    ) {
        $this->data["branches"][$from][$from."_mergeDate"] = new DateTime();
        $this->data["branches"][$to] = array_merge(
            $this->data["branches"][$to],
            $this->data["branches"][$from]
        );
        if ($afterdelete) unset($this->data["branches"][$from]);
        if ($save) $this->push();
    }

    /**
     * Danegeh nesnesini varsayılan durumuna sıfırlar
     */
    public function reset() {
        $this->data = [
            "title"=> $this->title,
            "branches"=> [
                "main"=> [
                    "creationDate"=> $this->data["branches"]["main"]["creationDate"]
                ]
            ],
            "is_reset"=> true,
            "resetDate"=> new DateTime()
        ];
        $this->push();
    }

    /**
     * JSON formatındaki verileri döndürür.
     * @return array JSON verilerini içeren dizidir.
     */
    public function getJSONData() {
        return $this->data;
    }
    public function getCommitHistory() {}

    /**
     * Verileri JSON dosyasına kaydeder.
     * @return array Kaydetme işleminin başarılı olup olmadığını gösteren bir dizidir.
     */
    public function push() {
        // file_put_contents($this->src, json_encode($this->data));
        $logs = [];
        $file = fopen($this->src, "w"); $i = 0;
        while ($i == 0) {
            if (flock($file, LOCK_EX)) {
                fwrite($file, json_encode($this->data));
                flock($file, LOCK_UN);
                $i = 1;
                array_push($logs, true);
            } else array_push($logs, false);
        }
        return $logs;
    }

    /**
     * JSON dosyasındaki güncel verileri çeker.
     */
    public function pull() {
        $data = json_decode(file_get_contents($this->src), true);
        if (isset($data)) $this->data = $data;
        else {
            $this->data = [
                "title"=> $this->title,
                "branches"=> [
                    "main"=> [
                        "creationDate"=> new DateTime()
                    ]
                ]
            ];
            $this->push();
        }
    }
}



