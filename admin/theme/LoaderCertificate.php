<?php
namespace admin\theme;
class LoaderCertificate {
    public static function init() {
            return "<div id='loader' class='bg-white flex items-center overflow-hidden size-full top-0 left-0 fixed z-20'>
         <div class='lds-ripple m-auto'><div></div><div></div></div>
</div>";
    }
}
