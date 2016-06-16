
<nav>
  <ul>
      <li><a href="index.php">Index</a></li>
      <li><a href="invoice_.php">Invoice</a></li>
  </ul>

<?php if ($_SESSION['loggedin']) { ?>
  <p class="menuaddition">
      <a href="logout.php">logout</a>
  </p>
<?php } ?>
  <p class="menuaddition">
    In case of problems:<br>
    <a href='mailto:relativityUZH@gmail.com'>relativityUZH@gmail.com</a>
  </p>
</nav>
