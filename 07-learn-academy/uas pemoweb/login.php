<!DOCTYPE html>
 <html>

<head>
    <title>Last Project</title>
    <link rel="stylesheet" type="text/css" href="stylepemoweb.css">
</head>

<body>
    <!-- header -->
    <?php include('header.php') ?>
    
    <!-- menu -->
    <?php include('menu.php') ?>
   
    <!-- about --> 
    <section class="about">
        <div class="container2">
        <center>
            <h3><b>=&nbsp;&nbsp;LOG IN&nbsp;&nbsp;=</b></h3>
                <form action="table_login.php" method="POST">
                <table>
                    <tr>
                        <td>Email</td>
                        <!-- <td>:</td> -->
                        <td><input type="email" name="email"></td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <!-- <td>:</td> -->
                        <td><input type="password" name="password"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                        <button type="submit" name="log-in">LOG IN</button>
                        <button type="reset" name="reset">BATAL</button>
                        </td>
                    </tr>
                </table>

            </form></center>
        </div>
        <br><br><br>

    <!-- footer -->
    <?php include('footer.php') ?>

    </body>
</html>