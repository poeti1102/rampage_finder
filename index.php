<?php
    error_reporting(0);
    if (isset($_POST['getData'])) {
        include('functions.php');
        include('heroes.php');

        $rampageString = "----------------Rampage List----------------".PHP_EOL;
        $matchids = explode(PHP_EOL,$_POST['matchids']);
        foreach($matchids as $match) {
            $results = json_decode(CallAPI('GET' , 'https://api.opendota.com/api/matches/'.$match));

            $players = $results->players;
            for($i = 0 ; $i < 10 ; $i++) {
                $killtimes = $players[$i]->kills_log;
                $killcount = 0;
                $no_rampage = false;
                // Calculate 16 seconds interval;
                $j = 0; // Hero Kills
                foreach($killtimes as $killtime) { 
                    if (($j+1) == count($killtimes)) {
                        if(($killtimes[$j]->time - $killtimes[$j-1]->time) <= 16) {
                            $killcount += 1;
                        } else {
                            $killcount = 0; // Reset count
                        }

                        if($killcount == 5) {
                            $rampageString .= $match." - ".$heroes[$players[$i]->hero_id]." Rampage at ".$killtimes[$j-4]->time."<br>";
                        }

                        if ($killcount < 5) {
                            $killcount = 0; // Not get a rampage so I reset
                            if ($no_rampage == false) {
                                $rampageString .= $match." - No Rampage For " .$heroes[$players[$i]->hero_id]." <br>";
                                $no_rampage = true;
                            }
                            
                            //print_r($heroes[$players[$i]->hero_id]." get a kill at ".$killtime->time."<br>");
                        }
                        continue;
                    }
                    if(($killtimes[$j+1]->time - $killtime->time) <= 16) {
                        $killcount += 1;
                    } else {
                        $killcount = 0; // Reset count
                    }

                    if($killcount >= 5) {
                        $rampageString .= $match." - ".$heroes[$players[$i]->hero_id]." Rampage at ".$killtimes[$j-4]->time."<br>";
                    }
                    
                    //print_r($heroes[$players[$i]->hero_id]." get a kill at ".$killtime->time."<br>");
                    $j++;
                }
            }

            
        }
        $rampageString .= "------------------------------------------".PHP_EOL;
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
            <div class="form-group">
                <label>Enter Match Ids</label>
                <textarea id="input" class="form-control" rows="10" name="matchids"></textarea>
            </div>

            <button type="submit" name="getData" class="btn btn-block btn-primary">Get Rampages</button>
        </form>

        <?php if(isset($_POST['getData'])): ?>
        <pre>
        <?php echo $rampageString; ?>
        </pre>
        <?php endif; ?>
    </div>
</body>
</html>