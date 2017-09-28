<div id="level-nav">
	<div id="level-nav-container">
		<?php
        $query = $database_curriculum->prepare("Select * from Levels order by level_order ASC");
				$query->execute();
				$result = $query->get_result();

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
