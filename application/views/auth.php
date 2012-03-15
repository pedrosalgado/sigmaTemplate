<div id="searchBox">
<form>
<label>Procurar</label>
<input type="text" />
</form>
</div>
<div id="authBox">
    <p class="loginLabel"><span class="leftBrckt"></span><a href="#" class="loginLbl" onclick="showLogin(); return false;">login</a><span class="rightBrckt"></span></p>
    <form id="loginForm" class="loginForm" method="post" action="<?php echo base_url().index_page(); ?>/auth/authenticate">
        <p>
            <label for="username" style="">Username</label>
            <input type="text" value="" name="username"/>
        </p>
        <p>
            <label for="password" style="">Password</label>

            <input type="password" value="" name="password"/>
        </p>

        <input type="submit" class="loginFormBtn" />
    </form>

</div>
