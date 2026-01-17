<?php
$routes = [
  "secret" => [
    "label" => "Secret",
    "path" => "secret",
    "auth" => true
  ],
  "home" => [
    "label" => "Home",
    "path"  => "",
  ],
  "profile" => [
    "label" => "Profile",
    "path"  => "user/profile",
    "auth"  => true
  ],
  "logout" => [
    "label" => "Logout",
    "path"  => "auth/login?action=logout",
    "auth"  => true
  ],
  "login" => [
    "label" => "Login",
    "path"  => "auth/login",
    "auth"  => false
  ],
  "register" => [
    "label" => "Register",
    "path" => "auth/register",
    "auth" => false
  ],
  "blogs" => [
    "label" => "Blogs",
    "path" => "blogs/blogs",
    "auth" => true
  ]
];
$base = "/uni/app/views/";
$isLoggedIn = $auth->isLoggedIn();
?>

<nav>
  <?php foreach ($routes as $route): ?>

    <?php
    if (isset($route['auth'])) {
      if ($route['auth'] && !$isLoggedIn) continue;
      if (!$route['auth'] && $isLoggedIn) continue;
    }
    ?>

    <a href="<?= $base . $route['path'] ?>">
      <?= $route['label'] ?>
    </a>
  <?php endforeach; ?>
</nav>