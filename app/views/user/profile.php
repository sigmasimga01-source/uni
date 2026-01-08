<?php

require_once '../../app.php';

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
  $auth->logout();
  header('Location: login.php');
  exit();
}

$isLoggedIn = $auth->isLoggedIn();
if (!$isLoggedIn) {
  header('Location: login.php');
  exit();
}
$user = $auth->getUser();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
  
  $newUserName = trim($_POST['newusername']);
  $newName = trim($_POST['newname']);
  $newLastName = trim($_POST['newlastname']);
  $newTel = trim($_POST['newtel']);

  $valid = !empty($newUserName) && !empty($newName) && !empty($newLastName) && !empty($newTel);

  if ($valid) {
    $newData = [
      'username' => $newUserName,
      'name' => $newName,
      'lastname' => $newLastName,
      'tel' => $newTel
    ];

    try {
      $updateSuccess = $auth->updateProfile($user->getUserId(), $newData);
    } catch (\Throwable $th) {
      $_SESSION['msg'] = "Error: " . $th->getMessage();
      $updateSuccess = false;
    }

    if ($updateSuccess) {
      $_SESSION['msg'] = "Profile updated successfully.";
      $user = $auth->getUser();
    } else {
      $_SESSION['msg'] = "<p style=\"color: red\">Failed to update profile.<p>" . $th->getMessage();
    }
  } else {
    $_SESSION['msg'] = "All fields are required.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<?php $title = "Profile";
include_once '../_partials/header.php'; ?>

<body>
  <?php include_once '../_partials/navbar.php'; ?>
  <?= $auth->getMessage() ?>
  <div class="profile-card">
    <h2>Welcome, <?= $user->getUsername() ?></h2>
    <div class="info">
      <div><strong>Nasdasame:</strong> <?= $user->getName() ?></div>
      <div><strong>Last Name:</strong> <?= $user->getLastname() ?></div>
      <div><strong>Username:</strong> @<?= $user->getUsername() ?></div>
      <div><strong>Phone:</strong> <?= $user->getTel() ?></div>
    </div>

    <button id="editProfileBtn">Edit Profile</button>

    <form action="" method="post" id="editProfileForm" style="display: none; flex-direction: column; gap: 10px;">
      <input type="text" name="newusername" value="<?= $user->getUsername() ?>">
      <input type="text" name="newname" id="newname" placeholder="New Name" value="<?= ($user->getName()) ?>">
      <input type="text" name="newlastname" id="newlastname" placeholder="New Last Name" value="<?= ($user->getLastname()) ?>">
      <input type="text" name="newtel" id="newtel" placeholder="New Telephone" value="<?= ($user->getTel()) ?>">
      <input type="submit" name="update_profile" value="Update">
    </form>

  </div>
</body>

<script>
  const $editBtn = document.getElementById('editProfileBtn');

  $editBtn.addEventListener('click', () => {
    const $form = document.getElementById('editProfileForm');
    if ($form.style.display === 'none') {
      $form.style.display = 'flex';
    } else {
      $form.style.display = 'none';
    }
  });
</script>

</html>