<!-- hidebar(job id): function untuk hide page yang tak berkenaan -->
<!-- currentbar(): function untuk highlight current page di sidebar -->
<?php
//GLOBAL VARIABLE
$currentpage = basename($_SERVER["PHP_SELF"], '.php');
?>
<div id="sidebar">
  <style>
    .submenu {
      cursor: pointer;
    }
  </style>
  <ul>
    <li class="<?php currentbar($currentpage,['dashboard'])?>"><a href="dashboard.php"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>

    <li class="submenu <?php currentbar($currentpage,['register_employee','assign_supervisor','view_employee'])?>"> <a><i class="icon icon-user"></i> <span>Employee</span></a>
      <ul>
        <li <?php hidebar(1) ?>><a href="register_employee.php">Register Employee</a></li>
        <li><a href="view_employee.php">View Employee</a></li>
        <li <?php hidebar(1) ?>><a href="assign_supervisor.php">Assign Supervisor</a></li>
      </ul>
    </li>

    <li class="submenu <?php currentbar($currentpage,['add_transaction','view_transaction'])?>"> <a><i class="icon icon-truck"></i> <span>Transaction</span></a>
      <ul>
        <li><a href="add_transaction.php">Add Transaction</a></li>
        <li><a href="view_transaction.php">View Transaction</a></li>
      </ul>
    </li>

    <li class="<?php currentbar($currentpage,['change_password'])?>"><a href="change_password.php"><i class="icon icon-key"></i> <span>Change Password</span></a> </li>
  </ul>
</div>