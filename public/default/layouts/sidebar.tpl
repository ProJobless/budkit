<tpl:layout xmlns="http://www.w3.org/1999/xhtml" xmlns:tpl="http://budkit.org/tpl">
    <div class="navbar" id="navbar">
        <div class="navbar-inner">
            <a class="brand logo" href="/system/start/dashboard">:/budkit</a>
        </div>
    </div>
    <tpl:condition  data="user.isauthenticated" test="boolean" value="1" >
        <tpl:block data="page.block.side" />
    </tpl:condition>
</tpl:layout>


