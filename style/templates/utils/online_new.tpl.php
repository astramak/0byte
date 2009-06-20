<div class='rtblb'>
	<div class='tagsa'>
		<div>
			<?php if ($online): ?>
			В сети:
				<?php foreach ($online as $user): ?>
			<a href='user/<?php echo $user;?>/'><?php echo $user;?></a>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
		<br />
		<div>
		Новенькие:
			<?php foreach ($new as $user): ?>
			<a href='user/<?php echo $user;?>/'><?php echo $user;?></a>
			<?php endforeach;?>
		</div>
	</div>
</div>