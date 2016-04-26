<?php
/**
 * GIT DEPLOYMENT SCRIPT
 *
 * Used for automatically deploying websites via github or bitbucket, more deets here:
 *
 *		https://gist.github.com/1809044
 */
// The commands
$commands = array(
    'echo $PWD',
    'whoami',
    'git pull',
    'git status',
    'git submodule sync',
    'git submodule update',
    'git submodule status',
);
// Run the commands for output
$output = '';
foreach($commands AS $command){
    // Run it
    $tmp = shell_exec("cd ..;$command");
    // Output
    $output .= "<span style=\"color: #6BE234;\">\$</span> <span style=\"color: #729FCF;\">{$command}\n</span>";
    $output .= htmlentities(trim($tmp)) . "\n";
}
// Make it pretty for manual user access (and why not?)
$run_command = function($command, &$result, &$error, $stream = ""){
    $pipes = array();
    $descriptorspec = array(
        0 => array("pipe", "r"), // stdin
        1 => array("pipe", "w"), // stdout
        2 => array("pipe", "w"), // stderr
    );

    $process = proc_open($command, $descriptorspec, $pipes);
    if(is_resource($process)){

        fwrite($pipes[0], $stream);
        fclose($pipes[0]);

        $result = stream_get_contents($pipes[1]);
        fclose($pipes[1]);
        $error = stream_get_contents($pipes[2]);
        fclose($pipes[2]);
        $ret = proc_close($process);
    }

    if($result){
        $c = substr_count($result, "\n");
        if($c == 1){
            $result = str_replace("\n", "", $result);
        }
    }
    return $ret;
};
$out1 = '';
$error1 = '';
$out2 = '';
$error2 = '';

$run_command('/bin/bash '.__DIR__.'/../private/kill-node.sh', $out1, $error1);
$run_command('/bin/bash '.__DIR__.'/../private/start-node.sh', $out2, $error2);
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>GIT DEPLOYMENT SCRIPT</title>
</head>
<body style="background-color: #000000; color: #FFFFFF; font-weight: bold; padding: 0 10px;">
<pre>
 .  ____  .    ____________________________
 |/      \|   |                            |
[| <span style="color: #FF0000;">&hearts;    &hearts;</span> |]  | Git Deployment Script v0.1 |
 |___==___|  /              &copy; oodavid 2012 |
              |____________________________|

    <?php echo $output; ?>
    <?php var_dump(array($out1,$error1)) ?>
    <?php var_dump(array($out2,$error2)) ?>
</pre>
</body>
</html>
