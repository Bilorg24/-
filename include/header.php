<!DOCTYPE html>
<html lang="ru">
<head>
  <!-- Start Meta -->
  <meta charset="utf-8" />
  <meta name="author" content="Bilorg" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- End Meta -->

  <!-- Start Title -->
  <title><?= isset($page_title) ? $page_title : 'Resources'; ?></title>
  <!-- End Title -->

  <!-- Start CSS -->
  <link rel="stylesheet" href="/css/bootstrap.min.css" />
  <link rel="stylesheet" href="/css/dataTables.bootstrap4.min.css" />
  <link rel="stylesheet" href="/css/font-awesome.css" />
  <link rel="stylesheet" href="/css/style.css" />
  <!-- End CSS -->

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="/img/favicon.png">
  <!-- Check Local Storage Color Mode -->
  <script>
    // Get Local Storage ITem
    let localstorageMode = localStorage.getItem("BookmarksManagerColorMode");
    // Check If Exist Or Not, Then Switch Colors
    null === localstorageMode
      ? document.documentElement.setAttribute("data-theme", "dark")
      : document.documentElement.setAttribute("data-theme", localstorageMode);
  </script>
</head>
<body>