<?php
// Veritabanı bağlantısı için gerekli bilgileri ekleyin
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jobs";

try {
    // PDO kullanarak veritabanı bağlantısını oluştur
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Veritabanından iletişim bilgilerini çek
    $stmt = $conn->prepare("SELECT * FROM contact_info LIMIT 1");
    $stmt->execute();
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>


<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <ul class="social-icons">
                    <li><a href="<?php echo $contact['facebook_link']; ?>"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="<?php echo $contact['twitter_link']; ?>"><i class="fab fa-twitter"></i></a></li>
                    <li><a href="<?php echo $contact['linkedin_link']; ?>"><i class="fab fa-linkedin-in"></i></a></li>
                </ul>
            </div>
            <div class="col-lg-12">
                <div class="copyright-text">
                    <p>
                        Copyright © 2024 Company Name
                        | Template by: <a href="https://www.yusufatakanozmen.com/">Yusuf Atakan Özmen</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>