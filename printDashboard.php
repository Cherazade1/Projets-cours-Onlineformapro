<?php
session_start();
error_log(print_r($_SESSION, 1));
if (isset($_SESSION['id']) && strlen($_SESSION['id']) > 0) {
  $host = 'localhost';
  $login = 'root';
  $mdp = '';
  $db = 'projet';
  $dsn = 'mysql:host=' . $host . ';dbname=' . $db;
  $pdo = new PDO($dsn, $login, $mdp);
  $sql = 'select * from contact';
  error_log($sql);
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_OBJ);
  error_log(print_r($result, 1));

  $sql2 = 'SELECT messages, id_user, prenom, nom, email FROM `messages`
           JOIN liaisons ON id_msg = messages.id
           JOIN contact ON id_user = contact.id';
  error_log($sql2);
  $stmt = $pdo->prepare($sql2);
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_OBJ);
  error_log(print_r($results, 1));
?>

  <!DOCTYPE html>
  <html>
  <link type="text/css" rel="stylesheet" href="main.css">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <!-- BOOTSTRAP CORE STYLE  -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link type="text/css" rel="stylesheet" href="main.css">
  <title>Project mini site statique</title>

  <body>
    <main class="container" style="color:white">
      <header class="brand">
        <img src="Image\logo_olt.png" id="logo" style="margin-top:50px;margin-bottom: 50px;">
      </header>
      <div class="content-wrapper">

        <div class="row pad-botm">
          <div class="col-md-12">
            <h4 class="header-line">Tableau de bord</h4>
          </div>
          <div>
            <table>
              <?php foreach ($results as $res) { ?>
                <tr>
                  <td><?php echo $res->prenom; ?></td>
                  <td><?php echo $res->nom; ?></td>
                  <td><?php echo $res->email; ?></td>
                  <td><?php echo $res->messages; ?></td>
                  <td class="center"><?php if (true) { ?></td>
                  <td class="center">
                    <a href="details.php?id=<?php echo htmlentities($res->id_user); ?>" class="btn btn-success btn-xs">Active</a>
                  <?php } else { ?>
                    <a href="#" class="btn btn-danger btn-xs">Inactive</a>
                  <?php } ?>
                  </td>
                </tr>
              <?php } ?>
            </table>
          </div>

        </div>
      </div>
    </main>
  </body>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

  </html>
<?php
} else {
  header('location:Administration.html');
}
?>