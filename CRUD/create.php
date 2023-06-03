index.php
<?php 

    ini_set('display_errors', 1);
    include_once ('./master/header.php');

    require_once('./DataController.php');
    $dataCtrl = new DataController;
    $posts = $dataCtrl->posts();

?>
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

<?php 
    include_once ('./master/footer.php');
?>