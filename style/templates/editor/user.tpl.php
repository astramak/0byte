<a class="user_tag" href='user/<?php echo $name; ?>/'><img src='<?php echo $avatar; ?>' />
<?php if ($blocked) { echo '<del>';} echo $name; if ($blocked) { echo '</del>';} ?></a>