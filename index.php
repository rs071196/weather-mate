<?php
$error="";
$weather="";
$woc;
$wc;
if (array_key_exists('city',$_GET))
{
    if($_GET['city']){
        $_GET['city']=str_replace(" ","-",$_GET['city']);
        $file_headers = @get_headers("https://www.weather-forecast.com/locations/".$_GET['city']."/forecasts/latest");
        if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
            $error="city could not be found!!";    
        }
        else{
            $fw=file_get_contents("https://www.weather-forecast.com/locations/".$_GET['city']."/forecasts/latest");
            $firstarray=explode('<tr class="b-forecast__table-description b-forecast__hide-for-small days-summaries"><th></th><td colspan="9"><span class="b-forecast__table-description-title">',$fw);
            if(sizeof($firstarray)>1){
                $secondarray=explode('</span></p></td>',$firstarray[1]);
                if(sizeof($secondarray)>1){
                    $weather= $secondarray[0];
                }
                else{
                    $error="city could not be found!!";    
                }
            }
            else{
                   $firstarray=explode('<a name="forecast-part-0"></a><p class="summary" data-magellan-destination="forecast-part-0">',$fw);
                   if(sizeof($firstarray)>1){
                        $secondarray=explode('</span></p>',$firstarray[1]);
                        if(sizeof($secondarray)>1){
                            $weather= $secondarray[0];
                        }
                        else{
                            $error="city could not be found!!";    
                        }   
                    }
                    else{
                            $error="city could not be found!!";    
                    } 
            } 
        }
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="shortcut icon" type="image/png" href="fevi.jpg"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style type="text/css">
    
       html { 
            background: url(background.jpg) no-repeat center center fixed; 
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            position: relative;        
            width: 75%;            
            height: 800px;       
            margin-left: auto;      
            margin-right: auto;
        }
        body{background:none;}
        .container{
            text-align: center;
            margin-top:150px;
            width:450px;
        }
        button{margin:10px;}
    </style>

    <title>weather mate!!</title>
  </head>
  <body>
    <div class="container">
    <h1>what's the weather??</h1>
    <form>
        <div class="form-group">
        <label for="city">Enter the city name .</label>
        <input type="text" class="form-control" id="city" aria-describedby="city" placeholder="eg. London , tokyo etc." name ="city" value="<?php echo $_GET['city'] ?>">
  
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <div id ="weather">
        <?php
        if($weather){
            echo '<div class="alert alert-success" role="alert">'.$weather.'</div>';
        }else if ($error)
             echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
        ?>
    </div>
    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>