<?php
    include './connect.php'
?>

<?php
    session_start();
    if (!isset($_SESSION['is_login'])) {
        header('Location: ./login.php');
        return;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm</title>
    <style>
        form.form {
            display: table;
        }
        .row {
            display: table-row;
        }

        label,
        input {
            display: table-cell;
            margin-bottom: 10px;
        }

        label {
            padding-right: 10px;
        }
    </style>
</head>
<body>
    <form class="form" action="#" method="post">
        <div class="row">
            <label for="tieude">Tiêu đề:</label>
            <textarea type="text" name="tieude"></textarea>
        </div>
        <div class="row">
            <label for="noidung">Nội dung:</label>
            <textarea type="text" name="noidung"></textarea>
        </div>
        <div class="row">
            <label for="danhmuc">Danh mục:</label>
            <select name="danhmuc">
                <?php
                    $result = $connect->query('SELECT * FROM danhmuc');
                    while ($row = $result->fetch_array()) {
                ?>
                <option value="<?php echo $row['id'] ?>"><?php echo $row['ten_danh_muc'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="row">
            <button type="submit">Thêm</button>
        </div>
    </form>

    <?php
        if (isset($_POST['tieude']) && isset($_POST['noidung']) && isset($_POST['danhmuc'])) {
            $sql = sprintf("INSERT INTO `tintuc`(`tieu_de`, `noi_dung`, `danh_muc_id`) VALUES ('%s','%s','%s')", $_POST['tieude'], $_POST['noidung'], $_POST['danhmuc']);
            $result = $connect->query($sql);
            if ($result) {
                echo 'Thêm thành công';
            } else {
                echo 'Thêm thất bại';
            }
        }
    ?>
</body>
</html>

<?php $connect->close(); ?>