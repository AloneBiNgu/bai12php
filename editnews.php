<?php
    include './connect.php';
?>

<?php
    session_start();
    if (!isset($_SESSION['username'])) {
        header('Location: ./login.php');
        return;
    }
?>

<?php
    if (isset($_GET['id'])) {
        $result = $connect->query('SELECT * FROM tintuc WHERE id = ' . $_GET['id']);
        $db = array();
        while ($row = $result->fetch_assoc()) {
            $db[] = $row;
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($db);
        exit();
    }

    if (isset($_POST['id']) && isset($_POST['tieude']) && isset($_POST['noidung']) && isset($_POST['danhmuc'])) {
        $sql = sprintf("UPDATE `tintuc` SET `tieu_de`='%s',`noi_dung`='%s',`danh_muc_id`='%s' WHERE id=%s", $_POST['tieude'], $_POST['noidung'], $_POST['danhmuc'], $_POST['id']);
        $result = $connect->query($sql);

        $res = array();
        if ($result === true) {
            $res['ok'] = true;
        } else {
            $res['ok'] = false;
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($res);
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa</title>
    <style>
        form.form {
            display: table;
        }

        .row {
            display: table-row;
        }

        label,
        input,
        select {
            display: table-cell;
            margin-bottom: 10px;
        }

        label {
            padding-right: 10px;
        }
    </style>
</head>

<body>
    <form>
        <div class="row">
            <label for="tintuc">Tin tức:</label>
            <select onchange="tintuc_event(this.value)" name="tintuc">
                <?php
                    $result = $connect->query('SELECT * FROM tintuc');
                    while ($row = $result->fetch_array()) {
                ?>
                <option value="<?php echo $row['id'] ?>"><?php echo $row['tieu_de'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="row">
            <label for="tieude">Tiêu đề:</label>
            <textarea name="tieude"cols="30" rows="10"></textarea>
        </div>
        <div class="row">
            <label for="noidung">Nội dung:</label>
            <textarea name="noidung"cols="30" rows="10"></textarea>
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
            <button type="submit">Chỉnh sửa</button>
        </div>
    </form>
    <script>
        const tintuc = document.querySelector('select[name="tintuc"]');
        const tieude = document.querySelector('textarea[name="tieude"]');
        const noidung = document.querySelector('textarea[name="noidung"]');
        const danhmuc = document.querySelector('select[name="danhmuc"]');

        tintuc.selectedIndex = 0;
        const event = new Event('change');
        tintuc.dispatchEvent(event);

        function tintuc_event(id) {
            fetch('?id=' + id, {
                method: 'get'
            }).then(res => res.json().then(data => {
                tieude.value = data[0]['tieu_de'];
                noidung.value = data[0]['noi_dung'];
                danhmuc.value = data[0]['danh_muc_id'];
            }))
        }

        const btn = document.querySelector('button');
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const newF = new FormData();
            newF.append('id', tintuc.value);
            newF.append('tieude', tieude.value);
            newF.append('noidung', noidung.value);
            newF.append('danhmuc', danhmuc.value);

            fetch('#', {
                method: 'post',
                body: newF
            }).then(res => res.json().then(data => {
                if (data.ok == true) {
                    alert('Chỉnh sửa thành công');
                    window.location.reload();
                } else {
                    alert('Chỉnh sửa thất bại');
                    window.location.reload();
                }
            }))
        })
    </script>
</body>

</html>

<?php $connect->close(); ?>