<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link rel="stylesheet" href="styles.css">

<!-- Bootstrap CSS (gerekli) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


    <!-- Sayfadaki tıklanır linklerin renklerini siyah yapar -->
    <style>
        .kategori-link {
            color: black !important;
        }
        .kategori-link:hover {
            color: #333 !important;
        }

        /* Breadcrumb okları için stil */
        .breadcrumb .breadcrumb-item + .breadcrumb-item::before {
            content: ">";
            color: #6c757d;
            padding: 0 6px;
        }
    </style>

        <style>
/* Breadcrumb çizgisi görünmesin, yan yana görünsün */
.breadcrumb {
    background-color: transparent !important;
    padding: 0;
    margin-bottom: 1rem;
    display: flex; /* DİKKAT: Bu satır önemli! */
    flex-wrap: wrap;
}

/* > işareti için */
.breadcrumb-item + .breadcrumb-item::before {
    content: ">";
    padding: 0 8px;
    color: #666;
}

/* Linkler */
.breadcrumb-item a {
    text-decoration: none;
    color: #000;
}

/* Aktif kategori */
.breadcrumb-item.active {
    color: #888;
}
</style>


</head>
</html>
