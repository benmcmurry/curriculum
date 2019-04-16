<div id="level-nav-container">
	<div id="level-nav">
		<?php
        $query = $elc_db->prepare("Select * from Levels where active=1 order by level_order ASC");
				$query->execute();
				$result = $query->get_result();
				
        while ($levels = $result->fetch_assoc()) {
            ?>
			<a title="<?php echo $levels['level_name']; ?>" href='#<?php echo $levels['level_short_name']; ?>'>
			<div  class='square'>
				<?php echo $levels['level_short_name']; ?>
			</div>

			</a>
		<?php

        }
        ?>
	</div>
</div>
