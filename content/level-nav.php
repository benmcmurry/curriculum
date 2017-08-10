<div id="level-nav">
	<div id="level-nav-container">
		<?php
        $query = "Select * from Levels order by level_order ASC";
        if (!$result = $db->query($query)) {
            die('There was an error running the query [' . $db->error . ']');
        }
        while ($levels = $result->fetch_assoc()) {
            ?>
			<a title="<?php echo $levels['level_name']; ?>" class='inDocumentLink' href='#<?php echo $levels['level_short_name']; ?>'>
			<div  class='square'>
				<?php echo $levels['level_short_name']; ?>
			</div>

			</a>
		<?php

        }
        ?>
	</div>
</div>
