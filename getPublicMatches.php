<?php
    error_reporting();
    if (isset($_POST['getData'])) {
        include('functions.php');
        include('heroes.php');

        
        $url = 'https://api.opendota.com/api/publicMatches';
        $matches = json_decode(CallAPI('GET' , $url));
        $publicMatches = [];
        foreach($matches as $match) {
            array_push($publicMatches , $match->match_id);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OPENDOTA Rampage Finder</title>
    <script
			  src="https://code.jquery.com/jquery-3.4.0.slim.min.js"
			  integrity="sha256-ZaXnYkHGqIhqTbJ6MB4l9Frs/r7U4jlx7ir8PJYBqbI="
              crossorigin="anonymous"></script>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <form action="" method="POST">
            <button type="submit" name="getData" class="btn btn-block btn-primary">Get Rampages</button>
        </form>

        <?php if(isset($_POST['getData'])): ?>
        <pre>
        <?php
            for($i = 1; $i < count($publicMatches); $i++){
                echo $publicMatches[$i]."<br>";
            }
        ?>
        </pre>
        <?php endif; ?>
    </div>
</body>
</html>