<?php
session_start();
// Page Title
$page_title = 'New Bookmark';
// Include Database
include '../../include/database.php';

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['user_id'])) {
    // Если нет, то перенаправляем на страницу авторизации
    header('Location:/login.php');
    exit;
}

// Check POST Request Parameters
if(isset($_POST['bookmark_submit'])) {
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
        // Insert New Bookmark
        $query = 'INSERT INTO bookmarks(bookmark_name, bookmark_order, user_id) VALUE (:bookmark_name, :bookmark_order, :user_id)';
        $stmt = $db->prepare($query);
        $stmt->execute([
                         'bookmark_name'  => $_POST['bookmark_name'],
                         'bookmark_order' => $_POST['last_bookmark_order'] + 1,
                         'user_id'        => $_SESSION['user_id'] 
                       ]);
        // Redirect To Bookmarks Page
        header('Location:/admin/bookmarks/index.php');
        exit();
    }
}

// Include Header
include '../../include/header.php';
// Include Navbar
include '../../include/navbar.php';

?>
<!-- Start Content -->
<div class="container">
    <div class="content-body">
        <h3>Добавить новую закладку</h3>
        <?php
        // Get Last Bookmark Order
        $stmt = $db->query('SELECT bookmark_order FROM bookmarks WHERE bookmark_column = 1 AND user_id = ' . $_SESSION['user_id'] . ' ORDER BY bookmark_order DESC LIMIT 1');
        $lastBookmarkOrder = $stmt->fetch();
        ?>
        <!-- New Bookmark Form -->
        <form class="mt-5" action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="form-group mb-3 alerts">
                <?= isset($alert) ? $alert : ''; ?>
            </div>
            <div class="form-group mb-4">
                <label for="bookmark_name">Имя закладки</label>
                <input type="text" name="bookmark_name" class="form-control" id="bookmark_name">
                <input type="hidden" name="last_bookmark_order" value="<?= $lastBookmarkOrder['bookmark_order']; ?>">
            </div>
            <input type="submit" value="Добавить" name="bookmark_submit" class="btn btn-primary">
        </form>
    </div>
</div>
<!-- End Content -->
<?php
// Include Footer
include '../../include/footer.php';
?>