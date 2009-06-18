<div class='rtblb'><div class='tagsa'>
<?php if ($count>0) {?>
    В сети:
    <?php foreach ($online as $user): ?>
    <a href='user/<?php echo $user;?>/'><?php echo $user;?></a> 
<?php endforeach;
}?>
<br /><br />Новенькие:
<?php foreach ($new as $user): ?>
    <a href='user/<?php echo $user;?>/'><?php echo $user;?></a>
<?php endforeach;?>
</div></div>