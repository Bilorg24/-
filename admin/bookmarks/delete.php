<?php
session_start();
// Page Title
$page_title = 'Delete Bookmark';

// Include Database
include '../../include/database.php';

// Get GET Request ID
if($_SERVER['REQUEST_METHOD'] === 'GET') {
  if(isset($_GET['id']) && !empty($_GET['id'])) {
    // Get Bookmark Of This ID
    $query = 'SELECT * FROM bookmarks WHERE bookmark_id = :bookmark_id';
    $stmt = $db->prepare($query);
    $stmt->execute(['bookmark_id' => $_GET['id']]);
    $bookmark = $stmt->fetch();
    // If ID Exists
    if(!$bookmark) {
      // Redirect To Bookmarks Page
      header('location: /admin/bookmarks');
      exit();
    }
  } else {
    // Redirect To Bookmarks Page
    header('location: /admin/bookmarks');
    exit();
  }
}

// Check POST Request
if(isset($_POST['delete'])) {
  // Delete All Links Related To This bookmark
  $query = 'DELETE FROM links WHERE bookmark_id = :bookmark_id';
  $stmt = $db->prepare($query);
  $stmt->execute(['bookmark_id' => $_POST['bookmark_id']]);

  // Delete Bookmark
  $query = 'DELETE FROM bookmarks WHERE bookmark_id = :bookmark_id';
  $stmt = $db->prepare($query);
  $stmt->execute(['bookmark_id' => $_POST['bookmark_id']]);

  // Redirect To Bookmarks Page
  header('location: /admin/bookmarks');
  exit();
}

// Include Header AFTER redirect
include '../../include/header.php';
// Include Navbar
include '../../include/navbar.php';

?>

<!-- Start Content -->
<div class="container">
  <div class="content-body">
    <h3>Удалить закладку</h3>
    <!-- New Bookmark Form -->
    <form class="mt-5" action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
      <div class="form-group mb-3 alerts">
        <div class="alert alert-danger alert-dismissible fade in show">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          Если вы удалите эту закладку, все ссылки, связанные с ней, также будут удалены. Вы уверены, что удалите эту закладку?
        </div>
      </div>
      <div class="form-group mb-4">
        <label for="bookmark_name">Имя закладки</label>
        <input type="text"
               name="bookmark_name"
               class="form-control"
               id="bookmark_name"
               value="<?= $bookmark['bookmark_name']; ?>"
               disabled>
      </div>
      <input type="hidden" name="bookmark_id" value="<?= $bookmark['bookmark_id']; ?>">
      <a class="btn btn-primary mr-3" href="/admin/bookmarks">Отмена</a>
      <input type="submit" value="Удалить" name="delete" class="btn btn-danger">
    </form>
  </div>
</div>
<!-- End Content -->

<?php

// Include Footer
include '../../include/footer.php';

?>