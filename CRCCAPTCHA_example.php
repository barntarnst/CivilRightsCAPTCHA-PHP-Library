<?php
/*
 * This is an example of how to use the Civil Right Defenders Captcha with the PHP Library.
 *    - Documentation and latest version
 *          http://civilrightsdefenders.org/captcha/
 *
 *  Remember to include jQuery!
 *
 *  Report bugs to captcha@civilrightsdefenders.org
 *  
 */
$success = false;
$info = "";

if(isset($_POST['name']) && isset($_POST['crc_captcha']) && isset($_POST['crc_sessid'])) {
  
  require_once('CRCphplib.php');
  $crccaptcha = new civilrightscaptcha();
  
  /* Remember to include both $_POST['crc_captcha'] and $_POST['crc_sessid'] as parameters to the check function. */

  if($crccaptcha->check(@$_POST['crc_captcha'], @$_POST['crc_sessid'])) {
    
    // Your code to enter posted comment into e.g. your database.
    $success = true;
    $info = "Your comment has been added!";
  }
  else {
    $info = "You did not enter the correct answer in the Civil Rights Captcha, try again!";
  }

}

?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Civil Rights Captcha Example Form</title>
  <style type="text/css">
    body { margin: 0; font-size: 14px; margin: 50px; }
    body, button, input, select, textarea, a, a:visited { 
      font-family: 'Andale Mono', tahoma, serif; color: #818181; text-transform: uppercase; 
      }
    .error { color: #f00; font-weight: bold; font-size: 1.2em; }
    .success { color: #00f; font-weight: bold; font-size: 1.2em; }
    fieldset { width: 90%; }
    legend { font-size: 24px; }
    .note { font-size: 18px; }
    input { padding: 5px;}
    textarea { width: 300px; height: 150px; }
  </style>
  <script src="http://code.jquery.com/jquery-latest.min.js"></script>
</head>
<body>
  <div id="info" class="<?php echo $success ? 'success' : 'error'; ?>"><?php echo $info . "<br /><br />"; ?></div>
  <form method="post" action="<?php echo $_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING'] ?>" id="crccaptcha_example">
    <label for="name">Name: </label><br /><input type="text" name="name" /><br /><br />
    <label for="comment">Your comment:<br /></label><textarea name="comment"></textarea><br /><br />
    This is to prove that you are human:<br /><br />
    <?php
          require_once('CRCphplib.php');
          $crccaptcha = new civilrightscaptcha();
          //If you want Swedish, uncomment the next line!
          //$crccaptcha->setLanguage("sv");
          echo $crccaptcha->show();
    ?>
    <br /><br />
    <input type="submit" />
  </form>
</body>
</html>