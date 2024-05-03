<?php
    include './connect.php';
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
        if (isset($_GET['id'])) {
            $result = $connect->query('SELECT * FROM tintuc WHERE id = ' . $_GET['id']);
            while ($row = $result->fetch_array()) {
    ?>
    <p><?php echo $row['noi_dung'] ?></p>
    <?php }} else { ?>
    <ol>
        <?php
            $result = $connect->query('SELECT * FROM danhmuc');
            while ($row = $result->fetch_array()) {
        ?>
        <li>
            <?php echo $row['ten_danh_muc'] ?>
            <?php
                $elm = $connect->query('SELECT * FROM tintuc WHERE danh_muc_id = ' . $row['id']);
                while ($elm_row = $elm->fetch_array()) {
            ?>
            <p><a href="?id=<?php echo $elm_row['id']?>"><?php echo $elm_row['tieu_de'] ?></a></p>
            <?php } ?>
        </li>
        <?php } ?>
    </ol>

    <?php } ?>
</body>

</html>

<?php $connect->close(); ?>