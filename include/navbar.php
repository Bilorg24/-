<nav>
  <div class="container">
    <div class="row flex-column flex-sm-row align-items-center justify-content-between">
      <!-- Title -->
      <h2 class="m-0 mb-3 mb-sm-0">
        <a href="/">Resources</a>
      </h2>
      <!-- Options -->
      <div class="options">
        <span class="option" id="toggleColorMode" title="Toggle Dark / Light Mode">
           <i class="fas fa-adjust"></i>
        </span>
        <span id="collapseAll"
              class="option collapsed"
              title="Collapse / Expand All Lists" <?= isset($homepage) ? '' : 'style="display: none;"'; ?>>
          <i class="fas fa-plus-square"></i>
        </span>
        <span class="option" title="Bookmarks">
          <a href="/admin/bookmarks/">
           <i class="fas fa-bookmark"></i>
          </a>
        </span>
        <span class="option" title="Links">
          <a href="/admin/links/">
           <i class="fas fa-link"></i>
          </a>
        </span>
        <span class="option" title="Visit Github Repo">
          <a>
          <form action="/logout.php" method="post" style="display: inline-flex;">
            <button class="logout-button" type="submit">Выйти</button>
          </form>
          </a>
        </span>
      </div>
    </div>
  </div>
</nav>
<style>
  .logout-button {
    background-color: #f44336; 
    color: white;
    padding: 3px 11px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
  }

  .logout-button:hover {
    background-color: #d32f2f; 
  }
</style>
<!-- End Nav -->
