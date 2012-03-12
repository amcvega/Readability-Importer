<?php
session_start();

if ($_FILES['uploadfile']['size'] > 1048576){
    echo "Sorry this file is too big";
    exit;
}else {

    $fh = fopen($_FILES['uploadfile']['tmp_name'],'r');

    $count = 0;
    $entries = array();

    while ($line = fgetcsv($fh)){
        if ($count != 0){
            $entry = array();            
            $entry['url'] = $line[0];
            $entry['folder'] = $line[3];
            $entries[] = $entry;
        }
        $count++;
    }    

    fclose($fh);

}
?>

<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Import to Readability</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width">
  <link rel="stylesheet" href="css/style.css">
  <script src="js/libs/modernizr-2.5.3.min.js"></script>
</head>
<body>
  <div id="container">
    <header>
    </header>
    <div role="main">
        <p class="stats"></p>
        <input type="button" value="Start Import"/>
        <p>This may take a while if you have a lot of articles. Keep this window open.</p>
        <ul class="log">
        </ul>
    </div>
    <footer>
    </footer>
  </div>
    <script type="text/javascript">
        var entries = <?php echo json_encode($entries); ?>;
    </script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.1.min.js"><\/script>')</script>
    <script type="text/javascript">
    $('document').ready(function(){
        $('.stats').text(entries.length + ' entries to upload');

        var orig = entries.length;
        var current = entries.pop();

        var addPost = function(){ 
            $.post(
                'singlepost.php',
                {'url':current.url,'folder':current.folder},
                function(data){
                    if (data == 202){
                        $('ul.log').prepend('<li>'+current.url+' successfully added to '+current.folder+'</li>');                        
                    }else {
                        $('ul.log').prepend('<li>ERROR: '+data+' '+current.url+' couldn\'t be added to '+current.folder+'</li>');                                                
                    }
                    var progress = orig - entries.length;
                    $('.stats').text(progress + '/' + orig + ' entries uploaded');
                    if (entries.length > 0){
                        current = entries.pop();
                        addPost();
                    }else {
                        $('.stats').text('ALL DONE ' + $('.stats').text());
                        $('.stats').append(' <a href="http://readability.com">Visit Readability.com</a>');                        
                    }
                }
            );
        };

        $('input:button').click(function(){addPost();});

        
    });

    </script>
</body>
</html>