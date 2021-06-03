
<?php echo $message; ?>

<form class="row g-3 m-3 ms-0 form border" name="frmLogin" action="authenticate.php" method="post">
    <fieldset style="margin: 0 0 .25rem 0; padding: 0;">
    <legend>Log in</legend>
        <div class="row mb-3">
            <label for="sID" class="col-sm-2 col-form-label">Student ID:</label>
            <div class="col-sm-5">
            <input class="form-control" id="sID" name="txtid" type="text" />
            </div>
            <br/>
        </div>
        <div class="row mb-3">
            <label for="pass" class="col-sm-2 col-form-label">Password:</label>
            <div class="col-sm-5">
            <input class="form-control" id="pass" name="txtpwd" type="password" />
            </div>
            <br/>
        </div>
   <input class="btn btn-primary m-2" type="submit" value="Login" name="btnlogin" />
    </fieldset>
</form>