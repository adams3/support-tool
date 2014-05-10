<?php

/**
 * Template to My account
 *
 * @author Adam Studenic
 *
 */


require_once 'header.php';

$userData = getUser();
$success = null;

if (isset($_POST["submit"]) && $_POST["submit"] == "saveChanges") {
    $data = $_POST;
    unset($data["submit"]);
    $userData = saveUser($data);

}

header("location:my-account.php?success=true");
?>
<div class="page-header mt0">
    <h1>My account <small>Manage your account here</small></h1>
</div>
<form id="formLogIn" name="formLogIn" class="form-signin" method="post" action="my-account.php">
    <h2 class="form-signin-heading">Account information</h2>
    <?php
    if (isset($userData["success"]) && $userData["success"]) {
        echo "<div class='alert alert-success'>Changes saved successfully</div>";
    } elseif (isset($userData["success"]) && !$userData["success"]) {
        echo "<div class='alert alert-danger'>Ooops, something went wrong</div>";
    }
    ?>

    <input name="name" type="text" class="form-control top" placeholder="Name" value="<?php echo $userData["name"]; ?>" required>
    <input name="surname" type="text" class="form-control bottom" placeholder="Surname" value="<?php echo $userData["surname"]; ?>"  required>
    <input name="email" type="email" class="form-control bottom mb10" placeholder="Email address" value="<?php echo $userData["email"]; ?>" readonly required>
    <input name="password" type="password" class="form-control top hide" value="<?php echo $userData["password"]; ?>" >
    <input name="oldPassword" type="password" class="form-control top" placeholder="Old password" >
    <input name="newPassword" type="password" class="form-control bottom" placeholder="New password" >
    <input name="submit" type="text" value="saveChanges" class="hide">
    <button class="btn btn-lg btn-primary btn-block" type="submit">Save changes</button>

</form>

<?php
require_once 'footer.php';
?>
