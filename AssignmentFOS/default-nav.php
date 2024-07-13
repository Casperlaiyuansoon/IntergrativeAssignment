<!DOCTYPE html>

<style>

nav{
    background-color: darkorange;
    height: 100px;
    width: 100%;
    position: sticky;
}

.nav-menu{
    font-size: 20px;
    font-weight: 200;
    display: inline-flex;
    
}

.nav-menu li{
    margin: auto;
    padding: 30px 40px;
    display: inline-flex;
}

.nav-menu a{
    color: whitesmoke;
    font-size: 30px;
    text-decoration: none;
    position: relative;
    font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

a:hover{
    position: relative;
    text-decoration: underline;
    transition: 2s;
}

.side-menu{
    background-color: whitesmoke;
    float: right;
    height: 700px;
    width: 220px;
    font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.side-menu li{
    display: inline-block;
}

.side-menu ul{
    position: relative;
}

.side-menu li a{
    color: black;
    display: inline-block;
    font-size: 20px;
    padding: 10px;
    position: relative;
    text-decoration: none;
}

.side-menu a:hover {
    color: aliceblue;
    background-color: darkorange;
    text-decoration: solid;
    transition: 0.3s;
    padding: 10px;
}

.account-details{
    text-align: center;
    background-color: darkorange;
    width: 220px;
    height: 90px;
    padding-top: 1px;
}
</style>

<html>
    <body>
        <nav>
            <div class="nav-menu">
                <li><a href="homepage.php">Home</a></li>
                <li><a href="">Menu</a></li>
                <li><a href="">Orders</a></li>
                <li><a href="">Review</a></li>
            </div>
        </nav>

        <div class="side-menu">

        <div class="account-details">
            <h2>User Account</h2>
        </div> 

            <ul>
                <li>
                    <a href="">Account</a>
                    <a href="">Order History</a>
                    <a href="">Payment History</a>
                    <a href="">Cart</a>
                    <a href="">Login</a>
                    <a href="">Log Out</a>
                </li>
            </ul>

     </div>

    </body>
</html>