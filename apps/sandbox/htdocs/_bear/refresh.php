<?php
// clear APC cache
apc_clear_cache();
apc_clear_cache('user');
header("Location: /");