<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo $view['file_path'] . " ({$view['mod_date']})" . " {$view['is_writable_label']}" ?></title>
    <link href="codeEdit.css" media="screen" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="favicon.ico" type="image/vnd.microsoft.icon" />
    <link rel="icon" href="favicon.ico" type="image/vnd.microsoft.icon" />

    <script src="js/jquery-1.6.1.js" type="text/javascript" s></script>
    <script src="js/jquery.keybind/jquery.keybind.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/ace/ace.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/ace/theme-eclipse.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/ace/mode-php.js" type="text/javascript" charset="utf-8"></script>
    <script src="codeEdit.js"> type="text/javascript"></script>
    <!--    <script src="js/ace/keybinding-vim.js" type="text/javascript" charset="utf-8"></script>-->
</head>
<body>
    <div id="label" class="editor_label">
    <!-- <span class="editor_file"><?php echo $view['file_path']?> -->
    </span><span class="editor_file_save" id="save_now">Save</span></div>
    <pre id="editor"><?php echo htmlspecialchars($view['file_contents']); ?></pre>
    <script>
    $(function(){
        editor = $.codeEdit.factory();
        // var vim = require 'js/ace/keyboard/keybinding/vim'.Vim;
        // editor.setKeyboardHandler(vim)
        editor.gotoLine(<?php echo $view['line'];?>);
        editor.setReadOnly(<?php echo ($view['is_writable'] ? 'false' : 'true');?>);
        <?php echo ($view['is_writable']) ? "$.codeEdit.label('reset');" : "$.codeEdit.label('readonly');"; ?>
        var save = function() {$.codeEdit.save("<?php echo $view['file_path'] ?>", editor.getSession().getValue());};
        $('#editor').keybind('keyup', {
              'C-s': save,
              'C-S-s': save
         });
         $('#save_now').click(save);
    });
    </script>
</body>
</html>
