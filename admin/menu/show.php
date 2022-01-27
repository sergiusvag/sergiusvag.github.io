<?php

    require_once '/OpenServer/domains/XO/includes/connect.php';	

    $tableNameShow = 'questions';
    $questionsShow = mysqli_query($connection, "SELECT * FROM `$tableNameShow`");

    session_start();
    if(!$_SESSION["user"]) {
		require_once '/OpenServer/domains/XO/includes/components/head.php';
    }
?>

<!DOCTYPE html>
<html lang="ru">
<head>
<?php
    require_once '/OpenServer/domains/XO/includes/components/head.php';
?>
<link rel="stylesheet" href="/css/admin.css">
</head>
<body>
<!-- questions -->
<section id="questions" class="questions">
    <div class="user-wrap">
        <p class="user-info">Добро пожаловать, <span class="user-name"><?= $_SESSION["user"]["login"] ?></span></p>
        <a href="../logout.php" class="btn btn-logout">Выйти</a>
    </div>
    <div class="admin-panel">
        <div class="menu menu-buttons">
            <a href="./show.php"  class="admin-panel-btn admin-panel-btn_show">Показать</a>
            <a href="./add.php" class="admin-panel-btn admin-panel-btn_add">Добавить</a>
            <a href="./new.php" class="admin-panel-btn admin-panel-btn_new">Новое</a>
            <a href="./mistakes.php" class="admin-panel-btn admin-panel-btn_mistake">Ошибки</a>
        </div>
        <div class="container">
            <div class="form-wrapper d-block">
                <div class="form-question form-question_show">
                <h3 class="form-question__title">Меню редакции вопросов</h3>
                    <?php
                        if ($_SESSION["Message"]) {
                    ?>
                        <div class="message error-message">
                            <p><?= $_SESSION["Message"] ?> </p>
                        </div>
                    <?php
                        }

                        $_SESSION["Message"] = 0;
                    ?>
                <div class="table-wrap">
                    <table class="table-question_show">
                        <thead >
                            <th scope="col" class="table-small-col">№</th>
                            <th scope="col">Вопрос</th>
                            <th scope="col">Вартант №1</th>
                            <th scope="col">Вартант №2</th>
                            <th scope="col">Вартант №3</th>
                            <th scope="col">Вартант №4</th>
                            <th scope="col">Ответ</th>
                            <th scope="col">Место</th>
                            <th scope="col">Действие</th>
                        </thead>
                        <?php
                            while ($question = mysqli_fetch_assoc($questionsShow)){
                                ?>
                                <tbody>
                                    <tr>
                                        <th scope="row"><?= $question["id"] ?></th>
                                        <td><?= $question["question"] ?></td>
                                        <td><?= $question["option1"] ?></td>
                                        <td><?= $question["option2"] ?></td>
                                        <td><?= $question["option3"] ?></td>
                                        <td><?= $question["option4"] ?></td>
                                        <td><?= $question["answer"] ?></td>
                                        <td><?= $question["location"] ?></td>
                                        <td class="show-buttons table-small-col">
                                            <form action="../delete-question.php?backTo=show" method="post">
                                                <input type="hidden" name="id" value="<?= $question["id"] ?>">
                                                <input type="hidden" name="tableName" value="<?= $tableNameShow ?>">
                                                <input type="hidden" name="item" value="Вопрос">
                                                <button type="submit" class="btn-show btn-show-delete">Удалить</button>
                                            </form>
                                            <a href="../edit-question.php?id=<?= $question["id"] ?>&tableName=<?= $tableNameShow ?>&check=true&backTo=show" class="btn-show btn-show-edit">Редактировать</a>
                                        </td>
                                    </tr>
                                </tbody>
                                <?php
                            }
                        ?>
                    </table>
                    </div>
</div>
            </div>
        </div>
    </div>
</section>
<!-- Connect JS -->
<!-- <script src="../admin/js/admin.js"></script> -->
</body>
</html>
