<!-- Unique Header Styling -->
<style>
    .nav-link {
        display: inline-block;
        background:rgb(252, 137, 44);
        color:rgb(230, 188, 188);
        text-decoration: none;
        padding: 0.4em 0.8em;
        border-radius: 8px;
        margin-left: 0.3em;
        font-family: 'Verdana', sans-serif;
        font-size: 0.9em;
        transition: background 0.3s ease;
    }

    .nav-link:hover {
        background: #393e46;
    }

    .greeting {
        color: #00adb5;
        font-weight: bold;
        margin-right: 0.5em;
        display: inline-flex;
        align-items: center;
        font-family: 'Tahoma', sans-serif;
    }

    .greeting img {
        width: 24px;
        height: 24px;
        margin-right: 0.3em;
        border-radius: 50%;
    }

    .brand-title {
        font-size: 2em;
        font-family: 'Trebuchet MS', sans-serif;
        letter-spacing: 3px;
        color: #393e46;
    }

    .search-bar {
        margin-top: 1em;
    }

    .search-bar input[type="text"] {
        padding: 0.5em;
        width: 200px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .search-bar input[type="submit"] {
        padding: 0.5em 1em;
        background-color: #00adb5;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    nav ul {
        list-style: none;
        padding-left: 0;
        display: flex;
        gap: 1em;
        margin-top: 1em;
    }

    nav ul li a {
        text-decoration: none;
        color: #00796b;
        font-weight: 600;
    }

    nav ul li a:hover {
        text-decoration: underline;
    }
</style>

<header>
    <h1 class="brand-title">Car Purchase</h1>

    <div class="search-bar">
        <form action="searchAuction.php" method="POST">
            <input type="text" name="search" placeholder="Find your dream car..." />
            <input type="submit" name="submit" value="Go" />
        </form>
    </div>

    <div class="user-actions">
        <?php
        if (isset($_SESSION['logged-in']) && $_SESSION['logged-in']) {
            $username = htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8');
            echo '<span class="greeting"><img src="/assets/avatar.png" alt="User">' . $username . '</span>';

            if ($username === 'admin') {
                echo '<a href="adminPanel.php" class="nav-link">Dashboard</a>';
            }

            echo '<a href="logout.php" class="nav-link">Sign Out</a>';
        } else {
            echo '<a href="login.php" class="nav-link">Login</a>';
            echo '<a href="register.php" class="nav-link">Join</a>';
        }
        ?>
    </div>
</header>

<?php
// Load category navigation
$query = "SELECT * FROM category";
$result = $Connection->query($query);

if ($result && $result->rowCount() > 0) {
    echo '<nav><ul>';
    while ($cat = $result->fetch(PDO::FETCH_ASSOC)) {
        $category = htmlspecialchars($cat['category_name'], ENT_QUOTES, 'UTF-8');
        $encoded = urlencode($category);
        echo "<li><a href='showCategory.php?category=$encoded'>$category</a></li>";
    }
    echo '</ul></nav>';
}
?>