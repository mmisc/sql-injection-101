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

  mysql_connect(getenv('DB_HOST'),getenv('DB_USERNAME'),getenv('DB_PASSWORD'));
  mysql_select_db(getenv('DB_DATABASE'));

  $q = mysql_query($sql);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zwitscher</title>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.3.0/styles/default.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
<!--    <link href="bootstrap-theme.min.css" rel="stylesheet">-->
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
        </div><!--/.nav-collapse -->
      </div>
    </nav>
  <div class="alert alert-warning">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Debug:</strong> "<?php echo $sql; ?>
  </div>
<?php
  if($q === FALSE) {
    echo "<div class=\"alert alert-danger\">";
    echo "<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>";
    echo "<strong>SQL Error:</strong> " . mysql_error();
    echo "</div>";
    echo "<div class=\"alert alert-danger\">";
    echo "<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>";
    echo "<strong>Error:</strong> Check the <a href=\"?src\">source</a> for better understanding";
    echo "</div";
  }
  $num = mysql_num_rows($q); ?>
    <div class="container"> 
      <div class="starter-template">
        <div class="row">
          <div class="col-sm-12">



<ul class="list-group">

<?php
  while($row = mysql_fetch_array($q)) {
    $user = $row['user'];
    echo "<li  class=\"row list-group-item\">";
    echo "<span class=\"col-sm-1\">";
    echo "<img src=\"https://www.gravatar.com/avatar/".md5($user."2f12530acc8771af77f5d3cfe344594e")."?f=y&d=identicon\" alt=\"".$user."\">";
    echo "</span>";
    echo "<span class=\"col-sm-11\">";
    echo $user." ";
    echo "<div class=\"pull-right\"><span  class=\"label label-info\">" . $row['hashtag']."</span> </div> <hr />";
    echo $row['msg']."</span></li>";
    //echo "</span>";
  }
?>



</ul>
</div>
</div>
</div>
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.3.0/highlight.min.js"></script>
<script>hljs.initHighlightingOnLoad();</script>
 <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"><\/script>')</script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="https://maxcdn.bootstrapcdn.com/js/ie10-viewport-bug-workaround.js"></script>

  </body>
</html>
