<?php
session_start();

// Проверка авторизации
if (!isset($_SESSION["user_id"])) {
    header("Location: /index-login.php");
    exit;
}

// Page Title
$page_title = 'Links';

// Include Database
include '../../include/database.php';

// Include Header
include '../../include/header.php';

// Include Navbar
include '../../include/navbar.php';

// Get Links Data
$stmt = $db->prepare('SELECT * FROM links WHERE user_id = :user_id ORDER BY link_id DESC');
$stmt->execute(['user_id' => $_SESSION['user_id']]);
$links = $stmt->fetchAll();
?>
<!-- Start Content -->
<div class="container">
  <div class="content-body">
    <h3>Ссылки</h3>
    <!-- Add New Button -->
    <a class="btn btn-primary my-5" href="/admin/links/create.php">
      <i class="fas fa-link mr-2"></i>
      Создать новую ссылку
    </a>
    <!-- Links Table -->
    <div class="table-responsive">
      <table class="table table-bordered dataTable">
        <thead>
          <tr>
            <th>#</th>
            <th>Название</th>
            <th>Ссылка</th>
            <th>Изображение</th>
            <th>Закладка</th>
            <th>Управление</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Virtual Index
          $virtualIndex = 0;
          // Loop Through All Bookmarks
          foreach($links as $link) {
            // Get Number Of Links Related To Current Bookmark
            $query = 'SELECT bookmark_name FROM bookmarks WHERE bookmark_id = :bookmark AND user_id = :user_id'; // Добавьте user_id в запрос
            $stmt = $db->prepare($query);
            $stmt->execute(['bookmark' => $link['bookmark_id'], 'user_id' => $_SESSION['user_id']]);
            $bookmark = $stmt->fetch();
            ?>
            <tr>
              <td><?= ++$virtualIndex; ?></td>
              <td class="link-name"><?= $link['link_name']; ?></td>
              <td class="link-href">
                <a href="<?= $link['link_href']; ?>" target="_blank"><?= $link['link_href']; ?></a>
              </td>
              <td>
                <img src="/favicons/<?= $link['link_image']; ?>" alt="">
              </td>
              <td><?= $bookmark['bookmark_name']; ?></td>
              <td class="control">
                <a class="mr-3" href="/admin/links/update.php?id=<?= $link['link_id']; ?>">
                  <i class="fa fa-edit"></i>
                </a>
                <a href="/admin/links/delete.php?id=<?= $link['link_id']; ?>">
                  <i class="fa fa-trash"></i>
                </a>
              </td>
            </tr>
            <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- End Content -->
<?php
// Include Footer
include '../../include/footer.php';
?>