<?php
  $search = "#trivia";

  if( isset($_GET['search']) ){
    $search = $_GET['search'];
  }

  if( isset($_GET['src']) ){
    show_source(__FILE__);
    exit();
  }  
  $sql = "SELECT * FROM zwitscher WHERE hashtag = '" .$search. "';";

  $con = mysqli_connect(getenv('DB_HOST'),getenv('DB_USERNAME'),getenv('DB_PASSWORD'), getenv('DB_DATABASE'));

  $q = mysqli_query($con, $sql);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zwitscher</title>
    <link rel="stylesheet" href="assets/bootstrap-3.3.7-dist/css/bootstrap.min.css">
    <link href="theme.css" rel="stylesheet">
  </head>
  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Spannendes Gezwitscher</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul>
          <div class="col-sm-3 col-md-3 pull-right">
            <form class="navbar-form" role="search">
              <div class="input-group">
                <input type="text" class="form-control" placeholder=<?php echo "\"" . $search . "\""; ?>  name="search" id="search">
                <div class="input-group-btn">
                  <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </nav>
    <div class="alert alert-warning">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Debug:</strong> "<?php echo $sql; ?>
    </div>
    <?php
      if($q === FALSE) {
        echo '<div class="alert alert-danger">';
        echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
        echo '<strong>SQL Error:</strong> ' . mysqli_error($con) . '</div>';
        echo '<div class="alert alert-danger">';
        echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
        echo '<strong>Error:</strong> Check the <a href="?src">source</a> for debugging!</div>';
      }
    ?>
    <div class="container"> 
      <div class="starter-template">
        <div class="row">
          <div class="col-sm-12">
            <ul class="list-group">
              <?php
                while($row = mysqli_fetch_array($q)) {
                  echo '<li class="row list-group-item">';
                  echo '<div class="col-sm-1"><svg width="80" height="80" data-jdenticon-value="' . $row['user'] . '"></svg></div>';
                  echo '<div class="col-sm-11">' . $row['user'];
                  echo '<div class="pull-right"><div  class="label label-info">' . $row['hashtag'].'</div></div><hr/>';
                  echo $row['msg']."</div></li>";
                }
              ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <script src="assets/jdenticon.min.js"></script>
  </body>
</html>
