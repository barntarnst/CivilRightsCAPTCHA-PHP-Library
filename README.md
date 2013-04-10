CivilRightsCAPTCHA-PHP-Library
==============================

PHP library for Civil Rights Defenders CAPTCHA. Using a library is the simplest way to add the Civil Rights CAPTCHA to your site.

There is a Wiki at http://captcha.civilrightsdefenders.org.

The package includes the library and an example page (with a version of jQuery) to demonstrate how to use it. The Civil Rights CAPTCHA depends on the javascript library jQuery.

## Step 1: Displaying the CATPCHA
To display the captcha in your html form, simply echo the show() function at the place in the &lt;form&gt; where you want the captcha to display.

```html
require_once('CRCphplib.php');
$crccaptcha = new civilrightscaptcha();
//To set language use (Sets to Swedish, default is english): 
//$crccaptcha->setLanguage('sv'); 
echo $crccaptcha->show();
```

A form with the captcha could look something like this.

```html
<html>
  <head>
  <script src='http://code.jquery.com/jquery-latest.min.js' type='text/javascript'></script>
  </head>
  <body>
    <!-- your HTML content -->
 
    <form method="post" action="verify.php">
      <!-- your form inputs -->
      <?php
          require_once('CRCphplib.php');
          $crccaptcha = new civilrightscaptcha();
          echo $crccaptcha->show();
      ?>
      <input type="submit" />
    </form>
 
    <!-- more of your HTML content -->
  </body>
</html>
```

Notice that the require_once() expects the library file to be in the same catalog as your script. If it is not, you must link approperiately. The jQuery library must be included for the captcha to function.

## Step 2: Verifying the entered answer
After the form has been submitted to your form-proccessing-php-file, you must verify that the user entered the correct answer.

```html
require_once('CRCphplib.php');
$crccaptcha = new civilrightscaptcha();
if($crccaptcha->check($_POST['crc_captcha'], $_POST['crc_sessid'])) {
    //Your code if the user entered the correct answer!
}
else {
    //Your code if the user entered the wrong answer!
}
```

When the user submits the form, two fields (crc_captcha & crc_sessid) are also submitted from the captcha. Both these have to be used as parameters to the check function. The check function returns a boolean TRUE if the answer is correct and FALSE if it is not. 