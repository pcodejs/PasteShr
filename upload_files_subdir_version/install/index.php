<?php
if(!file_exists('database.sql')){
  die('404 - Page not found.');
}

$smvc = '.';

/** Set the full path to the docroot */
define('ROOT', realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR);

/** Make the application relative to the docroot, for symlink'd index.php */
if (!is_dir($smvc) and is_dir(ROOT . $smvc)) {
    $smvc = ROOT . $smvc;
}

/** Define the absolute paths for configured directories */
define('SMVC', realpath($smvc) . DIRECTORY_SEPARATOR);

/** Unset non used variables */
unset($smvc);

if (isset($_POST['DB_HOST'])):
    error_reporting(E_ALL ^ E_WARNING);
    
    function remove_comments(&$output) {
        $lines = explode("\n", $output);
        $output = "";
        
        // try to keep mem. use down
        $linecount = count($lines);
        
        $in_comment = false;
        for ($i = 0; $i < $linecount; $i++) {
            if (preg_match("/^\/\*/", preg_quote($lines[$i]))) {
                $in_comment = true;
            }
            
            if (!$in_comment) {
                $output.= $lines[$i] . "\n";
            }
            
            if (preg_match("/\*\/$/", preg_quote($lines[$i]))) {
                $in_comment = false;
            }
        }
        
        unset($lines);
        return $output;
    }
    function remove_remarks($sql) {
        $lines = explode("\n", $sql);
        
        // try to keep mem. use down
        $sql = "";
        
        $linecount = count($lines);
        $output = "";
        
        for ($i = 0; $i < $linecount; $i++) {
            if (($i != ($linecount - 1)) || (strlen($lines[$i]) > 0)) {
                if (isset($lines[$i][0]) && $lines[$i][0] != "#") {
                    $output.= $lines[$i] . "\n";
                } 
                else {
                    $output.= "\n";
                }
                
                // Trading a bit of speed for lower mem. use here.
                $lines[$i] = "";
            }
        }
        
        return $output;
    }
    function split_sql_file($sql, $delimiter) {
        
        // Split up our string into "possible" SQL statements.
        $tokens = explode($delimiter, $sql);
        
        // try to save mem.
        $sql = "";
        $output = array();
        
        // we don't actually care about the matches preg gives us.
        $matches = array();
        
        // this is faster than calling count($oktens) every time thru the loop.
        $token_count = count($tokens);
        for ($i = 0; $i < $token_count; $i++) {
            
            // Don't wanna add an empty string as the last thing in the array.
            if (($i != ($token_count - 1)) || (strlen($tokens[$i] > 0))) {
                
                // This is the total number of single quotes in the token.
                $total_quotes = preg_match_all("/'/", $tokens[$i], $matches);
                
                // Counts single quotes that are preceded by an odd number of backslashes,
                // which means they're escaped quotes.
                $escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$i], $matches);
                
                $unescaped_quotes = $total_quotes - $escaped_quotes;
                
                // If the number of unescaped quotes is even, then the delimiter did NOT occur inside a string literal.
                if (($unescaped_quotes % 2) == 0) {
                    
                    // It's a complete sql statement.
                    $output[] = $tokens[$i];
                    
                    // save memory.
                    $tokens[$i] = "";
                } 
                else {
                    
                    // incomplete sql statement. keep adding tokens until we have a complete one.
                    // $temp will hold what we have so far.
                    $temp = $tokens[$i] . $delimiter;
                    
                    // save memory..
                    $tokens[$i] = "";
                    
                    // Do we have a complete statement yet?
                    $complete_stmt = false;
                    
                    for ($j = $i + 1; (!$complete_stmt && ($j < $token_count)); $j++) {
                        
                        // This is the total number of single quotes in the token.
                        $total_quotes = preg_match_all("/'/", $tokens[$j], $matches);
                        
                        // Counts single quotes that are preceded by an odd number of backslashes,
                        // which means they're escaped quotes.
                        $escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$j], $matches);
                        
                        $unescaped_quotes = $total_quotes - $escaped_quotes;
                        
                        if (($unescaped_quotes % 2) == 1) {
                            
                            // odd number of unescaped quotes. In combination with the previous incomplete
                            // statement(s), we now have a complete statement. (2 odds always make an even)
                            $output[] = $temp . $tokens[$j];
                            
                            // save memory.
                            $tokens[$j] = "";
                            $temp = "";
                            
                            // exit the loop.
                            $complete_stmt = true;
                            
                            // make sure the outer loop continues at the right point.
                            $i = $j;
                        } 
                        else {
                            
                            // even number of unescaped quotes. We still don't have a complete statement.
                            // (1 odd and 1 even always make an odd)
                            $temp.= $tokens[$j] . $delimiter;
                            
                            // save memory.
                            $tokens[$j] = "";
                        }
                    }
                     // for..
                    
                }
                 // else
                
            }
        }
        
        return $output;
    }
    
    $dbhost = trim($_POST['DB_HOST']);
    $dbname = trim($_POST['DB_NAME']);
    $dbusername = trim($_POST['DB_USERNAME']);
    $dbpassword = trim($_POST['DB_PASSWORD']);
    
    $db = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);
    if ($db->connect_errno > 0) {
        $message = "<div class='alert alert-danger'>Could not connect to the database</div>";
    } 
    else {
        
        $dbms_schema = 'database.sql';
        
        $sql_query = @fread(@fopen($dbms_schema, 'r'), @filesize($dbms_schema)) or die('problem ');
        $sql_query = remove_remarks($sql_query);
        $sql_query = split_sql_file($sql_query, ';');
        
        $i = 1;
        foreach ($sql_query as $sql) {
            $result = $db->query($sql) or die('The selected database is not empty');
        }
        if ($result) {

            $site_name = trim($_POST['site_name']);
            $app_url = trim($_POST['app_url']);
            $site_email = trim($_POST['site_email']);
            $admin_email = trim($_POST['admin_email']);
            $admin_password = trim($_POST['admin_password']);
            $admin_password = password_hash($admin_password, PASSWORD_DEFAULT);


            $db->query("UPDATE settings SET `value`='$site_name' WHERE `key`='site_name'");
            $db->query("UPDATE settings SET `value`='$site_email' WHERE `key`='site_email'");
            $db->query("UPDATE users SET `email`='$admin_email', `password`='$admin_password' WHERE `name`='admin'");
            mysqli_close($db);   
        $eprdata = file_get_contents(SMVC . "../../.env.example");
        $eprdata = str_replace('MY_APP_NAME', '"'.$site_name.'"', $eprdata);
        $eprdata = str_replace('MY_URL', $app_url, $eprdata);
        $eprdata = str_replace('MY_DBHOST', $dbhost, $eprdata);
        $eprdata = str_replace('MY_DBNAME', $dbname, $eprdata);
        $eprdata = str_replace('MY_DBUSERNAME', $dbusername, $eprdata);
        $eprdata = str_replace('MY_DBPASSWORD', $dbpassword, $eprdata);


        if (file_put_contents(SMVC . "../../.env", $eprdata)) {
            
            @rename('database.sql','backup.sql');
            //file_put_contents('index.php', "<html>Directory Access Forbidden</html>");
            $message = "<div class='alert alert-success'>Installation successful! Go to <a href='".$app_url."'>Home page</a></div>";
        }

        }
    }

endif;
?>


<!DOCTYPE html>
<html>
<head>
    <title>Installer</title>
 <!-- Bootstrap Core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style type="text/css">
body {
    margin-top:40px;
}
.stepwizard-step p {
    margin-top: 10px;
}
.stepwizard-row {
    display: table-row;
}
.stepwizard {
    display: table;
    width: 50%;
    position: relative;
}
.stepwizard-step button[disabled] {
    opacity: 1 !important;
    filter: alpha(opacity=100) !important;
}
.stepwizard-row:before {
    top: 14px;
    bottom: 0;
    position: absolute;
    content: " ";
    width: 100%;
    height: 1px;
    background-color: #ccc;
    z-order: 0;
}
.stepwizard-step {
    display: table-cell;
    text-align: center;
    position: relative;
}
.btn-circle {
    width: 30px;
    height: 30px;
    text-align: center;
    padding: 6px 0;
    font-size: 12px;
    line-height: 1.428571429;
    border-radius: 15px;
}    
</style>    
</head>
<body>

<div class="container">
	

<div class="col-md-offset-3 col-md-6">
<?php if(isset($message)) echo $message; ?>
</div> 

<div class="stepwizard col-md-offset-3">

    <div class="stepwizard-row setup-panel">
      <div class="stepwizard-step">
        <a href="#step-1" type="button" class="btn btn-primary btn-circle">1</a>
        <p>Requirements</p>
      </div>
      <div class="stepwizard-step">
        <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
        <p>Database</p>
      </div>
      <div class="stepwizard-step">
        <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
        <p>Admin panel</p>
      </div>
    </div>
  </div>
  
  <form role="form" action="" method="post">
    <div class="row setup-content" id="step-1">
      <div class="col-xs-6 col-md-offset-3">
        <div class="col-md-12">
          <h3> Step 1 - Requirements</h3>
                    
              <p><b>PHP Version  - </b> PHP = 7.1.X</p>
              <p><b>MySQL Version  - </b> MySQL = 5.*</p>			  
              <p><b>Extensions :</b></p>
              <ul>
                <li>FOPEN PHP Extension</li>
				        <li>cURL PHP Extension</li>
                <li>OpenSSL PHP Extension</li>
                <li>PDO PHP Extension</li>
                <li>Mbstring PHP Extension</li>
                <li>Tokenizer PHP Extension</li>
        				<li>XML PHP Extension</li>
        				<li>Ctype PHP Extension</li>
        				<li>JSON PHP Extension</li>
        				<li>BCMath PHP Extension</li>	
            </ul>
         
          <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
        </div>
      </div>
    </div>
    <div class="row setup-content" id="step-2">
      <div class="col-xs-6 col-md-offset-3">
        <div class="col-md-12">
          <h3> Step 2 - Database configuration</h3>
          <div class="form-group">
            <label class="control-label">Database Host</label>
            <input maxlength="200" type="text" required="required" class="form-control" placeholder="localhost" name="DB_HOST" />
          </div>
          <div class="form-group">
            <label class="control-label">Database Name</label>
            <input maxlength="200" type="text" required="required" class="form-control" placeholder="Database name" name="DB_NAME"  />
          </div>
        <div class="form-group">
            <label class="control-label">Database Username</label>
            <input maxlength="200" type="text" required="required" class="form-control" placeholder="Database username" name="DB_USERNAME"  />
          </div>
            <div class="form-group">
            <label class="control-label">Database Password</label>
            <input maxlength="200" type="password" required="required" class="form-control" placeholder="Database password" name="DB_PASSWORD"  />
          </div>
          <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
        </div>
      </div>
    </div>
    <div class="row setup-content" id="step-3">
      <div class="col-xs-6 col-md-offset-3">
        <div class="col-md-12">
          <h3> Step 3 - Admin panel configuration</h3>
        <div class="form-group">
            <label class="control-label">App Name</label>
            <input  maxlength="100" type="text" required="required" class="form-control" placeholder="App Name" name="site_name" />
        </div>
        <div class="form-group">
            <label class="control-label">App E-Mail</label>
            <input  maxlength="100" type="email" required="required" class="form-control" placeholder="App E-Mail" name="site_email" />
        </div>
        <div class="form-group">
            <label class="control-label">App URL</label>
            <input  maxlength="100" type="text" required="required" class="form-control" placeholder="http://example.com" name="app_url" />
        </div>        

        <div class="form-group">
            <label class="control-label">Admin E-Mail</label>
            <input  maxlength="100" type="email" required="required" class="form-control" placeholder="Admin E-Mail" name="admin_email" />
          </div>
          <div class="form-group">
            <label class="control-label">Admin Password</label>
            <input maxlength="100" type="password" required="required" class="form-control" placeholder="Admin Password" name="admin_password" />
          </div>

          <button class="btn btn-success btn-lg pull-right" type="submit">Submit</button>
        </div>

      </div>
    </div>

  </form>
  
</div>

<script type="text/javascript">
$(document).ready(function () {
  var navListItems = $('div.setup-panel div a'),
          allWells = $('.setup-content'),
          allNextBtn = $('.nextBtn');

  allWells.hide();

  navListItems.click(function (e) {
      e.preventDefault();
      var $target = $($(this).attr('href')),
              $item = $(this);

      if (!$item.hasClass('disabled')) {
          navListItems.removeClass('btn-primary').addClass('btn-default');
          $item.addClass('btn-primary');
          allWells.hide();
          $target.show();
          $target.find('input:eq(0)').focus();
      }
  });

  allNextBtn.click(function(){
      var curStep = $(this).closest(".setup-content"),
          curStepBtn = curStep.attr("id"),
          nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
          curInputs = curStep.find("input[type='text'],input[type='url']"),
          isValid = true;

      $(".form-group").removeClass("has-error");
      for(var i=0; i<curInputs.length; i++){
          if (!curInputs[i].validity.valid){
              isValid = false;
              $(curInputs[i]).closest(".form-group").addClass("has-error");
          }
      }

      if (isValid)
          nextStepWizard.removeAttr('disabled').trigger('click');
  });

  $('div.setup-panel div a.btn-primary').trigger('click');
});    
</script>
</body>
</html>