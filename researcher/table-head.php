<thead>
<tr>
    <?php for ($i = 0; $i < count($columnName); $i++) { ?>
        <th <?php if ($i == 0) {
            echo 'style="display:none"';
        } ?>><?php
            $parts = preg_split('/(?=[A-Z])/', $columnName[$i]);
            for($j=0;$j<count($parts);$j++){
                echo $parts[$j];
                echo " ";
            }
            //echo $columnName[$i];
            ?></th>
    <?php } ?>
</tr>
</thead>