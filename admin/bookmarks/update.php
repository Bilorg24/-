<?php
session_start();
// Page Title
$page_title = 'Edit Bookmark';

// Include Database
include '../../include/database.php';

// Handle GET Request (check if ID is valid and exists)
if($_SERVER['REQUEST_METHOD'] === 'GET') {
  if(isset($_GET['id'])) {
    // Get Bookmark Of This ID
    $query = 'SELECT * FROM bookmarks WHERE bookmark_id = :bookmark_id';
    $stmt = $db->prepare($query);
    $stmt->execute(['bookmark_id' => $_GET['id']]);
    $bookmark = $stmt->fetch();
    // Check If ID Exists
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

// Handle POST Request (update bookmark)
if(isset($_POST['bookmark_submit'])) {
  // Get Bookmark Of This ID
  $query = 'SELECT * FROM bookmarks WHERE bookmark_id = :bookmark_id';
  $stmt = $db->prepare($query);
  $stmt->execute(['bookmark_id' => $_POST['bookmark_id']]);
  $bookmark = $stmt->fetch();

  if(empty($_POST['bookmark_name'])) {
    // Check Name If Empty
    $alert = '<div class="alert alert-danger alert-dismissible fade in show">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                Название закладки не может быть пустым.
              </div>';
  } elseif(strlen($_POST['bookmark_name']) > 100) {
    // Check Name Length
    $alert = '<div class="alert alert-danger alert-dismissible fade in show">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                Имя закладки не может содержать более 100 символов.
              </div>';
  } else {
    // Insert Name
    $query = 'UPDATE bookmarks SET bookmark_name = :bookmark_name WHERE bookmark_id = :bookmark_id';
    $stmt = $db->prepare($query);
    $stmt->execute([
                     'bookmark_name' => $_POST['bookmark_name'],
                     'bookmark_id'   => $_POST['bookmark_id']
                   ]);
    // Redirect To Bookmarks Page
    header('Location: /admin/bookmarks');
    exit();
  }
}

// Include Header (move this after redirects)
include '../../include/header.php';

// Include Navbar (move this after redirects)
include '../../include/navbar.php';

?>
<!-- Start Content -->
<div class="container">
  <div class="content-body">
    <h3>Edit Bookmark</h3>
    <?php if(isset($alert)) echo $alert; ?>
    <!-- Edit Bookmark Form -->
    <form class="mt-5" action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
      <div class="form-group mb-4">
        <label for="bookmark_name">Bookmark Name</label>
        <input type="text"
               name="bookmark_name"
               class="form-control"
               id="bookmark_name"
               value="<?= $bookmark['bookmark_name']; ?>">
      </div>
      <input type="hidden" name="bookmark_id" value="<?= $bookmark['bookmark_id']; ?>">
      <a class="btn btn-primary mr-3" href="/admin/bookmarks">Cancel</a>
      <input type="submit" value="Save" name="bookmark_submit" class="btn btn-primary">
    </form>
  </div>
</div>
<!-- End Content -->
<?php
// Include Footer
include '../../include/footer.php';
?>

<!-- Start Content -->
<div class="container">
  <div class="content-body">
    <h3>Обновить закладку</h3>
    <!-- New Bookmark Form -->
    <form class="mt-5" action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
      <div class="form-group mb-3 alerts">
        <?= isset($alert) ? $alert : ''; ?>
      </div>
      <div class="form-group mb-4">
        <label for="bookmark_name">Имя закладки</label>
        <input type="text"
               name="bookmark_name"
               class="form-control"
               id="bookmark_name"
               value="<?= $bookmark['bookmark_name']; ?>">
        <input type="hidden" name="bookmark_id" value="<?= $bookmark['bookmark_id']; ?>">
      </div>
      <input type="submit" value="Обновить" name="bookmark_submit" class="btn btn-primary">
    </form>
  </div>
</div>
<!-- End Content -->

<?php

// Include Footer
include '../../include/footer.php';

?>

