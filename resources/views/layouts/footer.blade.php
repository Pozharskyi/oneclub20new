<!DOCTYPE html>
<html>
    <head>
    </head>
<body>
    <footer class="main-footer">
        <div class="foot-wrap">
            <div class="container">
                <div class="row">
                    <div class="foot-content">

                        <div class="col-sm-3">

                            <div class="mnu-button-wrap hidden-sm hidden-md hidden-lg">
                                <button id="catalog" class="mnu-button" value="Меню">
                                    <img src="{{ url('img/arrow-grey.png') }}" alt="">Каталог</button>
                            </div>

                            <ul class='first-ul'>
                                <li class="first hidden-xs">каталог</li>
                                <li><a href="http://localhost:8081/list/men">Мужчинам</a></li>
                                <li><a href="http://localhost:8081/list/women">Женщинам</a></li>
                                <li><a href="http://localhost:8081/list/children">Детям</a></li>
                                <li><a href="http://localhost:8081/list/home">Для дома</a></li>
                                <li><a href="#">Бренды</a></li>
                            </ul>
                        </div>

                        <div class="col-sm-3">
                            <div class="mnu-button-wrap hidden-sm hidden-md hidden-lg">
                                <button id="for-byers" class="mnu-button" value="Меню">
                                    <img src="{{ url('img/arrow-grey.png') }}" alt="">Покупателям</button>
                            </div>
                            <ul class="second-ul">
                                <li class="first hidden-xs">покупателям</li>
                                <li><a href="##">Оплата</a></li>
                                <li><a href="##">Возврат</a></li>
                                <li><a href="##">Доставка</a></li>
                                <li><a href="##">Оферта</a></li>
                                <li><a href="##">Поддержка</a></li>
                            </ul>
                        </div>

                        <div class="col-sm-2">
                            <div class="mnu-button-wrap hidden-sm hidden-md hidden-lg">
                                <button id="about-us" class="mnu-button" value="Меню">
                                    <img src="{{ url('img/arrow-grey.png') }}" alt="">О нас</button>
                            </div>
                            <ul class="third-ul">
                                <li class="first hidden-xs">о нас</li>
                                <li><a href="##">О проекте</a></li>
                                <li><a href="##">Вакансии</a></li>
                                <li><a href="##">Партнерам</a></li>
                                <li><a href="##">Контакты</a></li>
                                <li><a href="##">FAQ</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="soc-wrap">
                            <div class="foot-logo-wrap">
                                <a href="##"><img src="{{ url('img/logotype-footer.png') }}" alt=""></a>
                            </div>

                            <p>© 2016 One Club 2.0<br>All Right reserved</p>

                            <ul class="soc-buttons">
                                <li><a href="##"><img src="{{ url('img/fb-icon.png') }}" alt=""></a></li>
                                <li><a href="##"><img src="{{ url('img/insta-icon.png') }}" alt=""></a></li>
                                <li><a href="##"><img src="{{ url('img/twitter-icon.png') }}" alt=""></a></li>
                                <li><a href="##"><img src="{{ url('img/pin-icon.png') }}" alt=""></a></li>
                            </ul>

                            <ul class="pay-wrap">
                                <li><a href="##"><img src="{{ url('img/visa-icon.png') }}" alt=""></a></li>
                                <li><a href="##"><img src="{{ url('img/mastercard-icon.png') }}" alt=""></a></li>
                                <li><a href="##"><img src="{{ url('img/liqpay-icon.png') }}" alt=""></a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </footer>

    <div id="popup1" class="overlay">
        <div class="popup">
            <h2>Here i am</h2>
            <a class="close" href="##">&times;</a>
            <div class="content">
                Thank to pop me out of that button, but now i'm done so you can close this window.
            </div>
        </div>
    </div>
    <!-- Optimized loading JS Start -->
    <script>var scr = {"scripts":[
            {"src" : "/js/libs.min.js", "async" : false},
            {"src" : "/js/common.js", "async" : false}
        ]};!function(t,n,r){"use strict";var c=function(t){if("[object Array]"!==Object.prototype.toString.call(t))return!1;for(var r=0;r<t.length;r++){var c=n.createElement("script"),e=t[r];c.src=e.src,c.async=e.async,n.body.appendChild(c)}return!0};t.addEventListener?t.addEventListener("load",function(){c(r.scripts);},!1):t.attachEvent?t.attachEvent("onload",function(){c(r.scripts)}):t.onload=function(){c(r.scripts)}}(window,document,scr);
    </script>
    <!-- Optimized loading JS End -->
</body>
</html>