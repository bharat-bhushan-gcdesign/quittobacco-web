<?php
print_r(shell_exec("zip -r backup-29-may.zip ../* -x \*public\*"));
echo "Success";