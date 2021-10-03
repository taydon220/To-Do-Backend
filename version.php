<html>
    <body>

        <h1>
        <?php

        $db = new SQLite3('test.db');

        $version = $db->querySingle('SELECT SQLITE_VERSION()');

        echo $version; 

        ?>
        </h1>
    </body>
</html>