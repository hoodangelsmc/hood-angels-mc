<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["photo"])) {
    $title = $_POST["title"];
    $date = $_POST["date"];
    $target_dir = "../assets/";
    
    // Dosya adını temizle ve benzersiz yap
    $file_ext = strtolower(pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION));
    $new_filename = "upload_" . time() . "." . $file_ext;
    $target_file = $target_dir . $new_filename;

    // Kontroller
    $uploadOk = 1;
    $check = getimagesize($_FILES["photo"]["tmp_name"]);
    if($check === false) {
        $message = "Dosya bir resim değil.";
        $messageType = "error";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            // JSON verisini güncelle
            $json_file = "../assets/gallery_data.json";
            $data = json_decode(file_get_contents($json_file), true);
            
            $new_entry = [
                "src" => "assets/" . $new_filename,
                "title" => $title,
                "date" => $date
            ];
            
            // En başa ekle (yeni fotoğraflar en üstte görünsün)
            array_unshift($data, $new_entry);
            
            if (file_put_contents($json_file, json_encode($data, JSON_PRETTY_PRINT))) {
                $message = "Fotoğraf başarıyla yüklendi ve galeriye eklendi.";
                $messageType = "success";
            } else {
                $message = "JSON güncellenirken hata oluştu.";
                $messageType = "error";
            }
        } else {
            $message = "Dosya yüklenirken bir hata oluştu.";
            $messageType = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Scorpion MC</title>
    <link rel="stylesheet" href="../assets/mobile.css">
    <link rel="stylesheet" href="../assets/animations.css">
    <style>
        body {
            background-color: #000;
            color: #fff;
            font-family: 'Inter', sans-serif;
            padding: 4rem 2rem;
        }
        .container-small {
            max-width: 600px;
            margin: 0 auto;
        }
        h1 {
            font-family: 'Hessian', serif;
            font-size: 3rem;
            margin-bottom: 3rem;
            text-align: center;
            letter-spacing: 5px;
        }
        .form-card {
            padding: 3rem;
            border: 1px solid rgba(255,255,255,0.05);
        }
        .form-group {
            margin-bottom: 2rem;
        }
        label {
            display: block;
            color: #888;
            margin-bottom: 0.8rem;
            font-size: 0.9rem;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        input, select {
            width: 100%;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            padding: 1.2rem;
            color: #fff;
            font-family: inherit;
            outline: none;
            transition: all 0.3s ease;
        }
        input:focus {
            border-color: #fff;
        }
        .btn-submit {
            width: 100%;
            margin-top: 1rem;
            cursor: pointer;
        }
        .alert {
            padding: 1.5rem;
            margin-bottom: 2rem;
            border-radius: 4px;
            text-align: center;
        }
        .alert-success { background: rgba(0, 255, 0, 0.1); color: #00ff00; border: 1px solid rgba(0, 255, 0, 0.2); }
        .alert-error { background: rgba(255, 0, 0, 0.1); color: #ff0000; border: 1px solid rgba(255, 0, 0, 0.2); }
        
        .nav-admin {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 4rem;
        }
        .logout-link {
            color: #888;
            text-decoration: none;
            font-size: 0.9rem;
            letter-spacing: 2px;
            transition: color 0.3s ease;
        }
        .logout-link:hover { color: #fff; }
    </style>
</head>
<body>
    <div class="container-small">
        <div class="nav-admin">
            <a href="../galeri.html" class="logout-link">← GALERİYE DÖN</a>
            <a href="logout.php" class="logout-link">ÇIKIŞ YAP</a>
        </div>

        <h1>FOTOĞRAF EKLE</h1>

        <?php if ($message): ?>
            <div class="alert alert-<?php echo $messageType; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="glass-card form-card reveal visible">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="photo">Fotoğraf Seç</label>
                    <input type="file" id="photo" name="photo" accept="image/*" required>
                </div>
                <div class="form-group">
                    <label for="title">Başlık (Hessian Font)</label>
                    <input type="text" id="title" name="title" placeholder="Örn: Kulüp Gecesi" required>
                </div>
                <div class="form-group">
                    <label for="date">Tarih</label>
                    <input type="date" id="date" name="date" value="<?php echo date('Y-m-d'); ?>" required>
                </div>
                <button type="submit" class="btn-primary btn-submit">YÜKLE VE YAYINLA</button>
            </form>
        </div>
    </div>
    <script src="../assets/animations.js" defer></script>
</body>
</html>
