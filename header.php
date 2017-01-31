<h1><left>Queen's BnB</left></h1>
            <ul>
                <?php if($rank >= 0 && $admin == 0){ ?>
                <li><a href="search.php">Search</a></li>
                <li><a href="viewbookings.php">View Bookings</a></li>
                <li><a href="addproperty.php">Add Property</a></li>
                <li><a href="logout.php">Logout</a></li>
                <li><a href="profile.php"><?php echo $accountname; ?></a></li>
                <?php }
		      if($rank >= 0 && $admin == 1){ ?>
                <li><a href="manageusers.php">Users</a></li>
		<li><a href="manageproperties.php">Properties</a></li>
                <li><a href="profile.php"><?php echo $accountname; ?></a></li>
                <?php }
		      if($rank == -1){ ?>
                <li><a href="index.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
                <?php } ?>
            </ul>
