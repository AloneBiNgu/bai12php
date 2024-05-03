<?php
    include './connect.php';
?>

<?php
    session_start();
    if (isset($_SESSION['is_login'])) {
        header('Location: ./addnews.php');
        return;
    }

    if (isset($_POST['username']) && isset($_POST['password'])) {
        $sql = sprintf("SELECT * FROM taikhoan WHERE ten_tk='%s' AND mat_khau='%s'", $_POST['username'], $_POST['password']);
        $result = $connect->query($sql);
        $responseData = array();
        if ($result->num_rows > 0) {
            session_regenerate_id(true);
            $_SESSION['is_login'] = true;
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
    <title>Đăng nhập</title>
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
            <label for="username">Tên đăng nhập:</label>
            <input type="text" name="username">
        </div>
        <div class="row">
            <label for="password">Mật khẩu:</label>
            <input type="password" name="password">
        </div>
        <div class="row">
            <button type="submit">Đăng nhập</button>
        </div>
    </form>

    <script>
        const btn = document.querySelector('button');
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const username =document.querySelector('input[name="username"]').value;
            const password =document.querySelector('input[name="password"]').value;

            const newF = new FormData();
            newF.append('username', username);
            newF.append('password', password);

            fetch('#', {
                method: 'post',
                body: newF
            }).then(res => res.json().then(data => {
                if (data.ok == true) {
                    alert('Đăng nhập thành công');
                    window.location.href = './addnews.php';
                } else {
                    alert('Đăng nhập thất bại');
                }
            }))
        })
    </script>
</body>
</html>