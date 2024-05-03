<?php
    include './connect.php';
?>

<?php
    session_start();
    if (!isset($_SESSION['is_login'])) {
        header('Location: ./login.php');
        return;
    }
?>

<?php
    if (isset($_POST['tintuc'])) {
        $result = $connect->query('DELETE FROM `tintuc` WHERE id=' . $_POST['tintuc']);

        $responseData = array();
        if ($result === true) {
            $responseData['ok'] = true;
        } else {
            $responseData['ok'] = false;
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($responseData);

        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xóa</title>
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
    <form>
        <div class="row">
            <label for="tintuc">Tin tức:</label>
            <select name="tintuc">
                <?php
                    $result = $connect->query('SELECT * FROM tintuc');
                    while ($row = $result->fetch_array()) {
                ?>
                <option value="<?php echo $row['id'] ?>"><?php echo $row['tieu_de'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="row">
            <button type="submit">Xóa</button>
        </div>
    </form>
    <script>
        const btn = document.querySelector('button');
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const sel = document.querySelector('select');
            const newF = new FormData();
            newF.append('tintuc', sel.value);
            fetch('#', {
                method: 'post',
                body: newF
            }).then(res => res.json().then(data => {
                if (data.ok == true) {
                    alert('Xóa thành công');
                    sel.remove(sel.selectedIndex);
                } else {
                    alert('Xóa thất bại');
                }
            }))
        })
    </script>
</body>

</html>

<?php $connect->close(); ?>