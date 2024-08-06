<?php
// Start output buffering (optional but recommended)
ob_start();

// Page Title
$page_title = 'Delete Link';

// Include Database
include '../../include/database.php';

// Handle GET Request (check if ID is valid and exists)
if($_SERVER['REQUEST_METHOD'] === 'GET') {
  if(isset($_GET['id']) && !empty($_GET['id'])) {
    // Get Link Of This ID
    $query = 'SELECT * FROM links WHERE link_id = :link_id';
    $stmt = $db->prepare($query);
    $stmt->execute(['link_id' => $_GET['id']]);
    $link = $stmt->fetch();

    // If ID doesn't exist, redirect to Links Page
    if(!$link) {
      header('location: /admin/links');
      exit();
    }
  } else {
    // Redirect To Links Page
    header('location: /admin/links');
    exit();
  }
}

// Handle POST Request (delete link)
if(isset($_POST['delete'])) {
  // Delete All Links Related To This bookmark
  $query = 'DELETE FROM links WHERE link_id = :link_id';
  $stmt = $db->prepare($query);
  $stmt->execute(['link_id' => $_POST['link_id']]);

  // Redirect To Bookmarks Page
  header('location: /admin/links');
  exit();
}

// Include Header
include '../../include/header.php';

// Include Navbar
include '../../include/navbar.php';

?>
<!-- Start Content -->
<div class="container">
  <div class="content-body">
    <h3>Удалить ссылку</h3>
    <!-- Delete Link Form -->
    <form class="mt-5" action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
      <div class="form-group mb-3 alerts">
        <div class="alert alert-danger alert-dismissible fade in show">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          Вы уверены, что удалите эту ссылку?
        </div>
      </div>
      <div class="form-group mb-4">
        <label for="link_name">Название</label>
        <input type="text"
               name="link_name"
               class="form-control"
               id="link_name"
               value="<?= $link['link_name']; ?>"
               disabled>
      </div>
      <div class="form-group mb-4">
        <label for="link_href">Ссылка</label>
        <input type="text"
               name="link_href"
               class="form-control"
               id="link_href"
               value="<?= $link['link_href']; ?>"
               disabled>
      </div>
      <div class="form-group mb-4">
        <label>Изображение</label>
        <div class="img" style="max-width: 50px">
          <img class="img-fluid" src="/favicons/<?= $link['link_image']; ?>" alt="">
        </div>
      </div>
      <input type="hidden" name="link_id" value="<?= $link['link_id']; ?>">
      <a class="btn btn-primary mr-3" href="/admin/bookmarks">Отмена</a>
      <input type="submit" value="Удалить" name="delete" class="btn btn-danger">
    </form>
  </div>
</div>
<!-- End Content -->
<?php
// Include Footer
include '../../include/footer.php';

// Send all buffered output (if using output buffering)
ob_end_flush();
?>