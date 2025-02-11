<?php
session_start();

// Проверка авторизации
if (!isset($_SESSION["user_id"])) {
    header("Location: /index-login.php");
    exit;
}

// Page Title
$page_title = 'Bookmarks';

// Include Database
include '../../include/database.php';

// Include Header
include '../../include/header.php';

// Include Navbar
include '../../include/navbar.php';

// Get Bookmarks Data
$stmt = $db->prepare('SELECT * FROM bookmarks WHERE user_id = :user_id ORDER BY bookmark_id DESC');
$stmt->execute(['user_id' => $_SESSION['user_id']]); 
$bookmarks = $stmt->fetchAll();
?>
<!-- Start Content -->
<div class="container">
  <div class="content-body">
    <h3>Закладки</h3>
    <!-- Add New Button -->
    <a class="btn btn-primary my-5" href="/admin/bookmarks/create.php">
      <i class="fas fa-bookmark mr-2"></i>
      Добавить новую закладку
    </a>
    <!-- Bookmarks Table -->
    <div class="table-responsive">
      <table class="table table-bordered dataTable">
        <thead>
          <tr>
            <th>#</th>
            <th>Название</th>
            <th>Ссылка</th>
            <th>Управление</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Virtual Index
          $virtualIndex = 0;
          // Loop Through All Bookmarks
          foreach($bookmarks as $bookmark) {
            // Get Number Of Links Related To Current Bookmark
            $query = 'SELECT link_id FROM links WHERE bookmark_id = :bookmark AND user_id = :user_id'; // Добавьте user_id в запрос
            $stmt = $db->prepare($query);
            $stmt->execute(['bookmark' => $bookmark['bookmark_id'], 'user_id' => $_SESSION['user_id']]);
            $linksNumber = $stmt->rowCount();

            ?>
            <tr>
              <td><?= ++$virtualIndex; ?></td>
              <td><?= $bookmark['bookmark_name']; ?></td>
              <td><?= $linksNumber; ?></td>
              <td class="control">
                <a class="mr-3" href="/admin/bookmarks/update.php?id=<?= $bookmark['bookmark_id']; ?>">
                  <i class="fa fa-edit"></i>
                </a>
                <a href="/admin/bookmarks/delete.php?id=<?= $bookmark['bookmark_id']; ?>">
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