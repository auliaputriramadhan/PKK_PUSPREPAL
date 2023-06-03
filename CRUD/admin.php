<?php 

    ini_set('display_errors', 1);
    include_once ('./master/header.php');

    require_once('./DataController.php');
    $dataCtrl = new DataController;
    $posts = $dataCtrl->posts();

?>
<!DOCTYPE html>
<!-- Coding by CodingNepal | www.codingnepalweb.com -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title> Admin Page</title>
    <link rel="stylesheet" href="style.css">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>

<div class="row py-4">
        <div class="col-xl-5 col-xl-5 col-md-5 col-sm-12 col-12 offset-xl-3 offset-lg-3">
            <?php echo isset($_SESSION['response'])?
                ($_SESSION['response']['status'] == "success" ? '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times; </button>
                '.$_SESSION['response']['message'].'</div>' :
                 '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times; </button>
                '.$_SESSION['response']['message'].'</div>'):''?>

            <?php session_unset(); ?>
        </div>
  <!-- NABAR -->
  <div class="sidebar">
    <div class="logo-details">
      <i class='bx bxl-c-plus-plus'></i>
      <span class="logo_name">PUSPREPAL</span>
    </div>
      <ul class="nav-links">
        <li>
          <a href="#" class="active">
            <i class='bx bx-grid-alt' ></i>
            <span class="links_name">Dashboard</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class='bx bx-user' ></i>
            <span class="links_name"> Data Admin</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class='bx bx-list-ul' ></i>
            <span class="links_name">Kategori</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class='bx bx-trophy' ></i>
            <span class="links_name">Prestasi</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class='bx bx-cog' ></i>
            <span class="links_name">Setting</span>
          </a>
        </li>
        <li class="log_out">
          <a href="#">
            <i class='bx bx-log-out'></i>
            <span class="links_name">Log out</span>
          </a>
        </li>
      </ul>
  </div>
  <section class="home-section">
    <nav>
      <div class="sidebar-button">
        <i class='bx bx-menu sidebarBtn'></i>
        <span class="dashboard">Dashboard</span>
      </div>
      <div class="search-box">
        <input type="text" placeholder="Search...">
        <i class='bx bx-search' ></i>


      </div>
    </nav>
<!-- end NAVBAR -->
    <div class="home-content">
      <div class="sales-boxes">
        <div class="recent-sales box">
           <div class="col-xl-4 col-lg-4 col-md-4  text-right">
            <a href="create.php" class="btn btn-primary "> Create Post </a>
        </div>
    </div>

    <div class="table-responsive py-4">
        <table class="table table-striped">
            <thead class="bg-secondary text-white">
                <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th style="width:16%">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if(count($posts) > 0):
                        foreach($posts as $post):?>
                            <tr>
                                <td> <?= $post['id']; ?> </td>
                                <td> <?= stripslashes($post['title']); ?> </td>
                                <td> <?= stripslashes($post['description']); ?> </td>
                                <td> <?= $post['created_at']; ?> </td>
                                <td> <a href="show.php?post=<?= $post['id']; ?>" name="show" class="btn btn-info btn-sm">View</a>
                                    <a href="edit.php?post=<?= $post['id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                    <a href="DataController.php?delete=<?= $post['id'];?>" class="btn btn-danger btn-sm" onclick="return confirm('Do you want delete this record?');">Delete</a>
                                </td>
                            </tr>
               
                <?php
                        endforeach;
                    else: ?>
                        <tr>
                            <td colspan="5" rowspan="2">
                                <h5 class="text-danger text-center"> Sorry! No post found. </h5>
                            </td>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
        </div>
      </div>
    </div>
  </section>

  <script>
   let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".sidebarBtn");
sidebarBtn.onclick = function() {
  sidebar.classList.toggle("active");
  if(sidebar.classList.contains("active")){
  sidebarBtn.classList.replace("bx-menu" ,"bx-menu-alt-right");
}else
  sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
}
 </script>

</body>
</html>
<?php 
    include_once ('./master/footer.php');
?>