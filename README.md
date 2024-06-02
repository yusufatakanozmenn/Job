# Job Pursuit - People Box Bitirme Projesi

## Proje Hakkında

**Job Pursuit**, People Box şirketi için geliştirilen bitirme projem, bir iş yönetim ve iş başvuru takip sistemidir. Bu proje, kullanıcıların iş ilanlarını görüntülemesini, başvuru yapmasını ve yönetim ekibinin iş ilanlarını yönetmesini sağlar. Proje, yönetici, insan kaynakları (IK) ve çalışan rollerine göre farklı yetkilere sahip kullanıcıların giriş yapmasını ve sistemdeki görevlerini gerçekleştirmesini sağlar.

## Özellikler

- **Kullanıcı Girişi:** Farklı roller (admin, IK, employee) için giriş yapma imkanı.
- **İş Listesi:** Tüm iş ilanlarının listelendiği ve yönetildiği sayfa.
- **İş Başvuruları:** Kullanıcıların iş ilanlarına başvuru yapabilmesi ve başvuruların yönetilmesi.
- **Kullanıcı Yönetimi:** Yalnızca admin ve IK kullanıcıları tarafından erişilebilen kullanıcı listesi ve yönetimi.
- **Responsive Tasarım:** Mobil ve masaüstü cihazlar için uyumlu arayüz.

## Kurulum ve Kullanım

### Gereksinimler

- PHP 7.4 veya daha üstü
- MySQL 5.7 veya daha üstü
- Web sunucusu (Apache, Nginx vb.)

### Kurulum

1. Bu projeyi yerel makinenize veya sunucunuza klonlayın:

    ```bash
    git clone https://github.com/kullanici_adi/job-pursuit.git
    cd job-pursuit
    ```

2. Veritabanınızı oluşturun ve gerekli tabloları içe aktarın. `database.sql` dosyasını kullanarak veritabanını yapılandırabilirsiniz:

    ```sql
    CREATE DATABASE jobs;
    USE jobs;
    SOURCE path/to/database.sql;
    ```

3. `ayar.php` dosyasını veritabanı bağlantı bilgilerinize göre düzenleyin:

    ```php
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "jobs";

    $connection = new mysqli($servername, $username, $password, $dbname);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    ?>
    ```

4. Web sunucunuzu başlatın ve projeyi tarayıcınızda açın. Örneğin, `http://localhost/job-pursuit`.

### Kullanım

1. **Giriş Yap:** Ana sayfada kullanıcı adınızı ve şifrenizi girerek giriş yapın.
2. **İş Listesi:** Admin veya IK olarak giriş yaptığınızda, iş ilanlarını listeleyebilir, düzenleyebilir veya silebilirsiniz.
3. **İş Başvuruları:** Çalışan olarak giriş yaptığınızda, iş ilanlarına başvurabilirsiniz.
4. **Kullanıcı Yönetimi:** Yalnızca admin ve IK kullanıcıları, kullanıcı listesine erişebilir ve kullanıcıları yönetebilir.

## Dosya Yapısı

- `index.php`: Ana sayfa
- `login.php`: Kullanıcı giriş sayfası
- `profile.php`: Kullanıcı profil sayfası
- `jobs_list.php`: İş ilanları listesi
- `jobs_apply_list.php`: İş başvuruları listesi
- `user_list.php`: Kullanıcı listesi (Yalnızca admin ve IK için)
- `create_job.php`: Yeni iş ilanı oluşturma sayfası
- `edit_job.php`: İş ilanı düzenleme sayfası
- `delete_job.php`: İş ilanı silme sayfası
- `ayar.php`: Veritabanı bağlantı ayarları
- `assets/`: CSS, JS ve resim dosyaları

## Lisans

Bu proje MIT Lisansı altında lisanslanmıştır - daha fazla bilgi için `LICENSE` dosyasına bakın.
