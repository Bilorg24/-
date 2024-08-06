<?php
session_start();

// Проверка авторизации
if (!isset($_SESSION["user_id"])) {
    header("Location: index-login.php");
    exit;
}

// Home Page Indicator
$homepage = true;

// Include Database
include 'include/database.php';

// Include Header
include 'include/header.php';
// Include Navbar
include 'include/navbar.php';

?>

<!-- Start Layout Change Message -->
<div class="layout-message" id="layout-message"></div>
<!-- End Layout Change Message -->

<!-- Start Content -->
<div class="container">
  <div class="row content-body">
  <?php
session_start(); // Начните сессию

// ... (Ваши настройки подключения к БД)

// Получите ID пользователя из сессии
$userId = $_SESSION['user_id']; 

// Loop Through The 4 Columns
for ($j = 1; $j <= 4; $j++) {
  ?>
  <!-- Start Column <?= $j; ?> -->
  <div class="column col-md-6 col-xl-3" data-column="<?= $j; ?>">
    <?php
    // Get Bookmark Of This ID
    $query = 'SELECT * FROM bookmarks WHERE bookmark_column = :bookmark_column AND user_id = :user_id ORDER BY bookmark_order';
    $stmt = $db->prepare($query);
    $stmt->execute(['bookmark_column' => $j, 'user_id' => $userId]);
    $bookmarks = $stmt->fetchAll();

    // Loop Through All Bookmarks In Current Column
    foreach ($bookmarks as $bookmark) {
      ?>
      <div class="portlet bookmark"
           id="<?= $bookmark['bookmark_id']; ?>"
           data-order="<?= $bookmark['bookmark_order']; ?>">
        <div class="portlet-header header">
          <span class="name"><?= $bookmark['bookmark_name']; ?></span>
          <span class="toggle"><i class="fas fa-plus"></i></span>
        </div>
        <div class="portlet-content body">
          <?php
          // Get Links Data Related To Current Bookmark
          $query = 'SELECT * FROM links WHERE bookmark_id = :bookmark';
          $stmt = $db->prepare($query);
          $stmt->execute(['bookmark' => $bookmark['bookmark_id']]);
          $links = $stmt->fetchAll();

          // Loop Through All Links Related To This Bookmark
          foreach ($links as $link) {
            ?>
            <a href="<?= $link['link_href']; ?>" target="_blank">
              <img src="favicons/<?= $link['link_image']; ?>" />
              <span class="name"><?= $link['link_name']; ?></span>
            </a>
            <?php
          }
          ?>
        </div>
      </div>
      <?php
    }
    ?>
  </div>
  <!-- End Column <?= $j; ?> -->
  <?php
}
?>
  </div>
</div>
<!-- End Content -->


<?php
// Include Footer
include 'include/footer.php';
?>
