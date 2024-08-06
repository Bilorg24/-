<?php
session_start();

// Page Title
$page_title = 'New Link';

// Include Database
include '../../include/database.php';

// Проверка авторизации
if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}

// Получение закладок текущего пользователя
$stmt = $db->prepare('SELECT * FROM bookmarks WHERE user_id = :user_id ORDER BY bookmark_id DESC');
$stmt->execute(['user_id' => $_SESSION['user_id']]); 
$bookmarks = $stmt->fetchAll();

if(isset($_POST['link_submit'])) {
  // ... (Your validation code) ...
    // Move Image To Favicons Directory
    move_uploaded_file($_FILES['link_image']['tmp_name'], '../../favicons/' . $_FILES['link_image']['name']);
    // Insert Links
    $query = 'INSERT INTO links(bookmark_id, link_name, link_href, link_image, user_id) VALUE (:bookmark_id, :link_name, :link_href, :link_image, :user_id)';
    $stmt = $db->prepare($query);
    $stmt->execute([
                     'bookmark_id' => $_POST['link_bookmark'],
                     'link_name'   => $_POST['link_name'],
                     'link_href'   => $_POST['link_href'],
                     'link_image'  => $_FILES['link_image']['name'],
                     'user_id'     => $_SESSION['user_id'] 
                   ]);
    // Redirect To Links Page
    header('Location: /admin/links');
    exit();
  // ... (Your other code) ... 
}

// Include Header
include '../../include/header.php';

// Include Navbar
include '../../include/navbar.php';

?>
<div class="container">
  <div class="content-body">
    <h3>Создать новую ссылку</h3>
    <!-- New Bookmark Form -->
    <form class="mt-5" action="<?= $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
      <div class="form-group mb-3 alerts">
        <?= isset($alert) ? $alert : ''; ?>
      </div>
      <div class="form-group mb-4">
        <label for="link_name">Название</label>
        <input type="text" name="link_name" class="form-control" id="link_name">
      </div>
      <div class="form-group mb-4">
        <label for="link_href">Ссылка</label>
        <input type="text" name="link_href" class="form-control" id="link_href">
      </div>
      <div class="form-group mb-4">
        <label for="link_image">Изображение</label>
        <input type="file" name="link_image" class="form-control" id="link_image">
      </div>
      <div class="form-group mb-4">
        <label for="link_bookmark">Закладка</label>
        <select class="form-control" name="link_bookmark" id="link_bookmark">
          <?php
          // Loop Through All Bookmarks
          foreach($bookmarks as $bookmark) {
            ?>
            <option value="<?= $bookmark['bookmark_id']; ?>"><?= $bookmark['bookmark_name']; ?></option>
            <?php
          }
          ?>
        </select>
      </div>
      <input type="submit" value="Добавить" name="link_submit" class="btn btn-primary">
    </form>
  </div>
</div>
<?php
include '../../include/footer.php';
?>