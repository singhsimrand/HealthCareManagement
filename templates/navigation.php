<div class="header" style="padding-top:10px;">
	<img src="<?php echo $BASE_URL; ?>/images/times_now_logo.png" align="left" style="margin-right:25px;" />
	<div style="float:right;padding-right:25px;">
		<div style="color:#FFF;">Executive Intelligence Platform</div>
		<div><input type="text" value=""/><input type="button" value="search"/></div>
	</div>
</div>
<div class="navigation_bar">
	<ul class="nav nav-pills">
		<li <?php
		if($ACTION == "home")
		{
			?>class="active"<?php
		}
		?>><a href="<?php echo $BASE_URL; ?>/">Home</a></li>
		<?php
		foreach ($lenses_list as $key => $value)
		{
			if(is_string($key))
			{
				?>
				<li class="dropdown<?php
				if(in_array_recursive('id',substr($ACTION,5),$value))
				{
					echo " active ";
				}
				?>">
					<a class="dropdown-toggle"  data-toggle="dropdown" href="#"><?php echo $key; ?><b class="caret"></b></a>
					<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
						<?php
						foreach ($value as $key_L2 => $value_L2)
						{
							?><li <?php
							if($ACTION == "view/".$value_L2['id'])
							{
								?>class="active"<?php
							}
							?>><a tabindex="-1" href="<?php echo $BASE_URL; ?>/view/<?php echo $value_L2['id'];?>"><?php echo $value_L2['title']; ?></a></li><?php
						}
						?>								
					</ul>
				</li>
				<?php
			}
			else
			{
				?><li <?php
				if($ACTION == "view/".$value['id'])
				{
					?>class="active"<?php
				}
				?>><a href="<?php echo $BASE_URL; ?>/view/<?php echo $value['id'];?>"><?php echo $value['title'];?></a></li><?php
			}
			
		}
		
		
		?>
	</ul>
</div>