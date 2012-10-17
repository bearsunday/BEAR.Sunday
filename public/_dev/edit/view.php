<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo $view['file_path'] . " ({$view['mod_date']})" . " {$view['is_writable_label']}" ?></title>
    <link rel="stylesheet" href="codeEdit.css" media="screen" type="text/css" />
    <link rel="shortcut icon" href="favicon.ico" type="image/vnd.microsoft.icon" />
    <link rel="icon" href="favicon.ico" type="image/vnd.microsoft.icon" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script src="http://d1n0x3qji82z53.cloudfront.net/src-min-noconflict/ace.js"></script>
    <script src="codeEdit.js"></script>
</head>
<body>
    <div id="label" class="editor_label">
    <!-- <span class="editor_file"><?php echo $view['file_path']?> -->
    </span><span class="editor_file_save" id="save_now">Save</span></div>
    <pre id="editor"><?php echo htmlspecialchars($view['file_contents']); ?></pre>
    <script>
    $(function(){
        editor = $.codeEdit.factory();
        editor.gotoLine(<?php echo $view['line'];?>);
        editor.setReadOnly(<?php echo ($view['is_writable'] ? 'false' : 'true');?>);
        <?php echo ($view['is_writable']) ? "$.codeEdit.label('reset');" : "$.codeEdit.label('readonly');"; ?>
        var save = function() {$.codeEdit.save("<?php echo $view['file_path'] ?>", editor.getSession().getValue());};
		editor.commands.addCommand({
		    name: 'Save',
		    bindKey: {win: 'Ctrl-S',  mac: 'Command-S'},
		    exec: save
		});
         $('#save_now').click(save);
    });
    </script>
</body>
</html>
